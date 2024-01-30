@extends('layouts.admin')

@section('styles')

<style>
.school-code {
    cursor: pointer;
}

title {
    color: red;
    font-weight: bolder;
}

.school-code:hover {
    background-color: #f8f9fa;
    color: red;
}
#totalSumContainer {
        border-radius: 10px; /* Adjust the value as per your requirement */
        padding: 10px;
        margin: 10px;
        border: 1px solid #ccc;
        background-color: #f2f2f2;
        font-weight: bold;
    }
#currentBalance {
    border-radius: 10px; /* Adjust the value as per your requirement */
        padding: 10px;
        margin: 10px;
        border: 1px solid #ccc;
        background-color: #f2f2f2;
        font-weight: bold;
}
#allocations {
    border-radius: 10px; /* Adjust the value as per your requirement */
        padding: 10px;
        margin: 10px;
        border: 1px solid #ccc;
        background-color: #f2f2f2;
        font-weight: bold;
}

#balance {

    border-radius: 10px; /* Adjust the value as per your requirement */
        padding: 10px;
        margin: 10px;
        border: 1px solid #ccc;
        background-color: #f2f2f2;
        font-weight: bold;
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
    flex: 0 0 12.5%;
    /* Forces the column to take up 1/8th of the row */
    max-width: 12.5%;
}
</style>
@endsection

@section('content')

<div class="card">
    <div class="card-header">

        <!-- All Schools Checkbox -->&nbsp; &nbsp;
        <label><input type="checkbox" id="selectAllSchools" class="form-check-input"><b> All Schools</b></label>


        <div class="row mt-2">
            <!-- School Checkboxes -->
            @foreach ($schools as $school)
            <div class="col-lg-3 col-md-4 col-sm-6 text-center">
                <div class="school-code" title="{{ $school->name }}" onclick="toggleCheckboxes({{ $school->id }})">
                    {{ $school->code }}
                </div>
                <div class="form-checkboxes" id="checkboxes_{{ $school->id }}" style="display: none;">
                    <label><input type="checkbox" class="form-check-input" name="school_{{ $school->id }}">
                        School</label>
                    @for ($i = 1; $i <= 4; $i++) <label><input type="checkbox"
                            name="form_{{ $i }}_school_{{ $school->id }}"> F{{ $i }}</label>
                        @endfor
                </div>
            </div>
            <!-- Row Break for Better Responsiveness -->
            @if ($loop->iteration % 4 == 0)
        </div>
        <div class="row mt-2">
            @endif
            @endforeach
        </div>
        <hr style="background-color:red; height: 4px; width:75%" />
        <!-- Payment and Allocation Fields -->
        <div class="row">

            <div class="form-group col-md-3">
                <label class="required" for="allocation_id">{{ trans('cruds.allocation.fields.payment_code') }}</label>
                <select class="form-control select2 {{ $errors->has('allocation') ? 'is-invalid' : '' }}" name="allocation_id" id="allocation_id" required>
                    @foreach($allocations as $id => $entry)
                    <option value="{{ $id }}" {{ old('allocation_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('allocation'))
                <div class="invalid-feedback">
                    {{ $errors->first('allocation') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.allocation.fields.payment_code_helper') }}</span>
          </div>

            
                
            <div id="allocations" class="panel bg-success text-white p-3 mb-2 col-md-2">
    Total Amount: <span id="totalAmount">0</span>
</div>
<div id="balance" class="panel bg-success text-white p-3 mb-2 col-md-2">
    Total Amount: <span id="totalAmount">0</span>
</div>

<div id="totalSumContainer" class="panel bg-primary text-white p-3 mb-2 col-md-2">
    Total Amount: <span id="totalAmount">0</span>
</div>
<div id="currentBalance" class="panel bg-danger text-white p-3 mb-2 col-md-2">
    Total Amount: <span id="totalAmount">0</span>
</div>
        </div>
 
    <hr style="background-color:black; height: 4px; width:75%" />
    <!-- Filter Button -->
    <div class="text-center mt-2">
        <button type="button" class="btn btn-primary" id="filterButton">Filter</button>
    </div>
</div>

<div class="card-body">






 
    <hr style="background-color:black; height: 4px; width:75%" />
    <!-- Data Table -->

    <table id="dataTable" class="table table-bordered table-striped" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>School Name</th>
                <th>F1</th>
                <th>F2</th>
                <th>F3</th>
                <th>F4</th>
                <th>Final Column</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated here -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">
                    <button onclick="sendDataToController()">Submit Data</button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
</div>


<!-- Modal for Confirming Submission -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Submission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- END OF THE MODAL -->

@endsection

@section('scripts')
<!-- Include jQuery -->


<script>
$(document).ready(function() { 



    function strToNumber(str) {
    // Use a regular expression to extract the number
    // This regex looks for any sequence of digits, possibly separated by commas, and may start with a currency symbol
    var matches = str.match(/[\d,]+\.?\d*/);

    // Check if the match was successful
    if (matches) {
        // Replace commas and parse the number
        return parseFloat(matches[0].replace(/,/g, ''));
    } else {
        console.log("No number found in the string.");
        return null;
    }
}
  
    function getAndLogDigits(divId) {
        // Get the content of the div
        var content = $('#' + divId).html();
        
        // Use a regular expression to extract digits
        var digitsMatch = content.match(/\d+/g);
        var digits = digitsMatch ? digitsMatch.join('') : '';

        // Log or use the digits as needed
       

        // If you need it as a number
        var number = digits ? parseInt(digits, 10) : 0;
        return digits;
    }


    Intl.NumberFormat('US-English');
      // Event delegation for dynamically added input fields
      $(document).on('keyup', 'input.form-control', function() {
      //  console.log('Input ID:', this.id); // Log the ID of the input
        // You can also call other functions here if needed
    });

    var sum = 0;
    $(document).on('blur', 'input.form-control', function() {
      //console.log(this.id);
     // console.log(this.value);
    });

    function calculateAndLogSum() {
        var sum = 0;
        $('input.form-control').each(function() {
            sum += parseFloat($(this).val()) || 0; // Adding || 0 to handle NaN cases
        });
       
        $('#totalSumContainer').html("Total: ");

        $('#totalSumContainer').html("<b>Total:</b> " + new Intl.NumberFormat().format(sum));

        var bal = $('#balance').html();
        var currentTotal = $('#totalSumContainer').html();

        bal = strToNumber(bal);
        currentTotal = strToNumber(currentTotal);
 
        var currentBalance = (bal - currentTotal);

        $('#currentBalance').html("Current Balance: " + new Intl.NumberFormat().format(currentBalance));

     
  
    }

    

    // Event delegation for dynamically added input fields
    $(document).on('blur', 'input.form-control', function() {
    calculateAndLogSum(); // Calculate and log the sum whenever a textbox loses focus

             
    });

   

    $('#allocation_id').change(function() {


        var payment_code = $(this).val();
        if (payment_code) {
            $.ajax({
                url: '{{ route('admin.students.payment-details', ['payment_code' => '__payment_code__']) }}'.replace('__payment_code__', payment_code),
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#allocations').html("ALLOCATIONS: " + new Intl.NumberFormat().format(data.allocation.amount));

                    var bal = data.allocation.amount - data.totalAmount;
                    $('#balance').html("BALANCE: "+ new Intl.NumberFormat().format(bal));
                    console.log(new Intl.NumberFormat().format(bal));
                    console.log(data.totalAmount);
                    // Update other fields
                }
            });
        }
    });



    //var schoolNameToIdMap = @json($schoolNameToIdMap);
    $('#dataTable').DataTable();

    //hide allocation inputbox 
    //$('#payment_code').hide();

    // Handler for "All Schools" checkbox
    $('#selectAllSchools').change(function() {
        var checked = $(this).is(':checked');
        console.log('All Schools checked:', checked);
        $('input[name^="school_"]').prop('checked', checked).change();
        $('input[name^="form_"]').prop('checked', checked);
    });

    // Handler for "All Form X" checkboxes
    $('.selectForm').change(function() {
        var checked = $(this).is(':checked');
        var formNumber = $(this).data('form');
        console.log('All Form ' + formNumber + ' checkbox:', checked ? 'checked' : 'unchecked');

        $('input[name^="form_' + formNumber + '_school_"]').each(function() {
            var schoolId = $(this).attr('name').split('_')[3];
            console.log('Setting form ' + formNumber + ' for school ' + schoolId + ' to ' + (
                checked ? 'checked' : 'unchecked'));
            $(this).prop('checked', checked);

            // Show form checkboxes container if hidden
            var checkboxesDiv = $('#checkboxes_' + schoolId);
            if (checkboxesDiv.css('display') === 'none' && checked) {
                console.log('Showing form checkboxes for school', schoolId);
                checkboxesDiv.css('display', 'flex');
            }
        });
    });

    // Additional logging for individual school and form checkboxes

    $('input[name^="school_"], input[name^="form_"]').change(function() {
        var checkboxName = $(this).attr('name');
        var isChecked = $(this).is(':checked');
        console.log('Checkbox ' + checkboxName + ' changed:', isChecked ? 'checked' : 'unchecked');
    });

});


document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.school-code').forEach(function(schoolElement) {
        schoolElement.addEventListener('click', function() {
            const schoolId = this.getAttribute('value');
            // Toggle the school's checkbox
            const schoolCheckbox = document.getElementById('school_' + schoolId);
            schoolCheckbox.checked = !schoolCheckbox.checked;

            // Disable form checkboxes if school is unchecked
            document.querySelectorAll('.form-checkbox').forEach(function(formCheckbox) {
                if (formCheckbox.id.includes('school_' + schoolId)) {
                    formCheckbox.disabled = !schoolCheckbox.checked;
                }
            });
        });
    });
});







/*function sendSelectionsToBackend(selectedSchools) {
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
}*/


function toggleCheckboxes(schoolId) {
    var checkboxesDiv = document.getElementById('checkboxes_' + schoolId);
    if (checkboxesDiv) {
        checkboxesDiv.style.display = checkboxesDiv.style.display === 'none' ? 'flex' : 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded and parsed");
    document.getElementById('filterButton').addEventListener('click', function() {
        let selectedSchools = [];
        let allSchools = document.querySelectorAll('input[name^="school_"]:checked');

        allSchools.forEach(function(schoolCheckbox) {
            let schoolId = schoolCheckbox.name.split('_')[1];
            let selectedForms = [];

            document.querySelectorAll(
                `input[name^="form_"][name$="_school_${schoolId}"]:checked`).forEach(
                function(formCheckbox) {
                    let formNumber = formCheckbox.name.split('_')[1];
                    selectedForms.push(formNumber);
                });

            selectedSchools.push({
                schoolId: schoolId,
                forms: selectedForms
            });
        });


    });
});

$('#filterButton').on('click', function() {
    var selectedSchools = {};

    // Collect selected schools and their forms
    $('input[name^="school_"]:checked').each(function() {
        var schoolId = $(this).attr('name').split('_')[1];
        selectedSchools[schoolId] = [];

        $('input[name^="form_"][name$="_school_' + schoolId + '"]:checked').each(function() {
            var formId = $(this).attr('name').split('_')[1];
            selectedSchools[schoolId].push(formId);
        });
    });

    // Check for payment code
    var paymentCode = $('#allocation_id').val();
    alert(paymentCode);
    // Check allocations from the div content
    var allocationContent = $('#allocations').html();
    var totalAllocations = parseInt(allocationContent) || 0; // Assuming the div contains a numeric value

    // The 'if' statement: Check if payment code is entered and allocations are greater than 0
    if (!paymentCode) {
        alert("You have not selected any payment code or your allocations is 0");
        return false; // Prevent further execution and default action
    }

    // Continue with the function if conditions are met
    sendSelections(selectedSchools);
    return true; // Allow normal behavior
});









/*function sendSelections(selectedSchools) {
    $.ajax({
        url: '/admin/students/bulk',
        type: 'POST',
        data: {
            selectedSchools: selectedSchools,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            console.log(data);
            populateDataTable(data);
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
}*/

