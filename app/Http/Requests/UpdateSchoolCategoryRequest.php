<?php

namespace App\Http\Requests;

use App\Models\SchoolCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSchoolCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('school_category_edit');
    }

    public function rules()
    {
        return [
            'category_name' => [
                'string',
                'required',
            ],
        ];
    }
}
