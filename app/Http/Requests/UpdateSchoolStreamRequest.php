<?php

namespace App\Http\Requests;

use App\Models\SchoolStream;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSchoolStreamRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('school_stream_edit');
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
