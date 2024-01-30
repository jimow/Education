<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySchoolCategoryRequest;
use App\Http\Requests\StoreSchoolCategoryRequest;
use App\Http\Requests\UpdateSchoolCategoryRequest;
use App\Models\SchoolCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SchoolCategoryController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('school_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SchoolCategory::query()->select(sprintf('%s.*', (new SchoolCategory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'school_category_show';
                $editGate      = 'school_category_edit';
                $deleteGate    = 'school_category_delete';
                $crudRoutePart = 'school-categories';

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
            $table->editColumn('category_name', function ($row) {
                return $row->category_name ? $row->category_name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.schoolCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('school_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.schoolCategories.create');
    }

    public function store(StoreSchoolCategoryRequest $request)
    {
        $schoolCategory = SchoolCategory::create($request->all());

        return redirect()->route('admin.school-categories.index');
    }

    public function edit(SchoolCategory $schoolCategory)
    {
        abort_if(Gate::denies('school_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.schoolCategories.edit', compact('schoolCategory'));
    }

    public function update(UpdateSchoolCategoryRequest $request, SchoolCategory $schoolCategory)
    {
        $schoolCategory->update($request->all());

        return redirect()->route('admin.school-categories.index');
    }

    public function show(SchoolCategory $schoolCategory)
    {
        abort_if(Gate::denies('school_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.schoolCategories.show', compact('schoolCategory'));
    }

    public function destroy(SchoolCategory $schoolCategory)
    {
        abort_if(Gate::denies('school_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroySchoolCategoryRequest $request)
    {
        $schoolCategories = SchoolCategory::find(request('ids'));

        foreach ($schoolCategories as $schoolCategory) {
            $schoolCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
