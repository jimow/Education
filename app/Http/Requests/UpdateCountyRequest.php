<?php

namespace App\Http\Requests;

use App\Models\County;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCountyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('county_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
