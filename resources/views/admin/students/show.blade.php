@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.student.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.students.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.id') }}
                        </th>
                        <td>
                            {{ $student->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.fullname') }}
                        </th>
                        <td>
                            {{ $student->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Models\Student::GENDER_SELECT[$student->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.date_of_birth') }}
                        </th>
                        <td>
                            {{ $student->date_of_birth }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.ward') }}
                        </th>
                        <td>
                            {{ $student->ward->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.nemis_number') }}
                        </th>
                        <td>
                            {{ $student->nemis_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.admission_number') }}
                        </th>
                        <td>
                            {{ $student->admission_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.on_scholarship') }}
                        </th>
                        <td>
                            {{ App\Models\Student::ON_SCHOLARSHIP_SELECT[$student->on_scholarship] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.scholarship_amount') }}
                        </th>
                        <td>
                            {{ $student->scholarship_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.scholarship_donor') }}
                        </th>
                        <td>
                            {{ $student->scholarship_donor }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.disability') }}
                        </th>
                        <td>
                            {{ App\Models\Student::DISABILITY_SELECT[$student->disability] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.parental_status') }}
                        </th>
                        <td>
                            {{ App\Models\Student::PARENTAL_STATUS_SELECT[$student->parental_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.father_fullname') }}
                        </th>
                        <td>
                            {{ $student->father_fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.father_phone_number') }}
                        </th>
                        <td>
                            {{ $student->father_phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.father_death_certificate') }}
                        </th>
                        <td>
                            @if($student->father_death_certificate)
                                <a href="{{ $student->father_death_certificate->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $student->father_death_certificate->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.mother_fullname') }}
                        </th>
                        <td>
                            {{ $student->mother_fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.mother_phone_number') }}
                        </th>
                        <td>
                            {{ $student->mother_phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.mother_death_certificate') }}
                        </th>
                        <td>
                            @if($student->mother_death_certificate)
                                <a href="{{ $student->mother_death_certificate->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $student->mother_death_certificate->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.photo') }}
                        </th>
                        <td>
                            @if($student->photo)
                                <a href="{{ $student->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $student->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.stream') }}
                        </th>
                        <td>
                            {{ $student->stream->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.school') }}
                        </th>
                        <td>
                            {{ $student->school->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.form') }}
                        </th>
                        <td>
                            {{ $student->form->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.birth_certificate') }}
                        </th>
                        <td>
                            @if($student->birth_certificate)
                                <a href="{{ $student->birth_certificate->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.birth_certificate_number') }}
                        </th>
                        <td>
                            {{ $student->birth_certificate_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.father_national_id_no') }}
                        </th>
                        <td>
                            {{ $student->father_national_id_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.mother_national_id_no') }}
                        </th>
                        <td>
                            {{ $student->mother_national_id_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Student::STATUS_SELECT[$student->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.day_scholar') }}
                        </th>
                        <td>
                            {{ App\Models\Student::DAY_SCHOLAR_SELECT[$student->day_scholar] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.registered_by') }}
                        </th>
                        <td>
                            {{ $student->registered_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.approved_by') }}
                        </th>
                        <td>
                            {{ $student->approved_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.guardian_fullname') }}
                        </th>
                        <td>
                            {{ $student->guardian_fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.guardian_phone_number') }}
                        </th>
                        <td>
                            {{ $student->guardian_phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.guardian_national') }}
                        </th>
                        <td>
                            {{ $student->guardian_national }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.other_documents') }}
                        </th>
                        <td>
                            @foreach($student->other_documents as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.students.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection