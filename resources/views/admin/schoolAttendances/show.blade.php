@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.schoolAttendance.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.school-attendances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.schoolAttendance.fields.id') }}
                        </th>
                        <td>
                            {{ $schoolAttendance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.schoolAttendance.fields.admission_number') }}
                        </th>
                        <td>
                            {{ $schoolAttendance->admission_number->admission_number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.schoolAttendance.fields.year') }}
                        </th>
                        <td>
                            {{ $schoolAttendance->year->year ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.schoolAttendance.fields.school_term') }}
                        </th>
                        <td>
                            {{ App\Models\SchoolAttendance::SCHOOL_TERM_SELECT[$schoolAttendance->school_term] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.schoolAttendance.fields.prepared_by') }}
                        </th>
                        <td>
                            {{ $schoolAttendance->prepared_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.schoolAttendance.fields.confirmed_by') }}
                        </th>
                        <td>
                            {{ $schoolAttendance->confirmed_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.schoolAttendance.fields.school_name') }}
                        </th>
                        <td>
                            {{ $schoolAttendance->school_name->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.school-attendances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection