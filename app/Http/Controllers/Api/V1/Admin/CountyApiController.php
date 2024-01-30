<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountyRequest;
use App\Http\Requests\UpdateCountyRequest;
use App\Http\Resources\Admin\CountyResource;
use App\Models\County;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CountyApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('county_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CountyResource(County::all());
    }

    public function store(StoreCountyRequest $request)
    {
        $county = County::create($request->all());

        return (new CountyResource($county))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(County $county)
    {
        abort_if(Gate::denies('county_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CountyResource($county);
    }

    public function update(UpdateCountyRequest $request, County $county)
    {
        $county->update($request->all());

        return (new CountyResource($county))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(County $county)
    {
        abort_if(Gate::denies('county_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $county->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
