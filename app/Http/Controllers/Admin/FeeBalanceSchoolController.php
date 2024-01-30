<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeBalanceSchool;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FeeBalanceSchoolController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fee_balance_school_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feeBalanceSchools = FeeBalanceSchool::with(['school', 'year'])->get();

        return view('admin.feeBalanceSchools.index', compact('feeBalanceSchools'));
    }
}