function sendSelections(selectedSchools) {

    $.ajax({
        url: '/admin/students/bulk',
        type: 'POST',
        contentType: 'application/json', // Ensure the content type is set to JSON
        data: JSON.stringify({
            selectedSchools: selectedSchools,
            _token: $('meta[name="csrf-token"]').attr('content')
        }),
        success: function(data) {

            populateDataTable(data);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
        }
    });
}

function getSelectedSchoolsAndForms() {
    var selectedSchools = {};

    // Iterate over each school checkbox
    $('input[name^="school_"]:checked').each(function() {
        var schoolId = $(this).attr('name').split('_')[1];
        selectedSchools[schoolId] = [];

        // Check for selected forms in this school
        $('input[name^="form_"][name$="_school_' + schoolId + '"]:checked').each(function() {
            var formId = $(this).attr('name').split('_')[1];
            selectedSchools[schoolId].push(formId);
        });

        // If no forms are selected for this school, remove the school entry
        if (selectedSchools[schoolId].length === 0) {
            delete selectedSchools[schoolId];
        }
    });

    return selectedSchools;
}



/*function populateDataTable(data) {
    // Destroy the existing DataTable before repopulating
    var table = $('#dataTable').DataTable();
    table.destroy();

    var tableBody = $('#dataTable tbody');
    tableBody.empty();

    data.forEach(function(rowData) {
        var row = $('<tr></tr>');
        row.append('<td></td>');
        row.append('<td>' + rowData.schoolName + '</td>');

        // Iterate through each form
        ['F1', 'F2', 'F3', 'F4'].forEach(function(form, index) {
            // Check if this form is selected for the current school
            var isFormSelected = rowData.selectedForms.includes(String(index + 1)); // Ensure matching the form number correctly

            var input = $('<input>', {
                type: 'text',
                class: 'form-control', // Bootstrap class for styling
                id: 'school' + rowData.schoolId + '_form' + (index + 1),
                readonly: !isFormSelected // Set readonly based on whether the form is selected
            });
            row.append($('<td></td>').append(input));
        });

        row.append('<td>' + rowData.finalColumnData + '</td>');
        tableBody.append(row);
    });

    // Reinitialize the DataTable
    $('#dataTable').DataTable({
        // DataTables configuration options here
    });
}
*/


function populateDataTable(data) {
    // Destroy the existing DataTable before repopulating
    var table = $('#dataTable').DataTable();
    table.destroy();

    var tableBody = $('#dataTable tbody');
    tableBody.empty();
    
    data.forEach(function(rowData) {
        /* var schoolNameToIdMap = @json($schoolNameToIdMap);
         var currentTerm = @json(getCurrentTermOrHoliday());
         var year = @json(getCurrentYear());*/
        var row = $('<tr></tr>');
        row.append('<td></td>'); // Assuming this is for a specific data you might want to populate
        row.append('<td>' + rowData.schoolName + '</td>');
        // Iterate through each form
        ['F1', 'F2', 'F3', 'F4'].forEach(function(form, index) {
            var cell = $('<td></td>');
            var f =getFormId(form);
            var isFormSelected = rowData.selectedForms.includes(String(index +
            1)); // Ensure matching the form number correctly
            /* var schoolID = schoolNameToIdMap[rowData.schoolName];
             var formId = getFormId(form);
             var term = currentTerm;*/
            console.log(rowData.schoolId, f);
            var input = $('<input>', {
                type: 'text',
                class: 'form-control',
                id: 'school' + rowData.schoolId + '_form' + (index + 1),
                //title: rowData.schoolName + "--" + formId + " # " + schoolID + " Term " + term + " Year " + year,
                title: f,//rowData.schoolId + "--" + index++, //add the id or name of the input field

                readonly: !isFormSelected // Set readonly based on whether the form is selected
            });
//how to get the id of the input field

            cell.append(input);
            //get the sum of all the input fields for the forms
            var sum = 0;
            $('input[id^="school' + rowData.schoolId + '_form' + (index + 1) + '"]').each(function() {
    sum += parseInt($(this).val() || 0); // Adding || 0 to handle NaN cases
});

            //cell.append('<td>' + sum + '</td>');
            //row.append(cell);

            //console the sum as you key up the input fields
            input.keyup(function() {
                console.log(sum);
            });
            // Append student count if available
            if (rowData.studentCounts && rowData.studentCounts[form]) {
                var countSpan = $('<span>', {
                    text: ' (' + rowData.studentCounts[form] + ' students)',
                    class: 'student-count'
                });
                cell.append(countSpan);
            }

            row.append(cell);
        });

        row.append('<td>' + rowData.finalColumnData + '</td>');
        tableBody.append(row);
    });



    // Reinitialize the DataTable
    $('#dataTable').DataTable({
        // DataTable options here
    });
}





function populateDataTable2(data) {
    var table = $('#financialOverviewTable').DataTable();

    table.clear(); // Clear existing data

    data.forEach(function(rowData) {
        var row = [
            rowData.schoolName, // School Name
            // Repeat for each form, checking if it was selected
            rowData.selectedForms.includes('F1') ? '<input type="text" value="' + rowData.form1 + '" />' :
            '<input type="text" value="' + rowData.form1 + '" readonly>',
            rowData.selectedForms.includes('F2') ? '<input type="text" value="' + rowData.form2 + '" />' :
            '<input type="text" value="' + rowData.form2 + '" readonly>',
            rowData.selectedForms.includes('F3') ? '<input type="text" value="' + rowData.form3 + '" />' :
            '<input type="text" value="' + rowData.form3 + '" readonly>',
            rowData.selectedForms.includes('F4') ? '<input type="text" value="' + rowData.form4 + '" />' :
            '<input type="text" value="' + rowData.form4 + '" readonly>',
            rowData.finalColumnData // Data for the final column
        ];

        table.row.add(row);
    });

    table.draw(); // Redraw the table with the new data
}


function collectTableData() {
    var tableData = [];
    var code = $('#allocation_id').val();
    $('#dataTable tbody tr').each(function() {
        var row = $(this);
        var schoolId = row.find('.school-id').val(); // Assuming a hidden input with the class 'school-id'

        var rowData = {
            schoolId: schoolId,
            schoolName: row.find('td').eq(1).text(),
            formsData: {},
            code: code,
        };

        row.find('input[type="text"].form-control').each(function() {
            var input = $(this);
            var formId = input.attr('id').match(/_form(\d+)/)[1]; // Extract form number from ID
            if (formId) {
                rowData.formsData['F' + formId] = input.val();
            }
        });

        tableData.push(rowData);
    });
    console.log(tableData);
    return tableData;
}


/*function sendDataToController() {
    var tableData = collectTableData();

    // Construct the table content
    var modalBody = '<table class="table"><thead><tr><th>School</th><th>Form</th><th>Amount</th></tr></thead><tbody>';
    var totalAmount = 0;

    tableData.forEach(function(rowData) {
        Object.keys(rowData.formsData).forEach(function(form) {
            var amount = parseFloat(rowData.formsData[form]).toFixed(2); // Format as currency
            totalAmount += parseFloat(amount);
            modalBody += '<tr><td>' + rowData.schoolName + '</td><td>' + form + '</td><td>' + amount + '</td></tr>';
        });
    });

    modalBody += '</tbody><tfoot><tr><th colspan="2">Total</th><th>' + totalAmount.toFixed(2) + '</th></tr></tfoot></table>';

    // Load content and show modal
    $('#confirmationModal .modal-body').html(modalBody);
    $('#confirmationModal').modal('show');

    // Confirm submit
    $('#confirmSubmit').on('click', function() {
        performAjaxSubmission(tableData);
    });
}

function performAjaxSubmission(tableData) {
    // AJAX request
    $.ajax({
        url: '/admin/students/post-bulk',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            tableData: tableData,
            _token: $('meta[name="csrf-token"]').attr('content')
        }),
        success: function(response) {
            console.log('Server responded with:', response);
            $('#confirmationModal').modal('hide');
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            $('#confirmationModal').modal('hide');
        }
    });
}*/
//Function to convert digits to currency format.
function formatCurrency(value) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD', // Change to your desired currency code
        minimumFractionDigits: 2
    }).format(value);
}


var schoolNameIdMap = @json(getSchoolNameIdMap());
var currentTerm = @json(getCurrentTermOrHoliday());

function getFormId(formName) {
    const formMap = {
        'F1': 1,
        'F2': 2,
        'F3': 3,
        'F4': 4
        // Add more mappings if needed
    };

    return formMap[formName] || null; // Return null if formName is not in the map
}


/*function sendDataToController() {
    var tableData = collectTableData();
    console.log(tableData);
    var htmlContent = '<table class="table"><thead><tr><th>School</th><th>F1</th><th>F2</th><th>F3</th><th>F4</th></tr></thead><tbody>';
    


        
    tableData.forEach(function(rowData) {
        htmlContent += '<tr><td>' + rowData.schoolName + '</td>';

        // Add columns for each form
        htmlContent += '<td>' + (rowData.formsData['F1'] ? formatCurrency(rowData.formsData['F1']) : '-') + '</td>';
        htmlContent += '<td>' + (rowData.formsData['F2'] ? formatCurrency(rowData.formsData['F2']) : '-') + '</td>';
        htmlContent += '<td>' + (rowData.formsData['F3'] ? formatCurrency(rowData.formsData['F3']) : '-') + '</td>';
        htmlContent += '<td>' + (rowData.formsData['F4'] ? formatCurrency(rowData.formsData['F4']) : '-') + '</td>';
        htmlContent += '</tr>';
    });

    htmlContent += '</tbody></table>';

    Swal.fire({
        title: 'Confirm Submission',
        html: htmlContent,
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            return performAjaxSubmission(tableData);
        }
    });
}
*/

function sendDataToController() {

   

    var tableData = collectTableData();
    console.log(tableData);
    var htmlContent =
        '<table class="table"><thead><tr><th>School</th><th>F1</th><th>Fees Required F1</th><th>F2</th><th>Fees Required F2</th><th>F3</th><th>Fees Required F3</th><th>F4</th><th>Fees Required F4</th></tr></thead><tbody>';

    tableData.forEach(function(rowData) {
        htmlContent += '<tr><td>' + rowData.schoolName + '</td>';
        var schoolName = rowData.schoolName;
        var schoolNameIdMap = @json(getSchoolNameIdMap());
      
        var schoolId = schoolNameIdMap[rowData.schoolName]; // Convert school name to ID

        // Loop through each form and add two columns: one for the form data, another for the fees
        ['F1', 'F2', 'F3', 'F4'].forEach(function(form) {
            var formValue = rowData.formsData[form] || '-';

        

            var dataToSend = {
                //school_id: rowData.schoolId,
                schoolId: schoolId,
                form_id: getFormId(form),
           
              
            };

            console.log(dataToSend);
            // dataToSend.push(schoolName);
            $.ajax({
                url: '/admin/students/get-fees-ajax',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    dataToSend,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }),
                success: function(response) {
                    console.log('Server responded with:', response);
                    $('#confirmationModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#confirmationModal').modal('hide');
                }
            });


            var feesRequired = 100; //feesData[rowData.schoolName][form];
            htmlContent += '<td>' + formValue + '</td>'; // Form data
            htmlContent += '<td>' + (feesRequired ? formatCurrency(feesRequired) : '-') +
            '</td>'; // Fees required
        });

        htmlContent += '</tr>';
    });

    htmlContent += '</tbody></table>';

    Swal.fire({
        title: 'Confirm Submission',
        html: htmlContent,
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            return performAjaxSubmission(tableData);
        },
        width: '1000px'
    });
}



function performAjaxSubmission(tableData) {
    // AJAX request
    $.ajax({
        url: '/admin/students/post-bulk',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            tableData: tableData,

            _token: $('meta[name="csrf-token"]').attr('content')
        }),
        success: function(response) {
            console.log('Server responded with:', response);
            Swal.fire('Submitted!', 'Your data has been submitted.', 'success');
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            Swal.fire('Error', 'There was a problem submitting your data.', 'error');
        }
    });
}


//search for payment code for auto complete
</script>

@endsection