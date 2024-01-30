@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.otherSetting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.other-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.otherSetting.fields.id') }}
                        </th>
                        <td>
                            {{ $otherSetting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherSetting.fields.name') }}
                        </th>
                        <td>
                            {{ $otherSetting->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherSetting.fields.fees_percentage') }}
                        </th>
                        <td>
                            {{ $otherSetting->fees_percentage }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherSetting.fields.term_1') }}
                        </th>
                        <td>
                            {{ $otherSetting->term_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherSetting.fields.term_2') }}
                        </th>
                        <td>
                            {{ $otherSetting->term_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherSetting.fields.term_3') }}
                        </th>
                        <td>
                            {{ $otherSetting->term_3 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otherSetting.fields.day_fees_percentage') }}
                        </th>
                        <td>
                            {{ $otherSetting->day_fees_percentage }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.other-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection