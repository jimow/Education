<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // County
    Route::apiResource('counties', 'CountyApiController');

    // Constituency
    Route::apiResource('constituencies', 'ConstituencyApiController');

    // Ward
    Route::apiResource('wards', 'WardApiController');

    // Principals
    Route::apiResource('principals', 'PrincipalsApiController');

    // School Gender Type
    Route::apiResource('school-gender-types', 'SchoolGenderTypeApiController');

    // School
    Route::apiResource('schools', 'SchoolApiController');

    // School Streams
    Route::apiResource('school-streams', 'SchoolStreamsApiController');

    // Students
    Route::post('students/media', 'StudentsApiController@storeMedia')->name('students.storeMedia');
    Route::apiResource('students', 'StudentsApiController');

    // Student Transfers
    Route::apiResource('student-transfers', 'StudentTransfersApiController');

    // Year
    Route::apiResource('years', 'YearApiController');

    // School Attendance
    Route::apiResource('school-attendances', 'SchoolAttendanceApiController');

    // Bursary
    Route::apiResource('bursaries', 'BursaryApiController');

    // Report Forms
    Route::post('report-forms/media', 'ReportFormsApiController@storeMedia')->name('report-forms.storeMedia');
    Route::apiResource('report-forms', 'ReportFormsApiController');

    // Student Bursary Register
    Route::apiResource('student-bursary-registers', 'StudentBursaryRegisterApiController');
});
