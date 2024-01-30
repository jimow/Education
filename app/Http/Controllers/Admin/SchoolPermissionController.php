<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySchoolPermissionRequest;
use App\Http\Requests\StoreSchoolPermissionRequest;
use App\Http\Requests\UpdateSchoolPermissionRequest;
use App\Models\School;
use App\Models\SchoolPermission;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SchoolPermissionController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('school_permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SchoolPermission::with(['schools', 'users'])->select(sprintf('%s.*', (new SchoolPermission)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'school_permission_show';
                $editGate      = 'school_permission_edit';
                $deleteGate    = 'school_permission_delete';
                $crudRoutePart = 'school-permissions';

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
            $table->editColumn('school', function ($row) {
                $labels = [];
                foreach ($row->schools as $school) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $school->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('user', function ($row) {
                $labels = [];
                foreach ($row->users as $user) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $user->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'school', 'user']);

            return $table->make(true);
        }

        $schools = School::get();
        $users   = User::get();

        return view('admin.schoolPermissions.index', compact('schools', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('school_permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schools = School::pluck('name', 'id');

        $users = User::pluck('name', 'id');

        return view('admin.schoolPermissions.create', compact('schools', 'users'));
    }

    public function store(StoreSchoolPermissionRequest $request)
    {
        $schoolPermission = SchoolPermission::create($request->all());
        $schoolPermission->schools()->sync($request->input('schools', []));
        $schoolPermission->users()->sync($request->input('users', []));

        return redirect()->route('admin.school-permissions.index');
    }

    public function edit(SchoolPermission $schoolPermission)
    {
        abort_if(Gate::denies('school_permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schools = School::pluck('name', 'id');

        $users = User::pluck('name', 'id');

        $schoolPermission->load('schools', 'users');

        return view('admin.schoolPermissions.edit', compact('schoolPermission', 'schools', 'users'));
    }

    public function update(UpdateSchoolPermissionRequest $request, SchoolPermission $schoolPermission)
    {
        $schoolPermission->update($request->all());
        $schoolPermission->schools()->sync($request->input('schools', []));
        $schoolPermission->users()->sync($request->input('users', []));

        return redirect()->route('admin.school-permissions.index');
    }

    public function show(SchoolPermission $schoolPermission)
    {
        abort_if(Gate::denies('school_permission_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolPermission->load('schools', 'users');

        return view('admin.schoolPermissions.show', compact('schoolPermission'));
    }

    public function destroy(SchoolPermission $schoolPermission)
    {
        abort_if(Gate::denies('school_permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolPermission->delete();

        return back();
    }

    public function massDestroy(MassDestroySchoolPermissionRequest $request)
    {
        $schoolPermissions = SchoolPermission::find(request('ids'));

        foreach ($schoolPermissions as $schoolPermission) {
            $schoolPermission->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
