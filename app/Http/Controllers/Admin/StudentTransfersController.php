<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStudentTransferRequest;
use App\Http\Requests\StoreStudentTransferRequest;
use App\Http\Requests\UpdateStudentTransferRequest;
use App\Models\Principal;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentTransfer;
use App\Models\User;
use App\Models\Year;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentTransfersController extends Controller
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

        $years    = Year::get();
        $users    = User::get();
        $students = Student::get();

        return view('admin.studentBursaryRegisters.index', compact('years', 'users', 'students'));
    }


    public function create()
    {
        abort_if(Gate::denies('student_transfer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admission_numbers = Student::pluck('admission_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $trasnsfer_froms = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $transfer_tos = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $confirmed_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.studentTransfers.create', compact('admission_numbers', 'confirmed_bies', 'transfer_tos', 'trasnsfer_froms'));
    }

    public function store(StoreStudentTransferRequest $request)
    {
        $studentTransfer = StudentTransfer::create($request->all());

        return redirect()->route('admin.student-transfers.index');
    }

    public function edit(StudentTransfer $studentTransfer)
    {
        abort_if(Gate::denies('student_transfer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admission_numbers = Student::pluck('admission_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $trasnsfer_froms = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $transfer_tos = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $confirmed_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $studentTransfer->load('admission_number', 'trasnsfer_from', 'transfer_to', 'principal_approval_transfer_from', 'principal_approval_transfer_to', 'initiated_by', 'confirmed_by', 'authorized_by');

        return view('admin.studentTransfers.edit', compact('admission_numbers', 'confirmed_bies', 'studentTransfer', 'transfer_tos', 'trasnsfer_froms'));
    }

    public function update(UpdateStudentTransferRequest $request, StudentTransfer $studentTransfer)
    {
        $studentTransfer->update($request->all());

        return redirect()->route('admin.student-transfers.index');
    }

    public function show(StudentTransfer $studentTransfer)
    {
        abort_if(Gate::denies('student_transfer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentTransfer->load('admission_number', 'trasnsfer_from', 'transfer_to', 'principal_approval_transfer_from', 'principal_approval_transfer_to', 'initiated_by', 'confirmed_by', 'authorized_by');

        return view('admin.studentTransfers.show', compact('studentTransfer'));
    }

    public function destroy(StudentTransfer $studentTransfer)
    {
        abort_if(Gate::denies('student_transfer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentTransfer->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentTransferRequest $request)
    {
        $studentTransfers = StudentTransfer::find(request('ids'));

        foreach ($studentTransfers as $studentTransfer) {
            $studentTransfer->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
