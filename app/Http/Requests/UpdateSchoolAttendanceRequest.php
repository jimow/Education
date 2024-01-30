<?php

namespace App\Http\Requests;

use App\Models\SchoolAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSchoolAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('school_attendance_edit');
    }

    public function rules()
    {
        return [
            'admission_number_id' => [
                'required',
                'integer',
            ],
            'year_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
