<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStudentFormRequest;
use App\Http\Requests\StoreStudentFormRequest;
use App\Http\Requests\UpdateStudentFormRequest;
use App\Models\StudentForm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentFormController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('student_form_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = StudentForm::query()->select(sprintf('%s.*', (new StudentForm)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'student_form_show';
                $editGate      = 'student_form_edit';
                $deleteGate    = 'student_form_delete';
                $crudRoutePart = 'student-forms';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.studentForms.index');
    }

    public function create()
    {
        abort_if(Gate::denies('student_form_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.studentForms.create');
    }

    public function store(StoreStudentFormRequest $request)
    {
        $studentForm = StudentForm::create($request->all());

        return redirect()->route('admin.student-forms.index');
    }

    public function edit(StudentForm $studentForm)
    {
        abort_if(Gate::denies('student_form_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.studentForms.edit', compact('studentForm'));
    }

    public function update(UpdateStudentFormRequest $request, StudentForm $studentForm)
    {
        $studentForm->update($request->all());

        return redirect()->route('admin.student-forms.index');
    }

    public function show(StudentForm $studentForm)
    {
        abort_if(Gate::denies('student_form_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.studentForms.show', compact('studentForm'));
    }

    public function destroy(StudentForm $studentForm)
    {
        abort_if(Gate::denies('student_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentForm->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentFormRequest $request)
    {
        $studentForms = StudentForm::find(request('ids'));

        foreach ($studentForms as $studentForm) {
            $studentForm->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
