@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.feeBalanceSchool.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-FeeBalanceSchool">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.feeBalanceSchool.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.feeBalanceSchool.fields.school') }}
                        </th>
                        <th>
                            {{ trans('cruds.feeBalanceSchool.fields.balance') }}
                        </th>
                        <th>
                            {{ trans('cruds.feeBalanceSchool.fields.term') }}
                        </th>
                        <th>
                            {{ trans('cruds.feeBalanceSchool.fields.year') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feeBalanceSchools as $key => $feeBalanceSchool)
                        <tr data-entry-id="{{ $feeBalanceSchool->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $feeBalanceSchool->id ?? '' }}
                            </td>
                            <td>
                                {{ $feeBalanceSchool->school->name ?? '' }}
                            </td>
                            <td>
                                {{ $feeBalanceSchool->balance ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\FeeBalanceSchool::TERM_SELECT[$feeBalanceSchool->term] ?? '' }}
                            </td>
                            <td>
                                {{ $feeBalanceSchool->year->year ?? '' }}
                            </td>
                            <td>



                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-FeeBalanceSchool:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection