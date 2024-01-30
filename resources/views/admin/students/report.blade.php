@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    <h1>Students Report</h1>
    </div>

    <div class="card-body">
   
    
    
    <div class="row">
        <div class="col-md-2 form-control">
            <select class="form-select select2" id="ward_id" name="ward_id">
                <option value="">Select Ward</option>
                @foreach($wards as $ward)
                    <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 form-control">
            <select class="form-select select2" id="school_id" name="school_id">
                <option value="">Select School</option>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 form-control">
            <select class="form-select select2" id="gender" name="gender">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="col-md-2 form-control">
            <select class="form-select select2" id="form_id" name="form_id">
                <option value="">Select Form</option>
                @foreach($forms as $form)
                    <option value="{{ $form->id }}">{{ $form->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <button class="btn btn-primary" id="generateReport">Generate Report</button>
        </div>
    

    <div class="mt-3" id="reportResult">
     
 
    <table id="students-table" class="table table-primary">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Admission Number</th>
                    <th>Ward ID</th>
                    <th>School ID</th>
                    <th>Form ID</th>
                    <th>Status</th>
                    <th>On Scholarship</th>
                    <!-- Add any additional columns as needed -->
                </tr>
            </thead>
            <tbody>
               
                   
           
            </tbody>
        </table>

    </div>
</div>


@endsection


@section('scripts')

<script>

    // Ajax request when Generate Report button is clicked
   
 
    $('#generateReport').on('click', function () {
        
        console.log('jQuery version:', $.fn.jquery);
console.log('DataTables version:', $.fn.dataTable.version);

    $.ajax({
        type: 'POST',
        url: '{{ route("admin.students.generateReport") }}',
        data: {
            ward_id: $('#ward_id').val(),
            school_id: $('#school_id').val(),
            gender: $('#gender').val(),
            form_id: $('#form_id').val(),
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
          // Assuming response is an array of student objects
            if (Array.isArray(response.students)) {
              
                $('#students-table tbody').empty();

                response.students.forEach(function (student, index) {
               

                    var row = '<tr>' +
                        '<td>' + student.fullname + '</td>' +
                        '<td>' + student.admission_number + '</td>' +
                        '<td>' + student.ward_id + '</td>' +
                        '<td>' + student.school_id + '</td>' +
                        '<td>' + student.form_id + '</td>' +
                        '<td>' + student.status + '</td>' +
                        '<td>' + student.on_scholarship + '</td>' +
                        '<td>' + student.id + '</td>' +
                        // Add any additional columns as needed
                        '</tr>';
                        
                    $('#students-table tbody').append(row);
                          
      
     
                });

                $('#students-table').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    // Add more options as needed
                });
              
               
            } else {
                console.error('Invalid response format. Please check your response data.');
            }
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
});

</script>



@endsection