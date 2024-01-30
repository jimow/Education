<?php

namespace App\Http\Requests;

use App\Models\SchoolAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySchoolAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('school_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:school_attendances,id',
        ];
    }
}
