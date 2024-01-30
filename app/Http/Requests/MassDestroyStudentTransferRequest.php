<?php

namespace App\Http\Requests;

use App\Models\StudentTransfer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyStudentTransferRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('student_transfer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:student_transfers,id',
        ];
    }
}
