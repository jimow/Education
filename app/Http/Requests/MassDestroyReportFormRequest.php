<?php

namespace App\Http\Requests;

use App\Models\ReportForm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyReportFormRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('report_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:report_forms,id',
        ];
    }
}
