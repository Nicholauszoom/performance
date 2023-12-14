<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LeaveController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\GeneralController;
use App\Http\Controllers\API\PasswordController;
use App\Http\Controllers\API\PushNotificationController;
use App\Http\Controllers\AttendanceController;



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

Route::get('/getNotification',[PushNotificationController::class,'index']);


Route::get('/test', function (Request $request) {
    return $request->header('apikey');
});
Route::middleware('auth:sanctum')->group( function () {
 Route::post('/logout',[AuthController::class,'logout']);
      Route::post('/updateToken',[PushNotificationController::class,'updateDeviceToken']);
      Route::post('/send-bulk-notification',[PushNotificationController::class,'bulksend']);

      // For user details
      Route::get('/user',[AuthController::class,'user']);

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

       //for approving Leaves
       Route::post('/approveLeave',[LeaveController::class,'approveLeave']);
       
       Route::post('/approveRevoke',[LeaveController::class,'revokeApprovedLeaveAdmin']);
      
       Route::post('/denyRevoke',[LeaveController::class,'revokeCancelLeaveAdmin']);
       
       Route::post('/revokeLeave',[LeaveController::class,'revokeApprovedLeave']);

       // For Saving Overtimes
      Route::post('/apply-overtime',[GeneralController::class,'applyOvertime']);
      // For Saving Leaves
      Route::post('/apply-leave',[LeaveController::class,'store']);

      // For Updating profile image
      Route::post('/update-image',[GeneralController::class,'updateImg']);
      
      Route::post('/updateUserInfo',[GeneralController::class,'updateUserInfo']);

            
      Route::post('/updateEmergencyInfo',[GeneralController::class,'employeeEmergency']);
      //for geting payslip
      Route::prefix('flex')->controller(ReportController::class)->group(function (){
      Route::any('/reports/payslip','payslip')->name('flex.employee_payslip');
      });
      Route::prefix('flex')->controller(ReportController::class)->group(function (){
            Route::any('/reports/heslb','heslb')->name('flex.emmployee_loanreport');
            });


      //test Apply Leave
      Route::post('/save-leave',[LeaveController::class,'saveLeave']);

      Route::get('/returnLeave',[LeaveController::class,'myLeaves']);

      Route::prefix('flex')->controller(ReportController::class)->group(function (){
            Route::any('/reports/employee_pension','employee_pension')->name('flex.e');
            });
      Route::patch('update-password-employee', [PasswordController::class, 'updatePassword'])->name('password.profile');


       //for approving overtimes
       Route::post('/approveOvertime',[GeneralController::class,'approveOvertime']);
       Route::post('/lineApproveOvertime',[GeneralController::class,'lineApproveOvertime']);
       Route::get('/getDashboardData',[GeneralController::class,'dashboardData']);
       Route::get('/myOvertimeApprovals',[GeneralController::class,'myOvertimeApprovals']);
       Route::post('/denyOvertime',[GeneralController::class,'denyOvertime']);

       Route::post('/rejectLeave',[LeaveController::class,'cancelLeave']);

       //move attachment to public/storage
       Route::post('/moveAttachment',[GeneralController::class,'leaveAttachment']);

       //Cancel Overtime
       Route::post('/cancelOvertime',[GeneralController::class,'cancelOvertime']);


       //User Leave cancellation

       Route::post('/cancelLeave',[LeaveController::class,'cancelUserLeave']);



       // Push Notification routes

       //get annual Leave Summary
       Route::get('/getAnnualLeaveSummary/{year}',[LeaveController::class,'annualLeaveSummary']);





      });


