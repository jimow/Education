@extends('layouts.admin')
@section('content')
@can('student_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.students.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.student.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Student', 'route' => 'admin.students.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.student.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Student">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.student.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.fullname') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.gender') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.date_of_birth') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.ward') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.nemis_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.admission_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.on_scholarship') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.scholarship_amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.scholarship_donor') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.disability') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.parental_status') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.father_fullname') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.father_phone_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.father_death_certificate') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.mother_fullname') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.mother_phone_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.mother_death_certificate') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.photo') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.stream') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.school') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.form') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.birth_certificate') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.birth_certificate_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.father_national_id_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.mother_national_id_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.day_scholar') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.registered_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.approved_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.guardian_fullname') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.guardian_phone_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.guardian_national') }}
                    </th>
                    <th>
                        {{ trans('cruds.student.fields.other_documents') }}
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
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\Student::GENDER_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
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
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\Student::ON_SCHOLARSHIP_SELECT as $key => $item)
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
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\Student::DISABILITY_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\Student::PARENTAL_STATUS_SELECT as $key => $item)
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
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($school_streams as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($schools as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($student_forms as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
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
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\Student::STATUS_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\Student::DAY_SCHOLAR_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
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
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
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


function maskName(name) {
        // Your masking logic here
        // For example, showing the first 2 letters and replacing the rest with 'XXX'
        return name.substr(0, 2) + 'XXX'.repeat(Math.max(0, name.length - 2));
    }
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('student_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.students.massDestroy') }}",
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
  dtButtons.push(deleteButton);



@endcan
dtButtons.push(
        {
            extend: 'excelHtml5',
            text: 'Export to Excel',
            customize: function (xlsx) {
                let sheet = xlsx.xl.worksheets['sheet1.xml'];
                $('row c[r^="B"]', sheet).each(function () {
                    let originalValue = $('is t', this).text();
                    let maskedValue = maskName(originalValue);
                    $('is t', this).text(maskedValue);
                });
            }
        },
        // Add other export buttons as needed
    );

    // Add print button with customization
    dtButtons.push(
        {
            extend: 'print',
            text: 'Print',
            customize: function (win) {
                $(win.document.body).find('table').each(function () {
                    // Assuming 'fullname' is in the second column (index 1)
                    $(this).find('tr td:eq(2)').each(function () {
                        let originalValue = $(this).text();
                        let maskedValue = maskName(originalValue);
                        $(this).text(maskedValue);
                    });
                });
            }
        }
    );
  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.students.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'fullname', name: 'fullname' },
{ data: 'gender', name: 'gender' },
{ data: 'date_of_birth', name: 'date_of_birth' },
{ data: 'ward_name', name: 'ward.name' },
{ data: 'nemis_number', name: 'nemis_number' },
{ data: 'admission_number', name: 'admission_number' },
{ data: 'on_scholarship', name: 'on_scholarship' },
{ data: 'scholarship_amount', name: 'scholarship_amount' },
{ data: 'scholarship_donor', name: 'scholarship_donor' },
{ data: 'disability', name: 'disability' },
{ data: 'parental_status', name: 'parental_status' },
{ data: 'father_fullname', name: 'father_fullname' },
{ data: 'father_phone_number', name: 'father_phone_number' },
{ data: 'father_death_certificate', name: 'father_death_certificate', sortable: false, searchable: false },
{ data: 'mother_fullname', name: 'mother_fullname' },
{ data: 'mother_phone_number', name: 'mother_phone_number' },
{ data: 'mother_death_certificate', name: 'mother_death_certificate', sortable: false, searchable: false },
{ data: 'photo', name: 'photo', sortable: false, searchable: false },
{ data: 'stream_name', name: 'stream.name' },
{ data: 'school_name', name: 'school.name' },
{ data: 'form_name', name: 'form.name' },
{ data: 'birth_certificate', name: 'birth_certificate', sortable: false, searchable: false },
{ data: 'birth_certificate_number', name: 'birth_certificate_number' },
{ data: 'father_national_id_no', name: 'father_national_id_no' },
{ data: 'mother_national_id_no', name: 'mother_national_id_no' },
{ data: 'status', name: 'status' },
{ data: 'day_scholar', name: 'day_scholar' },
{ data: 'registered_by_name', name: 'registered_by.name' },
{ data: 'approved_by_name', name: 'approved_by.name' },
{ data: 'guardian_fullname', name: 'guardian_fullname' },
{ data: 'guardian_phone_number', name: 'guardian_phone_number' },
{ data: 'guardian_national', name: 'guardian_national' },
{ data: 'other_documents', name: 'other_documents', sortable: false, searchable: false },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Student').DataTable(dtOverrideGlobals);
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