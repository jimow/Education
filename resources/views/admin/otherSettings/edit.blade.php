@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.otherSetting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.other-settings.update", [$otherSetting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.otherSetting.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $otherSetting->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.otherSetting.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fees_percentage">{{ trans('cruds.otherSetting.fields.fees_percentage') }}</label>
                <input class="form-control {{ $errors->has('fees_percentage') ? 'is-invalid' : '' }}" type="text" name="fees_percentage" id="fees_percentage" value="{{ old('fees_percentage', $otherSetting->fees_percentage) }}">
                @if($errors->has('fees_percentage'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fees_percentage') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.otherSetting.fields.fees_percentage_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="term_1">{{ trans('cruds.otherSetting.fields.term_1') }}</label>
                <input class="form-control {{ $errors->has('term_1') ? 'is-invalid' : '' }}" type="text" name="term_1" id="term_1" value="{{ old('term_1', $otherSetting->term_1) }}">
                @if($errors->has('term_1'))
                    <div class="invalid-feedback">
                        {{ $errors->first('term_1') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.otherSetting.fields.term_1_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="term_2">{{ trans('cruds.otherSetting.fields.term_2') }}</label>
                <input class="form-control {{ $errors->has('term_2') ? 'is-invalid' : '' }}" type="text" name="term_2" id="term_2" value="{{ old('term_2', $otherSetting->term_2) }}">
                @if($errors->has('term_2'))
                    <div class="invalid-feedback">
                        {{ $errors->first('term_2') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.otherSetting.fields.term_2_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="term_3">{{ trans('cruds.otherSetting.fields.term_3') }}</label>
                <input class="form-control {{ $errors->has('term_3') ? 'is-invalid' : '' }}" type="text" name="term_3" id="term_3" value="{{ old('term_3', $otherSetting->term_3) }}">
                @if($errors->has('term_3'))
                    <div class="invalid-feedback">
                        {{ $errors->first('term_3') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.otherSetting.fields.term_3_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="day_fees_percentage">{{ trans('cruds.otherSetting.fields.day_fees_percentage') }}</label>
                <input class="form-control {{ $errors->has('day_fees_percentage') ? 'is-invalid' : '' }}" type="text" name="day_fees_percentage" id="day_fees_percentage" value="{{ old('day_fees_percentage', $otherSetting->day_fees_percentage) }}">
                @if($errors->has('day_fees_percentage'))
                    <div class="invalid-feedback">
                        {{ $errors->first('day_fees_percentage') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.otherSetting.fields.day_fees_percentage_helper') }}</span>
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