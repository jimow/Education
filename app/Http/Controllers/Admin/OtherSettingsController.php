<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyOtherSettingRequest;
use App\Http\Requests\StoreOtherSettingRequest;
use App\Http\Requests\UpdateOtherSettingRequest;
use App\Models\OtherSetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OtherSettingsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('other_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = OtherSetting::query()->select(sprintf('%s.*', (new OtherSetting)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'other_setting_show';
                $editGate      = 'other_setting_edit';
                $deleteGate    = 'other_setting_delete';
                $crudRoutePart = 'other-settings';

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
            $table->editColumn('fees_percentage', function ($row) {
                return $row->fees_percentage ? $row->fees_percentage : '';
            });
            $table->editColumn('term_1', function ($row) {
                return $row->term_1 ? $row->term_1 : '';
            });
            $table->editColumn('term_2', function ($row) {
                return $row->term_2 ? $row->term_2 : '';
            });
            $table->editColumn('term_3', function ($row) {
                return $row->term_3 ? $row->term_3 : '';
            });
            $table->editColumn('day_fees_percentage', function ($row) {
                return $row->day_fees_percentage ? $row->day_fees_percentage : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.otherSettings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('other_setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.otherSettings.create');
    }

    public function store(StoreOtherSettingRequest $request)
    {
        $otherSetting = OtherSetting::create($request->all());

        return redirect()->route('admin.other-settings.index');
    }

    public function edit(OtherSetting $otherSetting)
    {
        abort_if(Gate::denies('other_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.otherSettings.edit', compact('otherSetting'));
    }

    public function update(UpdateOtherSettingRequest $request, OtherSetting $otherSetting)
    {
        $otherSetting->update($request->all());

        return redirect()->route('admin.other-settings.index');
    }

    public function show(OtherSetting $otherSetting)
    {
        abort_if(Gate::denies('other_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.otherSettings.show', compact('otherSetting'));
    }

    public function destroy(OtherSetting $otherSetting)
    {
        abort_if(Gate::denies('other_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otherSetting->delete();

        return back();
    }

    public function massDestroy(MassDestroyOtherSettingRequest $request)
    {
        $otherSettings = OtherSetting::find(request('ids'));

        foreach ($otherSettings as $otherSetting) {
            $otherSetting->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
