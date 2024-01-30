@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.studentBursaryRegister.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.student-bursary-registers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.studentBursaryRegister.fields.id') }}
                        </th>
                        <td>
                            {{ $studentBursaryRegister->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentBursaryRegister.fields.term') }}
                        </th>
                        <td>
                            {{ App\Models\StudentBursaryRegister::TERM_SELECT[$studentBursaryRegister->term] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentBursaryRegister.fields.year') }}
                        </th>
                        <td>
                            {{ $studentBursaryRegister->year->year ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentBursaryRegister.fields.amount_paid') }}
                        </th>
                        <td>
                            {{ $studentBursaryRegister->amount_paid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentBursaryRegister.fields.requested_by') }}
                        </th>
                        <td>
                            {{ $studentBursaryRegister->requested_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentBursaryRegister.fields.authorized_by') }}
                        </th>
                        <td>
                            {{ $studentBursaryRegister->authorized_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentBursaryRegister.fields.admission_number') }}
                        </th>
                        <td>
                            {{ $studentBursaryRegister->admission_number->admission_number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentBursaryRegister.fields.payment_code') }}
                        </th>
                        <td>
                            {{ $studentBursaryRegister->payment_code }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.student-bursary-registers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection