<?php

namespace App\Http\Requests;

use App\Models\StudentBursaryRegister;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStudentBursaryRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_bursary_register_edit');
    }

    public function rules()
    {
        return [
            'term' => [
                'required',
            ],
            'year_id' => [
                'required',
                'integer',
            ],
            'amount_paid' => [
                'required',
            ],
            'payment_code' => [
                'string',
                'nullable',
            ],
        ];
    }
}
