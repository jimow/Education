@extends('layouts.admin')
@section('content')
@can('school_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.schools.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.school.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'School', 'route' => 'admin.schools.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.school.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-School">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.school.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.gender_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.category') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.ward') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.principal') }}
                    </th>
                    <th>
                        {{ trans('cruds.principal.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.principal.fields.national') }}
                    </th>
                    <th>
                        {{ trans('cruds.principal.fields.phone_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.phone_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.postal_address') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.physical_address') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.physical_location') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.registered_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.approved_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.fees') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.uniform_fee') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.f_1_fee') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.f_2_fee') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.f_3_fee') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.f_4_fee') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.b_1_fee') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.b_2_fee') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.b_3_fee') }}
                    </th>
                    <th>
                        {{ trans('cruds.school.fields.b_4_fee') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($school_gender_types as $key => $item)
                                <option value="{{ $item->gender_type }}">{{ $item->gender_type }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($school_categories as $key => $item)
                                <option value="{{ $item->category_name }}">{{ $item->category_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($wards as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($principals as $key => $item)
                                <option value="{{ $item->fullname }}">{{ $item->fullname }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($users as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($users as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\School::UNIFORM_FEE_RADIO as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
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
@can('school_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.schools.massDestroy') }}",
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
    ajax: "{{ route('admin.schools.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'gender_type_gender_type', name: 'gender_type.gender_type' },
{ data: 'category_category_name', name: 'category.category_name' },
{ data: 'ward_name', name: 'ward.name' },
{ data: 'principal_fullname', name: 'principal.fullname' },
{ data: 'principal.email', name: 'principal.email' },
{ data: 'principal.national', name: 'principal.national' },
{ data: 'principal.phone_number', name: 'principal.phone_number' },
{ data: 'phone_number', name: 'phone_number' },
{ data: 'email', name: 'email' },
{ data: 'postal_address', name: 'postal_address' },
{ data: 'physical_address', name: 'physical_address' },
{ data: 'physical_location', name: 'physical_location' },
{ data: 'code', name: 'code' },
{ data: 'registered_by_name', name: 'registered_by.name' },
{ data: 'approved_by_name', name: 'approved_by.name' },
{ data: 'fees', name: 'fees' },
{ data: 'uniform_fee', name: 'uniform_fee' },
{ data: 'f_1_fee', name: 'f_1_fee' },
{ data: 'f_2_fee', name: 'f_2_fee' },
{ data: 'f_3_fee', name: 'f_3_fee' },
{ data: 'f_4_fee', name: 'f_4_fee' },
{ data: 'b_1_fee', name: 'b_1_fee' },
{ data: 'b_2_fee', name: 'b_2_fee' },
{ data: 'b_3_fee', name: 'b_3_fee' },
{ data: 'b_4_fee', name: 'b_4_fee' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-School').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
});

</script>
@endsection