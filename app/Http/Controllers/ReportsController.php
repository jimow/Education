<?php

namespace App\Http\Controllers;
use App\Models\Ward;
use App\Models\School;

use App\Models\StudentForm;
use App\Models\Student;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    //

    public function showReportForm()
{
    // Retrieve data for select options, assuming you have corresponding models and relationships
    $wards = Ward::all();
    $schools = School::all();
    $forms = StudentForm::all();
   
   

    return view('admin.students.create_report', compact('wards', 'schools', 'forms'));
}

public function generateReport(Request $request)
    {
        // Start building the query
        $query = Student::query();

        // Add conditions to the query based on the presence of request parameters
        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->has('ward_id')) {
            $query->where('ward_id', $request->ward_id);
        }

        if ($request->has('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('form_id')) {
            $query->where('form_id', $request->form_id);
        }


        // Execute the query and get the results
        $students = $query->get();

        // Return the results
        // You can return a view or JSON response based on your project's needs.
        // For example, to return a view with the students data:
        // return view('reports.student_report', compact('students'));

        // Or to return a JSON response:
        return response()->json($students);
    }
}
?>
