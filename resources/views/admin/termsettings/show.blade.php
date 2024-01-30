@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.termsetting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.termsettings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.termsetting.fields.id') }}
                        </th>
                        <td>
                            {{ $termsetting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.termsetting.fields.term') }}
                        </th>
                        <td>
                            {{ $termsetting->term }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.termsetting.fields.begins') }}
                        </th>
                        <td>
                            {{ $termsetting->begins }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.termsetting.fields.ends') }}
                        </th>
                        <td>
                            {{ $termsetting->ends }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.termsetting.fields.year') }}
                        </th>
                        <td>
                            {{ $termsetting->year->year ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.termsettings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection