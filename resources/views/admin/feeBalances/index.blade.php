@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.feeBalance.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-FeeBalance">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.feeBalance.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.feeBalance.fields.admission_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.feeBalance.fields.balance') }}
                        </th>
                        <th>
                            {{ trans('cruds.feeBalance.fields.term') }}
                        </th>
                        <th>
                            {{ trans('cruds.feeBalance.fields.year') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feeBalances as $key => $feeBalance)
                        <tr data-entry-id="{{ $feeBalance->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $feeBalance->id ?? '' }}
                            </td>
                            <td>
                                {{ $feeBalance->admission_number->admission_number ?? '' }}
                            </td>
                            <td>
                                {{ $feeBalance->balance ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\FeeBalance::TERM_SELECT[$feeBalance->term] ?? '' }}
                            </td>
                            <td>
                                {{ $feeBalance->year->year ?? '' }}
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
  let table = $('.datatable-FeeBalance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection