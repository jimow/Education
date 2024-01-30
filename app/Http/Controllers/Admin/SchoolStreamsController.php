<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySchoolStreamRequest;
use App\Http\Requests\StoreSchoolStreamRequest;
use App\Http\Requests\UpdateSchoolStreamRequest;
use App\Models\School;
use App\Models\SchoolStream;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SchoolStreamsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('school_stream_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SchoolStream::with(['school'])->select(sprintf('%s.*', (new SchoolStream)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'school_stream_show';
                $editGate      = 'school_stream_edit';
                $deleteGate    = 'school_stream_delete';
                $crudRoutePart = 'school-streams';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->addColumn('school_name', function ($row) {
                return $row->school ? $row->school->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'school']);

            return $table->make(true);
        }

        $schools = School::get();

        return view('admin.schoolStreams.index', compact('schools'));
    }

    public function create()
    {
        abort_if(Gate::denies('school_stream_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.schoolStreams.create', compact('schools'));
    }

    public function store(StoreSchoolStreamRequest $request)
    {
        $schoolStream = SchoolStream::create($request->all());

        return redirect()->route('admin.school-streams.index');
    }

    public function edit(SchoolStream $schoolStream)
    {
        abort_if(Gate::denies('school_stream_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schools = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $schoolStream->load('school');

        return view('admin.schoolStreams.edit', compact('schoolStream', 'schools'));
    }

    public function update(UpdateSchoolStreamRequest $request, SchoolStream $schoolStream)
    {
        $schoolStream->update($request->all());

        return redirect()->route('admin.school-streams.index');
    }

    public function show(SchoolStream $schoolStream)
    {
        abort_if(Gate::denies('school_stream_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolStream->load('school');

        return view('admin.schoolStreams.show', compact('schoolStream'));
    }

    public function destroy(SchoolStream $schoolStream)
    {
        abort_if(Gate::denies('school_stream_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolStream->delete();

        return back();
    }

    public function massDestroy(MassDestroySchoolStreamRequest $request)
    {
        $schoolStreams = SchoolStream::find(request('ids'));

        foreach ($schoolStreams as $schoolStream) {
            $schoolStream->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
