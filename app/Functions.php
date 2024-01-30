<?php

use App\Models\Termsetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\OtherSetting;
use App\Models\StudentBursaryRegister;

//calculates the Bursary Fee required by the a form in a school at a particular term and year
// the bursary is calculated like this. Student Count from that class or form multiplied by fees from the class which is in the 
//schools table multiplied by fees percentage/100 from other_settings table * the current term fees which is also found in the other_settings table

/*function calculateBursaryFee($schoolId, $formId, $term) {
    $studentCount = Student::where('school_id', $schoolId)->where('form_id', $formId)
    ->where('on_scholarship', 0)->where('status', 1)->count();
    $uniform_fees = hasUniformFees($schoolId);
    $form_fee = convertFormID($formId);  //This will be queries of the uniform fees is set to false
   
    $classFees = School::where('id', $schoolId)->first();
    
    //->where('year', $year)->where('term', $term)->first();
    if ($uniform_fees) {
        $classFee = $classFees->fees;
    }
    else {
        $classFee = $classFees->$form_fee;
    }
    
    $term = convertTermToDatabaseField();
    $settings = OtherSetting::first();
    
    $percentage_term_fee = $settings->$term;
    $feesPercentage = $settings->fees_percentage; 
    $bursaryFee = $studentCount * $classFee * $feesPercentage / 100 * $percentage_term_fee / 100;
    return $bursaryFee;
}*/
//function to check if a school has uniform_fees in the schools table. If uniform_fees is 1 return true
//else return false;

function hasUniformFees($schoolId) {
    $school = School::where('id', $schoolId)->first();

    // Check if the $school object is not null
    if ($school !== null && $school->uniform_fees == 1) {
        return true;
    } else {
        return false;
    }
}


//Revised calculateBursaryFee
function calculateBursaryFee($schoolId, $formId, $term) {
    $studentCount = Student::where('school_id', $schoolId)
        ->where('form_id', $formId)
        ->where('on_scholarship', 'No')
        ->where('status', 'Approved')
        ->count();

    $uniform_fees = hasUniformFees($schoolId);
    $form_fee = convertFormID($formId); // Ensure this function returns a valid property name

    $classFees = School::where('id', $schoolId)->first();

    if ($classFees !== null) {
        if ($uniform_fees) {
            $classFee = $classFees->fees;
        } else {
            // Check if the dynamic property exists
            if (property_exists($classFees, $form_fee)) {
                $classFee = $classFees->$form_fee;
            } else {
                $classFee = 0; // Default value or handle error
            }
        }
    } else {
        // Handle case when $classFees is null
        // Could return an error or set a default value for $classFee
        $classFee = 0; // Example default value
    }

    $termField = convertTermToDatabaseField(); // Ensure this function returns a valid field name
    $settings = OtherSetting::first();

    if ($settings !== null && property_exists($settings, $termField)) {
        $percentage_term_fee = $settings->$termField;
        $feesPercentage = $settings->fees_percentage;
        $bursaryFee = $studentCount * $classFee * $feesPercentage / 100 * $percentage_term_fee / 100;
        return 1000;
    } else {
        // Handle case when $settings is null or doesn't have $termField
        return 12000; // Example return value for error handling
    }
}
//Generate a function to calculate fees required by each form or class of a school using the following settings
//there a student table that has school_id, form_id, uniform_fees, on_scholarship(1-Yes, 2-NO),f1_fee,f2_fee
//f3_fee and f4_fee and also another field called fees. The fees fee can only be used if the uniform_fees = 1
//if the uniform_fee is 0 use f1_fee for form_id 1, f2_fee for form_id 2, f3_fee for form_id 3 ,f4_fee for form_id 4.
//There is also another table called other_settings that has fee_percentage and % fee for each term
//at the end you calculate fees required by getting stundet count based on school_id, form_id, scholarship
//multiplied by fees if uniform_fees is 1 (use f{}_fee for each form if uniform_fees is 0) multiplied by fees_percentage from
//other_settings * term_percentage
function calculateTotalFees($schoolId, $formId, $term) {
    // Fetch the number of students not on scholarship and active
    $studentCount = Student::where('school_id', $schoolId)
                           ->where('form_id', $formId)
                           ->where('on_scholarship', 'No')
                           ->where('status', 'Approved')
                           ->where('day_scholar', 'No')
                           ->count();
                           
   
    //get students count by using the same logic but adding if boarders = 0 to get non boarders students
    $studentCountDay = Student::where('school_id', $schoolId)
                           ->where('form_id', $formId)
                           ->where('on_scholarship', 'No')
                           ->where('status', 'Approved')
                           ->where('day_scholar', 'Yes')
                           ->count();

    // Fetch school fee details
    $school = School::find($schoolId);
  
    if (!$school) {
        // Handle the case when the school is not found
        return 0; // or throw an exception
    }

    $uniformFees = $school->uniform_fee;

    // Determine the fee to be used
    if ($uniformFees == "Yes") {
        $fee = $school->fees;
       
    } else {
        $feeFieldName = 'f_' . $formId . '_fee'; // Construct the fee field name dynamically
        $fee = $school->$feeFieldName;
    }
    //get the fee for boarders by query f1b_fee, f2b_fee, f3b_fee and f4b_fee from school table
    $feeBoardersFieldName = 'b_' . $formId . '_fee';
    $feeBoarders = $school->$feeBoardersFieldName;

    
    // Fetch the fee percentage for the term from other_settings table
    $settings = OtherSetting::first();
    if (!$settings) {
        // Handle the case when the settings are not found
        return 0; // or throw an exception
    }
    $mapToNumber = mapTermToNumber($term);
    $termFieldName = 'term_' . $mapToNumber;
 
    $termPercentage = $settings->$termFieldName;

    //Fee percentage is different for days schools and other boarding school
    //get school category
    //get categoryid
    $catId = getCategoryID('Day School');

    $schoolCatId = $school->category_id;

    if ($schoolCatId === $catId) {  // This is is a day school and its fee percentage is different from otheres
            $feesPercentage = $settings->day_fees_percentage;
    }
    else {
    $feesPercentage = $settings->fees_percentage;
    }
    // Calculate total fees
    $totalFees = $studentCount * $fee * ($feesPercentage / 100) * ($termPercentage / 100); //Total Fees By Boarders
    $totalFeesDay = $studentCountDay * (float) $feeBoarders * ($feesPercentage / 100) * ($termPercentage / 100);
    return $totalFees + $totalFeesDay;
}
//get student fees balance at the end of the term based on admission number, year and term

//TOTAL FEES FOR THE ENTIRE YEAR


function calculateTotalFeesForTheYear($schoolId, $formId) {
    // Fetch the number of students not on scholarship and active
    $studentCount = Student::where('school_id', $schoolId)
                           ->where('form_id', $formId)
                           ->where('on_scholarship', 'No')
                           ->where('status', 'Approved')
                           ->where('day_scholar', 'No')
                           ->count();
                           
   
    //get students count by using the same logic but adding if boarders = 0 to get non boarders students
    $studentCountDay = Student::where('school_id', $schoolId)
                           ->where('form_id', $formId)
                           ->where('on_scholarship', 'No')
                           ->where('status', 'Approved')
                           ->where('day_scholar', 'Yes')
                           ->count();

    // Fetch school fee details
    $school = School::find($schoolId);
  
    if (!$school) {
        // Handle the case when the school is not found
        return 0; // or throw an exception
    }

    $uniformFees = $school->uniform_fee;

    // Determine the fee to be used
    if ($uniformFees == "Yes") {
        $fee = $school->fees;
       
    } else {
        $feeFieldName = 'f_' . $formId . '_fee'; // Construct the fee field name dynamically
        $fee = $school->$feeFieldName;
    }
    //get the fee for boarders by query f1b_fee, f2b_fee, f3b_fee and f4b_fee from school table
    $feeBoardersFieldName = 'b_' . $formId . '_fee';
    $feeBoarders = $school->$feeBoardersFieldName;

    
    // Fetch the fee percentage for the term from other_settings table
    $settings = OtherSetting::first();
    if (!$settings) {
        // Handle the case when the settings are not found
        return 0; // or throw an exception
    }
  

    //Fee percentage is different for days schools and other boarding school
    //get school category
    //get categoryid
    $catId = getCategoryID('Day School');

    $schoolCatId = $school->category_id;

    if ($schoolCatId === $catId) {  // This is is a day school and its fee percentage is different from otheres
            $feesPercentage = $settings->day_fees_percentage;
    }
    else {
    $feesPercentage = $settings->fees_percentage;
    }
    // Calculate total fees
    $totalFees = $studentCount * $fee * ($feesPercentage / 100); //Total Fees By Boarders
    $totalFeesDay = $studentCountDay * (float) $feeBoarders * ($feesPercentage / 100);
    return $totalFees + $totalFeesDay;
}

function getCategoryID ($name) {
    $cat = SchoolCategory::where('category_name', $name)->first();
  
    return $cat->id;
}
//Total expected fees based on student counts 
function totalFees($schoolId, $term) {
    $studentCountBoarders = Student::where('school_id', $schoolId)
                                   
                                   ->where('on_scholarship', 0)
                                   ->where('status', 1)
                                   ->where('boarder', 1)
                                   ->count();
    
    $studentCountDay = Student::where('school_id', $schoolId)
                            
                              ->where('on_scholarship', 0)
                              ->where('status', 1)
                              ->where('boarder', 0)
                              ->count();

    $school = School::find($schoolId);
    if (!$school) {
        return 0;
    }

    $uniformFees = $school->uniform_fees;
    $fee = $uniformFees == 1 ? $school->fees : $school->{'f' . $formId . '_fee'};
    $feeBoardersFieldName = 'f' . $formId . 'b_fee';
    $feeBoarders = isset($school->$feeBoardersFieldName) ? (float) $school->$feeBoardersFieldName : 0;

    $settings = OtherSetting::first();
    if (!$settings) {
        return 0;
    }
    $termPercentage = $settings->{'term' . mapTermToNumber($term)};
    $feesPercentage = $settings->fees_percentage;

    $totalFeesBoarders = $studentCountBoarders * $feeBoarders * ($feesPercentage / 100) * ($termPercentage / 100);
    $totalFeesDay = $studentCountDay * $fee * ($feesPercentage / 100) * ($termPercentage / 100);

    return $totalFeesBoarders + $totalFeesDay;
}

//calculate the totalfeespaid from student bursary register which has amount_paid, term, year. 
function calculateTotalBursaryPaid($schoolId, $formId, $yearId, $term) {
    // Calculate the total bursary paid for a specific form in a specific school for the given term and year
    $totalBursaryPaid = DB::table('student_bursary_registers')
                            ->join('students', 'student_bursary_registers.admission_number_id', '=', 'students.id')
                            ->where('students.school_id', $schoolId)
                            ->where('students.form_id', $formId)
                            ->where('student_bursary_registers.year_id', $yearId)
                            ->where('student_bursary_registers.term', $term)
                            ->sum('student_bursary_registers.amount_paid');

    return $totalBursaryPaid;
}
//get total bursary paid for this year

function calculateTotalBursaryPaidForTheYear($schoolId, $formId, $yearId) {
    // Calculate the total bursary paid for a specific form in a specific school for the given term and year
    $totalBursaryPaid = DB::table('student_bursary_registers')
                            ->join('students', 'student_bursary_registers.admission_number_id', '=', 'students.id')
                            ->where('students.school_id', $schoolId)
                            ->where('students.form_id', $formId)
                            ->where('student_bursary_registers.year_id', $yearId)
                       
                            ->sum('student_bursary_registers.amount_paid');

    return $totalBursaryPaid;
}

function calculateStudentFeesSummary($schoolId, $formId, $term, $yearId) {
    // Get the total fees for the school, form, and term
    $totalFees = calculateTotalFees($schoolId, $formId, $term);

    // Get the total bursary paid for the school, form, term, and year
    $totalBursaryPaid = calculateTotalBursaryPaid($schoolId, $formId, $yearId, $term);

    // Fetch all students in the specified form and school
    $students = Student::where('school_id', $schoolId)
                        ->where('form_id', $formId)
                        ->get();

    // Initialize an array to hold each student's fee summary
    $studentFeeSummaries = [];

    foreach ($students as $student) {
        // Calculate each student's fee based on whether they are a day scholar or boarder
        $feeForStudent = $student->day_scholar === 'Yes' ? $totalFees : $totalFees; // Adjust this logic based on how day scholars and boarders are charged differently

        // Fetch the total bursary paid for each student
        $bursaryForStudent = DB::table('student_bursary_registers')
                                ->where('admission_number_id', $student->id)
                                ->where('year_id', $yearId)
                                ->where('term', $term)
                                ->sum('amount_paid');

        // Calculate the balance for each student
        $balance = $feeForStudent - $bursaryForStudent;

        // Add the student's summary to the array
        $studentFeeSummaries[] = [
            'student_id' => $student->id,
            'total_fee' => $feeForStudent,
            'total_bursary_paid' => $bursaryForStudent,
            'balance' => $balance
        ];
    }

    // Return the array of student fee summaries
    return $studentFeeSummaries;
}

//function to get total amount paid based on payment code

function getTotalAmountPaid($paymentCode) {
    $totalAmountPaid = DB::table('student_bursary_registers')
                        
                            ->where('payment_code', $paymentCode)
                            ->sum('student_bursary_registers.amount_paid');
    
                            return $totalAmountPaid;

}

//create a funcation to map payment code to table id
function getPaymentCode($id) {
    $alloc = DB::table('allocations')
                    ->where('id', $id)
                    ->first();
    $code = $alloc->payment_code;

    return $code;
}


function totalBursaryPaid($yearId, $term) {
    // Calculate the total bursary paid for a specific form in a specific school for the given term and year
    $userId = Auth::id();
    $accessid = DB::table('school_permission_user')
    ->join('school_school_permission', 'school_permission_user.school_permission_id', '=', 'school_school_permission.school_permission_id')
    ->where('school_permission_user.user_id', $userId)
    
    ->pluck('school_id');
    
$schools = School::whereIn('id', $accessid)->get();

    $totalBursary = DB::table('student_bursary_registers')
                            ->join('students', 'student_bursary_registers.admission_number_id', '=', 'students.id')
                           // ->where('students.school_id', $accessid)
                            ->where('student_bursary_registers.year_id', $yearId)
                            ->where('student_bursary_registers.term', $term)
                            ->sum('student_bursary_registers.amount_paid');

    return $totalBursary;
}
//caculate total students based on their forms uding students table
function getTotalStudentsByForm($schoolId, $formId) {
    $totalStudentsByForm = Student::where('school_id', $schoolId)
                                    ->where('form_id', $formId)
                                    ->where('status', 'Approved')
                                    ->where('on_scholarship', 'No')
                                    ->count();
    return $totalStudentsByForm;
}

//calculate the total students per school

function getTotalStudentsBySchool($schoolId) {
    $totalStudentsBySchool = Student::where('school_id', $schoolId)
                                    ->where('status', 'Approved')
                                    ->where('on_scholarship', 'No')
                                    ->count();
    return $totalStudentsBySchool;
}
function mapTermToNumber($termName) {
    $termMapping = [
        "Term 1" => 1,
        "Term 2" => 2,
        "Term 3" => 3
    ];

    // Return the corresponding number or a default value if not found
    return $termMapping[$termName] ?? null; // null or any other default value you prefer
}



function convertFormID($form_id) {
    if ($form_id === 1) {
        $form_id = 'f1_fee';
    }
    elseif ($form_id == 2) {
        $form_id = 'f2_fee';
    }
    elseif ($form_id == 2) {
        $form_id = 'f3_fee';
    }
    else {
        $form_id = 'f4_fee';
    }
    return $form_id;
}

//function to convert term to database field name eg Term 3 is term3, Term 2 is term2 and Term 1 is term1

function convertTermToDatabaseField() {  
    
    $term = getCurrentTermOrHoliday();
 if ($term == 'Term 1') {
    $term = 'term1';
 }
 elseif ($term == 'Term 2') {
    $term = 'term2';
 }
 else  {
    $term = 'term3';
 }
 


 return $term;

}

//get the id of the current year from year table

//create a function to multiply 2 variables


function getCurrentYear()

{
    $current_year = date('Y');
    $current_year = DB::table('years')->where('year', $current_year)->first();
    return $current_year->id;
}


