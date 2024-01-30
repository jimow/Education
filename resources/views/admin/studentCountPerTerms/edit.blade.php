@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.studentCountPerTerm.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.student-count-per-terms.update", [$studentCountPerTerm->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="school_id">{{ trans('cruds.studentCountPerTerm.fields.school') }}</label>
                <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}" name="school_id" id="school_id">
                    @foreach($schools as $id => $entry)
                        <option value="{{ $id }}" {{ (old('school_id') ? old('school_id') : $studentCountPerTerm->school->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('school'))
                    <div class="invalid-feedback">
                        {{ $errors->first('school') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentCountPerTerm.fields.school_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="count">{{ trans('cruds.studentCountPerTerm.fields.count') }}</label>
                <input class="form-control {{ $errors->has('count') ? 'is-invalid' : '' }}" type="number" name="count" id="count" value="{{ old('count', $studentCountPerTerm->count) }}" step="1">
                @if($errors->has('count'))
                    <div class="invalid-feedback">
                        {{ $errors->first('count') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentCountPerTerm.fields.count_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="year_id">{{ trans('cruds.studentCountPerTerm.fields.year') }}</label>
                <select class="form-control select2 {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year_id" id="year_id">
                    @foreach($years as $id => $entry)
                        <option value="{{ $id }}" {{ (old('year_id') ? old('year_id') : $studentCountPerTerm->year->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('year') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentCountPerTerm.fields.year_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.studentCountPerTerm.fields.term') }}</label>
                <select class="form-control {{ $errors->has('term') ? 'is-invalid' : '' }}" name="term" id="term">
                    <option value disabled {{ old('term', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\StudentCountPerTerm::TERM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('term', $studentCountPerTerm->term) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('term'))
                    <div class="invalid-feedback">
                        {{ $errors->first('term') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentCountPerTerm.fields.term_helper') }}</span>
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