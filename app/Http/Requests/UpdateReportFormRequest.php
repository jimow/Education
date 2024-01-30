<?php

namespace App\Http\Requests;

use App\Models\ReportForm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateReportFormRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('report_form_edit');
    }

    public function rules()
    {
        return [
            'student_id' => [
                'required',
                'integer',
            ],
            'year_id' => [
                'required',
                'integer',
            ],
            'report_form' => [
                'array',
            ],
        ];
    }
}
