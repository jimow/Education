@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.bursary.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bursaries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.bursary.fields.id') }}
                        </th>
                        <td>
                            {{ $bursary->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bursary.fields.school') }}
                        </th>
                        <td>
                            {{ $bursary->school->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bursary.fields.school_term') }}
                        </th>
                        <td>
                            {{ App\Models\Bursary::SCHOOL_TERM_SELECT[$bursary->school_term] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bursary.fields.year') }}
                        </th>
                        <td>
                            {{ $bursary->year->year ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bursary.fields.amount_paid') }}
                        </th>
                        <td>
                            {{ $bursary->amount_paid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bursary.fields.cheque_no') }}
                        </th>
                        <td>
                            {{ $bursary->cheque_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bursary.fields.payment_code') }}
                        </th>
                        <td>
                            {{ $bursary->payment_code }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bursaries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection