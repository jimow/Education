<?php

namespace App\Http\Requests;

use App\Models\FeeBalanceSchool;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFeeBalanceSchoolRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('fee_balance_school_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:fee_balance_schools,id',
        ];
    }
}
