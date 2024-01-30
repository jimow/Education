<?php

namespace App\Http\Requests;

use App\Models\OtherSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOtherSettingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('other_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:other_settings,id',
        ];
    }
}
