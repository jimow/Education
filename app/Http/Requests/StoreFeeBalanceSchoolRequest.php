<?php

namespace App\Http\Requests;

use App\Models\FeeBalanceSchool;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFeeBalanceSchoolRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fee_balance_school_create');
    }

    public function rules()
    {
        return [];
    }
}
