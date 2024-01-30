<?php

namespace App\Http\Requests;

use App\Models\FeeBalanceSchool;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFeeBalanceSchoolRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fee_balance_school_edit');
    }

    public function rules()
    {
        return [];
    }
}
