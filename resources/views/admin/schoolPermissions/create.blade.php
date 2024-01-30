@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.schoolPermission.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.school-permissions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="schools">{{ trans('cruds.schoolPermission.fields.school') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('schools') ? 'is-invalid' : '' }}" name="schools[]" id="schools" multiple>
                    @foreach($schools as $id => $school)
                        <option value="{{ $id }}" {{ in_array($id, old('schools', [])) ? 'selected' : '' }}>{{ $school }}</option>
                    @endforeach
                </select>
                @if($errors->has('schools'))
                    <div class="invalid-feedback">
                        {{ $errors->first('schools') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolPermission.fields.school_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="users">{{ trans('cruds.schoolPermission.fields.user') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('users') ? 'is-invalid' : '' }}" name="users[]" id="users" multiple>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ in_array($id, old('users', [])) ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('users'))
                    <div class="invalid-feedback">
                        {{ $errors->first('users') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolPermission.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection