@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.bursary.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bursaries.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="school_id">{{ trans('cruds.bursary.fields.school') }}</label>
                <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}" name="school_id" id="school_id" required>
                    @foreach($schools as $id => $entry)
                        <option value="{{ $id }}" {{ old('school_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('school'))
                    <div class="invalid-feedback">
                        {{ $errors->first('school') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bursary.fields.school_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.bursary.fields.school_term') }}</label>
                <select class="form-control {{ $errors->has('school_term') ? 'is-invalid' : '' }}" name="school_term" id="school_term">
                    <option value disabled {{ old('school_term', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Bursary::SCHOOL_TERM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('school_term', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('school_term'))
                    <div class="invalid-feedback">
                        {{ $errors->first('school_term') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bursary.fields.school_term_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="year_id">{{ trans('cruds.bursary.fields.year') }}</label>
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
                <span class="help-block">{{ trans('cruds.bursary.fields.year_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="amount_paid">{{ trans('cruds.bursary.fields.amount_paid') }}</label>
                <input class="form-control {{ $errors->has('amount_paid') ? 'is-invalid' : '' }}" type="number" name="amount_paid" id="amount_paid" value="{{ old('amount_paid', '0.00') }}" step="0.01">
                @if($errors->has('amount_paid'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount_paid') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bursary.fields.amount_paid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cheque_no">{{ trans('cruds.bursary.fields.cheque_no') }}</label>
                <input class="form-control {{ $errors->has('cheque_no') ? 'is-invalid' : '' }}" type="text" name="cheque_no" id="cheque_no" value="{{ old('cheque_no', '') }}">
                @if($errors->has('cheque_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cheque_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bursary.fields.cheque_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_code">{{ trans('cruds.bursary.fields.payment_code') }}</label>
                <input class="form-control {{ $errors->has('payment_code') ? 'is-invalid' : '' }}" type="text" name="payment_code" id="payment_code" value="{{ old('payment_code', '') }}">
                @if($errors->has('payment_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bursary.fields.payment_code_helper') }}</span>
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