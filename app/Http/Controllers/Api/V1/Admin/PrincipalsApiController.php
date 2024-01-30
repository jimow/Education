<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePrincipalRequest;
use App\Http\Requests\UpdatePrincipalRequest;
use App\Http\Resources\Admin\PrincipalResource;
use App\Models\Principal;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PrincipalsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('principal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PrincipalResource(Principal::with(['created_by'])->get());
    }

    public function store(StorePrincipalRequest $request)
    {
        $principal = Principal::create($request->all());

        return (new PrincipalResource($principal))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Principal $principal)
    {
        abort_if(Gate::denies('principal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PrincipalResource($principal->load(['created_by']));
    }

    public function update(UpdatePrincipalRequest $request, Principal $principal)
    {
        $principal->update($request->all());

        return (new PrincipalResource($principal))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Principal $principal)
    {
        abort_if(Gate::denies('principal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $principal->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
