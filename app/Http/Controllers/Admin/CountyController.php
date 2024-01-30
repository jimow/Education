<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCountyRequest;
use App\Http\Requests\StoreCountyRequest;
use App\Http\Requests\UpdateCountyRequest;
use App\Models\County;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CountyController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('county_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = County::query()->select(sprintf('%s.*', (new County)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'county_show';
                $editGate      = 'county_edit';
                $deleteGate    = 'county_delete';
                $crudRoutePart = 'counties';

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

        return view('admin.counties.index');
    }

    public function create()
    {
        abort_if(Gate::denies('county_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.counties.create');
    }

    public function store(StoreCountyRequest $request)
    {
        $county = County::create($request->all());

        return redirect()->route('admin.counties.index');
    }

    public function edit(County $county)
    {
        abort_if(Gate::denies('county_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.counties.edit', compact('county'));
    }

    public function update(UpdateCountyRequest $request, County $county)
    {
        $county->update($request->all());

        return redirect()->route('admin.counties.index');
    }

    public function show(County $county)
    {
        abort_if(Gate::denies('county_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.counties.show', compact('county'));
    }

    public function destroy(County $county)
    {
        abort_if(Gate::denies('county_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $county->delete();

        return back();
    }

    public function massDestroy(MassDestroyCountyRequest $request)
    {
        $counties = County::find(request('ids'));

        foreach ($counties as $county) {
            $county->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
