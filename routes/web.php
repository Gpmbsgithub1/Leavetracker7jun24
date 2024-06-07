<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth'])->group(function () {
    Route::prefix('hr')->name('hr.')->group(function () {
        Route::get('home', 'App\Http\Controllers\HrController@index')->name('home');
        Route::get('employees', 'App\Http\Controllers\HrController@employees')->name('employees');
        Route::get('create-employee', 'App\Http\Controllers\HrController@create_employee')->name('create_employee');
        Route::post('create-employee-store', 'App\Http\Controllers\HrController@store_employee')->name('create_employee_store');
        Route::get('edit-employee/{id}', 'App\Http\Controllers\HrController@edit_employee')->name('edit_employee');
        Route::post('edit-employee-store/{id}', 'App\Http\Controllers\HrController@store_edit_employee')->name('edit_employee_store');
        Route::get('inact-employee/{id}', 'App\Http\Controllers\HrController@inactivate_employee')->name('inact_employee');
        Route::get('activate-employee/{id}', 'App\Http\Controllers\HrController@activate_employee')->name('act_employee');
        Route::get('inactive-employees', 'App\Http\Controllers\HrController@inactive_employees')->name('inactive_employees');
        Route::post('group-employee/{id}', 'App\Http\Controllers\HrController@add_to_group')->name('group_employee');
        Route::get('groups', 'App\Http\Controllers\HrController@groups')->name('groups');
        Route::get('create-group', 'App\Http\Controllers\HrController@create_group')->name('create_group');
        Route::post('create-group-store', 'App\Http\Controllers\HrController@store_group')->name('create_group_store');
        Route::get('edit-group/{id}', 'App\Http\Controllers\HrController@edit_group')->name('edit_group');
        Route::post('edit-group-store/{id}', 'App\Http\Controllers\HrController@store_edit_group')->name('edit_group_store');
        Route::get('delete-group/{id}', 'App\Http\Controllers\HrController@delete_group')->name('delete_group');
        Route::get('group-members/{id}', 'App\Http\Controllers\HrController@group_members')->name('group_members');
        Route::post('group-from-employee/{id}/{gid}', 'App\Http\Controllers\HrController@add_from_group')->name('from_group_employee');
        Route::get('make-manager/{id}/{uid}', 'App\Http\Controllers\HrController@make_manager')->name('make_manager');
        Route::post('add-group/{id}', 'App\Http\Controllers\HrController@add_group')->name('add_group');
        Route::get('remove-group/{id}/{gid}', 'App\Http\Controllers\HrController@remove_from_group')->name('remove_group');
        Route::get('documents', 'App\Http\Controllers\HrController@documents')->name('documents');
        Route::get('my-documents', 'App\Http\Controllers\HrController@my_docs')->name('my_docs');
        Route::get('add-document', 'App\Http\Controllers\HrController@add_doc')->name('add_document');
        Route::get('edit-document/{id}', 'App\Http\Controllers\HrController@edit_doc')->name('edit_document');
        Route::get('view-document/{id}', 'App\Http\Controllers\HrController@view_document')->name('view_document');
        Route::post('add-document-store', 'App\Http\Controllers\HrController@doc_store')->name('add_document_store');
        Route::post('edit-document-store/{id}', 'App\Http\Controllers\HrController@edit_doc_store')->name('edit_document_store');
        Route::get('delete-doc/{id}', 'App\Http\Controllers\HrController@delete_document')->name('delete_document');
        Route::get('awards', 'App\Http\Controllers\HrController@awards')->name('awards');
        Route::get('add-award', 'App\Http\Controllers\HrController@add_award')->name('add_award');
        Route::get('edit-award/{id}', 'App\Http\Controllers\HrController@edit_award')->name('edit_award');
        Route::get('view-award/{id}', 'App\Http\Controllers\HrController@view_award')->name('view_award');
        Route::post('add-award-store', 'App\Http\Controllers\HrController@award_store')->name('add_award_store');
        Route::post('edit-award-store/{id}', 'App\Http\Controllers\HrController@edit_award_store')->name('edit_award_store');
        Route::get('delete-award/{id}', 'App\Http\Controllers\HrController@delete_award')->name('delete_award');
        Route::get('leave-requests', 'App\Http\Controllers\HrController@leave_request')->name('leave_requests');
        Route::get('approved-leaves', 'App\Http\Controllers\HrController@approved_leaves')->name('approved_leaves');
        Route::get('rejected-leaves', 'App\Http\Controllers\HrController@rejected_leaves')->name('rejected_leaves');
        Route::get('leave-accept/{id}', 'App\Http\Controllers\HrController@leave_accept')->name('leave_accept');
        Route::post('leave-reject/{id}', 'App\Http\Controllers\HrController@leave_reject')->name('leave_reject');
        Route::get('view-leave/{id}', 'App\Http\Controllers\HrController@view_leave_doc')->name('view_leave_doc');
        Route::get('salary', 'App\Http\Controllers\HrController@salary')->name('salary');
        Route::get('{eid}/employee-profile', 'App\Http\Controllers\HrController@profile')->name('employee_profile');
        Route::get('{eid}/salary-slip', 'App\Http\Controllers\HrController@salary_slip')->name('salary_slip');
        Route::get('salary-slip', 'App\Http\Controllers\HrController@slip')->name('slip');
        Route::get('view-salary_slip/{id}', 'App\Http\Controllers\HrController@view_salary_slip')->name('view_salary_slip');
        Route::get('salary-expenses', 'App\Http\Controllers\HrController@expense')->name('expense');
        Route::get('holidays', 'App\Http\Controllers\HrController@holiday')->name('holiday');
        Route::get('add-holiday', 'App\Http\Controllers\HrController@add_holiday')->name('add_holiday');
        Route::post('holiday-store', 'App\Http\Controllers\HrController@holiday_store')->name('store_holiday');
        Route::get('edit-holiday/{id}', 'App\Http\Controllers\HrController@edit_holiday')->name('edit_holiday');
        Route::post('edit-holiday-store/{id}', 'App\Http\Controllers\HrController@edit_holiday_store')->name('edit_holiday_store');
        Route::get('delete-holiday/{id}', 'App\Http\Controllers\HrController@delete_holiday')->name('delete_holiday');
        Route::get('change-password', 'App\Http\Controllers\HrController@change_password')->name('change_password');
        Route::post('change-password/store', 'App\Http\Controllers\HrController@change')->name('change_password.store');
       
    });
	
	
	Route::group(['middleware' => ['auth']], function() {
	 Route::get('/downloadPDF/{eid}', 'PDFController@downloadPDF')->name('pdf.download');
	});

    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('home', 'App\Http\Controllers\EmployeeController@index')->name('home');
        Route::get('leaves', 'App\Http\Controllers\EmployeeController@leaves')->name('leaves');
        Route::get('approved-leaves', 'App\Http\Controllers\EmployeeController@approved_leaves')->name('approved_leaves');
        Route::get('rejected-leaves', 'App\Http\Controllers\EmployeeController@reject_leaves')->name('rejected_leaves');
        Route::get('request-leave', 'App\Http\Controllers\EmployeeController@request_leave')->name('request_leave');
        Route::post('leave-request-store', 'App\Http\Controllers\EmployeeController@leave_store')->name('request_leave_store');
        Route::get('view-leave/{id}', 'App\Http\Controllers\EmployeeController@view_leave_doc')->name('view_leave');
        Route::get('groups', 'App\Http\Controllers\EmployeeController@groups')->name('groups');
        Route::get('group-members/{id}', 'App\Http\Controllers\EmployeeController@group_members')->name('group_members');
        Route::get('remove-group/{id}/{gid}', 'App\Http\Controllers\EmployeeController@remove_from_group')->name('remove_group');
        Route::get('leave-requests/{id}/{eid}', 'App\Http\Controllers\EmployeeController@leave_requests')->name('leave_requests');
        Route::get('leave-accept/{id}/{gid}', 'App\Http\Controllers\EmployeeController@leave_accept')->name('leave_accept');
        Route::post('leave-reject/{id}/{gid}', 'App\Http\Controllers\EmployeeController@leave_reject')->name('leave_reject');
        Route::get('documents', 'App\Http\Controllers\EmployeeController@documents')->name('documents');
        Route::get('view-document/{id}', 'App\Http\Controllers\EmployeeController@view_document')->name('view_document');
        Route::get('delete-doc/{id}', 'App\Http\Controllers\EmployeeController@delete_document')->name('delete_document');
        Route::get('salary_slip', 'App\Http\Controllers\EmployeeController@salary_slip')->name('salary_slip');
        Route::get('view-salary_slip/{id}', 'App\Http\Controllers\EmployeeController@view_salary_slip')->name('view_salary_slip');
        Route::get('profile', 'App\Http\Controllers\EmployeeController@profile')->name('profile');
        Route::get('holidays', 'App\Http\Controllers\EmployeeController@holidays')->name('holidays');
        Route::get('change-password', 'App\Http\Controllers\EmployeeController@change_password')->name('change_password');
        Route::post('change-password/store', 'App\Http\Controllers\EmployeeController@change')->name('change_password.store');
    });

    Route::get('/', 'App\Http\Controllers\MainController@index')->name('main.home');
});

Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    return "Cache is cleared";
})->name('clear.cache');

Route::get('/clear-route', function () {
    Artisan::call('route:cache');
    return "Routes cleared";
})->name('clear.route');

Route::get('/clear-view', function () {
    Artisan::call('view:clear');
    return "Views cleared";
})->name('clear.view');

Route::get('employee/delete', 'App\Http\Controllers\EmployeeController@delete_employee')->name('employee.delete');
Route::get('salary/delete', 'App\Http\Controllers\EmployeeController@delete_salary')->name('salary.delete');
Route::get('user/delete', 'App\Http\Controllers\MainController@delete_user')->name('user.delete');
Route::get('company/create', 'App\Http\Controllers\MainController@create_company')->name('company.create');
Route::get('group/show', 'App\Http\Controllers\MainController@group')->name('group.show');
Route::get('desklog', 'App\Http\Controllers\MainController@desklog')->name('desklog.show');
Route::get('desklog/productive', 'App\Http\Controllers\MainController@productive')->name('desklog.productive');
Route::get('week/productive', 'App\Http\Controllers\MainController@week_productive')->name('week.productive');
Route::get('salary/slip', 'App\Http\Controllers\MainController@leave_split')->name('salary.slip');
Route::get('salary-slip', 'App\Http\Controllers\MainController@salary_slip')->name('salary-slip');
Route::get('salary-email', 'App\Http\Controllers\MainController@salary_email')->name('salary-email');
Route::get('salary-date', 'App\Http\Controllers\MainController@sal_date')->name('salary-date');
Route::get('cmp', 'App\Http\Controllers\MainController@cmp')->name('cmp');
Route::get('user-update', 'App\Http\Controllers\MainController@user_update')->name('user-update');
Route::get('pdf/salary-slip', 'App\Http\Controllers\MainController@pdf')->name('pdf.salary-slip');
Route::get('api/fetch', 'App\Http\Controllers\DesklogApp\Http\Controllers\ApiController@load_api')->name('api.fetch');
Route::get('api/users-fetch', 'App\Http\Controllers\DesklogApp\Http\Controllers\ApiController@desklog_users')->name('api.users-fetch');
Route::get('api', 'App\Http\Controllers\DesklogApp\Http\Controllers\ApiController@api')->name('api');
Route::get('users_api', 'App\Http\Controllers\ApiController@api')->name('user.usersapi');



require __DIR__.'/auth.php';
