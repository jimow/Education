<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySchoolGenderTypeRequest;
use App\Http\Requests\StoreSchoolGenderTypeRequest;
use App\Http\Requests\UpdateSchoolGenderTypeRequest;
use App\Models\SchoolGenderType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SchoolGenderTypeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('school_gender_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SchoolGenderType::query()->select(sprintf('%s.*', (new SchoolGenderType)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'school_gender_type_show';
                $editGate      = 'school_gender_type_edit';
                $deleteGate    = 'school_gender_type_delete';
                $crudRoutePart = 'school-gender-types';

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
            $table->editColumn('gender_type', function ($row) {
                return $row->gender_type ? $row->gender_type : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.schoolGenderTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('school_gender_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.schoolGenderTypes.create');
    }

    public function store(StoreSchoolGenderTypeRequest $request)
    {
        $schoolGenderType = SchoolGenderType::create($request->all());

        return redirect()->route('admin.school-gender-types.index');
    }

    public function edit(SchoolGenderType $schoolGenderType)
    {
        abort_if(Gate::denies('school_gender_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.schoolGenderTypes.edit', compact('schoolGenderType'));
    }

    public function update(UpdateSchoolGenderTypeRequest $request, SchoolGenderType $schoolGenderType)
    {
        $schoolGenderType->update($request->all());

        return redirect()->route('admin.school-gender-types.index');
    }

    public function show(SchoolGenderType $schoolGenderType)
    {
        abort_if(Gate::denies('school_gender_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.schoolGenderTypes.show', compact('schoolGenderType'));
    }

    public function destroy(SchoolGenderType $schoolGenderType)
    {
        abort_if(Gate::denies('school_gender_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolGenderType->delete();

        return back();
    }

    public function massDestroy(MassDestroySchoolGenderTypeRequest $request)
    {
        $schoolGenderTypes = SchoolGenderType::find(request('ids'));

        foreach ($schoolGenderTypes as $schoolGenderType) {
            $schoolGenderType->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
