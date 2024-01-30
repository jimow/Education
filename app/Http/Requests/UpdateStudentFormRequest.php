<?php

namespace App\Http\Requests;

use App\Models\StudentForm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStudentFormRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_form_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
