<?php

namespace App\Http\Requests;

use App\Models\StudentForm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyStudentFormRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('student_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:student_forms,id',
        ];
    }
}
