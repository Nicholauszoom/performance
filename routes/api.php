<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LeaveController;
use App\Http\Controllers\API\GeneralController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::controller(AuthController::class)->group(function(){

Route::post('login', 'login');

});



Route::middleware('auth:sanctum')->group( function () {


      // For user details
      Route::get('/user',[AuthController::class,'user']);
      Route::post('/logout',[AuthController::class,'logout']);
      //  For Leaves
      Route::get('/leaves',[LeaveController::class,'index']);
     //  For Pensions 
      Route::get('/my-pension',[GeneralController::class,'pension']);
      // For Overtime
      Route::get('/my-overtime',[GeneralController::class,'myOvetimes']);
      // For Leaves
      Route::get('/my-leaves',[GeneralController::class,'myLeaves']);
      //For Loans
      Route::get('/my-loans',[GeneralController::class,'myLoans']);
      // For Salary slips 
      Route::get('/my-slips',[GeneralController::class,'mySlips']);
      // For Salary slips details
      Route::get('/my-slips/{date}',[GeneralController::class,'SlipDetail']);


      // For Saving Overtimes
      Route::post('/apply-overtime',[GeneralController::class,'apply_overtime']);
      // For Saving Leaves
      Route::post('/apply-leave',[LeaveController::class,'store']);


});


