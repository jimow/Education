<?php

namespace App\Http\Requests;

use App\Models\SchoolGenderType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSchoolGenderTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('school_gender_type_edit');
    }

    public function rules()
    {
        return [
            'gender_type' => [
                'string',
                'required',
            ],
        ];
    }
}
