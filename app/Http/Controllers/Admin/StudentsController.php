<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyStudentRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\School;
use App\Models\SchoolStream;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\StudentForm;
use App\Models\User;
use App\Models\Ward;
use App\Models\Allocation;
use App\Models\StudentBursaryRegister;
use App\Models\Functions;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Student::with(['ward', 'stream', 'school', 'form', 'registered_by', 'approved_by'])->select(sprintf('%s.*', (new Student)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'student_show';
                $editGate      = 'student_edit';
                $deleteGate    = 'student_delete';
                $crudRoutePart = 'students';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
          
            $table->editColumn('fullname', function ($row) {
                return $row->fullname ? $row->fullname : '';
            });
            $table->editColumn('gender', function ($row) {
                return $row->gender ? Student::GENDER_SELECT[$row->gender] : '';
            });

            $table->addColumn('ward_name', function ($row) {
                return $row->ward ? $row->ward->name : '';
            });

            $table->editColumn('nemis_number', function ($row) {
                return $row->nemis_number ? $row->nemis_number : '';
            });
            $table->editColumn('admission_number', function ($row) {
                return $row->admission_number ? $row->admission_number : '';
            });
            $table->editColumn('on_scholarship', function ($row) {
                return $row->on_scholarship ? Student::ON_SCHOLARSHIP_SELECT[$row->on_scholarship] : '';
            });
            $table->editColumn('scholarship_amount', function ($row) {
                return $row->scholarship_amount ? $row->scholarship_amount : '';
            });
            $table->editColumn('scholarship_donor', function ($row) {
                return $row->scholarship_donor ? $row->scholarship_donor : '';
            });
            $table->editColumn('disability', function ($row) {
                return $row->disability ? Student::DISABILITY_SELECT[$row->disability] : '';
            });
            $table->editColumn('parental_status', function ($row) {
                return $row->parental_status ? Student::PARENTAL_STATUS_SELECT[$row->parental_status] : '';
            });
            $table->editColumn('father_fullname', function ($row) {
                return $row->father_fullname ? $row->father_fullname : '';
            });
            $table->editColumn('father_phone_number', function ($row) {
                return $row->father_phone_number ? $row->father_phone_number : '';
            });
            $table->editColumn('father_death_certificate', function ($row) {
                if ($photo = $row->father_death_certificate) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('mother_fullname', function ($row) {
                return $row->mother_fullname ? $row->mother_fullname : '';
            });
            $table->editColumn('mother_phone_number', function ($row) {
                return $row->mother_phone_number ? $row->mother_phone_number : '';
            });
            $table->editColumn('mother_death_certificate', function ($row) {
                if ($photo = $row->mother_death_certificate) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('photo', function ($row) {
                if ($photo = $row->photo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->addColumn('stream_name', function ($row) {
                return $row->stream ? $row->stream->name : '';
            });

            $table->addColumn('school_name', function ($row) {
                return $row->school ? $row->school->name : '';
            });

            $table->addColumn('form_name', function ($row) {
                return $row->form ? $row->form->name : '';
            });

            $table->editColumn('birth_certificate', function ($row) {
                return $row->birth_certificate ? '<a href="' . $row->birth_certificate->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('birth_certificate_number', function ($row) {
                return $row->birth_certificate_number ? $row->birth_certificate_number : '';
            });
            $table->editColumn('father_national_id_no', function ($row) {
                return $row->father_national_id_no ? $row->father_national_id_no : '';
            });
            $table->editColumn('mother_national_id_no', function ($row) {
                return $row->mother_national_id_no ? $row->mother_national_id_no : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Student::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('day_scholar', function ($row) {
                return $row->day_scholar ? Student::DAY_SCHOLAR_SELECT[$row->day_scholar] : '';
            });
            $table->addColumn('registered_by_name', function ($row) {
                return $row->registered_by ? $row->registered_by->name : '';
            });

            $table->addColumn('approved_by_name', function ($row) {
                return $row->approved_by ? $row->approved_by->name : '';
            });

            $table->editColumn('guardian_fullname', function ($row) {
                return $row->guardian_fullname ? $row->guardian_fullname : '';
            });
            $table->editColumn('guardian_phone_number', function ($row) {
                return $row->guardian_phone_number ? $row->guardian_phone_number : '';
            });
            $table->editColumn('guardian_national', function ($row) {
                return $row->guardian_national ? $row->guardian_national : '';
            });
            $table->editColumn('other_documents', function ($row) {
                if (! $row->other_documents) {
                    return '';
                }
                $links = [];
                foreach ($row->other_documents as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'ward', 'father_death_certificate', 'mother_death_certificate', 'photo', 'stream', 'school', 'form', 'birth_certificate', 'registered_by', 'approved_by', 'other_documents']);

            return $table->make(true);
        }

        $wards          = Ward::get();
        $school_streams = SchoolStream::get();
        $schools        = School::get();
        $student_forms  = StudentForm::get();
        $users          = User::get();

        return view('admin.students.index', compact('wards', 'school_streams', 'schools', 'student_forms', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('student_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $wards = Ward::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $streams = SchoolStream::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        //$schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $userId = auth()->id(); // Retrieve the logged-in user's ID

        $schools = School::whereHas('schoolPermissions.users', function ($query) use ($userId) {
            $query->where('id', $userId);
        })->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $forms = StudentForm::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.students.create', compact('forms', 'schools', 'streams', 'wards'));
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->all());

        if ($request->input('father_death_certificate', false)) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('father_death_certificate'))))->toMediaCollection('father_death_certificate');
        }

        if ($request->input('mother_death_certificate', false)) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('mother_death_certificate'))))->toMediaCollection('mother_death_certificate');
        }

        if ($request->input('photo', false)) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($request->input('birth_certificate', false)) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('birth_certificate'))))->toMediaCollection('birth_certificate');
        }

        foreach ($request->input('other_documents', []) as $file) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('other_documents');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $student->id]);
        }

        return redirect()->route('admin.students.index');
    }

    public function edit(Student $student)
    {
        abort_if(Gate::denies('student_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $wards = Ward::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $streams = SchoolStream::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $forms = StudentForm::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $student->load('ward', 'stream', 'school', 'form', 'registered_by', 'approved_by');

        return view('admin.students.edit', compact('forms', 'schools', 'streams', 'student', 'wards'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {

        $form = $request->form_id;
        $id = $request->school_id;
        
        $schid = School::find($id);//>code;
        $adm = $request->admission_number;
        $code = $schid->code;

        $current_year = date("y");
        if ($form == 1) {
            $year = $current_year;
        }
        if ($form == 2) {
            $year = $current_year - 1;
        }
        if ($form == 3) {
            $year = $current_year - 2;

        }
        if ($form == 4) {
            $year = $current_year - 3;
        }
        //$request->admission_number = $code."-".$adm."/".$year;
        $request->merge(['admission_number' => $code . "-" . $adm . "/" . $year]);

        if (empty($request->mother_fullname)) {
            $request->merge([
                'mother_fullname' =>'NA'
            ]);
        }
        if (empty($request->mother_phone_number)) {
            $request->merge([
                'mother_phone_number' =>'NA'
            ]);
        }
        $student->update($request->all());

        if ($request->input('father_death_certificate', false)) {
            if (! $student->father_death_certificate || $request->input('father_death_certificate') !== $student->father_death_certificate->file_name) {
                if ($student->father_death_certificate) {
                    $student->father_death_certificate->delete();
                }
                $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('father_death_certificate'))))->toMediaCollection('father_death_certificate');
            }
        } elseif ($student->father_death_certificate) {
            $student->father_death_certificate->delete();
        }

        if ($request->input('mother_death_certificate', false)) {
            if (! $student->mother_death_certificate || $request->input('mother_death_certificate') !== $student->mother_death_certificate->file_name) {
                if ($student->mother_death_certificate) {
                    $student->mother_death_certificate->delete();
                }
                $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('mother_death_certificate'))))->toMediaCollection('mother_death_certificate');
            }
        } elseif ($student->mother_death_certificate) {
            $student->mother_death_certificate->delete();
        }

        if ($request->input('photo', false)) {
            if (! $student->photo || $request->input('photo') !== $student->photo->file_name) {
                if ($student->photo) {
                    $student->photo->delete();
                }
                $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($student->photo) {
            $student->photo->delete();
        }

        if ($request->input('birth_certificate', false)) {
            if (! $student->birth_certificate || $request->input('birth_certificate') !== $student->birth_certificate->file_name) {
                if ($student->birth_certificate) {
                    $student->birth_certificate->delete();
                }
                $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('birth_certificate'))))->toMediaCollection('birth_certificate');
            }
        } elseif ($student->birth_certificate) {
            $student->birth_certificate->delete();
        }

        if (count($student->other_documents) > 0) {
            foreach ($student->other_documents as $media) {
                if (! in_array($media->file_name, $request->input('other_documents', []))) {
                    $media->delete();
                }
            }
        }
        $media = $student->other_documents->pluck('file_name')->toArray();
        foreach ($request->input('other_documents', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $student->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('other_documents');
            }
        }

        return redirect()->route('admin.students.index');
    }

    public function show(Student $student)
    {
        abort_if(Gate::denies('student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->load('ward', 'stream', 'school', 'form', 'registered_by', 'approved_by');

        return view('admin.students.show', compact('student'));
    }

    public function destroy(Student $student)
    {
        abort_if(Gate::denies('student_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentRequest $request)
    {
        $students = Student::find(request('ids'));

        foreach ($students as $student) {
            $student->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('student_create') && Gate::denies('student_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Student();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }


    public function getStudents() {
        $userId = auth()->id(); // or however you get the logged-in user's ID

        $students = Student::whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
            $query->where('id', $userId)
                  ->where('status', 0);
        })->get();
        return view('admin.students.approval_list', compact('students'));
    }
    

    public function getStreams(Request $request)
    {
       
            $schoolId = $request->input('school_id');
           
           
    
            $streams = SchoolStream::where('school_id', $schoolId)->get();
            
            return response()->json($streams);
      
        
    }



    public function getStudentDetails($admission_number)
    {
    $student = Student::where('id', $admission_number)->first();

    if (!$student) {
        return response()->json(['message' => 'Student not found'], 404);
    }

    // Return all fields or a subset as required
    return response()->json($student);
    }

    public function getPaymentDetails($id)
    {
    $alloc = Allocation::where('id', $id)->first();

    $code = getPaymentCode($id);

    $totalAmount = getTotalAmountPaid($code);

    if (!$alloc) {
        return response()->json(['message' => 'Student not found'], 404);
    }

    // Return all fields or a subset as required
    $responseData = [
        'allocation' => $alloc,
        'totalAmount' => $totalAmount
    ];

    // Return the response
    return response()->json($responseData);
}


    public function getStudentFees($admission_number)
    {
        $bal = checkFeesBalance($admission_number, 0, 'Term 3', 2023);

    
    $student = Student::where('id', $admission_number)->first();
    $student->push($bal);
    
    if (!$student) {
        return response()->json(['message' => 'Student not found'], 404);
    }

    // Return all fields or a subset as required
    return response()->json([$student,$bal]);
    }

    public function showBulkPaymentsPage() {
        $schools = School::all(); // Fetch schools or any other necessary data
        $schoolNameToIdMap = getSchoolNameIdMap(); // Call your function here
        $totalStudent = getTotalStudentsByForm(1,2);
         $allocations = Allocation::pluck('payment_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.students.bulk-payments', compact('schools','totalStudent','schoolNameToIdMap','allocations'));
    }
    
    //write a function named getFeesAjax that receives dataToSend var from an ajax
    public function getFeesAjax(Request $request) {
     $data = json_decode($request->getContent(), true);

     // Extract school_id and form_id from the received data
     $school_id = $data['dataToSend']['schoolId'] ?? null;
     $form_id = $data['dataToSend']['form_id'] ?? null;
     $term = getCurrentTermOrHoliday();
     // Get fees based on school_id and form_id
     $fees = calculateBursaryFee($school_id, $form_id, $term);

     // Return the fees as a response
     return response()->json([
         'fees' => $fees
     ]);
    }

    public function calculateFees($school_id, $form_id) {
          
        $fees = $school_id + $form_id;

        return $fees;
    }
    /*public function postBulk(Request $request) {

    
      $tableData = $request->input('tableData');
      
      
      $processedData = [];
      $fees = 0;
      $studentCounts = 0;
      $schid = 0;
      $form_id = 0;
    foreach ($tableData as $data) {
        $schoolName = $data['schoolName'];  // Extract school name
        $formData = $data['formsData'];     // Extract form data
        $schid = getSchoolID($schoolName);
        foreach ($formData as $formKey => $formValue) {
        //get all the admission of all students whose school is id and 
        if ($form == 'F1') {
         $form_id = 1;
        }
        elseif ($form== 'F2') {
         $form_id = 2;
        }

        elseif ($form== 'F3') {
         $form_id = 3;
        }
        else {
         $form_id = 4;
        }
        //get the 
        $am = $formValue
       
        $studentCount = Student::where('school_id',$schid)->where('form_id', $form_id)->count();

        //get the fees for each student
       // $fees = $am / $studentCount;
        
     
        $students = Student::where('school_id', $schid)->where('form_id', $form_id)->get();
        foreach($students as $st) {
        $student_id = $s->id;
       
        $bursaryRegister = new BursaryRegister();
        $bursaryRegister->term = 3 ;/* term value ;
        $bursaryRegister->year = 2023;
        $bursaryRegister->admission_number_id = $student_id;
        $bursaryRegister->amount = $am;
        $bursaryRegister->save();
        }
        
            if ($formValue !== null) {
                // Process each non-null form value
                $processedData[] = [
                    'schoolName' => $schoolName,
                    'schoolId' => $schid,
                    'form' => $formKey,
                    'value' => $formValue
                ];
               
            }
        }
    }

    // Return the response as JSON
    return response()->json([
        'message' => 'Data processed successfully',
        'processedData' => $processedData
    ]);
  
      //return response()->json(['message' => $tableData, 'test' => 'TEST','AnotherTest' => 'This is Another Test']);
  }*/
  
  public function postBulk(Request $request) {
    $tableData = $request->input('tableData');

    foreach ($tableData as $data) {
        $schoolName = $data['schoolName'];
        $formData = $data['formsData'];

        // Fetch school details
        $school = DB::table('schools')->where('name', $schoolName)->first();
        $schid = $school->id;
        $code = $data['code'];

        // FormKey mapping
        $formKeyMapping = ['F1' => 1, 'F2' => 2, 'F3' => 3, 'F4' => 4];

        foreach ($formData as $formKey => $formValue) {
            // Map formKey ('F1', 'F2', ...) to numeric form (1, 2, ...)
            $formKey = $formKeyMapping[$formKey] ?? 4;

            // Retrieve students for this form and school with status 'Approved' and on_scholarship 'Yes'
            $students = Student::where('school_id', $schid)
                                ->where('form_id', $formKey)
                                ->where('status', 'Approved')
                                ->where('on_scholarship', 'No')
                                ->get();

            $studentCount = $students->count();
            $valuePerStudent = $studentCount > 0 ? $formValue / $studentCount : 0;

            foreach ($students as $student) {
                if ($valuePerStudent > 0) {
                    // Create a new BursaryRegister record for each student only if valuePerStudent is greater than 0
                    $bursaryRegister = new StudentBursaryRegister();
                    $bursaryRegister->term = getCurrentTermOrHoliday(); // Replace with actual term if needed
                    $bursaryRegister->year_id = getCurrentYear(); // Replace with actual year if needed
                    $bursaryRegister->admission_number_id = $student->id; // Use the student's ID
                    $bursaryRegister->amount_paid = $valuePerStudent;
                    $bursaryRegister->payment_code = getPaymentCode($code);
                    $bursaryRegister->save();
                }
            }
        }
    }

    return response()->json(['message' => 'Data processed successfully']);
}


    
    public function getStudentBulk(Request $request) {
        $selectedSchools = $request->input('selectedSchools'); // This should be an associative array with school IDs as keys and arrays of selected form IDs as values
        
        if (!is_array($selectedSchools)) {
            return response()->json(['error' => 'Invalid data format'], 400); // Bad request
        }
        
        $dataForTable = [];
    
        foreach ($selectedSchools as $schoolId => $forms) {
            $school = School::find($schoolId);
            if (!$school) {
                continue; // If the school is not found, skip to the next iteration
            }

            $studentCounts = [];

            foreach ($forms as $formId) {
                $feePerStudent = $this->getFeeForForm($formId);
                $studentCount = Student::where('school_id', $schoolId)
                                       ->where('form_id', $formId)
                                       ->count();
    
                $studentCounts["F$formId"] = $studentCount; // Add the student count for each form
    
                //$totalFees += $feePerStudent * $studentCount;
                //$totalPaid += $this->getTotalPaidForForm($schoolId, $formId);
            }
    
            $rowData = [
                'schoolName' => $school->name,
                'schoolId' => $schoolId,
                'selectedForms' => $forms,
                'counts'=>$studentCounts,
                'finalColumnData' => 'Some data' // Replace with actual data you want to show in the final column
            ];
    
            $dataForTable[] = $rowData;
        }
    
        return response()->json($dataForTable);
    }

   /* public function getStudentBulk(Request $request) {
        $selectedSchools = $request->json()->get('selectedSchools');
    
        $dataForTable = [];
    
        foreach ($selectedSchools as $schoolId => $forms) {
            $school = School::find($schoolId);
            if (!$school) {
                continue; // Skip if the school is not found
            }
    
            $totalFees = 0;
            $totalPaid = 0;
    
            foreach ($forms as $formId) {
                // Assuming there's a method to get the fee for each form
               // $feePerStudent = $this->getFeeForForm($formId);
    
                // Count the number of students in this form at this school
                $studentCount = Student::where('school_id', $schoolId)
                                       ->where('form_id', $formId)
                                       ->count();
    
              ///  $totalFees += $feePerStudent * $studentCount;
    
                // Assuming there's a method to get the total paid amount for the form
              //  $totalPaid += $this->getTotalPaidForForm($schoolId, $formId);
            }
    
            $rowData = [
                'schoolName' => $school->name,
                'schoolId' => $schoolId,
                'selectedForms' => $forms,
                'totalFees' => 0,
                'totalPaid' => 0,
                'count' => $studentCount,
                // ... other data
            ];
    
            $dataForTable[] = $rowData;
        }
        return response()->json($dataForTable);
    }*/
    
    private function getFeeForForm($formId) {
        return 0; // Implement logic to get fee amount per student for the form
    }
    
    private function getTotalPaidForForm($schoolId, $formId) {
        return 0;// Implement logic to get total payment made for the form
    }
    
    public function scholarshipCount()
     {
        $userId = auth()->id();
        $scholarshipCount = Student::with(['ward', 'stream', 'school', 'form', 'registered_by', 'approved_by'])
        ->whereHas('school.schoolPermissions.users', function ($query) use ($userId) {
            $query->where('id', $userId);
        })
        ->where('on_scholarship', 'Yes') // Add this line to filter by disability
        ->get();
    return response()->json(['data2' => $scholarshipCount]);
    }


    //################################ _________________REPORTS_____________________################################


    public function showReportForm()
    {
        $wards = Ward::all();
        $schools = School::all();
        $forms = StudentForm::all();

        return view('admin.students.report', compact('wards', 'schools', 'forms'));
    }

    public function generateReport(Request $request)
    {
           // Implement your logic to fetch and filter students based on the request parameters
           $wardId = $request->input('ward_id');
           $schoolId = $request->input('school_id');
           $gender = $request->input('gender');
           $formId = $request->input('form_id');
   
           $students = Student::when(!is_null($wardId), function ($query) use ($wardId) {
               return $query->where('ward_id', $wardId);
           })->when(!is_null($schoolId), function ($query) use ($schoolId) {
               return $query->where('school_id', $schoolId);
           })->when(!is_null($gender), function ($query) use ($gender) {
               return $query->where('gender', $gender);
           })->when(!is_null($formId), function ($query) use ($formId) {
               return $query->where('form_id', $formId);
           })->get();
   
           // Transform names for privacy
           $students = $students->map(function ($student) {
               $student->fullname = $this->maskName($student->fullname);
               return $student;
           });
   
           return response()->json(['students' => $students]);
       }
   
       // Helper method to mask names with multiple words
      // Helper method to mask names with multiple words
      private function maskName($name)
      {
          $words = explode(' ', $name);
          $maskedWords = array_map(function ($word) {
              $length = strlen($word);
              $maskedPart = substr($word, 0, 2) . str_repeat('X', max(0, $length - 2));
              
              // Debugging: Log the original and masked parts
              \Log::info("Original: $word, Masked: $maskedPart");
      
              return $maskedPart;
          }, $words);
      
          return implode(' ', $maskedWords);
      }


}
