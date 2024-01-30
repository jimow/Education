<?php

namespace App\Http\Requests;

use App\Models\Ward;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWardRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ward_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:wards,name,' . request()->route('ward')->id,
            ],
        ];
    }
}
