<?php

namespace App\Http\Requests;

use App\Models\StudentCountPerTerm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStudentCountPerTermRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_count_per_term_create');
    }

    public function rules()
    {
        return [
            'count' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
