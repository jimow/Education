<?php

namespace App\Http\Requests;

use App\Models\FeeBalance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFeeBalanceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('fee_balance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:fee_balances,id',
        ];
    }
}
