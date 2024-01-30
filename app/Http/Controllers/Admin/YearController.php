<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyYearRequest;
use App\Http\Requests\StoreYearRequest;
use App\Http\Requests\UpdateYearRequest;
use App\Models\Year;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class YearController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('year_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Year::query()->select(sprintf('%s.*', (new Year)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'year_show';
                $editGate      = 'year_edit';
                $deleteGate    = 'year_delete';
                $crudRoutePart = 'years';

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
            $table->editColumn('year', function ($row) {
                return $row->year ? $row->year : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.years.index');
    }

    public function create()
    {
        abort_if(Gate::denies('year_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.years.create');
    }

    public function store(StoreYearRequest $request)
    {
        $year = Year::create($request->all());

        return redirect()->route('admin.years.index');
    }

    public function edit(Year $year)
    {
        abort_if(Gate::denies('year_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.years.edit', compact('year'));
    }

    public function update(UpdateYearRequest $request, Year $year)
    {
        $year->update($request->all());

        return redirect()->route('admin.years.index');
    }

    public function show(Year $year)
    {
        abort_if(Gate::denies('year_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.years.show', compact('year'));
    }

    public function destroy(Year $year)
    {
        abort_if(Gate::denies('year_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $year->delete();

        return back();
    }

    public function massDestroy(MassDestroyYearRequest $request)
    {
        $years = Year::find(request('ids'));

        foreach ($years as $year) {
            $year->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
