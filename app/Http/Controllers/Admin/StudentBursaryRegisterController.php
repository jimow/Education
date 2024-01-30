<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStudentBursaryRegisterRequest;
use App\Http\Requests\StoreStudentBursaryRegisterRequest;
use App\Http\Requests\UpdateStudentBursaryRegisterRequest;
use App\Models\Student;
use App\Models\StudentBursaryRegister;
use App\Models\User;
use App\Models\School;
use App\Models\Year;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentBursaryRegisterController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('student_bursary_register_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = StudentBursaryRegister::with(['year', 'requested_by', 'authorized_by', 'admission_number'])->select(sprintf('%s.*', (new StudentBursaryRegister)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'student_bursary_register_show';
                $editGate      = 'student_bursary_register_edit';
                $deleteGate    = 'student_bursary_register_delete';
                $crudRoutePart = 'student-bursary-registers';

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
            $table->editColumn('term', function ($row) {
                return $row->term ? StudentBursaryRegister::TERM_SELECT[$row->term] : '';
            });
            $table->addColumn('year_year', function ($row) {
                return $row->year ? $row->year->year : '';
            });

            $table->editColumn('amount_paid', function ($row) {
                return $row->amount_paid ? $row->amount_paid : '';
            });
            $table->addColumn('requested_by_name', function ($row) {
                return $row->requested_by ? $row->requested_by->name : '';
            });

            $table->addColumn('authorized_by_name', function ($row) {
                return $row->authorized_by ? $row->authorized_by->name : '';
            });

            $table->addColumn('admission_number_admission_number', function ($row) {
                return $row->admission_number ? $row->admission_number->admission_number : '';
            });

            $table->editColumn('payment_code', function ($row) {
                return $row->payment_code ? $row->payment_code : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'year', 'requested_by', 'authorized_by', 'admission_number']);

            return $table->make(true);
        }

        return view('admin.studentBursaryRegisters.index');
    }
    
    public function create()
    {
        abort_if(Gate::denies('student_bursary_register_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       

        $years = Year::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        $requested_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $admission_numbers = Student::pluck('admission_number', 'id')->prepend(trans('global.pleaseSelect'), '');
        
      
            $schools = School::all(); // Fetch all schools. Adjust query as needed.
    
            
     
        return view('admin.studentBursaryRegisters.create', compact('schools','admission_numbers', 'requested_bies', 'years'));
    }

    public function store(StoreStudentBursaryRegisterRequest $request)
    {
        $studentBursaryRegister = StudentBursaryRegister::create($request->all());

        return redirect()->route('admin.student-bursary-registers.index');
    }

    public function edit(StudentBursaryRegister $studentBursaryRegister)
    {
        abort_if(Gate::denies('student_bursary_register_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $years = Year::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        $requested_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $admission_numbers = Student::pluck('admission_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $studentBursaryRegister->load('year', 'requested_by', 'authorized_by', 'admission_number');

        return view('admin.studentBursaryRegisters.edit', compact('admission_numbers', 'requested_bies', 'studentBursaryRegister', 'years'));
    }

    public function update(UpdateStudentBursaryRegisterRequest $request, StudentBursaryRegister $studentBursaryRegister)
    {
        $studentBursaryRegister->update($request->all());

        return redirect()->route('admin.student-bursary-registers.index');
    }

    public function show(StudentBursaryRegister $studentBursaryRegister)
    {
        abort_if(Gate::denies('student_bursary_register_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentBursaryRegister->load('year', 'requested_by', 'authorized_by', 'admission_number');

        return view('admin.studentBursaryRegisters.show', compact('studentBursaryRegister'));
    }

    public function destroy(StudentBursaryRegister $studentBursaryRegister)
    {
        abort_if(Gate::denies('student_bursary_register_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentBursaryRegister->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentBursaryRegisterRequest $request)
    {
        $studentBursaryRegisters = StudentBursaryRegister::find(request('ids'));

        foreach ($studentBursaryRegisters as $studentBursaryRegister) {
            $studentBursaryRegister->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function fetchCode(Request $request) {
        $term = $request->get('term');
        //Autocomplete payment_code from bursaries table using term
        $payment_codes = Allocation::where('payment_code', $term)->pluck('payment_code');
        

        return response()->json($payment_codes);
    }
    
    public function fetchAmount(Request $request) {
        $selectedItem = $request->get('selectedItem');
        // Query your database or data source to get the amount for the selected item
        //query bursaries table fetch amount_paid where payment_code is selected_item
        $amount = Bursary::where('payment_code', $selectedItem)->sum('amount_paid');
        return response()->json($amount);
    }
}
