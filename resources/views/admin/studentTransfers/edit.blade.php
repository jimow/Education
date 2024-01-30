@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.studentTransfer.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.student-transfers.update", [$studentTransfer->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="admission_number_id">{{ trans('cruds.studentTransfer.fields.admission_number') }}</label>
                <select class="form-control select2 {{ $errors->has('admission_number') ? 'is-invalid' : '' }}" name="admission_number_id" id="admission_number_id" required>
                    @foreach($admission_numbers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('admission_number_id') ? old('admission_number_id') : $studentTransfer->admission_number->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('admission_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('admission_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentTransfer.fields.admission_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="trasnsfer_from_id">{{ trans('cruds.studentTransfer.fields.trasnsfer_from') }}</label>
                <select class="form-control select2 {{ $errors->has('trasnsfer_from') ? 'is-invalid' : '' }}" name="trasnsfer_from_id" id="trasnsfer_from_id" required>
                    @foreach($trasnsfer_froms as $id => $entry)
                        <option value="{{ $id }}" {{ (old('trasnsfer_from_id') ? old('trasnsfer_from_id') : $studentTransfer->trasnsfer_from->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('trasnsfer_from'))
                    <div class="invalid-feedback">
                        {{ $errors->first('trasnsfer_from') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentTransfer.fields.trasnsfer_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="transfer_to_id">{{ trans('cruds.studentTransfer.fields.transfer_to') }}</label>
                <select class="form-control select2 {{ $errors->has('transfer_to') ? 'is-invalid' : '' }}" name="transfer_to_id" id="transfer_to_id" required>
                    @foreach($transfer_tos as $id => $entry)
                        <option value="{{ $id }}" {{ (old('transfer_to_id') ? old('transfer_to_id') : $studentTransfer->transfer_to->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('transfer_to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('transfer_to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentTransfer.fields.transfer_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="confirmed_by_id">{{ trans('cruds.studentTransfer.fields.confirmed_by') }}</label>
                <select class="form-control select2 {{ $errors->has('confirmed_by') ? 'is-invalid' : '' }}" name="confirmed_by_id" id="confirmed_by_id">
                    @foreach($confirmed_bies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('confirmed_by_id') ? old('confirmed_by_id') : $studentTransfer->confirmed_by->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('confirmed_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('confirmed_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentTransfer.fields.confirmed_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.studentTransfer.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\StudentTransfer::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $studentTransfer->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentTransfer.fields.status_helper') }}</span>
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