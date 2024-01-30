@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.school.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.schools.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.id') }}
                        </th>
                        <td>
                            {{ $school->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.name') }}
                        </th>
                        <td>
                            {{ $school->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.gender_type') }}
                        </th>
                        <td>
                            {{ $school->gender_type->gender_type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.category') }}
                        </th>
                        <td>
                            {{ $school->category->category_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.ward') }}
                        </th>
                        <td>
                            {{ $school->ward->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.principal') }}
                        </th>
                        <td>
                            {{ $school->principal->fullname ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $school->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.email') }}
                        </th>
                        <td>
                            {{ $school->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.postal_address') }}
                        </th>
                        <td>
                            {{ $school->postal_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.physical_address') }}
                        </th>
                        <td>
                            {{ $school->physical_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.physical_location') }}
                        </th>
                        <td>
                            {{ $school->physical_location }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.code') }}
                        </th>
                        <td>
                            {{ $school->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.registered_by') }}
                        </th>
                        <td>
                            {{ $school->registered_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.approved_by') }}
                        </th>
                        <td>
                            {{ $school->approved_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.fees') }}
                        </th>
                        <td>
                            {{ $school->fees }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.uniform_fee') }}
                        </th>
                        <td>
                            {{ App\Models\School::UNIFORM_FEE_RADIO[$school->uniform_fee] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.f_1_fee') }}
                        </th>
                        <td>
                            {{ $school->f_1_fee }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.f_2_fee') }}
                        </th>
                        <td>
                            {{ $school->f_2_fee }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.f_3_fee') }}
                        </th>
                        <td>
                            {{ $school->f_3_fee }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.f_4_fee') }}
                        </th>
                        <td>
                            {{ $school->f_4_fee }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.b_1_fee') }}
                        </th>
                        <td>
                            {{ $school->b_1_fee }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.b_2_fee') }}
                        </th>
                        <td>
                            {{ $school->b_2_fee }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.b_3_fee') }}
                        </th>
                        <td>
                            {{ $school->b_3_fee }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.school.fields.b_4_fee') }}
                        </th>
                        <td>
                            {{ $school->b_4_fee }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.schools.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection