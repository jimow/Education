<?php

namespace App\Http\Requests;

use App\Models\Principal;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePrincipalRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('principal_create');
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
                'unique:principals',
            ],
            'national' => [
                'string',
                'required',
                'unique:principals',
            ],
            'phone_number' => [
                'string',
                'required',
                'unique:principals',
            ],
        ];
    }
}
