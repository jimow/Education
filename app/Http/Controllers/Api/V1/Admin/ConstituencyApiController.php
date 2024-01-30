<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConstituencyRequest;
use App\Http\Requests\UpdateConstituencyRequest;
use App\Http\Resources\Admin\ConstituencyResource;
use App\Models\Constituency;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConstituencyApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('constituency_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ConstituencyResource(Constituency::with(['county'])->get());
    }

    public function store(StoreConstituencyRequest $request)
    {
        $constituency = Constituency::create($request->all());

        return (new ConstituencyResource($constituency))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Constituency $constituency)
    {
        abort_if(Gate::denies('constituency_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ConstituencyResource($constituency->load(['county']));
    }

    public function update(UpdateConstituencyRequest $request, Constituency $constituency)
    {
        $constituency->update($request->all());

        return (new ConstituencyResource($constituency))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Constituency $constituency)
    {
        abort_if(Gate::denies('constituency_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $constituency->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
