<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\StudentCountPerTerm;
use App\Models\Year;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentCountPerTermController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('student_count_per_term_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentCountPerTerms = StudentCountPerTerm::with(['school', 'year'])->get();

        $schools = School::get();

        $years = Year::get();

        return view('admin.studentCountPerTerms.index', compact('schools', 'studentCountPerTerms', 'years'));
    }
}
