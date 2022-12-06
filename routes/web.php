<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessControll\RoleController;
use App\Http\Controllers\AccessControll\PermissionController;
use App\Http\Controllers\AccessControll\SystemController;
use App\Http\Controllers\AccessControll\UsersController;
use App\Http\Controllers\AccessControll\DesignationController;
use App\Http\Controllers\AccessControll\DepartmentController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Payroll\PayrollController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\setting\BranchController;
use App\Http\Controllers\WorkforceManagement\EmployeeController;
use App\Models\workforceManagement\Employee;

Route::get('/', function () {
    return view('auth.login');
});


Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

   // preoject
   Route::get('/project', [ProjectController::class, 'index'])->name('project.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resources([
        'permissions' => PermissionController::class,
        'roles' => RoleController::class,
        'system' => SystemController::class,
        'users' => UsersController::class,
        'departments' => DepartmentController::class,
        'designations' => DesignationController::class,
    ]);

    Route::get('user_disable/{id}', [UsersController::class, 'save_disable'])->name('user.disable');

    /**
     * Workforce Manegment
     */

    Route::get('/performance/workforce-management/active-mebers', [EmployeeController::class, 'activeMembers'])->name('employee.active');
    Route::get('/performance/workforce-management/employee-create', [EmployeeController::class, 'createEmployee'])->name('employee.create');
    Route::post('/performance/workforce-management/employee/store', [EmployeeController::class, 'storeEmployee'])->name('employee.store');

    Route::get('/suspended-employee', [EmployeeController::class, 'suspendedEmployee'])->name('employee.suspended');

    Route::get('/audit-trail', [AuditTrailController::class, 'index'])->name('audit');

    Route::get('bank-branch/{id}', [BranchController::class, 'fetchBranch'])->name('bankBranchFetcher');

    // Employee overtime
    Route::get('/perfromance/workforce-management/overtime', [EmployeeController::class, 'overtime'])->name('overtime');



    //route for payroll
    Route::group(['prefix' => 'payroll'], function () {
        Route::any('payroll',[PayrollController::class,'payroll'])->name('payroll');
        Route::any('temp_payroll_info',[PayrollController::class,'temp_payroll_info'])->name('temp_payroll_info');
        Route::post('payroll_info',[PayrollController::class,'payroll_info'])->name('payroll_info');
        Route::post('payroll_report',[PayrollController::class,'payroll_report'])->name('payroll_report');
        Route::any('initPayroll',[PayrollController::class,'initPayroll'])->name('initPayroll');
        Route::any('runpayroll',[PayrollController::class,'runpayroll'])->name('runpayroll');
        Route::any('send_payslips',[PayrollController::class,'send_payslips'])->name('send_payslips');
        Route::any('recommendpayroll',[PayrollController::class,'recommendpayroll'])->name('recommendpayroll');
        Route::any('cancelpayroll',[PayrollController::class,'cancelpayroll'])->name('cancelpayroll');
        Route::any('ADVtemp_less_payments',[PayrollController::class,'ADVtemp_less_payments'])->name('ADVtemp_less_payments');
        Route::any('less_payments_print',[PayrollController::class,'less_payments_print'])->name('less_payments_print');
        Route::any('grossReconciliation',[PayrollController::class,'grossReconciliation'])->name('grossReconciliation');
        Route::any('netReconciliation',[PayrollController::class,'netReconciliation'])->name('netReconciliation');
        Route::any('sendReviewEmail',[PayrollController::class,'sendReviewEmail'])->name('sendReviewEmail');
        Route::any('ADVtemp_less_payments',[PayrollController::class,'ADVtemp_less_payments'])->name('ADVtemp_less_payments');
        Route::any('generate_checklist',[PayrollController::class,'generate_checklist'])->name('generate_checklist');
        Route::any('employee_payslip', [PayrollController::class, 'employee_payslip'])->name('employee_payslip');
        Route::any('employeeFilter', [PayrollController::class, 'employeeFilter'])->name('employeeFilter');















        Route::any('incentives', [PayrollController::class,'incentives'])->name('incentives');
        Route::any('/partial-payment', [PayrollController::class, 'partialPayment'])->name('partialPayment');

    });

});

require __DIR__.'/auth.php';




