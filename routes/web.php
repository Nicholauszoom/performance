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
use App\Models\Payroll\Payroll;

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
    Route::get('/performance/workforce-management/active-mebers', [EmployeeController::class, 'activeMembers'])->name('members.active');
    Route::get('/performance/workforce-management/employee-create', [EmployeeController::class, 'createEmployee'])->name('employee.create');

    Route::get('/audit-trail', [AuditTrailController::class, 'index'])->name('audit');



    //route for payroll
    Route::group(['prefix' => 'payroll'], function () {
        Route::any('payroll',[PayrollController::class,'payroll'])->name('payroll');
        Route::any('payslip', [PayrollController::class, 'payslip'])->name('payslip');
        Route::any('incentives', [PayrollController::class,'incentives'])->name('incentives');
        Route::any('/partial-payment', [PayrollController::class, 'partialPayment'])->name('partialPayment');

    });

});

require __DIR__.'/auth.php';




