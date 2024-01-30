<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyReportFormRequest;
use App\Http\Requests\StoreReportFormRequest;
use App\Http\Requests\UpdateReportFormRequest;
use App\Models\ReportForm;
use App\Models\Student;
use App\Models\Year;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ReportFormsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('report_form_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ReportForm::with(['student', 'year'])->select(sprintf('%s.*', (new ReportForm)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'report_form_show';
                $editGate      = 'report_form_edit';
                $deleteGate    = 'report_form_delete';
                $crudRoutePart = 'report-forms';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('student_fullname', function ($row) {
                return $row->student ? $row->student->fullname : '';
            });

            $table->editColumn('school_term', function ($row) {
                return $row->school_term ? ReportForm::SCHOOL_TERM_SELECT[$row->school_term] : '';
            });
            $table->addColumn('year_year', function ($row) {
                return $row->year ? $row->year->year : '';
            });

            $table->editColumn('report_form', function ($row) {
                if (! $row->report_form) {
                    return '';
                }
                $links = [];
                foreach ($row->report_form as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'student', 'year', 'report_form']);

            return $table->make(true);
        }

        $students = Student::get();
        $years    = Year::get();

        return view('admin.reportForms.index', compact('students', 'years'));
    }

    public function create()
    {
        abort_if(Gate::denies('report_form_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::pluck('fullname', 'id')->prepend(trans('global.pleaseSelect'), '');

        $years = Year::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.reportForms.create', compact('students', 'years'));
    }

    public function store(StoreReportFormRequest $request)
    {
        $reportForm = ReportForm::create($request->all());

        foreach ($request->input('report_form', []) as $file) {
            $reportForm->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('report_form');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $reportForm->id]);
        }

        return redirect()->route('admin.report-forms.index');
    }

    public function edit(ReportForm $reportForm)
    {
        abort_if(Gate::denies('report_form_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::pluck('fullname', 'id')->prepend(trans('global.pleaseSelect'), '');

        $years = Year::pluck('year', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reportForm->load('student', 'year');

        return view('admin.reportForms.edit', compact('reportForm', 'students', 'years'));
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

        return redirect()->route('admin.report-forms.index');
    }

    public function show(ReportForm $reportForm)
    {
        abort_if(Gate::denies('report_form_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reportForm->load('student', 'year');

        return view('admin.reportForms.show', compact('reportForm'));
    }

    public function destroy(ReportForm $reportForm)
    {
        abort_if(Gate::denies('report_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reportForm->delete();

        return back();
    }

    public function massDestroy(MassDestroyReportFormRequest $request)
    {
        $reportForms = ReportForm::find(request('ids'));

        foreach ($reportForms as $reportForm) {
            $reportForm->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('report_form_create') && Gate::denies('report_form_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ReportForm();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
