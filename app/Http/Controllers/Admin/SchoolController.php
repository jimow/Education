<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySchoolRequest;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\Principal;
use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\SchoolGenderType;
use App\Models\User;
use App\Models\Ward;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SchoolController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('school_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = School::with(['gender_type', 'category', 'ward', 'principal', 'registered_by', 'approved_by'])->select(sprintf('%s.*', (new School)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'school_show';
                $editGate      = 'school_edit';
                $deleteGate    = 'school_delete';
                $crudRoutePart = 'schools';

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
            $table->addColumn('gender_type_gender_type', function ($row) {
                return $row->gender_type ? $row->gender_type->gender_type : '';
            });

            $table->addColumn('category_category_name', function ($row) {
                return $row->category ? $row->category->category_name : '';
            });

            $table->addColumn('ward_name', function ($row) {
                return $row->ward ? $row->ward->name : '';
            });

            $table->addColumn('principal_fullname', function ($row) {
                return $row->principal ? $row->principal->fullname : '';
            });

            $table->editColumn('principal.email', function ($row) {
                return $row->principal ? (is_string($row->principal) ? $row->principal : $row->principal->email) : '';
            });
            $table->editColumn('principal.national', function ($row) {
                return $row->principal ? (is_string($row->principal) ? $row->principal : $row->principal->national) : '';
            });
            $table->editColumn('principal.phone_number', function ($row) {
                return $row->principal ? (is_string($row->principal) ? $row->principal : $row->principal->phone_number) : '';
            });
            $table->editColumn('phone_number', function ($row) {
                return $row->phone_number ? $row->phone_number : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('postal_address', function ($row) {
                return $row->postal_address ? $row->postal_address : '';
            });
            $table->editColumn('physical_address', function ($row) {
                return $row->physical_address ? $row->physical_address : '';
            });
            $table->editColumn('physical_location', function ($row) {
                return $row->physical_location ? $row->physical_location : '';
            });
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : '';
            });
            $table->addColumn('registered_by_name', function ($row) {
                return $row->registered_by ? $row->registered_by->name : '';
            });

            $table->addColumn('approved_by_name', function ($row) {
                return $row->approved_by ? $row->approved_by->name : '';
            });

            $table->editColumn('fees', function ($row) {
                return $row->fees ? $row->fees : '';
            });
            $table->editColumn('uniform_fee', function ($row) {
                return $row->uniform_fee ? School::UNIFORM_FEE_RADIO[$row->uniform_fee] : '';
            });
            $table->editColumn('f_1_fee', function ($row) {
                return $row->f_1_fee ? $row->f_1_fee : '';
            });
            $table->editColumn('f_2_fee', function ($row) {
                return $row->f_2_fee ? $row->f_2_fee : '';
            });
            $table->editColumn('f_3_fee', function ($row) {
                return $row->f_3_fee ? $row->f_3_fee : '';
            });
            $table->editColumn('f_4_fee', function ($row) {
                return $row->f_4_fee ? $row->f_4_fee : '';
            });
            $table->editColumn('b_1_fee', function ($row) {
                return $row->b_1_fee ? $row->b_1_fee : '';
            });
            $table->editColumn('b_2_fee', function ($row) {
                return $row->b_2_fee ? $row->b_2_fee : '';
            });
            $table->editColumn('b_3_fee', function ($row) {
                return $row->b_3_fee ? $row->b_3_fee : '';
            });
            $table->editColumn('b_4_fee', function ($row) {
                return $row->b_4_fee ? $row->b_4_fee : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'gender_type', 'category', 'ward', 'principal', 'registered_by', 'approved_by']);

            return $table->make(true);
        }

        $school_gender_types = SchoolGenderType::get();
        $school_categories   = SchoolCategory::get();
        $wards               = Ward::get();
        $principals          = Principal::get();
        $users               = User::get();

        return view('admin.schools.index', compact('school_gender_types', 'school_categories', 'wards', 'principals', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('school_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gender_types = SchoolGenderType::pluck('gender_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = SchoolCategory::pluck('category_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $wards = Ward::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $principals = Principal::pluck('fullname', 'id')->prepend(trans('global.pleaseSelect'), '');

        $registered_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $approved_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.schools.create', compact('approved_bies', 'categories', 'gender_types', 'principals', 'registered_bies', 'wards'));
    }

    public function store(StoreSchoolRequest $request)
    {
        $school = School::create($request->all());

        return redirect()->route('admin.schools.index');
    }

    public function edit(School $school)
    {
        abort_if(Gate::denies('school_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gender_types = SchoolGenderType::pluck('gender_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = SchoolCategory::pluck('category_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $wards = Ward::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $principals = Principal::pluck('fullname', 'id')->prepend(trans('global.pleaseSelect'), '');

        $registered_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $approved_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $school->load('gender_type', 'category', 'ward', 'principal', 'registered_by', 'approved_by');

        return view('admin.schools.edit', compact('approved_bies', 'categories', 'gender_types', 'principals', 'registered_bies', 'school', 'wards'));
    }

    public function update(UpdateSchoolRequest $request, School $school)
    {
        $school->update($request->all());

        return redirect()->route('admin.schools.index');
    }

    public function show(School $school)
    {
        abort_if(Gate::denies('school_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $school->load('gender_type', 'category', 'ward', 'principal', 'registered_by', 'approved_by');

        return view('admin.schools.show', compact('school'));
    }

    public function destroy(School $school)
    {
        abort_if(Gate::denies('school_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $school->delete();

        return back();
    }

    public function massDestroy(MassDestroySchoolRequest $request)
    {
        $schools = School::find(request('ids'));

        foreach ($schools as $school) {
            $school->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
