<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBursaryRequest;
use App\Http\Requests\UpdateBursaryRequest;
use App\Http\Resources\Admin\BursaryResource;
use App\Models\Bursary;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BursaryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('bursary_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BursaryResource(Bursary::with(['school', 'year'])->get());
    }

    public function store(StoreBursaryRequest $request)
    {
        $bursary = Bursary::create($request->all());

        return (new BursaryResource($bursary))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Bursary $bursary)
    {
        abort_if(Gate::denies('bursary_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BursaryResource($bursary->load(['school', 'year']));
    }

    public function update(UpdateBursaryRequest $request, Bursary $bursary)
    {
        $bursary->update($request->all());

        return (new BursaryResource($bursary))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Bursary $bursary)
    {
        abort_if(Gate::denies('bursary_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bursary->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
