@extends('layouts.admin')
@section('content')
<style>

/* Add custom CSS styles here */
#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey;
}

#progressbar li {
    list-style-type: none;
    font-size: 12px;
    width: 33.33%;
    float: left;
    position: relative;
}
label {
    font-weight: bold;
}

#progressbar li.active {
    color: red;
    font-weight: bold;
}

input[type="button"] {
    display: block;
    margin: auto;
  
}








</style>
<div class="card">
    <div class="card-header bg-success text-white">
        {{ trans('global.create') }} {{ trans('cruds.student.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.students.store") }}" enctype="multipart/form-data">
            @csrf
<div class="container">
    <div class="row">
        <div class="col-md-12">
            
                <!-- Progress Bar -->
                <ul id="progressbar">
                    <li class="active">Student Details</li>
                    <li >Parent / Guardian Details</li>
                    <li >School Details</li>
                </ul>
                <!-- Student Details -->
                <fieldset>
				
                
                

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="required" for="fullname">{{ trans('cruds.student.fields.fullname') }}</label>
                                <input class="form-control {{ $errors->has('fullname') ? 'is-invalid' : '' }}" type="text" name="fullname" id="fullname" value="{{ old('fullname', '') }}" required>
                                @if($errors->has('fullname'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('fullname') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.fullname_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="required">{{ trans('cruds.student.fields.gender') }}</label>
                                <select class="form-control select2 {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender" required>
                                    <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                    @foreach(App\Models\Student::GENDER_SELECT as $key => $label)
                                        <option value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('gender'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('gender') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.gender_helper') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="required font-weight-bold" for="date_of_birth">{{ trans('cruds.student.fields.date_of_birth') }}</label>
                                <input class="form-control date {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" type="text" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                @if($errors->has('date_of_birth'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('date_of_birth') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.date_of_birth_helper') }}</span>
                            </div>
                        </div>
                            
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="required" for="ward_id">{{ trans('cruds.student.fields.ward') }}</label>
                                <select class="form-control select {{ $errors->has('ward') ? 'is-invalid' : '' }}" name="ward_id" id="ward_id" required>
                                    @foreach($wards as $id => $entry)
                                        <option value="{{ $id }}" {{ old('ward_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('ward'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('ward') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.ward_helper') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="required" for="admission_number">{{ trans('cruds.student.fields.admission_number') }}</label>
                                <input class="form-control {{ $errors->has('admission_number') ? 'is-invalid' : '' }}" type="text" name="admission_number" id="admission_number" value="{{ old('admission_number', '') }}" required>
                                @if($errors->has('admission_number'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('admission_number') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.admission_number_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="required" for="nemis_number">{{ trans('cruds.student.fields.nemis_number') }}</label>
                                <input class="form-control {{ $errors->has('nemis_number') ? 'is-invalid' : '' }}" type="text" name="nemis_number" id="nemis_number" value="{{ old('nemis_number', '') }}" required>
                                @if($errors->has('nemis_number'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nemis_number') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.nemis_number_helper') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="required">{{ trans('cruds.student.fields.on_scholarship') }}</label>
                                <select class="form-control select2 {{ $errors->has('on_scholarship') ? 'is-invalid' : '' }}" name="on_scholarship" id="on_scholarship" required>
                                    <option value disabled {{ old('on_scholarship', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                    @foreach(App\Models\Student::ON_SCHOLARSHIP_SELECT as $key => $label)
                                        <option value="{{ $key }}" {{ old('on_scholarship', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('on_scholarship'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('on_scholarship') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.on_scholarship_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="scholarship_amount">{{ trans('cruds.student.fields.scholarship_amount') }}</label>
                                <input class="form-control {{ $errors->has('scholarship_amount') ? 'is-invalid' : '' }}" type="number" name="scholarship_amount" id="scholarship_amount" value="{{ old('scholarship_amount', '') }}" step="0.01">
                                @if($errors->has('scholarship_amount'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('scholarship_amount') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.scholarship_amount_helper') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="required">{{ trans('cruds.student.fields.disability') }}</label>
                                <select class="form-control {{ $errors->has('disability') ? 'is-invalid' : '' }}" name="disability" id="disability" required>
                                    <option value disabled {{ old('disability', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                    @foreach(App\Models\Student::DISABILITY_SELECT as $key => $label)
                                        <option value="{{ $key }}" {{ old('disability', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('disability'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('disability') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.disability_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="birth_certificate_number">{{ trans('cruds.student.fields.birth_certificate_number') }}</label>
                                <input class="form-control {{ $errors->has('birth_certificate_number') ? 'is-invalid' : '' }}" type="text" name="birth_certificate_number" id="birth_certificate_number" value="{{ old('birth_certificate_number', '') }}">
                                @if($errors->has('birth_certificate_number'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('birth_certificate_number') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.birth_certificate_number_helper') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="photo">{{ trans('cruds.student.fields.photo') }}</label>
                                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                                </div>
                                @if($errors->has('photo'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('photo') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.photo_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="birth_certificate">{{ trans('cruds.student.fields.birth_certificate') }}</label>
                                <div class="needsclick dropzone {{ $errors->has('birth_certificate') ? 'is-invalid' : '' }}" id="birth_certificate-dropzone">
                                </div>
                                @if($errors->has('birth_certificate'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('birth_certificate') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.birth_certificate_helper') }}</span>
                            </div>
                        </div>
                    </div>
                    

               
           
                    <!-- All the input fields for student details -->
                    <input type="button" name="next" class="next action-button btn btn-primary mx-auto" value="Next" />
                </fieldset>

                <!-- Parent / Guardian Details -->
                <fieldset>
				
                    
                    <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.student.fields.parental_status') }}</label>
                            <select class="form-control select2{{ $errors->has('parental_status') ? 'is-invalid' : '' }}" name="parental_status" id="parental_status" required>
                                <option value disabled {{ old('parental_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Student::PARENTAL_STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('parental_status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('parental_status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('parental_status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.parental_status_helper') }}</span>
                        </div>
                     </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="father_fullname">{{ trans('cruds.student.fields.father_fullname') }}</label>
                                <input class="form-control {{ $errors->has('father_fullname') ? 'is-invalid' : '' }}" type="text" name="father_fullname" id="father_fullname" value="{{ old('father_fullname', '') }}">
                                @if($errors->has('father_fullname'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('father_fullname') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.father_fullname_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label  for="mother_fullname">{{ trans('cruds.student.fields.mother_fullname') }}</label>
                                <input class="form-control {{ $errors->has('mother_fullname') ? 'is-invalid' : '' }}" type="text" name="mother_fullname" id="mother_fullname" value="{{ old('mother_fullname', '') }}" >
                                @if($errors->has('mother_fullname'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('mother_fullname') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.mother_fullname_helper') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="father_phone_number">{{ trans('cruds.student.fields.father_phone_number') }}</label>
                                <input class="form-control {{ $errors->has('father_phone_number') ? 'is-invalid' : '' }}" type="text" name="father_phone_number" id="father_phone_number" value="{{ old('father_phone_number', '') }}">
                                @if($errors->has('father_phone_number'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('father_phone_number') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.father_phone_number_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label  for="mother_phone_number">{{ trans('cruds.student.fields.mother_phone_number') }}</label>
                                <input class="form-control {{ $errors->has('mother_phone_number') ? 'is-invalid' : '' }}" type="text" name="mother_phone_number" id="mother_phone_number" value="{{ old('mother_phone_number', '') }}">
                                @if($errors->has('mother_phone_number'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('mother_phone_number') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.mother_phone_number_helper') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="father_national_id_no">{{ trans('cruds.student.fields.father_national_id_no') }}</label>
                                <input class="form-control {{ $errors->has('father_national_id_no') ? 'is-invalid' : '' }}" type="text" name="father_national_id_no" id="father_national_id_no" value="{{ old('father_national_id_no', '') }}">
                                @if($errors->has('father_national_id_no'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('father_national_id_no') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.father_national_id_no_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            
                                <div class="form-group">
                                    <label for="mother_national_id_no">{{ trans('cruds.student.fields.mother_national_id_no') }}</label>
                                    <input class="form-control {{ $errors->has('mother_national_id_no') ? 'is-invalid' : '' }}" type="text" name="mother_national_id_no" id="mother_national_id_no" value="{{ old('mother_national_id_no', '') }}">
                                    @if($errors->has('mother_national_id_no'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('mother_national_id_no') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.student.fields.mother_national_id_no_helper') }}</span>
                                </div>
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="father_death_certificate">{{ trans('cruds.student.fields.father_death_certificate') }}</label>
                                <div class="needsclick dropzone {{ $errors->has('father_death_certificate') ? 'is-invalid' : '' }}" id="father_death_certificate-dropzone">
                                </div>
                                @if($errors->has('father_death_certificate'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('father_death_certificate') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.father_death_certificate_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mother_death_certificate">{{ trans('cruds.student.fields.mother_death_certificate') }}</label>
                                <div class="needsclick dropzone {{ $errors->has('mother_death_certificate') ? 'is-invalid' : '' }}" id="mother_death_certificate-dropzone">
                                </div>
                                @if($errors->has('mother_death_certificate'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('mother_death_certificate') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.mother_death_certificate_helper') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label for="guardian_fullname">{{ trans('cruds.student.fields.guardian_fullname') }}</label>
                            <input class="form-control {{ $errors->has('guardian_fullname') ? 'is-invalid' : '' }}" type="text" name="guardian_fullname" id="guardian_fullname" value="{{ old('guardian_fullname', '') }}">
                            @if($errors->has('guardian_fullname'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('guardian_fullname') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.guardian_fullname_helper') }}</span>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="guardian_phone_number">{{ trans('cruds.student.fields.guardian_phone_number') }}</label>
                            <input class="form-control {{ $errors->has('guardian_phone_number') ? 'is-invalid' : '' }}" type="text" name="guardian_phone_number" id="guardian_phone_number" value="{{ old('guardian_phone_number', '') }}">
                            @if($errors->has('guardian_phone_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('guardian_phone_number') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.guardian_phone_number_helper') }}</span>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="guardian_national">{{ trans('cruds.student.fields.guardian_national') }}</label>
                            <input class="form-control {{ $errors->has('guardian_national') ? 'is-invalid' : '' }}" type="text" name="guardian_national" id="guardian_national" value="{{ old('guardian_national', '') }}">
                            @if($errors->has('guardian_national'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('guardian_national') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.guardian_national_helper') }}</span>
                        </div>
                    
                    </div>

               
                    <!-- All the input fields for parent/guardian details -->
                    
                        <input type="button" name="previous" class="previous action-button btn btn-primary" value="Previous" />
                        <input type="button" name="next" class="next action-button btn btn-primary" value="Next button button" />
                 
                </fieldset>

                <!-- School Details -->
                <fieldset>
				
               
              

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="required" for="school_id">{{ trans('cruds.student.fields.school') }}</label>
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
                                <span class="help-block">{{ trans('cruds.student.fields.school_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="form_id">{{ trans('cruds.student.fields.form') }}</label>
                                <select class="form-control select2 {{ $errors->has('form') ? 'is-invalid' : '' }}" name="form_id" id="form_id" required>
                                    @foreach($forms as $id => $entry)
                                        <option value="{{ $id }}" {{ old('form_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('form'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('form') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.form_helper') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="stream_id">{{ trans('cruds.student.fields.stream') }}</label>
                                <select class="form-control select2 {{ $errors->has('stream') ? 'is-invalid' : '' }}" name="stream_id" id="stream_id">
                                    @foreach($streams as $id => $entry)
                                        <option value="{{ $id }}" {{ old('stream_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('stream'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('stream') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.student.fields.stream_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="form-group">
                            <label>day_scholar</label>
                            <select class="form-control {{ $errors->has('day_scholar') ? 'is-invalid' : '' }}" name="day_scholar" id="day_scholar">
                                <option value disabled {{ old('day_scholar', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Student::DAY_SCHOLAR_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('day_scholar', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('day_scholar'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('day_scholar') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.student.fields.status_helper') }}</span>
                        </div>
                    </div>
                        
                    </div>

                    <!-- Add More Rows for Other School Details -->

               
            
                    <!-- All the input fields for school details -->
                    <input type="button" name="previous" class="previous action-button btn btn-primary" value="Previous" />
                    <input type="submit" name="submit" class="btn btn-success" value="Add Student" />
                </fieldset>
            </form>
        </div>
    </div>
</div>

   </div>
           
            
            
            
            
          <!--
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>-->
    </div>
</div>

@endsection

@section('scripts')
<script>

 Dropzone.options.fatherDeathCertificateDropzone = {
    url: '{{ route('admin.students.storeMedia') }}',
    maxFilesize: 8, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 8,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="father_death_certificate"]').remove()
      $('form').append('<input type="hidden" name="father_death_certificate" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="father_death_certificate"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($student) && $student->father_death_certificate)
      var file = {!! json_encode($student->father_death_certificate) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="father_death_certificate" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
<script>
    Dropzone.options.motherDeathCertificateDropzone = {
    url: '{{ route('admin.students.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="mother_death_certificate"]').remove()
      $('form').append('<input type="hidden" name="mother_death_certificate" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="mother_death_certificate"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($student) && $student->mother_death_certificate)
      var file = {!! json_encode($student->mother_death_certificate) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="mother_death_certificate" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
<script>
    Dropzone.options.photoDropzone = {
    url: '{{ route('admin.students.storeMedia') }}',
    maxFilesize: 8, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 8,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($student) && $student->photo)
      var file = {!! json_encode($student->photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
<script>
    Dropzone.options.birthCertificateDropzone = {
    url: '{{ route('admin.students.storeMedia') }}',
    maxFilesize: 8, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 8
    },
    success: function (file, response) {
      $('form').find('input[name="birth_certificate"]').remove()
      $('form').append('<input type="hidden" name="birth_certificate" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="birth_certificate"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($student) && $student->birth_certificate)
      var file = {!! json_encode($student->birth_certificate) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="birth_certificate" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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

$(document).ready(function () {


   

    function toggleFields(parentalStatus) {
        // Define all the fields
        const fatherFields = ['#father_fullname', '#father_phone_number', '#father_national_id_no'];
        const motherFields = ['#mother_fullname', '#mother_phone_number', '#mother_national_id_no'];
        const guardianFields = ['#guardian_fullname', '#guardian_phone_number', '#guardian_national'];

        // Function to enable fields
        function enableFields(fields) {
            fields.forEach(field => {
                $(field).prop('disabled', false);
            });
        }

        // Function to disable fields
        function disableFields(fields) {
            fields.forEach(field => {
                $(field).prop('disabled', true);
            });
        }

        switch (parentalStatus) {
            case 'Both Alive':
                enableFields(fatherFields);
                enableFields(motherFields);
                disableFields(guardianFields);

                break;
            case 'Father Deceased':
                disableFields(fatherFields);
                enableFields(motherFields);
                disableFields(guardianFields);
                break;
            case 'Mother Deceased':
                enableFields(fatherFields);
                disableFields(motherFields);
                disableFields(guardianFields);
                break;
            case 'Both Deceased':
                disableFields(fatherFields);
                disableFields(motherFields);
                enableFields(guardianFields);
                break;
            default:
                // Default case, if needed
                break;
        }
    }

    // Attach change event listener to parental status select
    $('#parental_status').change(function() {
        toggleFields(this.value);
    });

    // Call the function on page load with the current selected value
    toggleFields($('#parental_status').val());





    var current_fs, next_fs, previous_fs;

    // Hide all fieldsets except the first one
    $('fieldset:gt(0)').hide();

    $(".next").click(function () {

        
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        // Validation - Check if all required fields are filled
        var isValid = true;
        /*current_fs.find('input,select').each(function() {
            if ($(this).prop('required') && $(this).val() === "") {
                isValid = false;
                $(this).css('border-color', 'red'); // Highlight the empty required field
            } else {
                $(this).css('border-color', ''); // Reset border color
            }
        });*/


        current_fs.find('input, select').each(function() {
    if ($(this).prop('required') && $(this).val() === "") {
        isValid = false;
        $(this).css('border-color', 'red'); // Highlight the empty required field
    } else if ($(this).hasClass('select2') && !$(this).val()) {
        isValid = false;
        $(this).next('.select2-container').find('.select2-selection').css('border-color', 'red');
    } else {
        $(this).css('border-color', ''); // Reset border color
        if ($(this).hasClass('select2')) {
            $(this).next('.select2-container').find('.select2-selection').css('border-color', '');
        }
    }
});


        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please fill all required fields before proceeding.',
                confirmButtonText: 'OK'
            });
            return false; // Prevent moving to the next step
        }

        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        //updateProgressBar(current);
        next_fs.show();
        current_fs.hide();
    });

    $(".previous").click(function () {
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        previous_fs.show();
        current_fs.hide();
    });

    function updateProgressBar(currentStep) {
    let index = 0;
    $('#progressbar li').each(function() {
        // If current index is less than the current step, add the 'active' class
        if (index < currentStep) {
            $(this).addClass('active');
        } else {
            // Otherwise, remove the 'active' class
            $(this).removeClass('active');
        }
        index++;
    });
}

$('#school_id').on('change', function() {
        
        var schoolId = $(this).val();

       
        if(schoolId) {
            $.ajax({
                url: '{{ route("admin.students.get-streams") }}',
                type: 'GET',
                data: { school_id: schoolId },
            
                success: function(data) {
                    $('#stream_id').empty().append('<option value="">Select Stream</option>');
                    $.each(data, function(key, value) {
                       console.log(value.id);
                       console.log(value);
                        $('#stream_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                }
            });
            
        } else {
            $('#stream-select').empty().append('<option value="">Select Stream</option>');
        }
    });

});


// This is the new function to update the progress bar's active step
// Call it inside your next/previous button click events after updating the current fieldset

// Example:
document.getElementById('date_of_birth').addEventListener('change', function() {
    var selectedDate = new Date(this.value);
    var currentDate = new Date();
    var thirteenYearsAgo = new Date(currentDate.getFullYear() - 13, currentDate.getMonth(), currentDate.getDate());

    if (selectedDate > thirteenYearsAgo) {
        alert('The date must be at least 13 years ago.');
        this.value = ''; // Clear the selected date
    }
});


function formatAdmissionNumber(admissionNumber, formId) {
  // Assume the school code is a constant, set it accordingly
  const schoolCode = 'SCHOOLCODE'; 

  // Get the current year
  const currentYear = new Date().getFullYear();

  // Calculate the year of registration based on the form ID
  let yearRegistered;
  switch (formId) {
    case 1: // Form 1
      yearRegistered = currentYear;
      break;
    case 2: // Form 2
      yearRegistered = currentYear - 1;
      break;
    case 3: // Form 3
      yearRegistered = currentYear - 2;
      break;
    case 4: // Form 4
      yearRegistered = currentYear - 3;
      break;
    default:
      yearRegistered = currentYear; // Default case can be adjusted as needed
  }

  // Format the year to the last two digits
  const formattedYear = String(yearRegistered).slice(-2);

  // Construct the formatted admission number string
  const formattedAdmissionNumber = `${schoolCode}-${admissionNumber}/${formattedYear}`;

  return formattedAdmissionNumber;
}

// Example usage:
const admissionNumberEntered = '1234';
const formId = 1; // This would be dynamic based on the form of the student
const formattedNumber = formatAdmissionNumber(admissionNumberEntered, formId);
//alert(formattedNumber); // Outputs: SCHOOLCODE-1234/23 (if the current year is 2023)





/*document.addEventListener('DOMContentLoaded', function() {
    function toggleFields(parentalStatus) {
        // Define all the fields
        const fatherFields = ['father_fullname', 'father_phone_number', 'father_national_id_no'];
        const motherFields = ['mother_fullname', 'mother_phone_number', 'mother_national_id_no'];
        const guardianFields = ['guardian_fullname', 'guardian_phone_number', 'guardian_national'];

        // Function to enable fields
        function enableFields(fields) {
            fields.forEach(field => {
                document.getElementById(field).disabled = false;
            });
        }

        // Function to disable fields
        function disableFields(fields) {
            fields.forEach(field => {
                document.getElementById(field).disabled = true;
            });
        }

        switch (parentalStatus) {
            case 'Both Alive':
                enableFields(fatherFields);
                enableFields(motherFields);
                disableFields(guardianFields);
                break;
            case 'Father Deceased':
                disableFields(fatherFields);
                enableFields(motherFields);
                enableFields(guardianFields);
                break;
            case 'Mother Deceased':
                enableFields(fatherFields);
                disableFields(motherFields);
                enableFields(guardianFields);
                break;
            case 'Both Deceased':
                disableFields(fatherFields);
                disableFields(motherFields);
                enableFields(guardianFields);
                break;
            default:
                // Default case, if needed
                break;
        }
    }

    // Attach change event listener to parental status select
    document.getElementById('parental_status').addEventListener('change', function() {
        alert("Hello");
        toggleFields(this.value);
    });

    // Call the function on page load with the current selected value
    toggleFields(document.getElementById('parental_status').value);
});*/



</script>
@endsection