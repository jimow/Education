<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolStreamRequest;
use App\Http\Requests\UpdateSchoolStreamRequest;
use App\Http\Resources\Admin\SchoolStreamResource;
use App\Models\SchoolStream;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SchoolStreamsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('school_stream_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SchoolStreamResource(SchoolStream::with(['school'])->get());
    }

    public function store(StoreSchoolStreamRequest $request)
    {
        $schoolStream = SchoolStream::create($request->all());

        return (new SchoolStreamResource($schoolStream))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SchoolStream $schoolStream)
    {
        abort_if(Gate::denies('school_stream_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SchoolStreamResource($schoolStream->load(['school']));
    }

    public function update(UpdateSchoolStreamRequest $request, SchoolStream $schoolStream)
    {
        $schoolStream->update($request->all());

        return (new SchoolStreamResource($schoolStream))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SchoolStream $schoolStream)
    {
        abort_if(Gate::denies('school_stream_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolStream->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
