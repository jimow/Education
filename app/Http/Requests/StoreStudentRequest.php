<?php

namespace App\Http\Requests;

use App\Models\Student;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStudentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_create');
    }

    public function rules()
    {
        return [
            'fullname' => [
                'string',
                'required',
            ],
            'gender' => [
                'required',
            ],
            'date_of_birth' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'ward_id' => [
                'required',
                'integer',
            ],
            'nemis_number' => [
                'string',
                'required',
                'unique:students',
            ],
            'admission_number' => [
                'string',
                'required',
                'unique:students',
            ],
            'on_scholarship' => [
                'required',
            ],
            'scholarship_donor' => [
                'string',
                'nullable',
            ],
            'disability' => [
                'required',
            ],
            'parental_status' => [
                'required',
            ],
            'father_fullname' => [
                'string',
                'nullable',
            ],
            'father_phone_number' => [
                'string',
                'nullable',
            ],
            'mother_fullname' => [
                'string',
                'required',
            ],
            'mother_phone_number' => [
                'string',
                'required',
            ],
            'school_id' => [
                'required',
                'integer',
            ],
            'birth_certificate_number' => [
                'string',
                'nullable',
            ],
            'father_national_id_no' => [
                'string',
                'nullable',
            ],
            'mother_national_id_no' => [
                'string',
                'nullable',
            ],
            'guardian_fullname' => [
                'string',
                'nullable',
            ],
            'guardian_phone_number' => [
                'string',
                'nullable',
            ],
            'guardian_national' => [
                'string',
                'nullable',
            ],
            'other_documents' => [
                'array',
            ],
        ];
    }
}
