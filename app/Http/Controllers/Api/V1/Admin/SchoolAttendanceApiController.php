<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolAttendanceRequest;
use App\Http\Requests\UpdateSchoolAttendanceRequest;
use App\Http\Resources\Admin\SchoolAttendanceResource;
use App\Models\SchoolAttendance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SchoolAttendanceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('school_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SchoolAttendanceResource(SchoolAttendance::with(['admission_number', 'year', 'prepared_by', 'confirmed_by', 'school_name'])->get());
    }

    public function store(StoreSchoolAttendanceRequest $request)
    {
        $schoolAttendance = SchoolAttendance::create($request->all());

        return (new SchoolAttendanceResource($schoolAttendance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SchoolAttendance $schoolAttendance)
    {
        abort_if(Gate::denies('school_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SchoolAttendanceResource($schoolAttendance->load(['admission_number', 'year', 'prepared_by', 'confirmed_by', 'school_name']));
    }

    public function update(UpdateSchoolAttendanceRequest $request, SchoolAttendance $schoolAttendance)
    {
        $schoolAttendance->update($request->all());

        return (new SchoolAttendanceResource($schoolAttendance))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SchoolAttendance $schoolAttendance)
    {
        abort_if(Gate::denies('school_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolAttendance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
