@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.studentBursaryRegister.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.student-bursary-registers.update", [$studentBursaryRegister->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required">{{ trans('cruds.studentBursaryRegister.fields.term') }}</label>
                <select class="form-control {{ $errors->has('term') ? 'is-invalid' : '' }}" name="term" id="term" required>
                    <option value disabled {{ old('term', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\StudentBursaryRegister::TERM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('term', $studentBursaryRegister->term) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('term'))
                    <div class="invalid-feedback">
                        {{ $errors->first('term') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentBursaryRegister.fields.term_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="year_id">{{ trans('cruds.studentBursaryRegister.fields.year') }}</label>
                <select class="form-control select2 {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year_id" id="year_id" required>
                    @foreach($years as $id => $entry)
                        <option value="{{ $id }}" {{ (old('year_id') ? old('year_id') : $studentBursaryRegister->year->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('year') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentBursaryRegister.fields.year_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount_paid">{{ trans('cruds.studentBursaryRegister.fields.amount_paid') }}</label>
                <input class="form-control {{ $errors->has('amount_paid') ? 'is-invalid' : '' }}" type="number" name="amount_paid" id="amount_paid" value="{{ old('amount_paid', $studentBursaryRegister->amount_paid) }}" step="0.01" required>
                @if($errors->has('amount_paid'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount_paid') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentBursaryRegister.fields.amount_paid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="requested_by_id">{{ trans('cruds.studentBursaryRegister.fields.requested_by') }}</label>
                <select class="form-control select2 {{ $errors->has('requested_by') ? 'is-invalid' : '' }}" name="requested_by_id" id="requested_by_id">
                    @foreach($requested_bies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('requested_by_id') ? old('requested_by_id') : $studentBursaryRegister->requested_by->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('requested_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('requested_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentBursaryRegister.fields.requested_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="admission_number_id">{{ trans('cruds.studentBursaryRegister.fields.admission_number') }}</label>
                <select class="form-control select2 {{ $errors->has('admission_number') ? 'is-invalid' : '' }}" name="admission_number_id" id="admission_number_id">
                    @foreach($admission_numbers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('admission_number_id') ? old('admission_number_id') : $studentBursaryRegister->admission_number->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('admission_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('admission_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentBursaryRegister.fields.admission_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_code">{{ trans('cruds.studentBursaryRegister.fields.payment_code') }}</label>
                <input class="form-control {{ $errors->has('payment_code') ? 'is-invalid' : '' }}" type="text" name="payment_code" id="payment_code" value="{{ old('payment_code', $studentBursaryRegister->payment_code) }}">
                @if($errors->has('payment_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentBursaryRegister.fields.payment_code_helper') }}</span>
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