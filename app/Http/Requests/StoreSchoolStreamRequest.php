<?php

namespace App\Http\Requests;

use App\Models\SchoolStream;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSchoolStreamRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('school_stream_create');
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
