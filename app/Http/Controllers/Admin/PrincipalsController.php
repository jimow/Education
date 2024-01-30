<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPrincipalRequest;
use App\Http\Requests\StorePrincipalRequest;
use App\Http\Requests\UpdatePrincipalRequest;
use App\Models\Principal;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PrincipalsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('principal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Principal::with(['created_by'])->select(sprintf('%s.*', (new Principal)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'principal_show';
                $editGate      = 'principal_edit';
                $deleteGate    = 'principal_delete';
                $crudRoutePart = 'principals';

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
            $table->editColumn('fullname', function ($row) {
                return $row->fullname ? $row->fullname : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('national', function ($row) {
                return $row->national ? $row->national : '';
            });
            $table->editColumn('phone_number', function ($row) {
                return $row->phone_number ? $row->phone_number : '';
            });
            $table->addColumn('created_by_name', function ($row) {
                return $row->created_by ? $row->created_by->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'created_by']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.principals.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('principal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.principals.create');
    }

    public function store(StorePrincipalRequest $request)
    {
        $principal = Principal::create($request->all());

        return redirect()->route('admin.principals.index');
    }

    public function edit(Principal $principal)
    {
        abort_if(Gate::denies('principal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $principal->load('created_by');

        return view('admin.principals.edit', compact('principal'));
    }

    public function update(UpdatePrincipalRequest $request, Principal $principal)
    {
        $principal->update($request->all());

        return redirect()->route('admin.principals.index');
    }

    public function show(Principal $principal)
    {
        abort_if(Gate::denies('principal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $principal->load('created_by');

        return view('admin.principals.show', compact('principal'));
    }

    public function destroy(Principal $principal)
    {
        abort_if(Gate::denies('principal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $principal->delete();

        return back();
    }

    public function massDestroy(MassDestroyPrincipalRequest $request)
    {
        $principals = Principal::find(request('ids'));

        foreach ($principals as $principal) {
            $principal->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
