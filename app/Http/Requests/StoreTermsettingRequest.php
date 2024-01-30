<?php

namespace App\Http\Requests;

use App\Models\Termsetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTermsettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('termsetting_create');
    }

    public function rules()
    {
        return [
            'term' => [
                'string',
                'nullable',
            ],
            'begins' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'ends' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
