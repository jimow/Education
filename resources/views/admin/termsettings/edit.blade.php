@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.termsetting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.termsettings.update", [$termsetting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="term">{{ trans('cruds.termsetting.fields.term') }}</label>
                <input class="form-control {{ $errors->has('term') ? 'is-invalid' : '' }}" type="text" name="term" id="term" value="{{ old('term', $termsetting->term) }}">
                @if($errors->has('term'))
                    <div class="invalid-feedback">
                        {{ $errors->first('term') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.termsetting.fields.term_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="begins">{{ trans('cruds.termsetting.fields.begins') }}</label>
                <input class="form-control date {{ $errors->has('begins') ? 'is-invalid' : '' }}" type="text" name="begins" id="begins" value="{{ old('begins', $termsetting->begins) }}">
                @if($errors->has('begins'))
                    <div class="invalid-feedback">
                        {{ $errors->first('begins') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.termsetting.fields.begins_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ends">{{ trans('cruds.termsetting.fields.ends') }}</label>
                <input class="form-control date {{ $errors->has('ends') ? 'is-invalid' : '' }}" type="text" name="ends" id="ends" value="{{ old('ends', $termsetting->ends) }}">
                @if($errors->has('ends'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ends') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.termsetting.fields.ends_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="year_id">{{ trans('cruds.termsetting.fields.year') }}</label>
                <select class="form-control select2 {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year_id" id="year_id">
                    @foreach($years as $id => $entry)
                        <option value="{{ $id }}" {{ (old('year_id') ? old('year_id') : $termsetting->year->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('year') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.termsetting.fields.year_helper') }}</span>
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