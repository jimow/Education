@extends('layouts.admin')
<style>
  .scrollable-table {
    height: 200px; /* Adjust the height as needed */
    overflow-y: scroll;
  }
  thead th {
    position: sticky;
    top: 0; /* Adjust this value if you have other fixed content at the top */
    background-color: #fff; /* Ensure the text is visible when scrolling */
    z-index: 1; /* Ensure the header is above other content when scrolling */
  }
  .center {
  text-align: center;
  color: red;
}
</style>
@section('content')
@php
    // $currentPeriods = getCurrentTermOrHoliday();
            

   
                     // $gov = $role->contains(function ($value) {
   // return $value === 'Admin' || $value === 'Governor';
//});
                    //   $pr = $role->contains('Principal');
                     //  @endphp
                     
              
<div class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header bg-success text-white">
            <b>Dashboard</b> <span style="float: right"><b>{{ auth()->user()->name }} : {{ Auth::user()->roles->pluck('title')->join(', ') }}</b></span>
          </div>
          <div class="card-body">
            @if(session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>@endif
           
          
            <div class="row">
              <!-- School Name Card -->
         
          
              <div class="col-md-6 col-xl-3">
                <div class="card bg-primary text-white mb-4">
                  <div class="card-body">
                    
                    @php
                    // Your JSON string
                   
                    // Decode the JSON string into an array
                    $data = json_decode($am_term, true);
                
                    // Initialize totalBursary
                    $totalBursary = null;
                  
                    // Check if the array has at least one element and the 'total_bursary' key exists
                    if (!empty($data) && isset($data[0]['total_bursary'])) {
                        $totalBursary1 = $data[0]['total_bursary'];
                    }

                    $data2 = json_decode($am_year, true);
                
                    // Initialize totalBursary
                    $totalBursary2 = null;
                
                    // Check if the array has at least one element and the 'total_bursary' key exists
                    if (!empty($data2) && isset($data2[0]['total_bursary'])) {
                        $totalBursary2 = $data2[0]['total_bursary'];
                    }
                @endphp
                    {{$schoolName}}  
                  
                  </div>
                </div>
              </div>
              <!-- Number of Students Card -->
              <div class="col-md-6 col-xl-3">
                <div class="card bg-danger text-white mb-4">
                  <div class="card-body">
                  <a href="{{ route('admin.students.index') }}">&nbsp;Number of Students: {{$totalRegisteredStudent}}</a><!-- Dynamic data here -->
                  </div>
                </div>
              </div><!-- Gender Distribution Card -->
              <div class="col-md-6 col-xl-3">
                <div class="card bg-primary text-white mb-4">
                  <div class="card-body">
                    Gender: Boys: {{$boys}} Girls: {{$girls}}<!-- Dynamic data here -->
                  </div>
                </div>
              </div><!-- Bursary Paid This Term Card -->
              <div class="col-md-6 col-xl-3">
                <div class="card bg-danger text-white mb-4">
                  <div class="card-body">
                    Bursary This Term: KES @if($totalBursaryPaid)
                      {{ number_format($totalBursaryPaid) }}
                  @else
                      
                  @endif<!-- Dynamic data here -->
                  </div>
                </div>
              </div>
            </div><!-- Charts and Additional Information -->
            <hr />
            <div class="row">
              <!-- School Name Card -->
          
              <div class="col-md-6 col-xl-3">
                <div class="card bg-primary text-white mb-4">
                  <div class="card-body">
                    

                       
                   
                    &nbsp;Disability: {{$disability}} 

                      
    @php
        $feeSummary = calculateStudentFeesSummary(9, 1, "Term 1", 1);
        // Process $feeSummary to create a displayable string
        // For example, showing total fees for all students
        $totalFees = 0;
        foreach($feeSummary as $summary) {
            $totalFees += $summary['total_fee'];
        }
        echo "Total Fees: " . $totalFees;
    @endphp

                    </h5><!-- Dynamic data here -->
                
                   
                  </div>
                </div>
              </div>
           
              <!-- Number of Students Card -->
              <div class="col-md-6 col-xl-3">
                <div class="card bg-danger text-white mb-4" style="cursor: pointer" onclick="loadScholarshipCount()">
                  <div class="card-body">
                    On Scholarship: {{$scholarship}}  {{ maskName('Jamal Derow Hussein'); }}<!-- Dynamic data here -->
                  </div>
                </div>
              </div><!-- Gender Distribution Card -->
              <div class="col-md-6 col-xl-3">
                <div class="card bg-primary text-white mb-4">
                  <div class="card-body">
                    Approved Student : {{ $status }}<!-- Dynamic data here -->
                  </div>
                </div>
              </div><!-- Bursary Paid This Term Card -->
              <div class="col-md-6 col-xl-3">
                <div class="card bg-danger text-white mb-4">
                  <div class="card-body">
                    Expected: 0
                      
                 <!-- Dynamic data here -->
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <!-- Students Per Class Per Stream Chart -->
              <div class="col-md-6">
                <div class="card m-0">
                  <div class="card-header bg-dark text-white">
                    <h5>Students Per Form</h5>
                  </div>
                  <div class="card-body scrollable-table p-0">
                    <table class="table table-bordered border-dark table-striped m-0">
                        <tr>
                            <th>Form Name</th>
                            <th>Number of Students</th>
                        </tr>
                    @foreach ($schoolClasses as $class) 
                  
                    <tr>
                        <td>{{$class->name}}</td>
                        <td> {{$class->students_count}}</td>
                        </tr>
                    @endforeach
                    </table>
                  </div>
                </div>
              </div><!-- Students Per Ward and Constituency Chart -->
           
              
              <div class="col-md-6">
                <div class="card mb-4">
                  <div class="card-header bg-dark text-white">
                    <h5>  <i class="fas fa-chart-pie mr-1"></i> Students Per Ward</h5>
                  </div>
                  <div class="card-body scrollable-table">
                    <table class="table table-bordered border-dark">
                        <tr>
                            <th>Ward Name</th>
                            <th>Number of Students</th>
                        </tr>
                    @foreach ($wards as $ward) 
                    <tr>
                    <td>{{$ward->name}}</td>
                    <td> {{$ward->students_count}}</td>
                    </tr>
                    @endforeach
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <!-- Students Per Class Per Stream Chart -->
              <div class="col-md-12">
              <div class="card-header bg-success text-white">
              <h3 class="center">Fees Required against Bursary Paid for the Current Year - {{ getCurrentTermOrHoliday() }}</h3>
              </div>
            <table id="financialOverviewTable2" class="table table-bordered table-striped table-success table-hover">
              <thead>
                  <tr>
                      <th></th>
                      <th>School Name</th>
                      <th>F1 Fees</th>
                      
                      <th>F2 (Fees/Bursary)</th>
                      <th>F3 (Fees/Bursary)</th>
                      <th>F4 (Fees/Bursary)</th>
                      <th>Total (Fees/Bursary)</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($tableData as $data1)
                  <tr>
                      <td></td>
                      <td style="max-width:100%; white-space:nowrap color:red">{{ $data1['school_name'] }} <b>({{ $data1['total_students']}})</b></td>
                      <td>{{ number_format($data1['form1_fees'], 2) }} / {{ number_format($data1['form1_bursary'], 2) }} <b>({{ $data1['form1_student_count']}})</b></td>
                      <td>{{ number_format($data1['form2_fees'], 2) }} / {{ number_format($data1['form2_bursary'], 2) }} <b>({{ $data1['form2_student_count']}})</b></td>
                      <td>{{ number_format($data1['form3_fees'], 2) }} / {{ number_format($data1['form3_bursary'], 2) }} <b>({{ $data1['form3_student_count']}})</b></td>
                      <td>{{ number_format($data1['form4_fees'], 2) }} / {{ number_format($data1['form4_bursary'], 2) }} <b>({{ $data1['form4_student_count']}})</b></td>
                      <td>{{ number_format($data1['total_fees'], 2) }} / {{ number_format($data1['total_bursaries'], 2) }}</td>
                  </tr>
                  @endforeach
              </tbody>
          </table>

  
      </div>

      <!-- DATA FOR THE ENTIRE YEAR -->

      <div class="row">
              <!-- Students Per Class Per Stream Chart -->
              <div class="col-md-12">
              <div class="card-header bg-success text-white">
              <h3 class="center">Fees Required against Bursary Paid for the Current Year - {{ date ('Y') }}</h3>
                </div>

            <table id="tableForYear" class="table table-bordered table-striped table-success table-hover">
              <thead>
                  <tr>
                      <th></th>
                      <th>School Name</th>
                      <th>F1 Fees</th>
                      
                      <th>F2 (Fees/Bursary)</th>
                      <th>F3 (Fees/Bursary)</th>
                      <th>F4 (Fees/Bursary)</th>
                      <th>Total (Fees/Bursary)</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($tableDataYear as $data1)
                  <tr>
                      <td></td>
                      <td style="max-width:100%; white-space:nowrap color:red">{{ $data1['school_name'] }} <b>({{ $data1['total_students']}})</b></td>
                      <td>{{ number_format($data1['form1_fees'], 2) }} / {{ number_format($data1['form1_bursary'], 2) }} <b>({{ $data1['form1_student_count']}})</b></td>
                      <td>{{ number_format($data1['form2_fees'], 2) }} / {{ number_format($data1['form2_bursary'], 2) }} <b>({{ $data1['form2_student_count']}})</b></td>
                      <td>{{ number_format($data1['form3_fees'], 2) }} / {{ number_format($data1['form3_bursary'], 2) }} <b>({{ $data1['form3_student_count']}})</b></td>
                      <td>{{ number_format($data1['form4_fees'], 2) }} / {{ number_format($data1['form4_bursary'], 2) }} <b>({{ $data1['form4_student_count']}})</b></td>
                      <td>{{ number_format($data1['total_fees'], 2) }} / {{ number_format($data1['total_bursaries'], 2) }}</td>
                  </tr>
                  @endforeach
              </tbody>
          </table>

  
      </div>


              <div class="col-xl-12">
                <div class="card m-0">
                  <div class="card-header bg-success text-white">
                    <h3 class="center">List of Student @if ($role[0] == 'Principal') For <b>{{ $schoolNames[0] }}@endif</b></h3>
                  </div>
                  <div >
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead><tr>
                        <th>ID</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Admission Number</th>
                        <th scope="col">Nemis Number</th>
                      
                       
                      

                        <th scope="col">School</th>
                       
                        <th scope="col">Ward</th>
                        <th scope="col">Class</th>
                      </tr>
                    
                      </thead>
                    <tbody>
                    @foreach ($students as $student) 
                    <tr>
                        <td></td>
                        <td>{{ $student->fullname }}</td>
                         <td>{{ $student->admission_number }}</td>
                        <td>{{ $student->nemis_number}}</td>
                       

                        <td>{{$student->school->name}}
                    
                        
                        <td>{{ $student->ward->name}}</td>
                        <td>{{ $student->form->name}} {{ $student->stream->name}} </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                  </div>
                </div>
              </div>

            



            
              
       
          
              

        
              

                  <div class="card-body scrollable-table p-0">
                 
             

              
              

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <!-- MODAL -->
      <!-- Scholarship Count Modal -->
<div class="modal fade" id="scholarshipModal" tabindex="-1" role="dialog" aria-labelledby="scholarshipModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 900px;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="scholarshipModalLabel">Students On Scholarship</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <thead>
            <tr> <!-- Apply the bg-primary class here -->
              <th scope="col" class="bg-primary">Fullname</th>
              <th scope="col" class="bg-primary">Admission Number</th>
              <th scope="col" class="bg-primary">Nemis Number</th>
              <th scope="col" class="bg-primary">School</th>
              <th scope="col" class="bg-primary">Ward</th>
              <th scope="col" class="bg-primary">Gender</th>
            </tr>
          </thead>
          <tbody id="scholarshipStudentsBody">
            <!-- Data will be inserted here by AJAX -->
          </tbody>
        </table> </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<button onclick="loadScholarshipCount()" class="btn btn-primary">Show Scholarship Count</button>

      <!-- END OF MODAL -->


      <!-- NEW FORMAT ######################### -->





      
      
    
  </div>
@endsection
@section('scripts')
@parent
<script>

function maskName(name) {
    let words = name.split(' ');
    let maskedWords = words.map(function (word) {
        let length = word.length;
        let maskedPart = word.substr(0, 2) + '*'.repeat(Math.max(0, length - 2));

        // Debugging: Log the original and masked parts
        console.log("Original: " + word + ", Masked: " + maskedPart);

        return maskedPart;
    });

    return maskedWords.join(' ');
}
function loadScholarshipCount() {
    $.ajax({
        url: '{{ route('admin.students.scholarship-count') }}',
        type: 'GET',
        success: function(response) {


          var studentsArray = response.data2;

var tbody = $('#scholarshipStudentsBody');
tbody.empty(); // Clear existing rows

// Iterate over the array of students
studentsArray.forEach(function(student) {
  var row = `
    <tr>
      <td>${student.fullname}</td>
      <td>${student.admission_number}</td>
      <td>${student.nemis_number}</td>
      <td>${student.school.name}</td>
      <td>${student.ward.name}</td>
      <td>${student.gender}</td>
    </tr>
  `;
  tbody.append(row);
});
            
            $('#scholarshipCount').text(response.data2);
            $('#scholarshipModal').modal('show');
        },
        error: function(error) {
            console.log(error);
            alert('Could not load the scholarship count');
        }
    });
}


$(document).ready(function() {
        // Initialize DataTable

        $('#feesTable').DataTable({
                  // DataTables options
              });
          
        $('#schoolFeesTable').DataTable({
          "pagingType": "full_numbers",
            "lengthChange": true,
            "ordering": true,
            "info": true,
            "searching": true,
            pageLength: 10
        });

        $('#dataTable').DataTable({
          pageLength: 10,
          customize: function (xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];

                    // Iterate over the rows and apply the nameMask to the 'fullname' column
                    $('row c[r^="B"]', sheet).each(function () {
                        var originalValue = $('is t', this).text();
                        var maskedValue = maskName(originalValue);
                        $('is t', this).text(maskedValue);
                    });
                }
        });


        $('#bursaryPaymentTable').DataTable({
            "pagingType": "full_numbers",
            "lengthChange": true,
            "ordering": true,
            "info": true,
            "searching": true
        });

        $('#financialOverviewTable').DataTable({
            "pagingType": "full_numbers",
            "lengthChange": true,
            "ordering": true,
            "info": true,
            "searching": true,
            scrollX : true
        });
        $('#financialOverviewTable2').DataTable({
            "pagingType": "full_numbers",
            "lengthChange": true,
            "ordering": true,
            "info": true,
            "searching": true,
            scrollX : true
        });

        $('#tableForYear').DataTable({
            "pagingType": "full_numbers",
            "lengthChange": true,
            "ordering": true,
            "info": true,
            "searching": true,
            scrollX : true
        });

        
    
        $('#perSchool').DataTable();



    });
</script>
@endsection