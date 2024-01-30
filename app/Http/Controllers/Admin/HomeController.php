<?php

namespace App\Http\Controllers\Admin;
use App\Models\Student;
use App\Models\StudentForm;
use App\Models\Ward;
use Illuminate\Support\Facades\DB;
use App\Models\SchoolPermission;
use App\Models\School;
use App\Models\User;
use App\Functions;
use App\Models\StudentBursaryRegister;
use Yajra\DataTables\Facades\DataTables;
use App\Models\SchoolStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentBusaryRegister;
use App\Models\OtherSetting;
use Exception;


class HomeController
{



   

public function getSchoolName()
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




private function calculatePaidFees($schoolId, $formId, $term, $year) {
    return StudentBursaryRegister::join('students', 'student_bursary_registers.admission_number_id', '=', 'students.id')
        ->where('students.school_id', $schoolId)
        ->where('students.form_id', $formId)
        ->where('student_bursary_registers.term', $term)
        ->where('student_bursary_registers.year_id', $year)
        ->sum('student_bursary_registers.amount_paid');
}
    public function index(Request $request)
    { 
        
        //Get Current Term

        $term = getCurrentTermOrHoliday();
        $userId = auth()->id();

        $totalRegisteredStudent = Student::with(['ward', 'stream', 'school', 'form', 'registered_by', 'approved_by'])
        ->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
            $query->where('id', $userId);
        

        })->count();

        $approvedStudent =Student::with(['ward', 'stream', 'school', 'form', 'registered_by', 'approved_by'])
        ->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
            $query->where('id', $userId)
                  ->where('status',1)
                  ->where('on_scholarship','No');

        })->count();
        
        




$accessibleSchoolIds = DB::table('school_permission_user')
    ->join('school_school_permission', 'school_permission_user.school_permission_id', '=', 'school_school_permission.school_permission_id')
    ->where('school_permission_user.user_id', $userId)
    ->pluck('school_id');

$schools = School::whereIn('id', $accessibleSchoolIds)->get();




//create a variable that returns a table with columns like schoolNames, F1, F2,F3 and F4. The rows will contain 
//school Name, total fees for f1, f2, f3, f4. Remember I have a working function that will easily calculate totalfees
//based on school_id and form_id both

$term = getCurrentTermOrHoliday(); // replace with the current term value
$yearId = getCurrentYear();

$tableData = $schools->map(function ($school) use ($yearId, $term) {
    $totalFees = 0;
    $totalBursaries = 0;

    $rowData = [
        'school_name' => $school->name,
        'total_students' => getTotalStudentsBySchool($school->id),
    ];

    for ($i = 1; $i <= 4; $i++) {
        $fees = calculateTotalFees($school->id, $i, $term);
        $bursary = calculateTotalBursaryPaid($school->id, $i, $yearId, $term);
        $studentCountByForm = getTotalStudentsByForm($school->id, $i);

        $rowData["form{$i}_fees"] = $fees;
        $rowData["form{$i}_bursary"] = $bursary;
        $rowData["form{$i}_student_count"] = $studentCountByForm;

        $totalFees += $fees;
        $totalBursaries += $bursary;
        $totalStudent = $studentCountByForm;
    }

    $rowData['total_fees'] = $totalFees;
    $rowData['total_bursaries'] = $totalBursaries;

    return $rowData;
});

// Pass this data to the view



//get data for the entire year instead of just the first term or second or third term





$tableDataYear = $schools->map(function ($school) use ($yearId) {
    $totalFees = 0;
    $totalBursaries = 0;

    $perYear = [
        'school_name' => $school->name,
        'total_students' => getTotalStudentsBySchool($school->id),
    ];

    for ($i = 1; $i <= 4; $i++) {
        $fees = calculateTotalFeesForTheYear($school->id, $i);
        $bursary = calculateTotalBursaryPaidForTheYear($school->id, $i, $yearId);
        $studentCountByForm = getTotalStudentsByForm($school->id, $i);

        $perYear["form{$i}_fees"] = $fees;
        $perYear["form{$i}_bursary"] = $bursary;
        $perYear["form{$i}_student_count"] = $studentCountByForm;

        $totalFees += $fees;
        $totalBursaries += $bursary;
        $totalStudent = $studentCountByForm;
    }

    $perYear['total_fees'] = $totalFees;
    $perYear['total_bursaries'] = $totalBursaries;

    return $perYear;
});



// Pass this data to the view


// Pass this data to the view



// Pass this data to the view


    
    // Calculating total fees based on the student form
/*$totalFeesForm = Student::where('status', '1')
->where('on_scholarship', 'No')
->whereIn('school_id', $accessibleSchoolIds)
->with(['school'])
->get()
->sum(function ($student) use ($term3Percentage, $feePercentage) {
    $formFee = $student->form_id ? $student->school['f' . $student->form_id . '_fee'] : 0;
    return $formFee * $term3Percentage * $feePercentage;
});*/




    

        $disability = Student::with(['ward', 'stream', 'school', 'form', 'registered_by', 'approved_by'])
    ->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
        $query->where('id', $userId);
    })
    ->where('disability', 'Yes') // Add this line to filter by disability
    ->count();

    $scholarship = Student::with(['ward', 'stream', 'school', 'form', 'registered_by', 'approved_by'])
    ->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
        $query->where('id', $userId);
    })
    ->where('on_scholarship', 'Yes') // Add this line to filter by disability
    ->count();
    //school id
    
    //Number of Student who are approved for scholarships - Status is set to 1
    $status = Student::whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
        $query->where('id', $userId);
    })
    ->where('on_scholarship', 'No') // Add this line to filter on scholarship
    ->where('status', "Approved")
    ->count();
    
    $schoolId = Student::with(['ward', 'stream', 'school', 'form', 'registered_by', 'approved_by'])
    ->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
        $query->where('id', $userId);
    })
    ->get() // Get the collection of students
    ->pluck('school.id') // Pluck the school ids from the student's school relationship
    ->unique() // Remove any duplicate ids
    ->values(); // Re-index the collection

    $boys = Student::with(['ward', 'stream', 'school', 'form', 'registered_by', 'approved_by'])
    ->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
        $query->where('id', $userId);
    })
    ->where('gender', 'Male') // Add this line to filter by disability
    ->count();

    $girls = Student::with(['ward', 'stream', 'school', 'form', 'registered_by', 'approved_by'])
    ->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
        $query->where('id', $userId);
    })
    ->where('gender', 'Female') // Add this line to filter by disability
    ->count();


        $schoolClasses = StudentForm::withCount(['students' => function ($query) use ($userId) {
            $query->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
                $query->where('id', $userId);
            });
        }])->get();
        
        $wards = Ward::withCount(['students' => function ($query) use ($userId) {
            $query->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
                $query->where('id', $userId);
            });
        }])
        ->having('students_count', '>', 0)
        ->get();
      /*  $formStream = Student::select('form_id', 'stream_id', DB::raw('count(*) as student_count'))
    ->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
        $query->where('id', $userId);
    })
    ->groupBy('form_id', 'stream_id')
    ->get();*/
     
    $formStream = Student::select(
        'student_forms.name as form_name',
        'school_streams.name as stream_name',
        DB::raw('count(*) as student_count')
    )
    ->join('student_forms', 'students.form_id', '=', 'student_forms.id')
    ->join('school_streams', 'students.stream_id', '=', 'school_streams.id')
    ->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
        $query->where('users.id', $userId);
    })
    ->groupBy('student_forms.name', 'school_streams.name')
    ->get();
    
   // $user = auth()->user(); // Get the currently authenticated user

// Get the schools where the logged-in user has permissions
   // Assume $userId is the ID of the logged-in user
$user = User::find($userId);

// Get the school names associated with the user's permissions
$schoolNames = $user->schoolPermission()->with('schools')->get()->flatMap(function ($permission) {
    return $permission->schools->pluck('name');
})->unique();

   // Assuming $userId is the ID of the logged-in user
$students = Student::with(['ward', 'stream', 'school', 'form', 'registered_by', 'approved_by'])
->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
    $query->where('id', $userId);
})
->get();

//get student count by school

/*$studentCountsBySchool = Student::select('school_id', \DB::raw('count(*) as student_count'))
->selectRaw('SUM(CASE WHEN gender = "Male" THEN 1 ELSE 0 END) AS male_count')
->selectRaw('SUM(CASE WHEN gender = "Female" THEN 1 ELSE 0 END) AS female_count')

->groupBy('school_id')
->get();*/

$studentCountsBySchool =  Student::select('students.school_id', 'schools.fees')
->selectRaw('COUNT(students.id) as student_count')
->selectRaw('COUNT(DISTINCT sbr.admission_number_id) as student_bursary_count')
->selectRaw('SUM(sbr.amount_paid) as total_amount_paid')
->selectRaw('SUM(CASE WHEN students.gender = "Male" THEN 1 ELSE 0 END) AS male_count')
->selectRaw('SUM(CASE WHEN students.gender = "Female" THEN 1 ELSE 0 END) AS female_count')
->selectRaw('(schools.fees * 0.2 * count(*) * 0.7) as total_fees_required')
->leftJoin('schools', 'students.school_id', '=', 'schools.id')
->leftJoin(DB::raw('(SELECT admission_number_id, SUM(amount_paid) as amount_paid FROM student_bursary_registers GROUP BY admission_number_id) sbr'), 'students.id', '=', 'sbr.admission_number_id')
->where('students.on_scholarship', 'No') // Add this line to filter by 'No' on_scholarship
->where('students.status', 1)
->groupBy('students.school_id', 'schools.fees')
->get();


//get first term school fees based on some settings provided.

//Get the bursary Payment for each student







// Assuming $userId is the ID of the current user
// and that user has access to certain schools
// and you have a 'bursaries' relationship defined on the Student model
// which connects to the 'student_bursary_registers' table

$am_term = Student::query()
    ->select('school_id')
    ->selectRaw('SUM(student_bursary_registers.amount_paid) as total_bursary')
    ->join('student_bursary_registers', 'students.id', '=', 'student_bursary_registers.admission_number_id')
    ->join('schools', 'students.school_id', '=', 'schools.id')
    ->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
        $query->where('users.id', $userId);
    })
    ->where('Term', $term)
    ->where('on_scholarship','No')
    ->where('status', 1)
    ->groupBy('school_id')
    ->get();

$am_year = Student::query()
    ->select('school_id')
    ->selectRaw('SUM(student_bursary_registers.amount_paid) as total_bursary')
    ->join('student_bursary_registers', 'students.admission_number', '=', 'student_bursary_registers.admission_number_id')
    ->join('schools', 'students.school_id', '=', 'schools.id')
    ->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
        $query->where('users.id', $userId);
    })
    ->where('year_id', 1)
    ->groupBy('school_id')
    ->get();



$user = Auth::user();
$role = $user->roles->pluck('title');



$schoolName = $this->getSchoolName(); // Call the method

//$feesterm = totalFees($term);

$year = getCurrentYear();
$totalBursaryPaid = totalBursaryPaid($year, $term);

/* ################################
AN ALTERNATIVE

##########################*/
    

        return view('home', compact('tableDataYear','totalBursaryPaid','tableData','schoolName','role','term','status','studentCountsBySchool','am_term','am_year','schoolId','scholarship','boys','girls','disability','role','wards','students','totalRegisteredStudent','schoolClasses','formStream','schoolNames'));
    }
}
