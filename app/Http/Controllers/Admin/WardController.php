<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyWardRequest;
use App\Http\Requests\StoreWardRequest;
use App\Http\Requests\UpdateWardRequest;
use App\Models\Constituency;
use App\Models\Ward;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WardController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('ward_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Ward::with(['constituency'])->select(sprintf('%s.*', (new Ward)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'ward_show';
                $editGate      = 'ward_edit';
                $deleteGate    = 'ward_delete';
                $crudRoutePart = 'wards';

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
            $table->addColumn('constituency_name', function ($row) {
                return $row->constituency ? $row->constituency->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'constituency']);

            return $table->make(true);
        }

        $constituencies = Constituency::get();

        return view('admin.wards.index', compact('constituencies'));
    }

    public function create()
    {
        abort_if(Gate::denies('ward_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $constituencies = Constituency::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.wards.create', compact('constituencies'));
    }

    public function store(StoreWardRequest $request)
    {
        $ward = Ward::create($request->all());

        return redirect()->route('admin.wards.index');
    }

    public function edit(Ward $ward)
    {
        abort_if(Gate::denies('ward_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $constituencies = Constituency::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ward->load('constituency');

        return view('admin.wards.edit', compact('constituencies', 'ward'));
    }

    public function update(UpdateWardRequest $request, Ward $ward)
    {
        $ward->update($request->all());

        return redirect()->route('admin.wards.index');
    }

    public function show(Ward $ward)
    {
        abort_if(Gate::denies('ward_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ward->load('constituency');

        return view('admin.wards.show', compact('ward'));
    }

    public function destroy(Ward $ward)
    {
        abort_if(Gate::denies('ward_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ward->delete();

        return back();
    }

    public function massDestroy(MassDestroyWardRequest $request)
    {
        $wards = Ward::find(request('ids'));

        foreach ($wards as $ward) {
            $ward->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
