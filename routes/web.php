<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\AccessControll\RoleController;
use App\Http\Controllers\AccessControll\PermissionController;
use App\Http\Controllers\AccessControll\SystemController;
use App\Http\Controllers\AccessControll\UsersController;
use App\Http\Controllers\AccessControll\DesignationController;
use App\Http\Controllers\AccessControll\DepartmentController;




Route::get('/', function () {
    return view('auth.login');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';


//Permission and Access Controll Routes
Route::resource('permissions', PermissionController::class)->middleware('auth');
Route::resource('roles', RoleController::class)->middleware('auth');
Route::resource('system', SystemController::class)->middleware('auth');
Route::resource('users', UsersController::class)->middleware('auth'); 
Route::resource('departments', DepartmentController::class)->middleware('auth');
Route::resource('designations', DesignationController::class)->middleware('auth');
Route::get('user_disable/{id}', 'AccessControll\UsersController@save_disable')->name('user.disable')->middleware('auth');

//route for payroll
Route::group(['prefix' => 'payroll'], function () {

    Route::resource('salary_template', 'Payroll\SalaryTemplateController')->middleware('auth');
    Route::any('manage_salary','Payroll\ManageSalaryController@getDetails')->middleware('auth');
Route::get('addTemplate', 'Payroll\ManageSalaryController@addTemplate')->middleware('auth');
  Route::get('manage_salary_edit/{id}','Payroll\ManageSalaryController@edit')->name('employee.edit')->middleware('auth');;;;
  Route::delete('manage_salary_delete/{id}','Payroll\ManageSalaryController@destroy')->name('employee.destroy')->middleware('auth');;;;
    Route::get('employee_salary_list','Payroll\ManageSalaryController@salary_list')->name('employee.salary')->middleware('auth');;;
    Route::resource('make_payment', 'Payroll\MakePaymentsController')->middleware('auth');   
  Route::get('make_payment/{user_id}/{departments_id}/{payment_month}', 'Payroll\MakePaymentsController@getPayment')->name('payment')->middleware('auth'); 
Route::get('edit_make_payment/{user_id}/{departments_id}/{payment_month}', 'Payroll\MakePaymentsController@editPayment')->name('payment.edit')->middleware('auth'); 
  Route::post('save_payment','Payroll\MakePaymentsController@save_payment')->name('save_payment')->middleware('auth');;;;
  Route::post('edit_payment','Payroll\MakePaymentsController@edit_payment')->name('edit_payment')->middleware('auth');;;;
  Route::get('make_payment/{departments_id}/{payment_month}', 'Payroll\MakePaymentsController@viewPayment')->name('view.payment')->middleware('auth'); 

Route::resource('multiple_payment', 'Payroll\MultiplePaymentsController')->middleware('auth');  
Route::post('save_multiple_payment','Payroll\MultiplePaymentsController@save_payment')->name('multiple_save.payment')->middleware('auth');;;;
Route::get('multiple_payment/{departments_id}/{payment_month}', 'Payroll\MultiplePaymentsController@viewPayment')->name('multiple_view.payment')->middleware('auth'); 

    Route::resource('advance_salary', 'Payroll\AdvanceController')->middleware('auth'); 
   Route::get('findAmount', 'Payroll\AdvanceController@findAmount')->middleware('auth'); 
      Route::get('findMonth', 'Payroll\AdvanceController@findMonth')->middleware('auth');   
  Route::get('advance_approve/{id}', 'Payroll\AdvanceController@approve')->name('advance.approve')->middleware('auth'); 
Route::get('advance_reject/{id}', 'Payroll\AdvanceController@reject')->name('advance.reject')->middleware('auth'); 
Route::resource('employee_loan', 'Payroll\EmployeeLoanController')->middleware('auth'); 
 Route::get('findLoan', 'Payroll\EmployeeLoanController@findLoan')->middleware('auth');  
   Route::get('findLoanMonth', 'Payroll\EmployeeLoanController@findMonth')->middleware('auth');   
  Route::get('employee_loan_approve/{id}', 'Payroll\EmployeeLoanController@approve')->name('employee_loan.approve')->middleware('auth'); 
Route::get('employee_loan_reject/{id}', 'Payroll\EmployeeLoanController@reject')->name('employee_loan.reject')->middleware('auth'); 
   Route::resource('overtime', 'Payroll\OvertimeController')->middleware('auth'); 
  Route::get('overtime_approve/{id}', 'Payroll\OvertimeController@approve')->name('overtime.approve')->middleware('auth'); 
Route::get('overtime_reject/{id}', 'Payroll\OvertimeController@reject')->name('overtime.reject')->middleware('auth'); 
   Route::get('findOvertime', 'Payroll\OvertimeController@findAmount')->middleware('auth'); 
  Route::get('findOvertimeMonth', 'Payroll\OvertimeController@findMonth')->middleware('auth');   
 Route::any('nssf', 'Payroll\GetPaymentController@nssf')->middleware('auth'); 
 Route::any('tax', 'Payroll\GetPaymentController@tax')->middleware('auth'); 
 Route::any('nhif', 'Payroll\GetPaymentController@nhif')->middleware('auth'); 
 Route::any('wcf', 'Payroll\GetPaymentController@wcf')->middleware('auth'); 
Route::any('payroll_summary', 'Payroll\GetPaymentController@payroll_summary')->middleware('auth'); 
 Route::any('generate_payslip', 'Payroll\GetPaymentController@generate_payslip')->middleware('auth'); 
 Route::any('received_payslip/{id}', 'Payroll\GetPaymentController@received_payslip')->name('payslip.generate')->middleware('auth'); 
Route::get('payslip_pdfview',array('as'=>'payslip_pdfview','uses'=>'Payroll\GetPaymentController@payslip_pdfview'))->middleware('auth');

Route::post('save_salary_details',array('as'=>'save_salary_details','uses'=>'Payroll\ManageSalaryController@save_salary_details'))->middleware('auth');
    Route::get('employee_salary_list',array('as'=>'employee_salary_list','uses'=>'Payroll\ManageSalaryController@employee_salary_list'))->middleware('auth');
    Route::resource('get_payment2', 'Payroll\GetPayment2Controller')->middleware('auth');
    Route::resource('make_payment2', 'Payroll\MakePayments2Controller')->middleware('auth'); 
   //Route::post('make_payment/store{user_id}{departments_id}{payment_month}', 'Payroll\MakePaymentsController@store')->name('make_payment.store')->middleware('auth'); 
    
});
