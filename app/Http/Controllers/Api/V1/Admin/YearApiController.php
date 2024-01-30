<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreYearRequest;
use App\Http\Requests\UpdateYearRequest;
use App\Http\Resources\Admin\YearResource;
use App\Models\Year;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class YearApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('year_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new YearResource(Year::all());
    }

    public function store(StoreYearRequest $request)
    {
        $year = Year::create($request->all());

        return (new YearResource($year))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Year $year)
    {
        abort_if(Gate::denies('year_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new YearResource($year);
    }

    public function update(UpdateYearRequest $request, Year $year)
    {
        $year->update($request->all());

        return (new YearResource($year))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Year $year)
    {
        abort_if(Gate::denies('year_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $year->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
