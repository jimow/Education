<?php

namespace App\Http\Requests;

use App\Models\FeeBalance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFeeBalanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fee_balance_edit');
    }

    public function rules()
    {
        return [];
    }
}
