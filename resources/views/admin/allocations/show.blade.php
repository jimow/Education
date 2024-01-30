@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.allocation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.allocations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.id') }}
                        </th>
                        <td>
                            {{ $allocation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.amount') }}
                        </th>
                        <td>
                            {{ $allocation->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.payment_code') }}
                        </th>
                        <td>
                            {{ $allocation->payment_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.cheque_no') }}
                        </th>
                        <td>
                            {{ $allocation->cheque_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.remarks') }}
                        </th>
                        <td>
                            {{ $allocation->remarks }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.term') }}
                        </th>
                        <td>
                            {{ App\Models\Allocation::TERM_SELECT[$allocation->term] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.bank_name') }}
                        </th>
                        <td>
                            {{ $allocation->bank_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.other_details') }}
                        </th>
                        <td>
                            {{ $allocation->other_details }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allocation.fields.year') }}
                        </th>
                        <td>
                            {{ $allocation->year->year ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.allocations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection