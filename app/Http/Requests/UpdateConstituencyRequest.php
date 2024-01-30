<?php

namespace App\Http\Requests;

use App\Models\Constituency;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateConstituencyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('constituency_edit');
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
