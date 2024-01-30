<?php

namespace App\Http\Requests;

use App\Models\Principal;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePrincipalRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('principal_edit');
    }

    public function rules()
    {
        return [
            'fullname' => [
                'string',
                'required',
            ],
            'email' => [
                'string',
                'required',
                'unique:principals,email,' . request()->route('principal')->id,
            ],
            'national' => [
                'string',
                'required',
                'unique:principals,national,' . request()->route('principal')->id,
            ],
            'phone_number' => [
                'string',
                'required',
                'unique:principals,phone_number,' . request()->route('principal')->id,
            ],
        ];
    }
}
