@extends('layouts.admin')
@section('styles')
<style>
    .school-code {
        cursor: pointer;
    }
    .school-code:hover {
        background-color: #f8f9fa;
        color: red;
    }
    .form-checkboxes {
       
        justify-content: center;
        gap: 10px;
        margin-top: 5px;
    }
  
    .form-checkboxes label {
        font-size: 0.8em;
    }
    .col-lg-1 {
        flex: 0 0 12.5%; /* Forces the column to take up 1/8th of the row */
        max-width: 12.5%;
    }
</style>


@endsection
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.studentBursaryRegister.title_singular') }} ---<span style="float:right"><a href="/admin/students/bulk-payments" >Bulk Payments</a></span>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.student-bursary-registers.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="row">


                <div class="form-group col-md-6">
                    <label for="admission_number_id">{{ trans('cruds.studentBursaryRegister.fields.admission_number') }}</label>
                    <select class="form-control select2 {{ $errors->has('admission_number') ? 'is-invalid' : '' }}" name="admission_number_id" id="admission_number_id">
                        @foreach($admission_numbers as $id => $entry)
                            <option value="{{ $id }}" {{ old('admission_number_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('admission_number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('admission_number') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.studentBursaryRegister.fields.admission_number_helper') }}</span>
                </div>
                <div class="form-group col-md-6 " id="fname">
                    <label for="fullname">{{ trans('cruds.student.fields.fullname') }}<span id="bal" style="float: right"></span></label>
                    <input class="form-control" type="text" name="fullname" id="fullname" />
                  
                </div>
            </div>

            <div class="row" >
                <div class="form-group col-md-6">
                    <label class="required">{{ trans('cruds.studentBursaryRegister.fields.term') }}</label>
                    <select class="form-control {{ $errors->has('term') ? 'is-invalid' : '' }}" name="term" id="term" required>
                        <option value disabled {{ old('term', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\StudentBursaryRegister::TERM_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('term', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('term'))
                        <div class="invalid-feedback">
                            {{ $errors->first('term') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.studentBursaryRegister.fields.term_helper') }}</span>
                </div>
                <div class="form-group col-md-6">
                    <label class="required" for="year_id">{{ trans('cruds.studentBursaryRegister.fields.year') }}</label>
                    <select class="form-control select2 {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year_id" id="year_id" required>
                        @foreach($years as $id => $entry)
                            <option value="{{ $id }}" {{ old('year_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('year'))
                        <div class="invalid-feedback">
                            {{ $errors->first('year') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.studentBursaryRegister.fields.year_helper') }}</span>
                </div>
            </div>
         
           <div class="row" >
            <div class="form-group col-md-6">
                <label class="required" for="amount_paid">{{ trans('cruds.studentBursaryRegister.fields.amount_paid') }}</label>
                <input class="form-control {{ $errors->has('amount_paid') ? 'is-invalid' : '' }}" type="number" name="amount_paid" id="amount_paid" value="{{ old('amount_paid', '0') }}" step="0.01" required>
                @if($errors->has('amount_paid'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount_paid') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentBursaryRegister.fields.amount_paid_helper') }}</span>
            </div>
            
            <div class="form-group col-md-6">
                <label for="payment_code">{{ trans('cruds.studentBursaryRegister.fields.payment_code') }}</label>
                <input class="form-control {{ $errors->has('payment_code') ? 'is-invalid' : '' }}" type="text" name="payment_code" id="payment_code" value="{{ old('payment_code', '') }}">
                <input class="form-control" id="fetchAmount" name="fetchAmount" />
                @if($errors->has('payment_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentBursaryRegister.fields.payment_code_helper') }}</span>
            </div>
           </div>
            <div class="form-group">
                <label for="requested_by_id">{{ trans('cruds.studentBursaryRegister.fields.requested_by') }}</label>
                <select class="form-control select2 {{ $errors->has('requested_by') ? 'is-invalid' : '' }}" name="requested_by_id" id="requested_by_id">
                    @foreach($requested_bies as $id => $entry)
                        <option value="{{ $id }}" {{ old('requested_by_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('requested_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('requested_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.studentBursaryRegister.fields.requested_by_helper') }}</span>
            </div>
           
            
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>


            <input type="text" id="paymentCode" placeholder="Enter payment code">

<!-- Span or div to display the allocation amount -->
<div id="allocationAmount">Allocation Amount: <span id="amount"></span></div>


        </form>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="schoolModal" tabindex="-1" aria-labelledby="schoolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="schoolModalLabel">Select Schools and Forms</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                @foreach ($schools as $school)
                    <div class="col-lg-1 text-center">
                        <div class="school-code" title="{{ $school->name }}" onclick="toggleCheckboxes({{ $school->id }})">
                            {{ $school->code }}
                        </div>
                        <div class="form-checkboxes" id="checkboxes_{{ $school->id }}" style="display: none;">
                            
                                <label><input type="checkbox" name="school_{{ $school->id }}"> School</label>
                                @for ($i = 1; $i <= 4; $i++)
                                    <label><input type="checkbox" name="form_{{ $i }}_school_{{ $school->id }}"> F{{ $i }}</label>
                                @endfor
                            
                        </div>
                    </div>
                    @if ($loop->iteration % 8 == 0)
                        </div><div class="row"> <!-- Break row every 8 items -->
                    @endif
                @endforeach
            </div>
        </div>
        
        
        
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="filterButton">Filter</button>
        </div>
      </div>
    </div>
  </div>
<!-- End Of Modal -->  
@endsection

@section('scripts')
<script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function() {
    






    var totalAllocations = 1000; // Replace with actual total allocations if needed

function updateSumAndBalance() {
    var sum = 0;
    // Iterate over each input and add its value to the sum
    $('.form-input').each(function() {
        sum += parseFloat($(this).val()) || 0; // Adding || 0 to handle NaN cases
    });

    // Update the total sum div
    $('#totalSum').text(sum.toFixed(2)); // Assuming two decimal places for currency

    // Calculate and update the balance
    var balance = totalAllocations - sum;
    $('#balance').text(balance.toFixed(2));
}

// Event delegation for dynamically added elements
$(document).on('input', '.form-input', function() {
    updateSumAndBalance();
});

// Initial calculation
updateSumAndBalance();
    $("#paymentCode").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "/admin/student-bursary-registers/fetch-code",
                data: { query: request.term },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.code + " - " + item.allocation_amount,
                            value: item.code,
                            amount: item.allocation_amount // Store the allocation amount
                        };
                    }));
                }
            });
        },
        minLength: 2, // Minimum length before searching
        select: function(event, ui) {
            // Update the span/div with the allocation amount
            $("#amount").text(ui.item.amount);

            // Optionally, you can also do something with the selected value
            console.log("Selected: " + ui.item.value + ", Amount: " + ui.item.amount);
        }
    });
/*
    $("#payment_code").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "/student-bursary-registers/fetch-code", // Backend URL to fetch suggestions
                type: "GET",
                dataType: "json",
                data: { term: request.term },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 2, // Minimum characters to trigger autocomplete
        select: function(event, ui) {
            // Fetch and display the amount when an option is selected
            fetchAmount(ui.item.value);
        }
    });

    function fetchAmount(selectedValue) {
        // Use AJAX to fetch the amount based on the selected value
        $.ajax({
            url: "/student-bursary-registers/fetch-amount", // Backend URL to fetch the amount
            type: "GET",
            data: { selectedItem: selectedValue },
            success: function(amount) {
                $("#amountValue").text(amount);
            }
        });
    }

*/
    $('#fname').hide();
  
   $('#admission_number_id').change(function() {

    
       var admissionNumberId = $(this).val();
       if (admissionNumberId) {
           $.ajax({
               url: '{{ route('admin.students.student-fees', ['admissionNumberId' => '__admissionNumberId__']) }}'.replace('__admissionNumberId__', admissionNumberId),
               type: "GET",
               dataType: "json",
               success:function(data) {
                   $('#fname').show();
                   console.log(data[1].balance);
                   $('#fullname').val(data[0].fullname);
                   //$('#nemis_number').val(data.nemis_number);
                
                 console.log(data[1].balance);
// Assuming jsonData is like: { "balance": 500, "status": "due" }

    document.getElementById('bal').textContent = 'Fee Balance: ' + data[1].balance;
    

                  // $('#trasnsfer_from_id').val(data.school_id).trigger('change');
                  // $('#disability').text(data.disability);
                  // $('#scholarship').text(data.on_scholarship);
                   // Update other fields
               }
           });
       }
   });

   document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.school-code').forEach(function (schoolElement) {
    schoolElement.addEventListener('click', function () {
      const schoolId = this.getAttribute('value');
      // Toggle the school's checkbox
      const schoolCheckbox = document.getElementById('school_' + schoolId);
      schoolCheckbox.checked = !schoolCheckbox.checked;

      // Disable form checkboxes if school is unchecked
      document.querySelectorAll('.form-checkbox').forEach(function (formCheckbox) {
        if (formCheckbox.id.includes('school_' + schoolId)) {
          formCheckbox.disabled = !schoolCheckbox.checked;
        }
      });
    });
  });
});


   

});


function sendSelectionsToBackend(selectedSchools) {
    $.ajax({
        url: '/admin/student/bulk', // Adjust this to your actual endpoint
        type: 'POST',
        data: { selections: selectedSchools },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // for CSRF protection
        },
        success: function(response) {
            // Call a function to handle the response and display the table
            displayTable(response);
        },
        error: function(xhr, status, error) {
            // Handle any errors
            console.error(error);
        }
    });
}


function toggleCheckboxes(schoolId) {
        var checkboxesDiv = document.getElementById('checkboxes_' + schoolId);
        if (checkboxesDiv) {
            checkboxesDiv.style.display = checkboxesDiv.style.display === 'none' ? 'flex' : 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM fully loaded and parsed");
        document.getElementById('filterButton').addEventListener('click', function () {
            let selectedSchools = [];
            let allSchools = document.querySelectorAll('input[name^="school_"]:checked');

            allSchools.forEach(function (schoolCheckbox) {
                let schoolId = schoolCheckbox.name.split('_')[1];
                let selectedForms = [];
                
                document.querySelectorAll(`input[name^="form_"][name$="_school_${schoolId}"]:checked`).forEach(function (formCheckbox) {
                    let formNumber = formCheckbox.name.split('_')[1];
                    selectedForms.push(formNumber);
                });

                selectedSchools.push({ schoolId: schoolId, forms: selectedForms });
            });

            console.log(selectedSchools);
            console.log("Tested");
        });
    });







</script>
@endsection