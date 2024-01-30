<?php

namespace App\Http\Requests;

use App\Models\School;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSchoolRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('school_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:schools,name,' . request()->route('school')->id,
            ],
            'gender_type_id' => [
                'required',
                'integer',
            ],
            'category_id' => [
                'required',
                'integer',
            ],
            'ward_id' => [
                'required',
                'integer',
            ],
            'phone_number' => [
                'string',
                'nullable',
            ],
            'email' => [
                'required',
            ],
            'postal_address' => [
                'string',
                'nullable',
            ],
            'physical_address' => [
                'string',
                'nullable',
            ],
            'physical_location' => [
                'string',
                'nullable',
            ],
            'code' => [
                'string',
                'required',
                'unique:schools,code,' . request()->route('school')->id,
            ],
            'fees' => [
                'string',
                'nullable',
            ],
            'f_2_fee' => [
                'string',
                'nullable',
            ],
            'b_3_fee' => [
                'string',
                'nullable',
            ],
            'b_4_fee' => [
                'string',
                'nullable',
            ],
        ];
    }
}
