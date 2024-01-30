@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ward.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.wards.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ward.fields.id') }}
                        </th>
                        <td>
                            {{ $ward->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ward.fields.name') }}
                        </th>
                        <td>
                            {{ $ward->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ward.fields.constituency') }}
                        </th>
                        <td>
                            {{ $ward->constituency->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.wards.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection