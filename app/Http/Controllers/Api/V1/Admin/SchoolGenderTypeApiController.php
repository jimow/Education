<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolGenderTypeRequest;
use App\Http\Requests\UpdateSchoolGenderTypeRequest;
use App\Http\Resources\Admin\SchoolGenderTypeResource;
use App\Models\SchoolGenderType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SchoolGenderTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('school_gender_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SchoolGenderTypeResource(SchoolGenderType::all());
    }

    public function store(StoreSchoolGenderTypeRequest $request)
    {
        $schoolGenderType = SchoolGenderType::create($request->all());

        return (new SchoolGenderTypeResource($schoolGenderType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SchoolGenderType $schoolGenderType)
    {
        abort_if(Gate::denies('school_gender_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SchoolGenderTypeResource($schoolGenderType);
    }

    public function update(UpdateSchoolGenderTypeRequest $request, SchoolGenderType $schoolGenderType)
    {
        $schoolGenderType->update($request->all());

        return (new SchoolGenderTypeResource($schoolGenderType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SchoolGenderType $schoolGenderType)
    {
        abort_if(Gate::denies('school_gender_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolGenderType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
