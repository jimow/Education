@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.schoolAttendance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.school-attendances.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="admission_number_id">{{ trans('cruds.schoolAttendance.fields.admission_number') }}</label>
                <select class="form-control select2 {{ $errors->has('admission_number') ? 'is-invalid' : '' }}" name="admission_number_id" id="admission_number_id" required>
                    @foreach($admission_numbers as $id => $entry)
                        <option value="{{ $id }}" {{ old('admission_number_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('admission_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('admission_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolAttendance.fields.admission_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="year_id">{{ trans('cruds.schoolAttendance.fields.year') }}</label>
                <select class="form-control select2 {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year_id" id="year_id" required>
                    @foreach($years as $id => $entry)
                        <option value="{{ $id }}" {{ old('year_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('year') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolAttendance.fields.year_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.schoolAttendance.fields.school_term') }}</label>
                <select class="form-control {{ $errors->has('school_term') ? 'is-invalid' : '' }}" name="school_term" id="school_term">
                    <option value disabled {{ old('school_term', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SchoolAttendance::SCHOOL_TERM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('school_term', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('school_term'))
                    <div class="invalid-feedback">
                        {{ $errors->first('school_term') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolAttendance.fields.school_term_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="school_name_id">{{ trans('cruds.schoolAttendance.fields.school_name') }}</label>
                <select class="form-control select2 {{ $errors->has('school_name') ? 'is-invalid' : '' }}" name="school_name_id" id="school_name_id">
                    @foreach($school_names as $id => $entry)
                        <option value="{{ $id }}" {{ old('school_name_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('school_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('school_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.schoolAttendance.fields.school_name_helper') }}</span>
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