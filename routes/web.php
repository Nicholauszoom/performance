<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessControll\RoleController;
use App\Http\Controllers\Recruitment\RegisterController;
use App\Http\Controllers\Recruitment\LoginController;
use App\Http\Controllers\AccessControll\PermissionController;
use App\Http\Controllers\AccessControll\SystemController;
use App\Http\Controllers\AccessControll\UsersController;
use App\Http\Controllers\AccessControll\DesignationController;
use App\Http\Controllers\AccessControll\DepartmentController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\Recruitment\JobController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Payroll\PayrollController;
use App\Http\Controllers\GeneralController;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\setting\BranchController;
use App\Http\Controllers\setting\PositionController;
use App\Http\Controllers\WorkforceManagement\EmployeeController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

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
        'skill' => SkillsController::class,
        'trainingApp'=>TrainingAppController::class,
    ]);

    Route::get('user_disable/{id}', [UsersController::class, 'save_disable'])->name('user.disable');

    /**
     * Workforce Manegment
     */

     Route::prefix('performance')->controller(EmployeeController::class)->group(function (){
        Route::get('/active-mebers',  'activeMembers')->name('employee.active');
        Route::get('/profile',  'employeeProfile')->name('employee.profile');
        Route::get('/employee-exit',  'employeeExit')->name('employee.exit');
        Route::get('/workforce-management/employee-create',  'createEmployee')->name('employee.create');
        Route::post('/workforce-management/employee/store',  'storeEmployee')->name('employee.store');
        Route::get('/suspended-employee',  'inactiveEmployee')->name('employee.suspended');
        Route::post('/getPositionSalaryRange', 'getPositionSalaryRange')->name('getPositionSalaryRange');
        Route::get('/workforce-management/overtime', 'overtime')->name('overtime');

        // Imprest
        Route::get('/workforce-management/imprest', 'imprest')->name('imprest.index');

        // Approve Employee
        Route::get('/workforce-management/employee-Approve/changes', 'approveEmpoyee')->name('approve.changes');
        Route::get('/workforce-management/employee-/register', 'approveRegister')->name('approve.register');
     });


    Route::get('/audit-trail', [AuditTrailController::class, 'index'])->name('audit');

 //route for learning and development
 Route::get('/skill', [SkillsController::class, 'skill'])->name('skill');
 Route::get('/skillsList', [SkillsController::class, 'skillsList'])->name('skillsList');
 Route::post('/addSkills', [SkillsController::class, 'skills'])->name('skills');
 Route::get('/trainingApp', [TrainingAppController::class, 'trainingApp'])->name('trainingApp');
 Route::post('/insertData', [TrainingAppController::class, 'insert'])->name('insert');
 //end learning and development
    Route::get('/performance/bankBranchFetcher', [BranchController::class, 'fetchBranch'])->name('bankBranchFetcher');
    Route::get('/performance/positionFetcher', [PositionController::class, 'positionFetcher'])->name('positionFetcher');

    // Employee overtime







    //route for payroll
    Route::group(['prefix' => 'payroll'], function () {
        Route::any('/partial-payment', [PayrollController::class, 'partialPayment'])->name('partialPayment');
    });
});
//Routes for Recruitment Module

Route::group(['prefix' => 'recruitment'], function () {
    Route::get('/login', [RegisterController::class, 'index'])->name('recruitment.login');
    Route::get('/register', [RegisterController::class, 'register'])->name('register.index');
    Route::post('/store', [RegisterController::class, 'storeUser'])->name('register.store');
    Route::post('/jobseeker-login', [LoginController::class, 'loginProcess'])->name('jobseeker.login');
});
Route::get('/jobsearch-Dashboard', [JobController::class, 'index'])->name('dashboard.index')->middleware('auth');
// Password Resetting Routes...

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/password-reset', [NewPasswordController::class, 'store'])->middleware('guest')->name('password.new');
require __DIR__ . '/auth.php';
