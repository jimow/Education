<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAllocationRequest;
use App\Http\Requests\StoreAllocationRequest;
use App\Http\Requests\UpdateAllocationRequest;
use App\Models\Allocation;
use App\Functions;
use App\Models\Year;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AllocationController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('allocation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Allocation::with(['year'])->select(sprintf('%s.*', (new Allocation)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'allocation_show';
                $editGate      = 'allocation_edit';
                $deleteGate    = 'allocation_delete';
                $crudRoutePart = 'allocations';

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
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('payment_code', function ($row) {
                return $row->payment_code ? $row->payment_code : '';
            });
            $table->editColumn('cheque_no', function ($row) {
                return $row->cheque_no ? $row->cheque_no : '';
            });
            $table->editColumn('remarks', function ($row) {
                return $row->remarks ? $row->remarks : '';
            });
            $table->editColumn('term', function ($row) {
                return $row->term ? Allocation::TERM_SELECT[$row->term] : '';
            });
            $table->editColumn('bank_name', function ($row) {
                return $row->bank_name ? $row->bank_name : '';
            });
            $table->editColumn('other_details', function ($row) {
                return $row->other_details ? $row->other_details : '';
            });
            $table->addColumn('year_year', function ($row) {
                return $row->year ? $row->year->year : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'year']);

            return $table->make(true);
        }

        $years = Year::get();

        return view('admin.allocations.index', compact('years'));
    }
    public function getAllocationDetails($code) {
        $allocation = Allocation::where('payment_code', $code)->first();

        //get total amount paid for this allocation using its payment code
        $total = getTotalAmountPaid($code);

        $balance = $allocation->amount - $total;
    
        if ($allocation) {
            return response()->json([
                'status' => 'success',
                'allocation' => $allocation,
                'balance' => $balance,
                'total' => $total
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Allocation not found.',
            ]);
        }
    }
    
    public function create()
    {
        abort_if(Gate::denies('allocation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $years = Year::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.allocations.create', compact('years'));
    }

    public function store(StoreAllocationRequest $request)
    {
        $allocation = Allocation::create($request->all());

        return redirect()->route('admin.allocations.index');
    }

    public function edit(Allocation $allocation)
    {
        abort_if(Gate::denies('allocation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $years = Year::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        $allocation->load('year');

        return view('admin.allocations.edit', compact('allocation', 'years'));
    }

    public function update(UpdateAllocationRequest $request, Allocation $allocation)
    {
        $allocation->update($request->all());

        return redirect()->route('admin.allocations.index');
    }

    public function show(Allocation $allocation)
    {
        abort_if(Gate::denies('allocation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allocation->load('year');

        return view('admin.allocations.show', compact('allocation'));
    }

    public function destroy(Allocation $allocation)
    {
        abort_if(Gate::denies('allocation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allocation->delete();

        return back();
    }

    public function massDestroy(MassDestroyAllocationRequest $request)
    {
        $allocations = Allocation::find(request('ids'));

        foreach ($allocations as $allocation) {
            $allocation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
