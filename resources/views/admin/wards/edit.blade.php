@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.ward.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.wards.update", [$ward->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.ward.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $ward->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ward.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="constituency_id">{{ trans('cruds.ward.fields.constituency') }}</label>
                <select class="form-control select2 {{ $errors->has('constituency') ? 'is-invalid' : '' }}" name="constituency_id" id="constituency_id">
                    @foreach($constituencies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('constituency_id') ? old('constituency_id') : $ward->constituency->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('constituency'))
                    <div class="invalid-feedback">
                        {{ $errors->first('constituency') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ward.fields.constituency_helper') }}</span>
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