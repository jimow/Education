@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.feeBalanceSchool.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.fee-balance-schools.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="school_id">{{ trans('cruds.feeBalanceSchool.fields.school') }}</label>
                <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}" name="school_id" id="school_id">
                    @foreach($schools as $id => $entry)
                        <option value="{{ $id }}" {{ old('school_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('school'))
                    <div class="invalid-feedback">
                        {{ $errors->first('school') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.feeBalanceSchool.fields.school_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="balance">{{ trans('cruds.feeBalanceSchool.fields.balance') }}</label>
                <input class="form-control {{ $errors->has('balance') ? 'is-invalid' : '' }}" type="number" name="balance" id="balance" value="{{ old('balance', '') }}" step="0.01">
                @if($errors->has('balance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('balance') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.feeBalanceSchool.fields.balance_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.feeBalanceSchool.fields.term') }}</label>
                <select class="form-control {{ $errors->has('term') ? 'is-invalid' : '' }}" name="term" id="term">
                    <option value disabled {{ old('term', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\FeeBalanceSchool::TERM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('term', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('term'))
                    <div class="invalid-feedback">
                        {{ $errors->first('term') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.feeBalanceSchool.fields.term_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="year_id">{{ trans('cruds.feeBalanceSchool.fields.year') }}</label>
                <select class="form-control select2 {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year_id" id="year_id">
                    @foreach($years as $id => $entry)
                        <option value="{{ $id }}" {{ old('year_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('year') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.feeBalanceSchool.fields.year_helper') }}</span>
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