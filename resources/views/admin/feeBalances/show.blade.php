@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.feeBalance.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fee-balances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.feeBalance.fields.id') }}
                        </th>
                        <td>
                            {{ $feeBalance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeBalance.fields.admission_number') }}
                        </th>
                        <td>
                            {{ $feeBalance->admission_number->admission_number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeBalance.fields.balance') }}
                        </th>
                        <td>
                            {{ $feeBalance->balance }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeBalance.fields.term') }}
                        </th>
                        <td>
                            {{ App\Models\FeeBalance::TERM_SELECT[$feeBalance->term] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeBalance.fields.year') }}
                        </th>
                        <td>
                            {{ $feeBalance->year->year ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fee-balances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection