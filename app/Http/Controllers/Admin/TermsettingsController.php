<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTermsettingRequest;
use App\Http\Requests\StoreTermsettingRequest;
use App\Http\Requests\UpdateTermsettingRequest;
use App\Models\Termsetting;
use App\Models\Year;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TermsettingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('termsetting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $termsettings = Termsetting::with(['year'])->get();

        $years = Year::get();

        return view('admin.termsettings.index', compact('termsettings', 'years'));
    }

    public function create()
    {
        abort_if(Gate::denies('termsetting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $years = Year::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.termsettings.create', compact('years'));
    }

    public function store(StoreTermsettingRequest $request)
    {
        $termsetting = Termsetting::create($request->all());

        return redirect()->route('admin.termsettings.index');
    }

    public function edit(Termsetting $termsetting)
    {
        abort_if(Gate::denies('termsetting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $years = Year::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        $termsetting->load('year');

        return view('admin.termsettings.edit', compact('termsetting', 'years'));
    }

    public function update(UpdateTermsettingRequest $request, Termsetting $termsetting)
    {
        $termsetting->update($request->all());

        return redirect()->route('admin.termsettings.index');
    }

    public function show(Termsetting $termsetting)
    {
        abort_if(Gate::denies('termsetting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $termsetting->load('year');

        return view('admin.termsettings.show', compact('termsetting'));
    }

    public function destroy(Termsetting $termsetting)
    {
        abort_if(Gate::denies('termsetting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $termsetting->delete();

        return back();
    }

    public function massDestroy(MassDestroyTermsettingRequest $request)
    {
        $termsettings = Termsetting::find(request('ids'));

        foreach ($termsettings as $termsetting) {
            $termsetting->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
