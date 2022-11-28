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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route::group(['middleware' => 'auth', 'prefix' => '/'], function () {
//     Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
//     Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
//     Route::get('{any}', [RoutingController::class, 'root'])->name('any');
// });


Route::resource('permissions', PermissionController::class)->middleware('auth');
Route::resource('roles', RoleController::class)->middleware('auth');
Route::resource('system', SystemController::class)->middleware('auth');
Route::resource('users', UsersController::class)->middleware('auth'); 
Route::resource('departments', DepartmentController::class)->middleware('auth');
Route::resource('designations', DesignationController::class)->middleware('auth');
Route::get('user_disable/{id}', 'AccessControll\UsersController@save_disable')->name('user.disable')->middleware('auth');
