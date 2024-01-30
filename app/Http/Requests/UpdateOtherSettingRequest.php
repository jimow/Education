<?php

namespace App\Http\Requests;

use App\Models\OtherSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOtherSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('other_setting_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'fees_percentage' => [
                'string',
                'nullable',
            ],
            'term_1' => [
                'string',
                'nullable',
            ],
            'term_2' => [
                'string',
                'nullable',
            ],
            'term_3' => [
                'string',
                'nullable',
            ],
            'day_fees_percentage' => [
                'string',
                'nullable',
            ],
        ];
    }
}
