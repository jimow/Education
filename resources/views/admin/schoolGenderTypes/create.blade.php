@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.schoolGenderType.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.school-gender-types.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="gender_type">{{ trans('cruds.schoolGenderType.fields.gender_type') }}</label>
                <input class="form-control {{ $errors->has('gender_type') ? 'is-invalid' : '' }}" type="text" name="gender_type" id="gender_type" value="{{ old('gender_type', '') }}" required>
                @if($errors->has('gender_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gender_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolGenderType.fields.gender_type_helper') }}</span>
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