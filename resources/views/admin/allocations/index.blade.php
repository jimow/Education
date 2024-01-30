@extends('layouts.admin')
@section('content')
@can('allocation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.allocations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.allocation.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Allocation', 'route' => 'admin.allocations.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.allocation.title_singular') }} {{ trans('global.list') }} {{ getTotalAmountPaid('ALL-JAN-16-13') }} 

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Allocation">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.allocation.fields.id') }} 
                    </th>
                    <th>
                        {{ trans('cruds.allocation.fields.amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.allocation.fields.payment_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.allocation.fields.cheque_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.allocation.fields.remarks') }}
                    </th>
                    <th>
                        {{ trans('cruds.allocation.fields.term') }}
                    </th>
                    <th>
                        {{ trans('cruds.allocation.fields.bank_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.allocation.fields.other_details') }}
                    </th>
                    <th>
                        {{ trans('cruds.allocation.fields.year') }}
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
                            @foreach(App\Models\Allocation::TERM_SELECT as $key => $item)
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
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($years as $key => $item)
                                <option value="{{ $item->year }}">{{ $item->year }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    </td>
                </tr>
            </thead>
        </table>
    </div>


    <!-- Allocation Code Modal -->
<div class="modal fade" id="allocationCodeModal" tabindex="-1" role="dialog" aria-labelledby="allocationCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="allocationCodeModalLabel">Allocation Code Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <p>Code: <span id="allocationCode"></span></p>
        <!-- Add more spans or elements to show other allocation details -->
        <p>Amount: <span id="allocationAmount"></span></p>
        <p>Total Amount Utilized: <span id="totalAmount"></span></p>
        <p>Balance</p>: <span id="balance"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('allocation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.allocations.massDestroy') }}",
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
    ajax: "{{ route('admin.allocations.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'amount', name: 'amount' },
{ data: 'payment_code', name: 'payment_code',
   


    render: function(data, type, row) {
                // Return the data wrapped in a button or link that can be clicked to open a modal
                return type === 'display' && data ? 
                    `<button class="btn btn-link payment-code-link" data-code="${data}" title="${data}">${data}</button>` : 
                    data;
            }
},
{ data: 'cheque_no', name: 'cheque_no' },
{ data: 'remarks', name: 'remarks' },
{ data: 'term', name: 'term' },
{ data: 'bank_name', name: 'bank_name' },
{ data: 'other_details', name: 'other_details' },
{ data: 'year_year', name: 'year.year' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Allocation').DataTable(dtOverrideGlobals);
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


// ... (the previous part of the script remains the same)

$(document).on('click', '.payment-code-link', function() {
    var paymentCode = $(this).data('code');
    
    $.ajax({
        url: '{{ route('admin.allocations', ['paymentCode' => '__paymentCode__']) }}'.replace('__paymentCode__', paymentCode),
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token, if necessary
        },
      
        success: function(response) {
            console.log(response);
           
            if (response.status === 'success') {
                // Set the allocation details in the modal
                var allocation = response.allocation;
                console.log(allocation.amount);
                $('#allocationCode').text(allocation.payment_code);
                 

                const number = allocation.amount;

// Format as currency with the Kenyan Shilling (KES) locale

$('#allocationAmount').text(formatCurrency(allocation.amount));
$('#totalAmount').text(formatCurrency(response.total));
$('#balance').text(formatCurrency(response.balance));             
              

              
                // Set other allocation details as needed
                // $('#anotherField').text(allocation.anotherField);
                
                // Show the modal.
                $('#allocationCodeModal').modal('show');
            } else {
                alert('Allocation details not found.');
                console.log(response);
      

            }
        },
        error: function() {
            alert('Error fetching allocation details.');
        }
    });
});

</script>
@endsection