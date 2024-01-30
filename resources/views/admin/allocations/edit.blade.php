@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.allocation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.allocations.update", [$allocation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.allocation.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $allocation->amount) }}" step="0.01" required>
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_code">{{ trans('cruds.allocation.fields.payment_code') }}</label>
                <input class="form-control {{ $errors->has('payment_code') ? 'is-invalid' : '' }}" type="text" name="payment_code" id="payment_code" value="{{ old('payment_code', $allocation->payment_code) }}">
                @if($errors->has('payment_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.payment_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cheque_no">{{ trans('cruds.allocation.fields.cheque_no') }}</label>
                <input class="form-control {{ $errors->has('cheque_no') ? 'is-invalid' : '' }}" type="text" name="cheque_no" id="cheque_no" value="{{ old('cheque_no', $allocation->cheque_no) }}">
                @if($errors->has('cheque_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cheque_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.cheque_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.allocation.fields.remarks') }}</label>
                <textarea class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" name="remarks" id="remarks">{{ old('remarks', $allocation->remarks) }}</textarea>
                @if($errors->has('remarks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remarks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.remarks_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.allocation.fields.term') }}</label>
                <select class="form-control {{ $errors->has('term') ? 'is-invalid' : '' }}" name="term" id="term">
                    <option value disabled {{ old('term', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Allocation::TERM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('term', $allocation->term) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('term'))
                    <div class="invalid-feedback">
                        {{ $errors->first('term') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.term_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_name">{{ trans('cruds.allocation.fields.bank_name') }}</label>
                <input class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $allocation->bank_name) }}">
                @if($errors->has('bank_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.bank_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="other_details">{{ trans('cruds.allocation.fields.other_details') }}</label>
                <input class="form-control {{ $errors->has('other_details') ? 'is-invalid' : '' }}" type="text" name="other_details" id="other_details" value="{{ old('other_details', $allocation->other_details) }}">
                @if($errors->has('other_details'))
                    <div class="invalid-feedback">
                        {{ $errors->first('other_details') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.other_details_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="year_id">{{ trans('cruds.allocation.fields.year') }}</label>
                <select class="form-control select2 {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year_id" id="year_id">
                    @foreach($years as $id => $entry)
                        <option value="{{ $id }}" {{ (old('year_id') ? old('year_id') : $allocation->year->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('year') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.year_helper') }}</span>
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