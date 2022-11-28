<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessControll\RoleController;
use App\Http\Controllers\AccessControll\PermissionController;
use App\Http\Controllers\AccessControll\SystemController;
use App\Http\Controllers\AccessControll\UsersController;
use App\Http\Controllers\AccessControll\DesignationController;
use App\Http\Controllers\AccessControll\DepartmentController;
use App\Http\Controllers\Payroll\SalaryTemplateController;
use App\Http\Controllers\Payroll\ManageSalaryController;
use App\Http\Controllers\Payroll\MakePaymentsController;
use App\Http\Controllers\Payroll\MultiplePaymentsController;
use App\Http\Controllers\Payroll\AdvanceController;
use App\Http\Controllers\Payroll\EmployeeLoanController;
use App\Http\Controllers\Payroll\OvertimeController;
use App\Http\Controllers\Payroll\GetPaymentController;
use App\Http\Controllers\Payroll\GetPayment2Controller;


















Route::get('/', function () {
    return view('auth.login');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('system', SystemController::class);
    Route::resource('users', UsersController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('designations', DesignationController::class);
    Route::get('user_disable/{id}', [UsersController::class, 'save_disable'])->name('user.disable');


    //route for payroll
Route::group(['prefix' => 'payroll'], function () {

    Route::resource('salary_template', SalaryTemplateController::class);
    Route::any('manage_salary',ManageSalaryController::class,'getDetails');
    Route::get('addTemplate', ManageSalaryController::class,'addTemplate');
    Route::get('manage_salary_edit/{id}',ManageSalaryController::class,'edit')->name('employee.edit');
    Route::delete('manage_salary_delete/{id}',ManageSalaryController::class,'destroy')->name('employee.destroy');
    Route::get('employee_salary_list',ManageSalaryController::class,'salary_list')->name('employee.salary');
    Route::resource('make_payment', MakePaymentsController::class);   
    Route::get('make_payment/{user_id}/{departments_id}/{payment_month}', MakePaymentsController::class,'getPayment')->name('payment'); 
    Route::get('edit_make_payment/{user_id}/{departments_id}/{payment_month}', MakePaymentsController::class,'editPayment')->name('payment.edit'); 
    Route::post('save_payment',MakePaymentsController::class,'save_payment')->name('save_payment');
    Route::post('edit_payment',MakePaymentsController::class,'edit_payment')->name('edit_payment');
    Route::get('make_payment/{departments_id}/{payment_month}', MakePaymentsController::class,'viewPayment')->name('view.payment'); 

    Route::resource('multiple_payment',MultiplePaymentsController::class);  
    Route::post('save_multiple_payment',MultiplePaymentsController::class,'save_payment')->name('multiple_save.payment');
    Route::get('multiple_payment/{departments_id}/{payment_month}', MultiplePaymentsController::class,'viewPayment')->name('multiple_view.payment'); 

    Route::resource('advance_salary', AdvanceController::class); 
    Route::get('findAmount', AdvanceController::class,'findAmount'); 
    Route::get('findMonth', AdvanceController::class,'findMonth');   
    Route::get('advance_approve/{id}', AdvanceController::class,'approve')->name('advance.approve'); 
    Route::get('advance_reject/{id}', AdvanceController::class,'reject')->name('advance.reject'); 
    Route::resource('employee_loan', EmployeeLoanController::class); 
    Route::get('findLoan',  EmployeeLoanController::class,'findLoan');  
    Route::get('findLoanMonth',  EmployeeLoanController::class,'findMonth');   
    Route::get('employee_loan_approve/{id}',  EmployeeLoanController::class,'approve')->name('employee_loan.approve'); 
    Route::get('employee_loan_reject/{id}',  EmployeeLoanController::class,'reject')->name('employee_loan.reject'); 
    Route::resource('overtime', OvertimeController::class); 
    Route::get('overtime_approve/{id}', OvertimeController::class,'approve')->name('overtime.approve'); 
    Route::get('overtime_reject/{id}', OvertimeController::class,'reject')->name('overtime.reject'); 
    Route::get('findOvertime', OvertimeController::class,'findAmount'); 
    Route::get('findOvertimeMonth', OvertimeController::class,'findMonth');   
    Route::any('nssf', GetPaymentController::class,'nssf'); 
    Route::any('tax', GetPaymentController::class,'tax'); 
    Route::any('nhif', GetPaymentController::class,'nhif'); 
    Route::any('wcf', GetPaymentController::class,'wcf'); 
    Route::any('payroll_summary', GetPaymentController::class,'payroll_summary'); 
    Route::any('generate_payslip', GetPaymentController::class,'generate_payslip'); 
    Route::any('received_payslip/{id}', GetPaymentController::class,'received_payslip')->name('payslip.generate'); 
    Route::any('payslip_pdfview', GetPaymentController::class,'payslip_pdfview')->name('payslip_pdfview'); 
    Route::post('save_salary_details', ManageSalaryController::class,'save_salary_details')->name('save_salary_details'); 

    Route::post('employee_salary_list', ManageSalaryController::class,'employee_salary_list')->name('employee_salary_list'); 
    Route::resource('get_payment2', GetPayment2Controller::class);
    Route::resource('make_payment2', GetPayment2Controller::class); 
   //Route::post('make_payment/store{user_id}{departments_id}{payment_month}', 'Payroll\MakePaymentsController@store')->name('make_payment.store')->middleware('auth'); 
    
});

});

require __DIR__.'/auth.php';




