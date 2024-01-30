<?php

namespace App\Http\Requests;

use App\Models\StudentBursaryRegister;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyStudentBursaryRegisterRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('student_bursary_register_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:student_bursary_registers,id',
        ];
    }
}
