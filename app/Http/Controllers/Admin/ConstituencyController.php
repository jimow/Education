<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyConstituencyRequest;
use App\Http\Requests\StoreConstituencyRequest;
use App\Http\Requests\UpdateConstituencyRequest;
use App\Models\Constituency;
use App\Models\County;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ConstituencyController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('constituency_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Constituency::with(['county'])->select(sprintf('%s.*', (new Constituency)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'constituency_show';
                $editGate      = 'constituency_edit';
                $deleteGate    = 'constituency_delete';
                $crudRoutePart = 'constituencies';

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
            $table->addColumn('county_name', function ($row) {
                return $row->county ? $row->county->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'county']);

            return $table->make(true);
        }

        $counties = County::get();

        return view('admin.constituencies.index', compact('counties'));
    }

    public function create()
    {
        abort_if(Gate::denies('constituency_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $counties = County::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.constituencies.create', compact('counties'));
    }

    public function store(StoreConstituencyRequest $request)
    {
        $constituency = Constituency::create($request->all());

        return redirect()->route('admin.constituencies.index');
    }

    public function edit(Constituency $constituency)
    {
        abort_if(Gate::denies('constituency_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $counties = County::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $constituency->load('county');

        return view('admin.constituencies.edit', compact('constituency', 'counties'));
    }

    public function update(UpdateConstituencyRequest $request, Constituency $constituency)
    {
        $constituency->update($request->all());

        return redirect()->route('admin.constituencies.index');
    }

    public function show(Constituency $constituency)
    {
        abort_if(Gate::denies('constituency_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $constituency->load('county');

        return view('admin.constituencies.show', compact('constituency'));
    }

    public function destroy(Constituency $constituency)
    {
        abort_if(Gate::denies('constituency_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $constituency->delete();

        return back();
    }

    public function massDestroy(MassDestroyConstituencyRequest $request)
    {
        $constituencies = Constituency::find(request('ids'));

        foreach ($constituencies as $constituency) {
            $constituency->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
