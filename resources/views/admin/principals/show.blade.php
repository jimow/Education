@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.principal.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.principals.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.principal.fields.id') }}
                        </th>
                        <td>
                            {{ $principal->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.principal.fields.fullname') }}
                        </th>
                        <td>
                            {{ $principal->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.principal.fields.email') }}
                        </th>
                        <td>
                            {{ $principal->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.principal.fields.national') }}
                        </th>
                        <td>
                            {{ $principal->national }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.principal.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $principal->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.principal.fields.created_by') }}
                        </th>
                        <td>
                            {{ $principal->created_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.principals.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection