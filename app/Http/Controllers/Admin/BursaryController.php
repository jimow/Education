<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBursaryRequest;
use App\Http\Requests\StoreBursaryRequest;
use App\Http\Requests\UpdateBursaryRequest;
use App\Models\Bursary;
use App\Models\School;
use App\Models\Year;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BursaryController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('bursary_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Bursary::with(['school', 'year'])->select(sprintf('%s.*', (new Bursary)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'bursary_show';
                $editGate      = 'bursary_edit';
                $deleteGate    = 'bursary_delete';
                $crudRoutePart = 'bursaries';

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
            $table->addColumn('school_name', function ($row) {
                return $row->school ? $row->school->name : '';
            });

            $table->editColumn('school.phone_number', function ($row) {
                return $row->school ? (is_string($row->school) ? $row->school : $row->school->phone_number) : '';
            });
            $table->editColumn('school.email', function ($row) {
                return $row->school ? (is_string($row->school) ? $row->school : $row->school->email) : '';
            });
            $table->editColumn('school.postal_address', function ($row) {
                return $row->school ? (is_string($row->school) ? $row->school : $row->school->postal_address) : '';
            });
            $table->editColumn('school_term', function ($row) {
                return $row->school_term ? Bursary::SCHOOL_TERM_SELECT[$row->school_term] : '';
            });
            $table->addColumn('year_year', function ($row) {
                return $row->year ? $row->year->year : '';
            });

            $table->editColumn('amount_paid', function ($row) {
                return $row->amount_paid ? $row->amount_paid : '';
            });
            $table->editColumn('cheque_no', function ($row) {
                return $row->cheque_no ? $row->cheque_no : '';
            });
            $table->editColumn('payment_code', function ($row) {
                return $row->payment_code ? $row->payment_code : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'school', 'year']);

            return $table->make(true);
        }

        $schools = School::get();
        $years   = Year::get();

        return view('admin.bursaries.index', compact('schools', 'years'));
    }

    public function create()
    {
        abort_if(Gate::denies('bursary_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $years = Year::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.bursaries.create', compact('schools', 'years'));
    }

    public function store(StoreBursaryRequest $request)
    {
        $bursary = Bursary::create($request->all());

        return redirect()->route('admin.bursaries.index');
    }

    public function edit(Bursary $bursary)
    {
        abort_if(Gate::denies('bursary_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $years = Year::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bursary->load('school', 'year');

        return view('admin.bursaries.edit', compact('bursary', 'schools', 'years'));
    }

    public function update(UpdateBursaryRequest $request, Bursary $bursary)
    {
        $bursary->update($request->all());

        return redirect()->route('admin.bursaries.index');
    }

    public function show(Bursary $bursary)
    {
        abort_if(Gate::denies('bursary_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bursary->load('school', 'year');

        return view('admin.bursaries.show', compact('bursary'));
    }

    public function destroy(Bursary $bursary)
    {
        abort_if(Gate::denies('bursary_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bursary->delete();

        return back();
    }

    public function massDestroy(MassDestroyBursaryRequest $request)
    {
        $bursaries = Bursary::find(request('ids'));

        foreach ($bursaries as $bursary) {
            $bursary->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
