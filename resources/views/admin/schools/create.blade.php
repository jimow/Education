@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.school.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.schools.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.school.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="gender_type_id">{{ trans('cruds.school.fields.gender_type') }}</label>
                <select class="form-control select2 {{ $errors->has('gender_type') ? 'is-invalid' : '' }}" name="gender_type_id" id="gender_type_id" required>
                    @foreach($gender_types as $id => $entry)
                        <option value="{{ $id }}" {{ old('gender_type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gender_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.gender_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="category_id">{{ trans('cruds.school.fields.category') }}</label>
                <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id" required>
                    @foreach($categories as $id => $entry)
                        <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="ward_id">{{ trans('cruds.school.fields.ward') }}</label>
                <select class="form-control select2 {{ $errors->has('ward') ? 'is-invalid' : '' }}" name="ward_id" id="ward_id" required>
                    @foreach($wards as $id => $entry)
                        <option value="{{ $id }}" {{ old('ward_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('ward'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ward') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.ward_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="principal_id">{{ trans('cruds.school.fields.principal') }}</label>
                <select class="form-control select2 {{ $errors->has('principal') ? 'is-invalid' : '' }}" name="principal_id" id="principal_id">
                    @foreach($principals as $id => $entry)
                        <option value="{{ $id }}" {{ old('principal_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('principal'))
                    <div class="invalid-feedback">
                        {{ $errors->first('principal') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.principal_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone_number">{{ trans('cruds.school.fields.phone_number') }}</label>
                <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', '') }}">
                @if($errors->has('phone_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.phone_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.school.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="postal_address">{{ trans('cruds.school.fields.postal_address') }}</label>
                <input class="form-control {{ $errors->has('postal_address') ? 'is-invalid' : '' }}" type="text" name="postal_address" id="postal_address" value="{{ old('postal_address', '') }}">
                @if($errors->has('postal_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('postal_address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.postal_address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="physical_address">{{ trans('cruds.school.fields.physical_address') }}</label>
                <input class="form-control {{ $errors->has('physical_address') ? 'is-invalid' : '' }}" type="text" name="physical_address" id="physical_address" value="{{ old('physical_address', '') }}">
                @if($errors->has('physical_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('physical_address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.physical_address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="physical_location">{{ trans('cruds.school.fields.physical_location') }}</label>
                <input class="form-control {{ $errors->has('physical_location') ? 'is-invalid' : '' }}" type="text" name="physical_location" id="physical_location" value="{{ old('physical_location', '') }}">
                @if($errors->has('physical_location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('physical_location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.physical_location_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="code">{{ trans('cruds.school.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}" required>
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="registered_by_id">{{ trans('cruds.school.fields.registered_by') }}</label>
                <select class="form-control select2 {{ $errors->has('registered_by') ? 'is-invalid' : '' }}" name="registered_by_id" id="registered_by_id">
                    @foreach($registered_bies as $id => $entry)
                        <option value="{{ $id }}" {{ old('registered_by_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('registered_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('registered_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.registered_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="approved_by_id">{{ trans('cruds.school.fields.approved_by') }}</label>
                <select class="form-control select2 {{ $errors->has('approved_by') ? 'is-invalid' : '' }}" name="approved_by_id" id="approved_by_id">
                    @foreach($approved_bies as $id => $entry)
                        <option value="{{ $id }}" {{ old('approved_by_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('approved_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('approved_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.approved_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fees">{{ trans('cruds.school.fields.fees') }}</label>
                <input class="form-control {{ $errors->has('fees') ? 'is-invalid' : '' }}" type="text" name="fees" id="fees" value="{{ old('fees', '') }}">
                @if($errors->has('fees'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fees') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.fees_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.school.fields.uniform_fee') }}</label>
                @foreach(App\Models\School::UNIFORM_FEE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('uniform_fee') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="uniform_fee_{{ $key }}" name="uniform_fee" value="{{ $key }}" {{ old('uniform_fee', '') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="uniform_fee_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('uniform_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('uniform_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.uniform_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="f_1_fee">{{ trans('cruds.school.fields.f_1_fee') }}</label>
                <input class="form-control {{ $errors->has('f_1_fee') ? 'is-invalid' : '' }}" type="number" name="f_1_fee" id="f_1_fee" value="{{ old('f_1_fee', '') }}" step="0.01">
                @if($errors->has('f_1_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('f_1_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.f_1_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="f_2_fee">{{ trans('cruds.school.fields.f_2_fee') }}</label>
                <input class="form-control {{ $errors->has('f_2_fee') ? 'is-invalid' : '' }}" type="text" name="f_2_fee" id="f_2_fee" value="{{ old('f_2_fee', '') }}">
                @if($errors->has('f_2_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('f_2_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.f_2_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="f_3_fee">{{ trans('cruds.school.fields.f_3_fee') }}</label>
                <input class="form-control {{ $errors->has('f_3_fee') ? 'is-invalid' : '' }}" type="number" name="f_3_fee" id="f_3_fee" value="{{ old('f_3_fee', '') }}" step="0.01">
                @if($errors->has('f_3_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('f_3_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.f_3_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="f_4_fee">{{ trans('cruds.school.fields.f_4_fee') }}</label>
                <input class="form-control {{ $errors->has('f_4_fee') ? 'is-invalid' : '' }}" type="number" name="f_4_fee" id="f_4_fee" value="{{ old('f_4_fee', '') }}" step="0.01">
                @if($errors->has('f_4_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('f_4_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.f_4_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="b_1_fee">{{ trans('cruds.school.fields.b_1_fee') }}</label>
                <input class="form-control {{ $errors->has('b_1_fee') ? 'is-invalid' : '' }}" type="number" name="b_1_fee" id="b_1_fee" value="{{ old('b_1_fee', '') }}" step="0.01">
                @if($errors->has('b_1_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('b_1_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.b_1_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="b_2_fee">{{ trans('cruds.school.fields.b_2_fee') }}</label>
                <input class="form-control {{ $errors->has('b_2_fee') ? 'is-invalid' : '' }}" type="number" name="b_2_fee" id="b_2_fee" value="{{ old('b_2_fee', '') }}" step="0.01">
                @if($errors->has('b_2_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('b_2_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.b_2_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="b_3_fee">{{ trans('cruds.school.fields.b_3_fee') }}</label>
                <input class="form-control {{ $errors->has('b_3_fee') ? 'is-invalid' : '' }}" type="text" name="b_3_fee" id="b_3_fee" value="{{ old('b_3_fee', '') }}">
                @if($errors->has('b_3_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('b_3_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.b_3_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="b_4_fee">{{ trans('cruds.school.fields.b_4_fee') }}</label>
                <input class="form-control {{ $errors->has('b_4_fee') ? 'is-invalid' : '' }}" type="text" name="b_4_fee" id="b_4_fee" value="{{ old('b_4_fee', '') }}">
                @if($errors->has('b_4_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('b_4_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.school.fields.b_4_fee_helper') }}</span>
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