@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.feeBalance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.fee-balances.update", [$feeBalance->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="admission_number_id">{{ trans('cruds.feeBalance.fields.admission_number') }}</label>
                <select class="form-control select2 {{ $errors->has('admission_number') ? 'is-invalid' : '' }}" name="admission_number_id" id="admission_number_id">
                    @foreach($admission_numbers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('admission_number_id') ? old('admission_number_id') : $feeBalance->admission_number->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('admission_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('admission_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.feeBalance.fields.admission_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="balance">{{ trans('cruds.feeBalance.fields.balance') }}</label>
                <input class="form-control {{ $errors->has('balance') ? 'is-invalid' : '' }}" type="number" name="balance" id="balance" value="{{ old('balance', $feeBalance->balance) }}" step="0.01">
                @if($errors->has('balance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('balance') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.feeBalance.fields.balance_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.feeBalance.fields.term') }}</label>
                <select class="form-control {{ $errors->has('term') ? 'is-invalid' : '' }}" name="term" id="term">
                    <option value disabled {{ old('term', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\FeeBalance::TERM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('term', $feeBalance->term) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('term'))
                    <div class="invalid-feedback">
                        {{ $errors->first('term') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.feeBalance.fields.term_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="year_id">{{ trans('cruds.feeBalance.fields.year') }}</label>
                <select class="form-control select2 {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year_id" id="year_id">
                    @foreach($years as $id => $entry)
                        <option value="{{ $id }}" {{ (old('year_id') ? old('year_id') : $feeBalance->year->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('year') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.feeBalance.fields.year_helper') }}</span>
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