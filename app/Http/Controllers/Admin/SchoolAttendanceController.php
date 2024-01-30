<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySchoolAttendanceRequest;
use App\Http\Requests\StoreSchoolAttendanceRequest;
use App\Http\Requests\UpdateSchoolAttendanceRequest;
use App\Models\School;
use App\Models\SchoolAttendance;
use App\Models\Student;
use App\Models\User;
use App\Models\Year;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SchoolAttendanceController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('school_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SchoolAttendance::with(['admission_number', 'year', 'prepared_by', 'confirmed_by', 'school_name'])->select(sprintf('%s.*', (new SchoolAttendance)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'school_attendance_show';
                $editGate      = 'school_attendance_edit';
                $deleteGate    = 'school_attendance_delete';
                $crudRoutePart = 'school-attendances';

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
            $table->addColumn('admission_number_admission_number', function ($row) {
                return $row->admission_number ? $row->admission_number->admission_number : '';
            });

            $table->addColumn('year_year', function ($row) {
                return $row->year ? $row->year->year : '';
            });

            $table->editColumn('school_term', function ($row) {
                return $row->school_term ? SchoolAttendance::SCHOOL_TERM_SELECT[$row->school_term] : '';
            });
            $table->addColumn('prepared_by_name', function ($row) {
                return $row->prepared_by ? $row->prepared_by->name : '';
            });

            $table->addColumn('confirmed_by_name', function ($row) {
                return $row->confirmed_by ? $row->confirmed_by->name : '';
            });

            $table->addColumn('school_name_name', function ($row) {
                return $row->school_name ? $row->school_name->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'admission_number', 'year', 'prepared_by', 'confirmed_by', 'school_name']);

            return $table->make(true);
        }

        $students = Student::get();
        $years    = Year::get();
        $users    = User::get();
        $schools  = School::get();

        return view('admin.schoolAttendances.index', compact('students', 'years', 'users', 'schools'));
    }

    public function create()
    {
        abort_if(Gate::denies('school_attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admission_numbers = Student::pluck('admission_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $years = Year::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        $school_names = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.schoolAttendances.create', compact('admission_numbers', 'school_names', 'years'));
    }

    public function store(StoreSchoolAttendanceRequest $request)
    {
        $schoolAttendance = SchoolAttendance::create($request->all());

        return redirect()->route('admin.school-attendances.index');
    }

    public function edit(SchoolAttendance $schoolAttendance)
    {
        abort_if(Gate::denies('school_attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admission_numbers = Student::pluck('admission_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $years = Year::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        $school_names = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $schoolAttendance->load('admission_number', 'year', 'prepared_by', 'confirmed_by', 'school_name');

        return view('admin.schoolAttendances.edit', compact('admission_numbers', 'schoolAttendance', 'school_names', 'years'));
    }

    public function update(UpdateSchoolAttendanceRequest $request, SchoolAttendance $schoolAttendance)
    {
        $schoolAttendance->update($request->all());

        return redirect()->route('admin.school-attendances.index');
    }

    public function show(SchoolAttendance $schoolAttendance)
    {
        abort_if(Gate::denies('school_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolAttendance->load('admission_number', 'year', 'prepared_by', 'confirmed_by', 'school_name');

        return view('admin.schoolAttendances.show', compact('schoolAttendance'));
    }

    public function destroy(SchoolAttendance $schoolAttendance)
    {
        abort_if(Gate::denies('school_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolAttendance->delete();

        return back();
    }

    public function massDestroy(MassDestroySchoolAttendanceRequest $request)
    {
        $schoolAttendances = SchoolAttendance::find(request('ids'));

        foreach ($schoolAttendances as $schoolAttendance) {
            $schoolAttendance->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
