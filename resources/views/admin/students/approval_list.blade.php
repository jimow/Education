@extends('layouts.admin')
@section('content')

@foreach ($students as $student)
    <p>{{ $student->fullname }}</p>
@endforeach



@endsection