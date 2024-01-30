@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.studentTransfer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.student-transfers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.studentTransfer.fields.id') }}
                        </th>
                        <td>
                            {{ $studentTransfer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentTransfer.fields.admission_number') }}
                        </th>
                        <td>
                            {{ $studentTransfer->admission_number->admission_number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentTransfer.fields.trasnsfer_from') }}
                        </th>
                        <td>
                            {{ $studentTransfer->trasnsfer_from->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentTransfer.fields.transfer_to') }}
                        </th>
                        <td>
                            {{ $studentTransfer->transfer_to->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentTransfer.fields.principal_approval_transfer_from') }}
                        </th>
                        <td>
                            {{ $studentTransfer->principal_approval_transfer_from->fullname ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentTransfer.fields.principal_approval_transfer_to') }}
                        </th>
                        <td>
                            {{ $studentTransfer->principal_approval_transfer_to->fullname ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentTransfer.fields.initiated_by') }}
                        </th>
                        <td>
                            {{ $studentTransfer->initiated_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentTransfer.fields.confirmed_by') }}
                        </th>
                        <td>
                            {{ $studentTransfer->confirmed_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentTransfer.fields.authorized_by') }}
                        </th>
                        <td>
                            {{ $studentTransfer->authorized_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentTransfer.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\StudentTransfer::STATUS_SELECT[$studentTransfer->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.student-transfers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection