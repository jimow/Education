<?php

namespace App\Http\Requests;

use App\Models\SchoolPermission;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSchoolPermissionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('school_permission_edit');
    }

    public function rules()
    {
        return [
            'schools.*' => [
                'integer',
            ],
            'schools' => [
                'array',
            ],
            'users.*' => [
                'integer',
            ],
            'users' => [
                'array',
            ],
        ];
    }
}
