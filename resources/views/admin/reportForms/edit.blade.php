@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.reportForm.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.report-forms.update", [$reportForm->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="student_id">{{ trans('cruds.reportForm.fields.student') }}</label>
                <select class="form-control select2 {{ $errors->has('student') ? 'is-invalid' : '' }}" name="student_id" id="student_id" required>
                    @foreach($students as $id => $entry)
                        <option value="{{ $id }}" {{ (old('student_id') ? old('student_id') : $reportForm->student->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('student'))
                    <div class="invalid-feedback">
                        {{ $errors->first('student') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.reportForm.fields.student_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.reportForm.fields.school_term') }}</label>
                <select class="form-control {{ $errors->has('school_term') ? 'is-invalid' : '' }}" name="school_term" id="school_term">
                    <option value disabled {{ old('school_term', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\ReportForm::SCHOOL_TERM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('school_term', $reportForm->school_term) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('school_term'))
                    <div class="invalid-feedback">
                        {{ $errors->first('school_term') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.reportForm.fields.school_term_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="year_id">{{ trans('cruds.reportForm.fields.year') }}</label>
                <select class="form-control select2 {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year_id" id="year_id" required>
                    @foreach($years as $id => $entry)
                        <option value="{{ $id }}" {{ (old('year_id') ? old('year_id') : $reportForm->year->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('year') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.reportForm.fields.year_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="report_form">{{ trans('cruds.reportForm.fields.report_form') }}</label>
                <div class="needsclick dropzone {{ $errors->has('report_form') ? 'is-invalid' : '' }}" id="report_form-dropzone">
                </div>
                @if($errors->has('report_form'))
                    <div class="invalid-feedback">
                        {{ $errors->first('report_form') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.reportForm.fields.report_form_helper') }}</span>
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
    var uploadedReportFormMap = {}
Dropzone.options.reportFormDropzone = {
    url: '{{ route('admin.report-forms.storeMedia') }}',
    maxFilesize: 8, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 8
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="report_form[]" value="' + response.name + '">')
      uploadedReportFormMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedReportFormMap[file.name]
      }
      $('form').find('input[name="report_form[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($reportForm) && $reportForm->report_form)
          var files =
            {!! json_encode($reportForm->report_form) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="report_form[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection