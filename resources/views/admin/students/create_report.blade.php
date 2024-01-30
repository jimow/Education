@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Create Report</h1>
    <form id="filterForm" >
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="ward_id">Ward</label>
            <select name="ward_id" id="ward_id" class="form-control">
                <option value="">Select Ward</option>
                @foreach($wards as $ward)
                    <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="school_id">School</label>
            <select name="school_id" id="school_id" class="form-control">
                <option value="">Select School</option>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="">Select Status</option>
                
                    <option value="Approved">Approved</option>
                    <option value="Not Approved">Not Approved</option>
        
            </select>
        </div>

        <div class="form-group">
            <label for="form_id">Form</label>
            <select name="form_id" id="form_id" class="form-control">
                <option value="">Select Form</option>
                @foreach($forms as $form)
                    <option value="{{ $form->id }}">{{ $form->name }}</option>
                @endforeach
            </select>
        </div>

       

        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>
</div>

<div>

<h1>Student Report</h1>

    <!-- Table for displaying student data -->
    <table id="studentsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Gender</th>
                <th>Ward ID</th>
                <th>School ID</th>
                <th>Status</th>
                <th>Form ID</th>
              
                <!-- Add more headers if needed -->
            </tr>
        </thead>
        <tbody>
            <!-- Data will be inserted here by AJAX -->
        </tbody>
    </table>
</div>

<!-- Include jQuery -->
@endsection

@section('scripts')

<script>
$(document).ready(function() {
   
    $('#filterForm').on('submit', function(event) {
        // Prevent the default form submission
        event.preventDefault();
        
        // Perform the AJAX call
        $.ajax({
            url: '{{ route('admin.report.generate') }}',
            type: 'GET',
            data: $(this).serialize(),
            success: function(data) {
                var rows = '';
                data.forEach(function(student) {
                    rows += '<tr>' +
                                '<td>' + student.gender + '</td>' +
                                '<td>' + student.ward_id + '</td>' +
                                '<td>' + student.school_id + '</td>' +
                                '<td>' + student.status + '</td>' +
                                '<td>' + student.form_id + '</td>' +
                                // ... Add more fields as needed ...
                            '</tr>';
                });
                $('#studentsTable tbody').html(rows);
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    });
});
</script>
</div>
@endsection
