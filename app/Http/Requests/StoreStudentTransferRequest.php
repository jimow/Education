<?php

namespace App\Http\Requests;

use App\Models\StudentTransfer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStudentTransferRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_transfer_create');
    }

    public function rules()
    {
        return [
            'admission_number_id' => [
                'required',
                'integer',
            ],
            'trasnsfer_from_id' => [
                'required',
                'integer',
            ],
            'transfer_to_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
