@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.schoolPermission.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.school-permissions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.schoolPermission.fields.id') }}
                        </th>
                        <td>
                            {{ $schoolPermission->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.schoolPermission.fields.school') }}
                        </th>
                        <td>
                            @foreach($schoolPermission->schools as $key => $school)
                                <span class="label label-info">{{ $school->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.schoolPermission.fields.user') }}
                        </th>
                        <td>
                            @foreach($schoolPermission->users as $key => $user)
                                <span class="label label-info">{{ $user->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.school-permissions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection