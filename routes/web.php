<?php
use App\Http\Controllers\Admin\StudentsController;
use App\Http\Controllers\Admin\StudentBursaryRegisterController;
use App\Http\Controllers\Admin\StudentTransfersController;
use App\Http\Controllers\Admin\AllocationController;

use App\Http\Controllers\ReportsController;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();





Route::get('/admin/students/report', [StudentsController::class, 'showReportForm'])->name('adminstudents.showReportForm');
Route::post('/admin/students/generate-report', [StudentsController::class, 'generateReport'])->name('admin.students.generateReport');


Route::get('/admin/students/bulk-payments', [StudentsController::class, 'showBulkPaymentsPage'])->name('admin.students.bulk-payments');
Route::get('/admin/students/get-school-streams', [StudentsController::class, 'getStreams'])->name('admin.students.get-streams');
Route::get('/admin/students/scholarship-count', [StudentsController::class,'scholarshipCount'])->name('admin.students.scholarship-count');
//Route::get('/admin/students/{admissionNumber}', [StudentsController::class, 'details'])->name('students.details');
Route::get('/admin/students/student-details/{admissionNumberId}', [StudentsController::class, 'getStudentDetails'])->name('admin.students.student-details');
Route::get('/admin/students/payment-details/{payment_code}', [StudentsController::class, 'getPaymentDetails'])->name('admin.students.payment-details');
Route::get('/admin/students/getStudents', 'StudentsController@getStudents')->name('admin.students.getStudents');
Route::get('/admin/students/student-fees/{admissionNumberId}', [StudentsController::class, 'getStudentFees'])->name('admin.students.student-fees');
Route::post('/admin/students/bulk',[StudentsController::class,'getStudentBulk'])->name('admin.students.bulk');
Route::get('/admin/student-bursary-registers/fetch-code', 'StudentBursaryRegisterController@fetchCode')->name('admin.student-bursary-registers.fetch-code');
Route::get('/admin/student-bursary-registers/fetch-amount', 'StudentBursaryRegisterController@fetchAmount')->name('admin.student-bursary-registers.fetch-amount');
Route::get('/admin/student-transfers/transfer-process', [StudentTransfersController::class, 'transferProcess'])->name('admin.student-transfers.transfer-process');
Route::get('/admin/allocations/{paymentCode}', [AllocationController::class,'getAllocationDetails'])->name('admin.allocations');

Route::get('/admin/report/form', [ReportsController::class, 'showReportForm'])->name('admin.report.form');
Route::get('/admin/report/generate', [ReportsController::class, 'generateReport'])->name('admin.report.generate');


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::post('permissions/parse-csv-import', 'PermissionsController@parseCsvImport')->name('permissions.parseCsvImport');
    Route::post('permissions/process-csv-import', 'PermissionsController@processCsvImport')->name('permissions.processCsvImport');
    Route::resource('permissions', 'PermissionsController');

    Route::post('students/bulk',[StudentsController::class,'getStudentBulk'])->name('students.bulk');
    Route::get('students/bulk-payments', [StudentsController::class, 'showBulkPaymentsPage'])->name('students.bulk-payments');
    Route::post('students/post-bulk',[StudentsController::class,'postBulk'])->name('students.post-bulk');
    Route::post('students/get-fees-ajax',[StudentsController::class,'getFeesAjax'])->name('students.get-fees-ajax');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::post('roles/parse-csv-import', 'RolesController@parseCsvImport')->name('roles.parseCsvImport');
    Route::post('roles/process-csv-import', 'RolesController@processCsvImport')->name('roles.processCsvImport');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // County
    Route::delete('counties/destroy', 'CountyController@massDestroy')->name('counties.massDestroy');
    Route::post('counties/parse-csv-import', 'CountyController@parseCsvImport')->name('counties.parseCsvImport');
    Route::post('counties/process-csv-import', 'CountyController@processCsvImport')->name('counties.processCsvImport');
    Route::resource('counties', 'CountyController');

    // Constituency
    Route::delete('constituencies/destroy', 'ConstituencyController@massDestroy')->name('constituencies.massDestroy');
    Route::post('constituencies/parse-csv-import', 'ConstituencyController@parseCsvImport')->name('constituencies.parseCsvImport');
    Route::post('constituencies/process-csv-import', 'ConstituencyController@processCsvImport')->name('constituencies.processCsvImport');
    Route::resource('constituencies', 'ConstituencyController');

    // Ward
    Route::delete('wards/destroy', 'WardController@massDestroy')->name('wards.massDestroy');
    Route::post('wards/parse-csv-import', 'WardController@parseCsvImport')->name('wards.parseCsvImport');
    Route::post('wards/process-csv-import', 'WardController@processCsvImport')->name('wards.processCsvImport');
    Route::resource('wards', 'WardController');

    // Principals
    Route::delete('principals/destroy', 'PrincipalsController@massDestroy')->name('principals.massDestroy');
    Route::post('principals/parse-csv-import', 'PrincipalsController@parseCsvImport')->name('principals.parseCsvImport');
    Route::post('principals/process-csv-import', 'PrincipalsController@processCsvImport')->name('principals.processCsvImport');
    Route::resource('principals', 'PrincipalsController');

    // School Gender Type
    Route::delete('school-gender-types/destroy', 'SchoolGenderTypeController@massDestroy')->name('school-gender-types.massDestroy');
    Route::post('school-gender-types/parse-csv-import', 'SchoolGenderTypeController@parseCsvImport')->name('school-gender-types.parseCsvImport');
    Route::post('school-gender-types/process-csv-import', 'SchoolGenderTypeController@processCsvImport')->name('school-gender-types.processCsvImport');
    Route::resource('school-gender-types', 'SchoolGenderTypeController');

    // School Category
    Route::delete('school-categories/destroy', 'SchoolCategoryController@massDestroy')->name('school-categories.massDestroy');
    Route::post('school-categories/parse-csv-import', 'SchoolCategoryController@parseCsvImport')->name('school-categories.parseCsvImport');
    Route::post('school-categories/process-csv-import', 'SchoolCategoryController@processCsvImport')->name('school-categories.processCsvImport');
    Route::resource('school-categories', 'SchoolCategoryController');

    // School
    Route::delete('schools/destroy', 'SchoolController@massDestroy')->name('schools.massDestroy');
    Route::post('schools/parse-csv-import', 'SchoolController@parseCsvImport')->name('schools.parseCsvImport');
    Route::post('schools/process-csv-import', 'SchoolController@processCsvImport')->name('schools.processCsvImport');
    Route::resource('schools', 'SchoolController');

    // School Streams
    Route::delete('school-streams/destroy', 'SchoolStreamsController@massDestroy')->name('school-streams.massDestroy');
    Route::post('school-streams/parse-csv-import', 'SchoolStreamsController@parseCsvImport')->name('school-streams.parseCsvImport');
    Route::post('school-streams/process-csv-import', 'SchoolStreamsController@processCsvImport')->name('school-streams.processCsvImport');
    Route::resource('school-streams', 'SchoolStreamsController');

    // Student Form
    Route::delete('student-forms/destroy', 'StudentFormController@massDestroy')->name('student-forms.massDestroy');
    Route::post('student-forms/parse-csv-import', 'StudentFormController@parseCsvImport')->name('student-forms.parseCsvImport');
    Route::post('student-forms/process-csv-import', 'StudentFormController@processCsvImport')->name('student-forms.processCsvImport');
    Route::resource('student-forms', 'StudentFormController');

    // Students
    Route::delete('students/destroy', 'StudentsController@massDestroy')->name('students.massDestroy');
    Route::post('students/media', 'StudentsController@storeMedia')->name('students.storeMedia');
    Route::post('students/ckmedia', 'StudentsController@storeCKEditorImages')->name('students.storeCKEditorImages');
    Route::post('students/parse-csv-import', 'StudentsController@parseCsvImport')->name('students.parseCsvImport');
    Route::post('students/process-csv-import', 'StudentsController@processCsvImport')->name('students.processCsvImport');
    Route::resource('students', 'StudentsController');

    // Student Transfers
    Route::delete('student-transfers/destroy', 'StudentTransfersController@massDestroy')->name('student-transfers.massDestroy');
    Route::post('student-transfers/parse-csv-import', 'StudentTransfersController@parseCsvImport')->name('student-transfers.parseCsvImport');
    Route::post('student-transfers/process-csv-import', 'StudentTransfersController@processCsvImport')->name('student-transfers.processCsvImport');
    Route::resource('student-transfers', 'StudentTransfersController');

    // Year
    Route::delete('years/destroy', 'YearController@massDestroy')->name('years.massDestroy');
    Route::post('years/parse-csv-import', 'YearController@parseCsvImport')->name('years.parseCsvImport');
    Route::post('years/process-csv-import', 'YearController@processCsvImport')->name('years.processCsvImport');
    Route::resource('years', 'YearController');

    // School Attendance
    Route::delete('school-attendances/destroy', 'SchoolAttendanceController@massDestroy')->name('school-attendances.massDestroy');
    Route::post('school-attendances/parse-csv-import', 'SchoolAttendanceController@parseCsvImport')->name('school-attendances.parseCsvImport');
    Route::post('school-attendances/process-csv-import', 'SchoolAttendanceController@processCsvImport')->name('school-attendances.processCsvImport');
    Route::resource('school-attendances', 'SchoolAttendanceController');

    // Bursary
    Route::delete('bursaries/destroy', 'BursaryController@massDestroy')->name('bursaries.massDestroy');
    Route::post('bursaries/parse-csv-import', 'BursaryController@parseCsvImport')->name('bursaries.parseCsvImport');
    Route::post('bursaries/process-csv-import', 'BursaryController@processCsvImport')->name('bursaries.processCsvImport');
    Route::resource('bursaries', 'BursaryController');

    // Report Forms
    Route::delete('report-forms/destroy', 'ReportFormsController@massDestroy')->name('report-forms.massDestroy');
    Route::post('report-forms/media', 'ReportFormsController@storeMedia')->name('report-forms.storeMedia');
    Route::post('report-forms/ckmedia', 'ReportFormsController@storeCKEditorImages')->name('report-forms.storeCKEditorImages');
    Route::post('report-forms/parse-csv-import', 'ReportFormsController@parseCsvImport')->name('report-forms.parseCsvImport');
    Route::post('report-forms/process-csv-import', 'ReportFormsController@processCsvImport')->name('report-forms.processCsvImport');
    Route::resource('report-forms', 'ReportFormsController');

    // Student Bursary Register
    Route::delete('student-bursary-registers/destroy', 'StudentBursaryRegisterController@massDestroy')->name('student-bursary-registers.massDestroy');
    Route::post('student-bursary-registers/parse-csv-import', 'StudentBursaryRegisterController@parseCsvImport')->name('student-bursary-registers.parseCsvImport');
    Route::post('student-bursary-registers/process-csv-import', 'StudentBursaryRegisterController@processCsvImport')->name('student-bursary-registers.processCsvImport');
    Route::resource('student-bursary-registers', 'StudentBursaryRegisterController');

    // School Permission
    Route::delete('school-permissions/destroy', 'SchoolPermissionController@massDestroy')->name('school-permissions.massDestroy');
    Route::post('school-permissions/parse-csv-import', 'SchoolPermissionController@parseCsvImport')->name('school-permissions.parseCsvImport');
    Route::post('school-permissions/process-csv-import', 'SchoolPermissionController@processCsvImport')->name('school-permissions.processCsvImport');
    Route::resource('school-permissions', 'SchoolPermissionController');

    // Termsettings
    Route::delete('termsettings/destroy', 'TermsettingsController@massDestroy')->name('termsettings.massDestroy');
    Route::resource('termsettings', 'TermsettingsController');

    // Student Count Per Term
    Route::resource('student-count-per-terms', 'StudentCountPerTermController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Fee Balance
    Route::resource('fee-balances', 'FeeBalanceController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Fee Balance School
    Route::resource('fee-balance-schools', 'FeeBalanceSchoolController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Other Settings
    Route::delete('other-settings/destroy', 'OtherSettingsController@massDestroy')->name('other-settings.massDestroy');
    Route::post('other-settings/parse-csv-import', 'OtherSettingsController@parseCsvImport')->name('other-settings.parseCsvImport');
    Route::post('other-settings/process-csv-import', 'OtherSettingsController@processCsvImport')->name('other-settings.processCsvImport');
    Route::resource('other-settings', 'OtherSettingsController');

    // Allocation
    Route::delete('allocations/destroy', 'AllocationController@massDestroy')->name('allocations.massDestroy');
    Route::post('allocations/parse-csv-import', 'AllocationController@parseCsvImport')->name('allocations.parseCsvImport');
    Route::post('allocations/process-csv-import', 'AllocationController@processCsvImport')->name('allocations.processCsvImport');
    Route::resource('allocations', 'AllocationController');

   


    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});
