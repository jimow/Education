@extends('layouts.admin')
@section('content')
@can('student_bursary_register_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.student-bursary-registers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.studentBursaryRegister.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'StudentBursaryRegister', 'route' => 'admin.student-bursary-registers.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.studentBursaryRegister.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-StudentBursaryRegister">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.studentBursaryRegister.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.studentBursaryRegister.fields.term') }}
                    </th>
                    <th>
                        {{ trans('cruds.studentBursaryRegister.fields.year') }}
                    </th>
                    <th>
                        {{ trans('cruds.studentBursaryRegister.fields.amount_paid') }}
                    </th>
                    <th>
                        {{ trans('cruds.studentBursaryRegister.fields.requested_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.studentBursaryRegister.fields.authorized_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.studentBursaryRegister.fields.admission_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.studentBursaryRegister.fields.payment_code') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
              
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('student_bursary_register_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.student-bursary-registers.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.student-bursary-registers.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'term', name: 'term' },
{ data: 'year_year', name: 'year.year' },
{ data: 'amount_paid', name: 'amount_paid' },
{ data: 'requested_by_name', name: 'requested_by.name' },
{ data: 'authorized_by_name', name: 'authorized_by.name' },
{ data: 'admission_number_admission_number', name: 'admission_number.admission_number' },
{ data: 'payment_code', name: 'payment_code' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-StudentBursaryRegister').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection