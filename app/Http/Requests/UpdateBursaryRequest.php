<?php

namespace App\Http\Requests;

use App\Models\Bursary;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBursaryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bursary_edit');
    }

    public function rules()
    {
        return [
            'school_id' => [
                'required',
                'integer',
            ],
            'cheque_no' => [
                'string',
                'nullable',
            ],
            'payment_code' => [
                'string',
                'nullable',
            ],
        ];
    }
}