function getSchoolNameIdMap() {
    return School::pluck('id', 'name')->toArray();
}


function getCurrentTermOrHoliday() {
    $today = now()->toDateString();

    // Check if today is in any term period
    $currentTerm = TermSetting::where('begins', '<=', $today)
                              ->where('ends', '>=', $today)
                              ->first();

    if ($currentTerm) {
        // If it's a term period, return term name and null for holiday
        return $currentTerm->term;
    } else {
        // If not a term, determine the last term for the holiday
        $lastTerm = TermSetting::where('ends', '<', $today)
                               ->orderBy('ends', 'desc')
                               ->first();

       
            // Return term name and "Holiday"
            return $lastTerm->term;
       
            // If no current term or holiday, return null values
        
    }
}
// Get school ID

function getSchoolID($schoolName) {
    $school = School::where('name', $schoolName)->first();
    return $school->id;
}





function geSchoolName()
{
    $userId = Auth::id(); // or use Auth::user()->id;

    if (!$userId) {
        return 'No user logged in';
    }

    $accessibleSchoolIds = DB::table('school_permission_user')
        ->join('school_school_permission', 'school_permission_user.school_permission_id', '=', 'school_school_permission.school_permission_id')
        ->where('school_permission_user.user_id', $userId)
        ->pluck('school_id');

    if ($accessibleSchoolIds->isEmpty()) {
        return 'No accessible schools';
    } elseif ($accessibleSchoolIds->count() === 1) {
        // Fetch and return the name of the single school
        $schoolName = DB::table('schools') // Replace 'schools' with your actual schools table name
            ->whereIn('id', $accessibleSchoolIds)
            ->value('name');
        return $schoolName;
    } else {
        return 'Schools'; // More than one accessible school
    }
}


/**
 * Checks if the amount paid covers the fees balance.
 * 
 * @param string $admissionNumber The student's admission number.
 * @param float $amount The amount paid.
 * @param string $term The term for which payment is made.
 * @param int $year The year for which payment is made.
 * @return array An array with a boolean indicating success and the balance (if any).
 */
function checkFeesBalance($admissionNumber, $amount, $term, $year) {
    // Fetch the student based on the admission number
    $student = Student::where('id', $admissionNumber)->first();

    if (!$student) {
        return ['success' => false, 'message' => 'Student not found', 'balance' => null];
    }

    $settings = OtherSetting::first();
    if (!$settings) {
        return ['success' => false, 'message' => 'Settings not found', 'balance' => null];
    }

    $school = $student->school;
    if (!$school) {
        return ['success' => false, 'message' => 'School not found', 'balance' => null];
    }

    $feesPercentage = $settings->fees_percentage / 100;
    $termPercentage = 0;

    switch ($term) {
        case 'Term 1':
            $termPercentage = $settings->term1 / 100;
            break;
        case 'Term 2':
            $termPercentage = $settings->term2 / 100;
            break;
        case 'Term 3':
            $termPercentage = $settings->term3 / 100;
            break;
    }

    $totalFeesRequired = $school->fees * $termPercentage * $feesPercentage;

    // Fetch total amount paid so far by the student
    $totalAmountPaid = StudentBursaryRegister::where('admission_number_id', $student->id)
                                             ->where('term', $term)
                                             ->where('year_id', $year)
                                             ->sum('amount_paid');

    // Include the new payment in the total
    $totalAmountPaid += $amount;

    // Calculate balance
    $balance = $totalFeesRequired - $totalAmountPaid;

    if ($balance >= 0) {
        return ['success' => true, 'balance' => $balance];
    } else {
        // More was paid than required
        $overpaidAmount = abs($balance);
        return ['success' => false, 'balance' => $overpaidAmount];
    }
}


//#################### TEST FUNCTIONS ##################################3


// Helper method to mask names with multiple words
function maskName($name)
{
    $words = explode(' ', $name);
    $maskedWords = array_map(function ($word) {
        $length = strlen($word);
        $maskedPart = substr($word, 0, 2) . str_repeat('*', max(0, $length - 2));
        
        // Debugging: Log the original and masked parts
        \Log::info("Original: $word, Masked: $maskedPart");

        return $maskedPart;
    }, $words);

    return implode(' ', $maskedWords);
}




?>