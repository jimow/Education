<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentTransferRequest;
use App\Http\Requests\UpdateStudentTransferRequest;
use App\Http\Resources\Admin\StudentTransferResource;
use App\Models\StudentTransfer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentTransfersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('student_transfer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentTransferResource(StudentTransfer::with(['admission_number', 'trasnsfer_from', 'transfer_to', 'principal_approval_transfer_from', 'principal_approval_transfer_to', 'initiated_by', 'confirmed_by', 'authorized_by'])->get());
    }

    public function store(StoreStudentTransferRequest $request)
    {
        $studentTransfer = StudentTransfer::create($request->all());

        return (new StudentTransferResource($studentTransfer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(StudentTransfer $studentTransfer)
    {
        abort_if(Gate::denies('student_transfer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentTransferResource($studentTransfer->load(['admission_number', 'trasnsfer_from', 'transfer_to', 'principal_approval_transfer_from', 'principal_approval_transfer_to', 'initiated_by', 'confirmed_by', 'authorized_by']));
    }

    public function update(UpdateStudentTransferRequest $request, StudentTransfer $studentTransfer)
    {
        $studentTransfer->update($request->all());

        return (new StudentTransferResource($studentTransfer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(StudentTransfer $studentTransfer)
    {
        abort_if(Gate::denies('student_transfer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentTransfer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
