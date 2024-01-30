<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeBalance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FeeBalanceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fee_balance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feeBalances = FeeBalance::with(['admission_number', 'year'])->get();

        return view('admin.feeBalances.index', compact('feeBalances'));
    }
}
