<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreReportFormRequest;
use App\Http\Requests\UpdateReportFormRequest;
use App\Http\Resources\Admin\ReportFormResource;
use App\Models\ReportForm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportFormsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('report_form_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReportFormResource(ReportForm::with(['student', 'year'])->get());
    }

    public function store(StoreReportFormRequest $request)
    {
        $reportForm = ReportForm::create($request->all());

        foreach ($request->input('report_form', []) as $file) {
            $reportForm->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('report_form');
        }

        return (new ReportFormResource($reportForm))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ReportForm $reportForm)
    {
        abort_if(Gate::denies('report_form_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReportFormResource($reportForm->load(['student', 'year']));
    }

    public function update(UpdateReportFormRequest $request, ReportForm $reportForm)
    {
        $reportForm->update($request->all());

        if (count($reportForm->report_form) > 0) {
            foreach ($reportForm->report_form as $media) {
                if (! in_array($media->file_name, $request->input('report_form', []))) {
                    $media->delete();
                }
            }
        }
        $media = $reportForm->report_form->pluck('file_name')->toArray();
        foreach ($request->input('report_form', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $reportForm->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('report_form');
            }
        }

        return (new ReportFormResource($reportForm))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ReportForm $reportForm)
    {
        abort_if(Gate::denies('report_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reportForm->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
