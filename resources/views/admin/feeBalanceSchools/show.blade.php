@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.feeBalanceSchool.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fee-balance-schools.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.feeBalanceSchool.fields.id') }}
                        </th>
                        <td>
                            {{ $feeBalanceSchool->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeBalanceSchool.fields.school') }}
                        </th>
                        <td>
                            {{ $feeBalanceSchool->school->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeBalanceSchool.fields.balance') }}
                        </th>
                        <td>
                            {{ $feeBalanceSchool->balance }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeBalanceSchool.fields.term') }}
                        </th>
                        <td>
                            {{ App\Models\FeeBalanceSchool::TERM_SELECT[$feeBalanceSchool->term] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeBalanceSchool.fields.year') }}
                        </th>
                        <td>
                            {{ $feeBalanceSchool->year->year ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fee-balance-schools.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection