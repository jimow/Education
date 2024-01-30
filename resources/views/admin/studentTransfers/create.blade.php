@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.studentTransfer.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.student-transfers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="admission_number_id">{{ trans('cruds.studentTransfer.fields.admission_number') }}</label>
                <select class="form-control select2 {{ $errors->has('admission_number') ? 'is-invalid' : '' }}" name="admission_number_id" id="admission_number_id" required>
                    @foreach($admission_numbers as $id => $entry)
                        <option value="{{ $id }}" {{ old('admission_number_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                 
                        @endforeach
                </select>
                @if($errors->has('admission_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('admission_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentTransfer.fields.admission_number_helper') }}</span>
            </div>
          
            <div class="row" id="fname">
            <div class="form-group col-md-6">
                <label for="full_names">Full Names</label>
                <input type="text" class="form-control" id="fullnames" name="fullnames">
            </div>
            <div class="form-group col-md-6">
                <label for="nemis_number">Nemis Number</label>
                <input type="text" class="form-control" id="nemis_number" name="nemis_number">
            </div>
            </div>

            <div class="row" id="on_s">
                <div class="form-group col-md-6">
                    <label for="full_names">On ScholarShip</label>
                    <p id="scholarship"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="nemis_number">Disability</label>
                    <p id="disability"></p>
                </div>
                </div>


           <div class="row" id="transfer">
            <div class="form-group col-md-6">
                <label class="required" for="trasnsfer_from_id">{{ trans('cruds.studentTransfer.fields.trasnsfer_from') }}</label>
                <select class="form-control select2 {{ $errors->has('trasnsfer_from') ? 'is-invalid' : '' }}" name="trasnsfer_from_id" id="trasnsfer_from_id" required>
                    @foreach($trasnsfer_froms as $id => $entry)
                        <option value="{{ $id }}" {{ old('trasnsfer_from_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('trasnsfer_from'))
                    <div class="invalid-feedback">
                        {{ $errors->first('trasnsfer_from') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentTransfer.fields.trasnsfer_from_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label class="required" for="transfer_to_id">{{ trans('cruds.studentTransfer.fields.transfer_to') }}</label>
                <select class="form-control select2 {{ $errors->has('transfer_to') ? 'is-invalid' : '' }}" name="transfer_to_id" id="transfer_to_id" required>
                    @foreach($transfer_tos as $id => $entry)
                        <option value="{{ $id }}" {{ old('transfer_to_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('transfer_to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('transfer_to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentTransfer.fields.transfer_to_helper') }}</span>
            </div>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.studentTransfer.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\StudentTransfer::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
@section('scripts')

<script>
$(document).ready(function() {


     $('#fname').hide();
     $('#on_s').hide();
    $('#admission_number_id').change(function() {

     
        var admissionNumberId = $(this).val();
        if (admissionNumberId) {
            $.ajax({
                url: '{{ route('admin.students.student-details', ['admissionNumberId' => '__admissionNumberId__']) }}'.replace('__admissionNumberId__', admissionNumberId),
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('#fname').show();
                    $('#on_s').show();
                    $('#fullnames').val(data.fullname);
                    $('#nemis_number').val(data.nemis_number);

                    $('#trasnsfer_from_id').val(data.school_id).trigger('change');
                    $('#disability').text(data.disability);
                    $('#scholarship').text(data.on_scholarship);
                    // Update other fields
                }
            });
        }
    });
});
</script>

@endsection
