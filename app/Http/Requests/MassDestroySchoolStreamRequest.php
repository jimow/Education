<?php

namespace App\Http\Requests;

use App\Models\SchoolStream;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySchoolStreamRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('school_stream_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:school_streams,id',
        ];
    }
}
