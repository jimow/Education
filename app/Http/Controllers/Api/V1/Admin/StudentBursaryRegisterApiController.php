<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentBursaryRegisterRequest;
use App\Http\Requests\UpdateStudentBursaryRegisterRequest;
use App\Http\Resources\Admin\StudentBursaryRegisterResource;
use App\Models\StudentBursaryRegister;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentBursaryRegisterApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('student_bursary_register_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentBursaryRegisterResource(StudentBursaryRegister::with(['year', 'requested_by', 'authorized_by', 'admission_number'])->get());
    }

    public function store(StoreStudentBursaryRegisterRequest $request)
    {
        $studentBursaryRegister = StudentBursaryRegister::create($request->all());

        return (new StudentBursaryRegisterResource($studentBursaryRegister))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(StudentBursaryRegister $studentBursaryRegister)
    {
        abort_if(Gate::denies('student_bursary_register_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentBursaryRegisterResource($studentBursaryRegister->load(['year', 'requested_by', 'authorized_by', 'admission_number']));
    }

    public function update(UpdateStudentBursaryRegisterRequest $request, StudentBursaryRegister $studentBursaryRegister)
    {
        $studentBursaryRegister->update($request->all());

        return (new StudentBursaryRegisterResource($studentBursaryRegister))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(StudentBursaryRegister $studentBursaryRegister)
    {
        abort_if(Gate::denies('student_bursary_register_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentBursaryRegister->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
