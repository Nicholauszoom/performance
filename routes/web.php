<?php

use App\Http\Controllers\AccelerationController;
use App\Http\Controllers\AccessControll\DepartmentController;
use App\Http\Controllers\AccessControll\DesignationController;
// use App\Http\Controllers\RoleController;
use App\Http\Controllers\AccessControll\PermissionController;
use App\Http\Controllers\AccessControll\RoleController;
use App\Http\Controllers\AccessControll\SystemController;
use App\Http\Controllers\AccessControll\UsersController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\BOTDataController;
use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\EmployeePerformanceController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Import\BankLoanController;
use App\Http\Controllers\Import\ImportEmployeeController;
use App\Http\Controllers\Import\PensionPayslipController;
use App\Http\Controllers\ImprestController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LearningDevelopment\SkillsController;
use App\Http\Controllers\Payroll\PayrollController;
use App\Http\Controllers\Payroll\ReportController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PerformanceReportsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Middleware\Loan;
use App\Http\Middleware\Organisation;
use App\Http\Middleware\Payroll;
use App\Http\Middleware\Report;
use App\Http\Middleware\Setting;
use App\Http\Middleware\WorkForce;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('auth.login');
// });

// Dashboard

Route::middleware('verify-outgoing-requests')->group(function () {

    Route::middleware(['auth', 'password.expired', 'auth.session'])->group(function () {

        /**
         * New view routes
         */

        Route::get('/faq', [HomeController::class, 'faq']);
        Route::get('/knowledge', [HomeController::class, 'knowledge']);

        // ###########################

        Route::get('/dashboard', [GeneralController::class, 'home'])->name('dashboard.index');
        //Route::get('file-import','Admin\JournalImportController@importView')->name('import-view');

        Route::any('import', [ImportEmployeeController::class, 'import'])->middleware([WorkForce::class])->name('import.employee');
        Route::any('download', [ImportEmployeeController::class, 'download'])->middleware([WorkForce::class])->name('export.employee');

        //->middleware('auth')->middleware([Dashboard::class]);

        // project
        Route::get('/project', [ProjectController::class, 'index'])->middleware([WorkForce::class])->name('project.index');

        Route::get('/profile', [ProfileController::class, 'edit'])->middleware([WorkForce::class])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->middleware([WorkForce::class])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware([WorkForce::class])->name('profile.destroy');

        Route::middleware('auth')->middleware([Setting::class])->group(function () {
            // Route For Resources
            Route::resources([
                'permissions' => PermissionController::class,
                'roles' => RoleController::class,
                'system' => SystemController::class,
                'users' => UsersController::class,
                'departments' => DepartmentController::class,
                'designations' => DesignationController::class,

                // 'skill' => SkillsController::class,
                // 'trainingApp'=>TrainingAppController::class,
            ]);
        });
        Route::prefix('bot')->middleware([Setting::class])->controller(BOTDataController::class)->group(function () {

            Route::any('/index', 'index')->name('bot.botIndex');
            Route::any('/postEmployeeData', 'postEmployeeData')->name('bot.postEmployeeData');
        });

        // Routes with workforce access permission
        Route::prefix('flex')->middleware([WorkForce::class])->controller(GeneralController::class)->group(function () {
            //charts routes

            Route::any('/chart-line-ajax', 'employeeChart')->name('flex.chart-line-ajax');

            // start of overtime routes

            Route::any('/passwordAutogenerate', 'passwordAutogenerate')->name('flex.passwordAutogenerate');

            Route::any('/statutory_deductions', 'statutory_deductions')->name('flex.statutory_deductions');
            Route::any('/overtime_info', 'overtime_info')->name('flex.overtime_info');
            Route::any('/overtime_category_info/{id}', 'overtime_category_info')->name('flex.overtime_category_info');
            Route::any('/confirmOvertime/{id}', 'confirmOvertime')->name('flex.confirmOvertime');
            Route::any('/recommendOvertime/{id}', 'recommendOvertime')->name('flex.recommendOvertime');
            Route::any('/arrears_info', 'arrears_info')->name('flex.arrears_info');
            Route::any('/individual_arrears_info', 'individual_arrears_info')->name('flex.individual_arrears_info');

            // start of termination routes
            Route::any('/termination', 'termination')->name('flex.termination');
            Route::any('/get_employee_available_info', 'get_employee_available_info')->name('flex.get_employee_available_info');
            Route::any('/add-termination', 'addTermination')->name('flex.addTermination');
            Route::post('/save-termination', 'saveTermination')->name('flex.saveTermination');
            Route::get('/view-termination/{id}', 'viewTermination')->name('flex.viewTermination');

            // start of approvals route
            Route::get('/approve-termination/{id}', 'approveTermination')->name('flex.approveTermination');
            Route::get('/cancel-termination/{id}', 'cancelTermination')->name('flex.cancelTermination');
            Route::get('/cancel-termination1/{id}', 'cancelTermination1')->name('flex.cancelTermination1');
            // end of termination routes

            //start of grievances and disciplinary actions routes
            Route::any('/grievancesCompain', 'grievancesComplains')->name('flex.grievancesCompain');
            Route::any('/add-complain', 'addComplain')->name('flex.addComplain');
            // end of complains

            //start of disciplinary actions routes
            Route::any('/grievancesCompain', 'grievancesComplains')->name('flex.grievancesCompain');
            Route::any('/add-action', 'addDisciplinary')->name('flex.addDisciplinary');
            Route::post('/addBulkDisciplinary', 'addBulkDisciplinary')->name('flex.addBulkDisciplinary');
            Route::any('/save-action', 'saveDisciplinary')->name('flex.saveDisciplinary');
            Route::any('/view-action/{id}', 'viewDisciplinary')->name('flex.viewDisciplinary');
            Route::any('/edit-action/{id}', 'editDisciplinary')->name('flex.editDisciplinary');
            Route::any('/update-action/{id}', 'updateDisciplinary')->name('flex.updateDisciplinary');
            Route::any('/delete-disciplinary/{id}', 'deleteAction')->name('flex.deleteDisciplinary');
            // end of disciplinary actions routes

            // start of grievances routes

            Route::any('/grievences', 'grievances')->name('flex.grievances');

            Route::any('/resolve_grievance/{id}', 'resolve_grievance')->name('flex.resolve_grievance');
            Route::any('/unresolve_grievance/{id}', 'unresolve_grievance')->name('flex.unresolve_grievance');

            // end of grievances routes

            // start of promotion/increment routes
            Route::any('promotion', 'promotion')->name('flex.promotion');
            Route::any('/add-promotion', 'addPromotion')->name('flex.addPromotion');
            Route::any('/add-bulk-increment', 'addBulkIncrement')->name('flex.addBulkIncrement');
            Route::post('/save-promotion', 'savePromotion')->name('flex.savePromotion');
            Route::get('/view-promotion/{id}', 'viewPromotion')->name('flex.viewPromotion');
            Route::any('/add-increment', 'addIncrement')->name('flex.addIncrement');
            Route::post('/save-increment', 'saveIncrement')->name('flex.saveIncrement');
            Route::get('/view-increment/{id}', 'viewIncrement')->name('flex.viewIncrement');
            Route::any('/depPositionFetcher', 'depPositionFetcher')->name('depPositionFetcher');
            Route::get('get/details/{id}', 'getDetails')->name('getDetails');

            // start of approvals route
            Route::get('/approve-promotion/{id}', 'approvePromotion')->name('flex.approvePromotion');
            Route::get('/cancel-promotion/{id}', 'cancelPromotion')->name('flex.cancelPromotion');
            // end of promotion/increment routes

            // start of employee personal details route
            //Route::any('/employee-profile/{id}','viewProfile')->name('flex.viewProfile');
            // Route::post('/save-details','updateEmployeeDetails')->name('flex.saveDetails');
            // Route::any('/delete-child/{id}','deleteChild')->name('flex.deleteChild');
            // Route::any('/delete-parent/{id}','deleteParent')->name('flex.deleteParent');
            // Route::any('/delete-qualification/{id}','deleteQualification')->name('flex.deleteQualification');
            // Route::any('/delete-certification/{id}','deleteCertification')->name('flex.deleteCertification');
            // Route::any('/delete-history/{id}','deleteHistory')->name('flex.deleteHistory');
            Route::any('/activateEmployee/{logID}/{empID}', 'activateEmployee')->name('flex.activateEmployee');
            Route::any('/deactivateEmployee', 'deactivateEmployee')->name('flex.deactivateEmployee');
            Route::any('/inactive_employee', 'inactive_employee')->name('flex.inactive_employee');

            // end of employee personal details  route

            // start of overtime routes

            Route::any('/applyOvertimeOnbehalf', 'applyOvertimeOnbehalf')->name('flex.applyOvertimeOnbehalf');

            // end of overtime routes

            // Start of performance routes
            Route::any('projects', 'projects')->name('flex.projects');
            Route::any('add-project', 'add_project')->name('flex.add-project');
            Route::any('save-project', 'save_project')->name('flex.save-project');
            Route::any('view-project/{id}', 'view_project')->name('flex.view-project');
            Route::any('edit-project/{id}', 'edit_project')->name('flex.edit-project');
            Route::any('update-project', 'update_project')->name('flex.update-project');
            Route::any('add-task/{id}', 'add_task')->name('flex.add-task');
            Route::any('save-task', 'save_project_task')->name('flex.save-task');
            Route::any('edit-project-task/{id}', 'edit_project_task')->name('flex.edit-project-task');
            Route::any('delete-project/{id}', 'delete_project')->name('flex.delete-project');
            Route::any('delete-project-task/{id}', 'delete_project_task')->name('flex.delete-project-task');
            Route::any('completed_task/{id}', 'completed_task')->name('flex.completed_task');
            Route::any('completed-project/{id}', 'completed_project')->name('flex.complete_project');

            // For Perfomance report
            Route::any('performance-report', 'performance')->name('flex.performance-report');

            Route::any('performanceDetails/{id}', 'performanceDetails')->name('flex.performanceDetails');

            // For Perfomance ratios
            Route::any('performance', 'performance_ratio')->name('flex.performance');
            Route::any('save_performance_ratio', 'save_performance_ratio')->name('flex.save_performance_ratio');

            // Task Assessment Routes
            Route::any('assess-task/{id}', 'assess_task')->name('flex.assess-task');
            Route::any('save-task-assessment', 'save_task_assessment')->name('flex.save_task_assessment');

            //Adhoc Tasks routes
            Route::any('tasks', 'tasks')->name('flex.tasks');
            Route::any('add-adhoctask', 'add_adhoctask')->name('flex.add-adhock_task');
            Route::any('save-adhoc-task', 'save_adhoc_task')->name('flex.save-adhoc-task');
            Route::any('delete-task/{id}', 'delete_task')->name('flex.delete-task');
            Route::any('completed_adhoctask/{id}', 'completed_adhoctask')->name('flex.completed_adhoctask');
            Route::any('delete-task/{id}', 'delete_task')->name('flex.delete-task');

            // Adhoc Task Assessment Routes
            Route::any('assess-adhoctask/{id}', 'assess_adhoctask')->name('flex.assess-adhoctask');
            Route::any('save-adhoctask-assessment', 'save_adhoctask_assessment')->name('flex.save_adhoctask_assessment');

            // Performance Ratios routes
            Route::any('performance-ratios', 'performance_ratios')->name('flex.performance-ratios');
            Route::any('save-target-ratio', 'save_target_ratio')->name('flex.save_target_ratio');
            Route::any('save-time-ratio', 'save_time_ratio')->name('flex.save_time_ratio');
            Route::any('save-behaviour-ratio', 'save_behaviour_ratio')->name('flex.save_behaviour_ratio');
            Route::any('delete-target-ratio/{id}', 'delete_target_ratio')->name('flex.delete-target-ratio');
            Route::any('delete-time-ratio/{id}', 'delete_time_ratio')->name('flex.delete-time-ratio');
            Route::any('delete-behaviour-ratio/{id}', 'delete_behaviour_ratio')->name('flex.delete-behaviour-ratio');
            // End of performance routes

            // Start of Talent Management
            Route::any('employee_profiles', 'employee_profiles')->name('flex.employee-profiles');
            Route::any('talent-ratios', 'talent_ratios')->name('flex.talent-ratios');
            Route::any('talent-ranges', 'talent_ranges')->name('flex.talent-range');

            Route::any('talent-matrix', 'talent_matrix')->name('flex.talent-matrix');

            // start of employees routes
            Route::any('/confirmOvertimePayment', 'confirmOvertimePayment')->name('flex.confirmOvertimePayment');
            Route::any('/unconfirmOvertimePayment', 'unconfirmOvertimePayment')->name('flex.unconfirmOvertimePayment');
            Route::any('/fetchOvertimeComment/{id}', 'fetchOvertimeComment')->name('flex.fetchOvertimeComment');
            Route::any('/commentOvertime', 'commentOvertime')->name('flex.commentOvertime');
            Route::any('/deleteposition', 'deleteposition')->name('flex.deleteposition');
            Route::any('/editdepartment', 'editdepartment')->name('flex.editdepartment');
            Route::any('/employee', 'employee')->name('flex.employee');

            Route::any('/deletekin/{empID}/{id}', 'deletekin')->name('flex.deletekin');
            Route::any('/addproperty', 'addproperty')->name('flex.addproperty');
            Route::any('/employee_exit/{id}', 'employee_exit')->name('flex.employee_exit');
            Route::any('/deleteproperty/$id', 'deleteproperty')->name('flex.deleteproperty');
            Route::any('/employeeDeactivationRequest', 'employeeDeactivationRequest')->name('flex.employeeDeactivationRequest');
            Route::any('/employeeActivationRequest/{id}', 'employeeActivationRequest')->name('flex.employeeActivationRequest');
            Route::any('/cancelRequest/{id}/{empID}', 'cancelRequest')->name('flex.cancelRequest');

            // end of employees routes

            // For Employee Transfers
            Route::any('/transfers', 'transfers')->name('flex.transfers');
        });
        // end of routes with workforce access permission

        // Routes with Payroll access permission
        Route::prefix('flex')->middleware([Payroll::class])->controller(GeneralController::class)->group(function () {

            Route::get('error', [HomeController::class, 'home']);

            Route::any('/payroll', 'payroll')->name('flex.payroll');

            Route::any('/approved_financial_payments', 'approved_financial_payments')->name('flex.approved_financial_payments');
        });
        Route::prefix('flex/payroll')->middleware('auth')->middleware([Payroll::class])->controller(PayrollController::class)->group(function () {
            Route::any('/initPayroll', 'initPayroll')->name('payroll.initPayroll');
            Route::any('/financial_reports', 'financial_reports')->name('payroll.financial_reports');
            Route::any('/employee_payslip', 'employee_payslip')->name('payroll.employee_payslip');
            Route::any('/payroll', 'payroll')->name('payroll.payroll');
            Route::any('/temp_payroll_info', 'temp_payroll_info')->name('payroll.temp_payroll_info');
            Route::any('/payroll_info', 'payroll_info')->name('payroll.payroll_info');
            Route::any('/temp_less_payments', 'temp_less_payments')->name('payroll.temp_less_payments');
            Route::any('/ADVtemp_less_payments', 'ADVtemp_less_payments')->name('payroll.ADVtemp_less_payments');
            Route::any('/less_payments', 'less_payments')->name('payroll.less_payments');
            Route::any('/less_payments_print', 'less_payments_print')->name('payroll.less_payments_print');
            Route::any('/concatArrays', 'concatArrays')->name('payroll.concatArrays');
            Route::any('/grossReconciliation', 'grossReconciliation')->name('payroll.grossReconciliation');
            Route::any('/netReconciliation', 'netReconciliation')->name('payroll.netReconciliation');
            Route::any('/sendReviewEmail', 'sendReviewEmail')->name('payroll.sendReviewEmail');
            Route::any('/sendMail', 'sendMail')->name('payroll.sendMail');
            Route::any('/comission_bonus', 'comission_bonus')->name('payroll.comission_bonus');
            Route::any('/partial_payment', 'partial_payment')->name('payroll.partial_payment');
            Route::any('/getComment/{date}', 'getComment')->name('payroll.getComment');
            Route::any('/salary_calculator', 'salary_calculator')->name('payroll.salary_calculator');
            Route::any('/calculateSalary', 'calculateSalary')->name('payroll.calculateSalary');
            Route::any('/recommendpayrollByHr/{pdate}/{message}', 'recommendpayrollByHr')->name('payroll.recommendpayrollByHr');
            Route::any('/recommendpayrollByFinance/{pdate}/{message}', 'recommendpayrollByFinance')->name('payroll.recommendpayrollByFinance');
            Route::any('/runpayroll/{pdate}', 'runpayroll')->name('payroll.runpayroll');

            Route::any('/approvepayroll/{pdate}', 'approvePayroll')->name('payroll.approvepayroll');

            Route::any('/partial_payment_manipulation', 'partial_payment_manipulation')->name('payroll.partial_payment_manipulation');
            Route::any('/generate_checklist', 'generate_checklist')->name('payroll.generate_checklist');
            Route::any('/arrearsPayment', 'arrearsPayment')->name('payroll.arrearsPayment');
            Route::any('/temp_submitLessPayments', 'temp_submitLessPayments')->name('payroll.temp_submitLessPayments');
            Route::any('/submitLessPayments', 'submitLessPayments')->name('payroll.submitLessPayments');
            Route::any('/arrearsPayment_schedule', 'arrearsPayment_schedule')->name('payroll.arrearsPayment_schedule');
            Route::any('/monthlyArrearsPayment_schedule', 'monthlyArrearsPayment_schedule')->name('payroll.monthlyArrearsPayment_schedule');
            Route::any('/cancelArrearsPayment', 'cancelArrearsPayment')->name('payroll.cancelArrearsPayment');
            Route::any('/confirmArrearsPayment', 'confirmArrearsPayment')->name('payroll.confirmArrearsPayment');
            Route::any('/recommendArrearsPayment', 'recommendArrearsPayment')->name('payroll.recommendArrearsPayment');
            Route::any('/cancelpayroll/{type}', 'cancelpayroll')->name('payroll.cancelpayroll');
            Route::any('/temp_payroll_review', 'temp_payroll_review')->name('payroll.temp_payroll_review');
            Route::any('/payroll_review', 'payroll_review')->name('payroll.payroll_review');
            Route::any('/send_payslips', 'send_payslips')->name('payroll.send_payslips');
            Route::any('/payslip_attachments', 'payslip_attachments')->name('payroll.payslip_attachments');
            Route::any('/mailConfiguration', 'mailConfiguration')->name('payroll.mailConfiguration');
            Route::any('/saveMail', 'saveMail')->name('payroll.saveMail');
            Route::any('/employeeFilter', 'employeeFilter')->name('payroll.employeeFilter');
            Route::any('/password_generator', 'password_generator')->name('payroll.password_generator');
            Route::any('/TestMail', 'TestMail')->name('payroll.TestMail');

            // for pay slip template
            Route::any('/salary_slip', 'getSlip')->name('payroll.salary_slip');
        });
        // End of routes with payroll access permission

        // start of attendance access permission routes

        // Routes 1
        Route::prefix('attendance')->middleware([WorkForce::class])->controller(AttendanceController::class)->group(function () {

            Route::any('/revoke_authority', 'revoke_authority')->name('attendance.revoke_authority');
            Route::any('/attendance', 'attendance')->name('attendance.attendance');
            Route::any('/attendees', 'attendees')->name('attendance.attendees');
            Route::any('/leave', 'leave')->name('attendance.leave');

            Route::any('/apply_leave', 'apply_leave')->name('attendance.apply_leave');

            Route::any('/recommendLeave', 'recommendLeave')->name('attendance.recommendLeave');
            Route::any('/holdLeave/{id}', 'holdLeave')->name('attendance.holdLeave');

            Route::any('/rejectLeave', 'rejectLeave')->name('attendance.rejectLeave');
            Route::any('/leavereport', 'leavereport')->name('attendance.leavereport');
            Route::any('/customleavereport', 'customleavereport')->name('attendance.customleavereport');
            Route::any('/leave_remarks', 'leave_remarks')->name('attendance.leave_remarks');
            Route::any('/leave_application_info', 'leave_application_info')->name('attendance.leave_application_info');
            Route::any('/updateLeaveReason', 'updateLeaveReason')->name('attendance.updateLeaveReason');
            Route::any('/updateLeaveAddress', 'updateLeaveAddress')->name('attendance.updateLeaveAddress');
            Route::any('/updateLeaveMobile', 'updateLeaveMobile')->name('attendance.updateLeaveMobile');
            Route::any('/updateLeaveType', 'updateLeaveType')->name('attendance.updateLeaveType');
            Route::any('/updateLeaveDateRange', 'updateLeaveDateRange')->name('attendance.updateLeaveDateRange');
            Route::any('/current_leave_progress', 'current_leave_progress')->name('attendance.current_leave_progress');
        });

        //start routes for  all users(wote)
        Route::prefix('flex/attendance')->controller(AttendanceController::class)->group(function () {
            Route::any('/my-leaves', 'myLeaves')->name('flex.my-leaves'); //atendance controller
            Route::post('/save_leave', 'saveLeave')->name('attendance.saveLeave'); //atendance controller
            Route::any('/cancelLeave/{id}', 'cancelLeave')->name('attendance.cancelLeave');
            Route::any('/revokeLeave/{id}', 'revokeLeave')->name('attendance.revokeLeave');
            Route::any('/cancelRevokeLeave/{id}', 'cancelRevokeLeave')->name('attendance.cancelRevokeLeave');
            Route::post('/revokeApprovedLeave', 'revokeApprovedLeave')->name('attendance.revokeApprovedLeave');
            Route::any('/revokeApprovedLeaveAdmin/{id}', 'revokeApprovedLeaveAdmin')->name('attendance.revokeApprovedLeaveAdmin');
            Route::any('/approveTotalRevoke/{id}', 'approveTotalRevoke')->name('attendance.approveTotalRevoke');
            Route::post('/totalRevokeInitiate', 'totalRevokeInitiate')->name('attendance.totalRevokeInitiate');
            Route::put('/revokeCancelLeaveAdmin/{id}', 'revokeCancelLeaveAdmin')->name('attendance.revokeCancelLeaveAdmin');
            //for manager
            Route::any('/leave', 'leave')->name('attendance.leave');
            Route::any('/annualleavebalance/{year}', 'annuaLeaveSummary')->name('attendance.annualleavebalance');
            Route::any('/clear-leaves', 'clear_leaves')->name('attendance.clear-leaves');

            Route::post('/saveLeaveOnBehalf', 'saveLeaveOnBehalf2')->name('attendance.saveLeaveOnBehalf'); //atendance controller

            Route::any('/approveLeave/{id}', 'approveLeave')->name('attendance.approveLeave');
        });

        Route::prefix('flex/')->controller(GeneralController::class)->group(function () {
            // start of selfservices routes leave_escalation
            Route::any('/leave_escalation', 'leave_escalation')->name('flex.leave_escalation');
            Route::any('/my-overtimes', 'myOvertimes')->name('flex.my-overtimes');
            Route::any('/my-loans', 'myLoans')->name('flex.my-loans');
            Route::any('/my-pensions', 'myPensions')->name('flex.my-pensions');
            Route::any('/my-biodata', 'my_biodata')->name('flex.my-biodata');
            Route::any('/applyOvertime', 'applyOvertime')->name('flex.applyOvertime');
            Route::get('error', [HomeController::class, 'home']);
            Route::any('/cancelOvertime/{id}', 'cancelOvertime')->name('flex.cancelOvertime');
            Route::any('/download_payslip', 'download_payslip')->name('flex.download_payslip');
            Route::any('/userdata/{id}', 'userdata')->name('flex.userdata');
            Route::any('user-image', 'updateImg')->name('flex.userimage');

            Route::any('/userprofile/{id}', 'userprofile')->name('flex.userprofile');

            Route::any('/addkin/{id}', 'addkin')->name('flex.addkin');

            //userprofile
            Route::any('/employee-profile/{id}', 'viewProfile')->name('flex.viewProfile');

            Route::post('/save-details', 'updateEmployeeDetails')->name('flex.saveDetails');
            Route::post('/save-details-employment', 'updateSpecificEmployeeDetails')->name('flex.saveDetailsEmployment');
            Route::post('/save-details-basic', 'employeeBasicDetails')->name('flex.saveBasicDetails');
            Route::post('/save-details-address', 'employeeAddressDetails')->name('flex.saveAddressDetails');
            Route::post('/save-details-person', 'employeePersonDetails')->name('flex.savePersonDetails');
            Route::post('/save-details-bio', 'employeeBioDetails')->name('flex.saveBioDetails');
            Route::post('/save-details-qualification', 'educationQualification')->name('flex.saveEducationDetails');
            Route::post('/save-details-professional', 'professionalCertificate')->name('flex.saveProfessionalCertifications');
            Route::post('/save-details-history', 'employeeHistory')->name('flex.saveEmployeeHistory');
            Route::post('/save-details-spouse', 'employeeSpouse')->name('flex.saveEmployeeSpouse');
            Route::post('/save-details-dependant', 'employeeDependant')->name('flex.saveEmployeeDependant');
            Route::post('/save-details-parents', 'employeeParent')->name('flex.saveEmployeeParent');
            Route::post('/save-details-emergence', 'employeeEmergency')->name('flex.saveEmployeeEmergency');
            Route::any('/delete-child/{id}', 'deleteChild')->name('flex.deleteChild');
            Route::any('/delete-parent/{id}', 'deleteParent')->name('flex.deleteParent');
            Route::any('/delete-qualification/{id}', 'deleteQualification')->name('flex.deleteQualification');
            Route::any('/delete-certification/{id}', 'deleteCertification')->name('flex.deleteCertification');
            Route::any('/delete-history/{id}', 'deleteHistory')->name('flex.deleteHistory');
            // end of self services

            //overtime approves
            Route::any('/lineapproveOvertime/{id}', 'lineapproveOvertime')->name('flex.lineapproveOvertime');
            Route::any('/hrapproveOvertime/{id}', 'hrapproveOvertime')->name('flex.hrapproveOvertime');
            Route::any('/fin_approveOvertime/{id}', 'fin_approveOvertime')->name('flex.fin_approveOvertime');
            Route::any('/denyOvertime/{id}', 'denyOvertime')->name('flex.denyOvertime');

            Route::any('/cancelApprovedOvertimes/{id}', 'cancelApprovedOvertimes')->name('flex.cancelApprovedOvertimes');

            //managers routes
            Route::any('/overtime', 'overtime')->name('flex.overtime');

            // start of grievances routes
            Route::any('/my-grievences', 'my_grievances')->name('flex.my-grievances');
            Route::any('/save-grievances', 'save_grievance')->name('flex.save-grievances');
            Route::any('/add-complain', 'addComplain')->name('flex.addComplain');

            //Route::any('/edit-complain/{id}','edit_complain')->name('flex.edit-complain');
            Route::any('/update-grievance', 'update_grievance')->name('flex.update-grievances');
            Route::any('/cancel-grievance/{id}', 'cancel_grievance')->name('flex.cancel-grievance');
            Route::any('/grievance_details/{id}', 'grievance_details')->name('flex.grievance_details');
        });

        Route::prefix('flex/reports')->middleware('auth')->controller(ReportController::class)->group(function () {
            Route::any('/employee_pension', 'employee_pension')->name('reports.employee_pension');
            Route::any('/payslip', 'payslip')->name('reports.payslip');
        });
        //end routes for all users



        // Routes 2
        Route::prefix('flex/attendance')->controller(AttendanceController::class)->group(function () {

            Route::any('/attendance', 'attendance')->name('attendance.attendance');
            Route::any('/attendees', 'attendees')->name('attendance.attendees');
            Route::any('/leaveforfeiting', 'leaveforfeiting')->name('attendance.leaveforfeiting');

            // for my leaves routes

            Route::any('/test', 'countWorkingDays')->name('flex.test');

            // for fetching sub leave type
            Route::get('get/details/{id}', 'getDetails')->name('getSubs');
            Route::get('get/detailsSub/{id}', 'getDetailsSub')->name('getLeaveSubs');
            Route::any('/check_leave_balance', 'check_leave_balance')->name('attendance.check_leave_balance');
            Route::any('/validate_sick_leave/{date}', 'validateSickLeaveDate')->name('attendance.validateSickLeave');

            Route::any('/recommendLeave/{id}', 'recommendLeave')->name('attendance.recommendLeave');
            Route::any('/recommendLeaveByHod/{id}', 'recommendLeaveByHod')->name('attendance.recommendLeaveByHod');

            Route::any('/holdLeave/{id}', 'holdLeave')->name('attendance.holdLeave');

            Route::any('/rejectLeave', 'rejectLeave')->name('attendance.rejectLeave');
            Route::any('/leavereport', 'leavereport')->name('attendance.leavereport');
            Route::any('/customleavereport', 'customleavereport')->name('attendance.customleavereport');
            Route::any('/leave_remarks/{id}', 'leave_remarks')->name('attendance.leave_remarks');
            Route::any('/leave_application_info/{id}/{empID}', 'leave_application_info')->name('attendance.leave_application_info');
            Route::any('/updateLeaveReason', 'updateLeaveReason')->name('attendance.updateLeaveReason');
            Route::any('/updateLeaveAddress', 'updateLeaveAddress')->name('attendance.updateLeaveAddress');
            Route::any('/updateLeaveMobile', 'updateLeaveMobile')->name('attendance.updateLeaveMobile');
            Route::any('/updateLeaveType', 'updateLeaveType')->name('attendance.updateLeaveType');
            Route::any('/updateLeaveDateRange', 'updateLeaveDateRange')->name('attendance.updateLeaveDateRange');
            Route::any('/current_leave_progress', 'current_leave_progress')->name('attendance.current_leave_progress');
        });
        // end of attendance routes

        // start of  loans access permission routes
        Route::prefix('flex/')->middleware('auth')->middleware([Loan::class])->controller(GeneralController::class)->group(function () {

            Route::any('/companyInfo', 'companyInfo')->name('flex.companyInfo');
            Route::any('/updatecompanyInfo', 'updatecompanyInfo')->name('flex.updatecompanyInfo');
            Route::any('/submitInputs', 'submitInputs')->name('flex.submitInputs');
            Route::any('/submitInputsPage', 'SubmitInputPage')->name('flex.submitInputsPage');

            Route::any('/salary_advance', 'salary_advance')->name('flex.salary_advance');
            Route::any('/loan_types', 'loan_types')->name('flex.loan_types');
            Route::any('/current_loan_progress', 'current_loan_progress')->name('flex.current_loan_progress');
            Route::any('/apply_salary_advance', 'apply_salary_advance')->name('flex.apply_salary_advance');
            Route::any('/insert_directLoan', 'insert_directLoan')->name('flex.insert_directLoan');
            Route::any('/confirmed_loans', 'confirmed_loans')->name('flex.confirmed_loans');
            Route::any('/loan_advanced_payments', 'loan_advanced_payments')->name('flex.loan_advanced_payments');
            Route::any('/adv_loan_pay', 'adv_loan_pay')->name('flex.adv_loan_pay');
            Route::any('/cancelLoan', 'cancelLoan')->name('flex.cancelLoan');
            Route::any('/recommendLoan/{id}', 'recommendLoan')->name('flex.recommendLoan');
            Route::any('/hrrecommendLoan/{id}', 'hrrecommendLoan')->name('flex.hrrecommendLoan');
            Route::any('/holdLoan/{id}', 'holdLoan')->name('flex.holdLoan');
            Route::any('/approveLoan/{id}', 'approveLoan')->name('flex.approveLoan');
            Route::any('/pauseLoan/{id}', 'pauseLoan')->name('flex.pauseLoan');
            Route::any('/resumeLoan/{id}', 'resumeLoan')->name('flex.resumeLoan');
            Route::any('/rejectLoan/{id}', 'rejectLoan')->name('flex.rejectLoan');
            Route::any('/loan_application_info/{id}', 'loan_application_info')->name('flex.loan_application_info');
            Route::any('/updateloan/{id}', 'updateloan')->name('flex.updateloan');
            Route::any('/updateloan_info', 'updateloan_info')->name('flex.updateloan_info');
        });

        Route::prefix('flex/pension_receipt')->middleware('auth')->middleware([Loan::class])->controller(PensionPayslipController::class)->group(function () {
            Route::get('/index', 'index')->name('pension_receipt.index');
            Route::get('/receipt_export', 'export')->name('pension_receipt.export');
            Route::post('/receipt_import', 'import')->name('pension_receipt.import');
            Route::get('/receipt_template', 'template')->name('pension_receipt.template');
        });

        //bank loans routes
        Route::prefix('flex/bank-loans')->middleware('auth')->middleware([Loan::class])->controller(BankLoanController::class)->group(function () {
            Route::get('/all-loans', 'index')->name('bank-loans');
            Route::get('/delete-loan/{id}', 'delete_loan')->name('flex.delete-loans');;
            Route::get('/loans-export', 'export')->name('loans.export');
            Route::post('/loans-import', 'import')->name('loans.import');
            Route::get('/loans-template', 'template')->name('loans.template');
        });
        // end of  loans access permission routes

        //start of organization access permission  routes
        Route::prefix('flex/')->middleware('auth')->middleware([Organisation::class])->controller(GeneralController::class)->group(function () {

            Route::any('/department', 'department')->name('flex.department');
            Route::any('/organization_level', 'organization_level')->name('flex.organization_level');
            Route::any('/organization_level_info/{id}', 'organization_level_info')->name('flex.organization_level_info');
            Route::any('/alldepartment', 'alldepartment')->name('flex.alldepartment');
            Route::any('/updateOrganizationLevelName', 'updateOrganizationLevelName')->name('flex.updateOrganizationLevelName');
            Route::any('/updateMinSalary', 'updateMinSalary')->name('flex.updateMinSalary');
            Route::any('/updateMaxSalary', 'updateMaxSalary')->name('flex.updateMaxSalary');
            Route::any('/departmentAdd', 'departmentAdd')->name('flex.departmentAdd');
            Route::any('/branch', 'branch')->name('flex.branch');
            Route::any('/costCenter', 'costCenter')->name('flex.costCenter');
            Route::any('/nationality', 'nationality')->name('flex.nationality');
            Route::any('/addEmployeeNationality', 'addEmployeeNationality')->name('flex.addEmployeeNationality');
            Route::any('/deleteCountry', 'deleteCountry')->name('flex.deleteCountry');
            Route::any('/addCompanyBranch', 'addCompanyBranch')->name('flex.addCompanyBranch');
            Route::any('/addCostCenter', 'addCostCenter')->name('flex.addCostCenter');
            Route::any('/updateCompanyBranch', 'updateCompanyBranch')->name('flex.updateCompanyBranch');
            Route::any('/updateCostCenter', 'updateCostCenter')->name('flex.updateCostCenter');
            Route::any('/addBank', 'addBank')->name('flex.addBank');
            Route::any('/addBankBranch', 'addBankBranch')->name('flex.addBankBranch');
            Route::any('/updateBank', 'updateBank')->name('flex.updateBank');
            Route::any('/updateBankBranchName', 'updateBankBranchName')->name('flex.updateBankBranchName');
            Route::any('/updateBankName', 'updateBankName')->name('flex.updateBankName');
            Route::any('/updateAbbrev', 'updateAbbrev')->name('flex.updateAbbrev');
            Route::any('/updateBankCode', 'updateBankCode')->name('flex.updateBankCode');
            Route::any('/updateBranchName', 'updateBranchName')->name('flex.updateBranchName');
            Route::any('/updateBranchCode', 'updateBranchCode')->name('flex.updateBranchCode');
            Route::any('/updateBranchSwiftcode', 'updateBranchSwiftcode')->name('flex.updateBranchSwiftcode');
            Route::any('/updateBranchStreet', 'updateBranchStreet')->name('flex.updateBranchStreet');
            Route::any('/updateBranchRegion', 'updateBranchRegion')->name('flex.updateBranchRegion');
            Route::any('/updateBranchCountry', 'updateBranchCountry')->name('flex.updateBranchCountry');
            Route::any('/deleteDepartment/{id}', 'deleteDepartment')->name('flex.deleteDepartment');
            Route::any('/deleteOrganizationLevel/{id}', 'deleteOrganizationLevel')->name('flex.deleteOrganizationLevel');
            Route::any('/activateDepartment/{id}', 'activateDepartment')->name('flex.activateDepartment');
            Route::any('/position_info/{id}', 'position_info')->name('flex.position_info');
            Route::any('/department_info/{id}', 'department_info')->name('flex.department_info');

            Route::any('/updatePositionName', 'updatePositionName')->name('flex.updatePositionName');
            Route::any('/updatePositionReportsTo', 'updatePositionReportsTo')->name('flex.updatePositionReportsTo');
            Route::any('/updatePositionCode', 'updatePositionCode')->name('flex.updatePositionCode');
            Route::any('/updatePositionOrganizationLevel', 'updatePositionOrganizationLevel')->name('flex.updatePositionOrganizationLevel');
            Route::any('/position', 'position')->name('flex.position');
            Route::any('/addPosition', 'addPosition')->name('flex.addPosition');
            Route::any('/addOrganizationLevel', 'addOrganizationLevel')->name('flex.addOrganizationLevel');
            Route::any('/deletePosition', 'deletePosition')->name('flex.deletePosition');
            Route::any('/activatePosition', 'activatePosition')->name('flex.activatePosition');

            Route::any('/contract_expire', 'contract_expire')->name('flex.contract_expire');
            Route::any('/retire', 'retire')->name('flex.retire');
            Route::any('/contract', 'contract')->name('flex.contract');
            Route::any('/addContract', 'addContract')->name('flex.addContract');
            Route::any('/updatecontract', 'updatecontract')->name('flex.updatecontract');
            Route::any('/deletecontract', 'deletecontract')->name('flex.deletecontract');

            Route::any('/organization_structure', 'organization_structure')->name('flex.organization_structure');
            Route::any('/accounting_coding', 'accounting_coding')->name('flex.accounting_coding');
            Route::any('/department_structure', 'department_structure')->name('flex.department_structure');
            Route::any('/Oldorganization_structure', 'Oldorganization_structure')->name('flex.Oldorganization_structure');
            Route::any('/grievances', 'grievances')->name('flex.grievances');
            Route::any('/brand_settings','brand_settings')->name('flex.brand_settings');

        });
        //end of organization access permission  routes

        //Start of Acceleration routes
        Route::prefix('flex/')->middleware('auth')->middleware([Report::class])->controller(AccelerationController::class)->group(function () {
            Route::any('acceleration', 'index')->name('flex.acceleration');
            Route::any('add-acceleration', 'create')->name('flex.add-acceleration');
            Route::any('save-acceleration', 'store')->name('flex.save-acceleration');
            Route::any('view-acceleration/{id}', 'show')->name('flex.view-acceleration');
            Route::any('edit-acceleration/{id}', 'edit')->name('flex.edit-acceleration');
            Route::any('update-acceleration', 'update')->name('flex.update-acceleration');
            Route::any('add-acceleration-task/{id}', 'add_acceleration_task')->name('flex.add-acceleration-task');
            Route::any('save-acceleration-task', 'save_acceleration_task')->name('flex.save-acceleration-task');
            Route::any('edit-project-task/{id}', 'edit_project_task')->name('flex.edit-project-task');
            Route::any('delete-acceleration/{id}', 'delete_project')->name('flex.delete-project');
            Route::any('delete-acceleration-task/{id}', 'delete_acceleration_task')->name('flex.delete-acceleration-task');
            Route::any('completed-acceleration-task/{id}', 'completed_acceleration_task')->name('flex.complete_acceleration_task');
            Route::any('assess-acceleration-task/{id}', 'assess_task')->name('flex.assess-acceleration-task');
            Route::any('save-acceleration-assessment', 'save_assessment')->name('flex.save_acceleration_assessment');
            Route::any('acceleration-report', 'performance')->name('flex.acceleration-report');
            Route::any('accelerationDetails/{id}', 'accelerationDetails')->name('flex.accelerationDetails');
            Route::any('completed-acceleration/{id}', 'completed_acceleration')->name('flex.complete_acceleration');
        });

        // For Performance Reports Routes
        Route::prefix('flex/')->middleware('auth')->middleware([Setting::class])->controller(PerformanceReportsController::class)->group(function () {
            Route::any('performance-reports', 'index')->name('flex.performance-reports');
            Route::any('organization-reports', 'organization_report')->name('flex.organization-reports');
            Route::any('project-report', 'project_report')->name('flex.project-report');
            Route::any('department-report', 'department_report')->name('flex.department-report');
            Route::any('acceleration-reports', 'acceleration_report')->name('flex.acceleration-reports');
        });

        // start of report access permissions routes
        Route::prefix('flex/')->controller(GeneralController::class)->group(function () {
            Route::any('/financial_reports', 'financial_reports')->name('flex.financial_reports');
            Route::any('/organisation_reports', 'organisation_reports')->name('flex.organisation_reports');
        });
        // end of report access permissions routes

        // For New Employees
        Route::prefix('flex/')->middleware([WorkForce::class])->controller(EmployeePerformanceController::class)->group(function () {
            Route::any('/all-employees', 'index')->name('flex.employee-list');
            Route::any('/modal', 'modal')->name('flex.modal');
            Route::any('/addScore', 'addScore')->name('flex.addScore');

            Route::any('/submit_performance', 'submit_performance')->name('flex.submit_performance');
            Route::any('/show_employee_performance/{id}', 'show_employee_performance')->name('flex.show_employee_performance');

            Route::any('/deleteEvaluation/{id}', 'deleteEvaluation')->name('flex.deleteEvaluation');

            Route::any('/employee-performance', 'employee_performance')->name('flex.employee-performance');
            Route::any('/performance-pillars', 'performance_pillars')->name('flex.performance-pillars');
            Route::any('/save-evaluation/{id}', 'save_evaluation')->name('flex.save-evaluation');
            Route::any('/add-evaluation/{id}', 'add_evaluation')->name('flex.add-evaluation');
            Route::any('/show_evaluation/{id}', 'show_evaluation')->name('flex.show_evaluation');

            Route::any('/delete-pillar/{id}', 'delete_pillar')->name('flex.delete-pillar');
            Route::any('/edit-pillar/{id}', 'edit_pillar')->name('flex.edit-pillar');
            Route::any('/add-pillar', 'add_pillar')->name('flex.add-pillar');
            Route::any('/save-pillar', 'save_pillar')->name('flex.save-pillar');
            Route::any('/update-pillar', 'update_pillar')->name('flex.update-pillar');
        });
        // End of new employees

        // start of settings access permissions routes
        Route::prefix('flex/')->controller(GeneralController::class)->middleware('auth')->middleware([WorkForce::class])->group(function () {

            // For Financial Groups Settings
            Route::any('/financial_group', 'financial_group')->name('flex.financial_group');
            Route::any('/financial_groups_details/{id}', 'financial_groups_details')->name('flex.financial_groups_details');
            Route::any('/financial_groups_byRole_details/{id}', 'financial_groups_byRole_details')->name('flex.financial_groups_byRole_details');

            // Permission Settings

            // start of unpaid leaves
            Route::any('/unpaid_leave', 'unpaid_leave')->name('flex.unpaid_leave');
            Route::any('/add_unpaid_leave', 'add_unpaid_leave')->name('flex.add_unpaid_leave');
            Route::any('/save_unpaid_leave', 'save_unpaid_leave')->name('flex.save_unpaid_leave');
            Route::any('/end_unpaid_leave/{id}', 'end_unpaid_leave')->name('flex.end_unpaid_leave');
            Route::any('/confirm_unpaid_leave/{id}', 'confirm_unpaid_leave')->name('flex.confirm_unpaid_leave');
            //end of unpaid leaves

            // start of holidays routes
            Route::any('/holidays', 'holidays')->name('flex.holidays');
            Route::any('/add-holiday', 'addHoliday')->name('flex.saveHoliday');
            Route::put('/update-holiday', 'updateHoliday')->name('flex.updateHoliday');
            Route::put('/update-leave-forfeitings', 'updateLeaveForfeitings')->name('flex.updateLeaveForfeitings');
            Route::any('/edit-holiday/{id}', 'editHoliday')->name('flex.editholiday');
            Route::any('/delete-holiday/{id}', 'deleteHoliday')->name('flex.deleteholiday');
            Route::any('/update-all-holidays', 'updateHolidayYear')->name('flex.updateHolidayYear');
            Route::any('/update-all-opening-balance', 'updateOpeningBalance')->name('flex.updateOpeningBalance');
            Route::post('/add-holiday-from-file', 'addHolidayFromExcel')->name('flex.addHolidayFromExcel');
            // end of holidays routes

            // start of email notifications settings routes
            Route::any('/email-notifications', 'emailNotification')->name('flex.email-notifications');
            Route::any('/edit-email-notification/{id}', 'editNotification')->name('flex.editNotification');
            Route::put('/update-email-notification', 'updateNotification')->name('flex.updateNotification');
            // end of email notifications settings routes

            // start of approval settings routes
            Route::any('/approvals', 'viewApprovals')->name('flex.approvals');

            Route::post('/save-approvals', 'saveApprovals')->name('flex.saveApprovals');
            Route::post('/save-loan-type', 'saveLoanType')->name('flex.saveLoanType');
            Route::any('/edit-approval/{id}', 'editApproval')->name('flex.editApproval');
            Route::put('/update-approval', 'updateApproval')->name('flex.updateApproval');
            Route::any('/delete-approval/{id}', 'deleteApproval')->name('flex.deleteApproval');
            // end of approval settings routes

            // start of approval_levels settings routes
            Route::any('/approval_levels/{id}', 'viewApprovalLevels')->name('flex.approval-levels');
            Route::post('/save-approval-level', 'saveApprovalLevel')->name('flex.saveApprovalLevel');
            Route::any('/edit-approval-level/{id}', 'editApprovalLevel')->name('flex.editApprovalLevel');
            Route::put('/update-approvalLevel', 'updateApprovalLevel')->name('flex.updateApprovalLevel');
            Route::any('/delete-approval-level/{id}', 'deleteApprovalLevel')->name('flex.deleteApprovalLevel');
            // end of approval_levels settings routes

            // Start of leave approvals
            Route::any('/leave-approvals', 'LeaveApprovals')->name('flex.leave-approval');
            Route::any('/upload-leave-approvals', 'UploadLeaveApprovals')->name('flex.upload-leave-approvals');
            Route::post('/save-leave-approval', 'saveLeaveApproval')->name('flex.save-leave-approval');
            Route::any('/edit-leave-approval/{id}', 'editLeaveApproval')->name('flex.editLeaveApproval');
            Route::any('/edit-leave-forfeitings/{id}', 'editLeaveForfeitings')->name('flex.editLeaveForfeitings');
            Route::put('/update-leave-approval', 'updateLeaveApproval')->name('flex.update-leave-approval');
            Route::any('/delete-leave-approval/{id}', 'deleteLeaveApproval')->name('flex.delete-leave-approval');

            //  End of leave approvals

            //For Audit Logs
            Route::any('/audit_logs', 'audit_logs')->name('flex.audit_logs');
            Route::any('/export_audit_logs', 'export_audit_logs')->name('flex.export_audit_logs');
            Route::any('/audit_logs/destroy', 'auditLogsDestry')->name('flex.LogsDestroy');
        });
        // end of settings access permissions routes

        // Start of other routes
        Route::get('user_disable/{id}', [UsersController::class, 'save_disable'])->middleware([WorkForce::class])->name('user.disable');

        Route::get('/audit-trail', [AuditTrailController::class, 'index'])->middleware([WorkForce::class])->name('audit');

        //route for learning and development
        Route::get('/skill', [SkillsController::class, 'skill'])->middleware([WorkForce::class])->name('skill');
        Route::get('/skillsList', [SkillsController::class, 'skillsList'])->middleware([WorkForce::class])->name('skillsList');
        Route::post('/addSkills', [SkillsController::class, 'skills'])->middleware([WorkForce::class])->name('skills');
        // Route::get('/trainingApp', [TrainingAppController::class, 'trainingApp'])->name('trainingApp');
        // Route::post('/insertData', [TrainingAppController::class, 'insert'])->name('insert');

        Route::get('flex/department_cost', [GeneralController::class, 'departmentCost'])->middleware([WorkForce::class])->name('flex.departmentCost');
        Route::any('flex/store_department_cost', [GeneralController::class, 'storeDepartmentCost'])->middleware([WorkForce::class])->name('flex.storedepartmentcost');

        Route::prefix('')->middleware([WorkForce::class])->controller(BaseController::class)->group(function () {

            Route::any('/index', 'index')->name('index');
            Route::any('/employee_info/{id}', 'employee_info')->name('flex.employee_info');
            // for biodata page
            // Route::any('/employee_data/{id}' ,'employee_data')->name('flex.employee_data');

            //Route::any('/' ,'index')->name('index');
            Route::any('/netTotalSummation', 'netTotalSummation')->name('netTotalSummation');
            Route::any('/register', 'register')->name('register');
            Route::any('/register_submit', 'register_submit')->name('register_submit');
            Route::any('/getPermissions', 'getPermissions')->name('getPermissions');
        });

        Route::prefix('flex')->controller(GeneralController::class)->middleware('auth')->middleware([WorkForce::class])->group(function () {

            Route::any('/index', 'index')->name('flex.index');
            Route::any('/import', 'import')->name('flex.import');
            Route::any('/password_check/{$str}', 'password_check')->name('flex.password_check');
            Route::any('/login_info', 'login_info')->name('flex.login_info');
            Route::any('/checkPassword/{$password}', 'checkPassword')->name('flex.checkPassword');
            Route::any('/update_login_info', 'update_login_info')->name('flex.update_login_info');
            // Route::any('/logout','logout')->name('flex.logout');

            // for employee biodata

            // for employee profile picture

            Route::any('/overtime_on_behalf', 'overtime_on_behalf')->name('flex.overtime_on_behalf');

            // Download biodata
            Route::any('/biodata', 'viewBiodata')->name('flex.biodata');
            // update profile image

            Route::any('/bank', 'bank')->name('flex.bank');

            Route::any('/addBudget', 'addBudget')->name('flex.addBudget');
            Route::any('/updateBudgetDescription', 'updateBudgetDescription')->name('flex.updateBudgetDescription');
            Route::any('/updateBudgetAmount', 'updateBudgetAmount')->name('flex.updateBudgetAmount');
            Route::any('/updateBudgetDateRange', 'updateBudgetDateRange')->name('flex.updateBudgetDateRange');
            Route::any('/approveBudget', 'approveBudget')->name('flex.approveBudget');
            Route::any('/disapproveBudget', 'disapproveBudget')->name('flex.disapproveBudget');
            Route::any('/deleteBudget', 'deleteBudget')->name('flex.deleteBudget');
            Route::any('/training_application', 'training_application')->name('flex.training_application');
            Route::any('/budget_info', 'budget_info')->name('flex.budget_info');
            Route::any('/requestTraining', 'requestTraining')->name('flex.requestTraining');
            Route::any('/requestTraining2', 'requestTraining2')->name('flex.requestTraining2');
            Route::any('/recommendTrainingRequest', 'recommendTrainingRequest')->name('flex.recommendTrainingRequest');
            Route::any('/suspendTrainingRequest', 'suspendTrainingRequest')->name('flex.suspendTrainingRequest');
            Route::any('/approveTrainingRequest', 'approveTrainingRequest')->name('flex.approveTrainingRequest');
            Route::any('/disapproveTrainingRequest', 'disapproveTrainingRequest')->name('flex.disapproveTrainingRequest');
            Route::any('/confirmTrainingRequest', 'confirmTrainingRequest')->name('flex.confirmTrainingRequest');
            Route::any('/unconfirmTrainingRequest', 'unconfirmTrainingRequest')->name('flex.unconfirmTrainingRequest');
            Route::any('/deleteTrainingRequest', 'deleteTrainingRequest')->name('flex.deleteTrainingRequest');
            Route::any('/response_training_linemanager', 'response_training_linemanager')->name('flex.response_training_linemanager');
            Route::any('/confirm_graduation', 'confirm_graduation')->name('flex.confirm_graduation');
            Route::any('/employeeCertification', 'employeeCertification')->name('flex.employeeCertification');
            Route::any('/confirmGraduation', 'confirmGraduation')->name('flex.confirmGraduation');
            Route::any('/confirmEmployeeCertification', 'confirmEmployeeCertification')->name('flex.confirmEmployeeCertification');
            Route::any('/addAccountability', 'addAccountability')->name('flex.addAccountability');
            Route::any('/addskills', 'addskills')->name('flex.addskills');

            Route::any('/updateskills', 'updateskills')->name('flex.updateskills');

            // start of reconcilliation summary route
            Route::any('/reconciliation-summary', 'reconcilliationSummary')->name('reports.recoSummary');
            // end of reconcilliation summary route

            // start of education qualification route
            Route::any('/addQualification', 'addQualification')->name('flex.addQualification');
            // end of education qualification route

            Route::any('/updateEmployee/{id}', 'updateEmployee')->name('flex.updateEmployee');
            Route::any('/updateFirstName', 'updateFirstName')->name('flex.updateFirstName');
            Route::any('/updateCode', 'updateCode')->name('flex.updateCode');
            Route::any('/updateLevel', 'updateLevel')->name('flex.updateLevel');
            Route::any('/updateMiddleName', 'updateMiddleName')->name('flex.updateMiddleName');
            Route::any('/updateLastName', 'updateLastName')->name('flex.updateLastName');
            Route::any('/updateGender', 'updateGender')->name('flex.updateGender');
            Route::any('/updateDob', 'updateDob')->name('flex.updateDob');
            Route::any('/updateExpatriate', 'updateExpatriate')->name('flex.updateExpatriate');
            Route::any('/updateEmployeePensionFund', 'updateEmployeePensionFund')->name('flex.updateEmployeePensionFund');
            Route::any('/updateEmployeePosition', 'updateEmployeePosition')->name('flex.updateEmployeePosition');
            Route::any('/updateEmployeeBranch', 'updateEmployeeBranch')->name('flex.updateEmployeeBranch');
            Route::any('/updateEmployeeBranch', 'updateEmployeeBranch')->name('flex.updateEmployeeBranch');
            Route::any('/updateEmployeeNationality', 'updateEmployeeNationality')->name('flex.updateEmployeeNationality');
            Route::any('/updateDeptPos', 'updateDeptPos')->name('flex.updateDeptPos');
            Route::any('/approveDeptPosTransfer', 'approveDeptPosTransfer')->name('flex.approveDeptPosTransfer');
            Route::any('/approveSalaryTransfer', 'approveSalaryTransfer')->name('flex.approveSalaryTransfer');
            Route::any('/approvePositionTransfer', 'approvePositionTransfer')->name('flex.approvePositionTransfer');
            Route::any('/cancelTransfer', 'cancelTransfer')->name('flex.cancelTransfer');
            Route::any('/updateSalary', 'updateSalary')->name('flex.updateSalary');
            Route::any('/updateEmail', 'updateEmail')->name('flex.updateEmail');
            Route::any('/updatePostAddress', 'updatePostAddress')->name('flex.updatePostAddress');
            Route::any('/updatePostCity', 'updatePostCity')->name('flex.updatePostCity');
            Route::any('/updatePhysicalAddress', 'updatePhysicalAddress')->name('flex.updatePhysicalAddress');
            Route::any('/updateMobile', 'updateMobile')->name('flex.updateMobile');
            Route::any('/updateHomeAddress', 'updateHomeAddress')->name('flex.updateHomeAddress');
            Route::any('/updateNationalID', 'updateNationalID')->name('flex.updateNationalID');
            Route::any('/updateTin', 'updateTin')->name('flex.updateTin');
            Route::any('/updateBankAccountNo', 'updateBankAccountNo')->name('flex.updateBankAccountNo');
            Route::any('/updateBank_Bankbranch', 'updateBank_Bankbranch')->name('flex.updateBank_Bankbranch');
            Route::any('/updateLineManager', 'updateLineManager')->name('flex.updateLineManager');
            Route::any('/updateEmployeeContract', 'updateEmployeeContract')->name('flex.updateEmployeeContract');
            Route::any('/updateMeritalStatus', 'updateMeritalStatus')->name('flex.updateMeritalStatus');
            Route::any('/updateCostCenterEmployee', 'updateCostCenterEmployee')->name('flex.updateCostCenterEmployee');
            Route::any('/updatePensionFundNo', 'updatePensionFundNo')->name('flex.updatePensionFundNo');
            Route::any('/updateOldID', 'updateOldID')->name('flex.updateOldID');
            Route::any('/updateEmployeePhoto', 'updateEmployeePhoto')->name('flex.updateEmployeePhoto');

            Route::any('/not_logged_in', 'not_logged_in')->name('flex.not_logged_in');
            Route::any('/viewrecords', 'viewrecords')->name('flex.viewrecords');
            Route::any('/home', 'home')->name('flex.home');
            Route::any('/positionFetcher', 'positionFetcher')->name('flex.positionFetcher');
            Route::any('/bankBranchFetcher', 'bankBranchFetcher')->name('flex.bankBranchFetcher');

            Route::any('/delete_deduction', 'delete_deduction')->name('flex.delete_deduction');
            Route::any('/delete_non_statutory_deduction/{id}', 'delete_non_statutory_deduction')->name('flex.delete_non_statutory_deduction');

            Route::any('/deduction_info/{pattern}', 'deduction_info')->name('flex.deduction_info');
            Route::any('/assign_deduction_individual', 'assign_deduction_individual')->name('flex.assign_deduction_individual');
            Route::any('/assign_deduction_group', 'assign_deduction_group')->name('flex.assign_deduction_group');
            Route::any('/remove_individual_deduction', 'remove_individual_deduction')->name('flex.remove_individual_deduction');
            Route::any('/remove_group_deduction', 'remove_group_deduction')->name('flex.remove_group_deduction');
            Route::any('/addpaye', 'addpaye')->name('flex.addpaye');
            Route::any('/deletepaye', 'deletepaye')->name('flex.deletepaye');
            Route::any('/paye_info/{id}', 'paye_info')->name('flex.paye_info');
            Route::any('/updatepaye', 'updatepaye')->name('flex.updatepaye');
            Route::any('/updateOvertimeAllowance', 'updateOvertimeAllowance')->name('flex.updateOvertimeAllowance');
            Route::any('/updateCommonDeductions', 'updateCommonDeductions')->name('flex.updateCommonDeductions');
            Route::any('/common_deductions_info/{id}', 'common_deductions_info')->name('flex.common_deductions_info');
            Route::any('/updatePensionName', 'updatePensionName')->name('flex.updatePensionName');
            Route::any('/updatePercentEmployee', 'updatePercentEmployee')->name('flex.updatePercentEmployee');
            Route::any('/updatePercentEmployer', 'updatePercentEmployer')->name('flex.updatePercentEmployer');
            Route::any('/updatePensionPolicy', 'updatePensionPolicy')->name('flex.updatePensionPolicy');
            Route::any('/updateDeductionName', 'updateDeductionName')->name('flex.updateDeductionName');
            Route::any('/updateDeductionAmount', 'updateDeductionAmount')->name('flex.updateDeductionAmount');
            Route::any('/updateDeductionPercent', 'updateDeductionPercent')->name('flex.updateDeductionPercent');
            Route::any('/updateDeductionPolicy', 'updateDeductionPolicy')->name('flex.updateDeductionPolicy');
            Route::any('/updateMealsName', 'updateMealsName')->name('flex.updateMealsName');
            Route::any('/updateMealsMargin', 'updateMealsMargin')->name('flex.updateMealsMargin');
            Route::any('/updateMealsLowerAmount', 'updateMealsLowerAmount')->name('flex.updateMealsLowerAmount');
            Route::any('/updateMealsUpperAmount', 'updateMealsUpperAmount')->name('flex.updateMealsUpperAmount');
            Route::any('/allowance', 'allowance')->name('flex.allowance');
            Route::any('/allowance_info/{id}', 'allowance_info')->name('flex.allowance_info');
            Route::any('/allowance_category_info/{id}', 'allowance_category_info')->name('flex.allowance_category_info');
            Route::any('/allowance_overtime', 'allowance_overtime')->name('flex.allowance_overtime');
            Route::any('/statutory_deductions', 'statutory_deductions')->name('flex.statutory_deductions');
            Route::any('/allowance_category', 'allowance_category')->name('flex.allowance_category');
            Route::any('/non_statutory_deductions', 'non_statutory_deductions')->name('flex.non_statutory_deductions');
            Route::any('/addAllowance', 'addAllowance')->name('flex.addAllowance');
            Route::any('/addAllowanceCategory', 'addAllowanceCategory')->name('flex.addAllowanceCategory');
            Route::any('/addOvertimeCategory', 'addOvertimeCategory')->name('flex.addOvertimeCategory');
            Route::any('/overtimeCategoryDelete/{id}', 'overtimeCategoryDelete')->name('flex.overtimeCategoryDelete');
            Route::any('/addDeduction', 'addDeduction')->name('flex.addDeduction');
            Route::any('/assign_allowance_individual', 'assign_allowance_individual')->name('flex.assign_allowance_individual');
            Route::any('/assign_allowance_employees', 'assign_allowance_employees')->name('flex.assign_allowance_employees');
            Route::any('/assign_allowance_group', 'assign_allowance_group')->name('flex.assign_allowance_group');
            Route::any('/remove_individual_from_allowance', 'remove_individual_from_allowance')->name('flex.remove_individual_from_allowance');
            Route::any('/remove_group_from_allowance', 'remove_group_from_allowance')->name('flex.remove_group_from_allowance');

            Route::any('/deleteAllowance/{id}', 'deleteAllowance')->name('flex.deleteAllowance');
            Route::any('/deleteAllowanceCategory/{id}', 'deleteAllowanceCategory')->name('flex.deleteAllowanceCategory');
            Route::any('/activateAllowance/{id}', 'activateAllowance')->name('flex.activateAllowance');
            Route::any('/updateAllowanceName', 'updateAllowanceName')->name('flex.updateAllowanceName');
            Route::any('/updateAllowanceTaxable', 'updateAllowanceTaxable')->name('flex.updateAllowanceTaxable');
            Route::any('/updateAllowancepensionable', 'updateAllowancepensionable')->name('flex.updateAllowancepensionable');

            Route::any('/updateRecursive', 'updateRecursive')->name('flex.updateRecursive');
            Route::any('/updateBik', 'updateBik')->name('flex.updateBik');
            Route::any('/updatecategory', 'updatecategory')->name('flex.updatecategory');

            Route::any('/company_branch_info', 'company_branch_info')->name('flex.company_branch_info');

            Route::any('/updateOvertimeName', 'updateOvertimeName')->name('flex.updateOvertimeName');
            Route::any('/updateAllowanceCategory', 'updateAllowanceCategory')->name('flex.updateAllowanceCategory');
            Route::any('/updateOvertimeRateDay', 'updateOvertimeRateDay')->name('flex.updateOvertimeRateDay');
            Route::any('/updateOvertimeRateNight', 'updateOvertimeRateNight')->name('flex.updateOvertimeRateNight');
            Route::any('/updateAllowanceAmount', 'updateAllowanceAmount')->name('flex.updateAllowanceAmount');
            Route::any('/updateAllowancePercent', 'updateAllowancePercent')->name('flex.updateAllowancePercent');
            Route::any('/updateAllowanceApplyTo', 'updateAllowanceApplyTo')->name('flex.updateAllowanceApplyTo');
            Route::any('/updateAllowancePolicy', 'updateAllowancePolicy')->name('flex.updateAllowancePolicy');
            Route::any('/addToBonus', 'addToBonus')->name('flex.addToBonus');
            Route::any('/addBonusTag', 'addBonusTag')->name('flex.addBonusTag');
            Route::any('/cancelBonus', 'cancelBonus')->name('flex.cancelBonus');
            Route::any('/confirmBonus/{id}', 'confirmBonus')->name('flex.confirmBonus');
            Route::any('/recommendBonus/{id}', 'recommendBonus')->name('flex.recommendBonus');
            Route::any('/deleteBonus/{id}', 'deleteBonus')->name('flex.deleteBonus');
            Route::any('/role', 'role')->name('flex.role');

            Route::any('/payroll_report_Logs', 'payrollReportLogs')->name('flex.payrollLogs');

            Route::any('/groups', 'groups')->name('flex.groups');
            Route::any('/removeEmployeeFromGroup', 'removeEmployeeFromGroup')->name('flex.removeEmployeeFromGroup');
            Route::any('/removeEmployeeByRoleFromGroup', 'removeEmployeeByRoleFromGroup')->name('flex.removeEmployeeByRoleFromGroup');

            Route::any('/removeEmployeeFromRole', 'removeEmployeeFromRole')->name('flex.removeEmployeeFromRole');
            Route::any('/addEmployeeToGroup', 'addEmployeeToGroup')->name('flex.addEmployeeToGroup');
            Route::any('/addEmployeeToGroupByRoles', 'addEmployeeToGroupByRoles')->name('flex.addEmployeeToGroupByRoles');

            Route::any('/updategroup', 'updategroup')->name('flex.updategroup');
            Route::any('/deleteRole/{id}', 'deleteRole')->name('flex.deleteRole');
            Route::any('/deleteGroup', 'deleteGroup')->name('flex.deleteGroup');
            Route::any('/permission', 'permission')->name('flex.permission');
            Route::any('/assignrole2', 'assignrole2')->name('flex.assignrole2');
            Route::any('/role_info', 'role_info')->name('flex.role_info');
            Route::any('/code_generator/$size', 'code_generator')->name('flex.code_generator');
            Route::any('/updaterole', 'updaterole')->name('flex.updaterole');
            Route::any('/assignrole', 'assignrole')->name('flex.assignrole');
            Route::any('/revokerole', 'revokerole')->name('flex.revokerole');
            Route::any('/appreciation', 'appreciation')->name('flex.appreciation');
            Route::any('/add_apprec', 'add_apprec')->name('flex.add_apprec');

            Route::any('/contract_expiration', 'contract_expiration')->name('flex.contract_expiration');
            Route::any('/updateCompanyName', 'updateCompanyName')->name('flex.updateCompanyName');
            Route::any('/addEmployee', 'addEmployee')->name('flex.addEmployee');
            Route::any('/getPositionSalaryRange', 'getPositionSalaryRange')->name('flex.getPositionSalaryRange');
            Route::any('/registerEmployee', 'registerEmployee')->name('flex.registerEmployee');

            Route::any('/userArray', 'userArray')->name('flex.userArray');
            Route::any('/userAgent', 'userAgent')->name('flex.userAgent');
            Route::any('/sendMailuser', 'sendMailuser')->name('flex.sendMailuser');
            Route::any('/patterntest', 'patterntest')->name('flex.patterntest');
            Route::any('/sendMailuserFinal', 'sendMailuserFinal')->name('flex.sendMailuserFinal');
            Route::any('/send_email', 'send_email')->name('flex.send_email');
            Route::any('/retired', 'retired')->name('flex.retired');
            Route::any('/loginuser', 'loginuser')->name('flex.loginuser');
            Route::any('/employeeReport', 'employeeReport')->name('flex.employeeReport');
            Route::any('/partial', 'partial')->name('flex.partial');
            Route::any('/deletePayment', 'deletePayment')->name('flex.deletePayment');
            Route::any('/updateGroupEdit', 'updateGroupEdit')->name('flex.updateGroupEdit');
            Route::any('/netTotalSummation/$payroll_date', 'netTotalSummation')->name('flex.netTotalSummation');
            Route::any('/updateContractStart', 'updateContractStart')->name('flex.updateContractStart');
            Route::any('/updateContractEnd', 'updateContractEnd')->name('flex.updateContractEnd');
            Route::any('/approveRegistration/{id}', 'approveRegistration')->name('flex.approveRegistration');
            Route::any('/disapproveRegistration/{id}', 'disapproveRegistration')->name('flex.disapproveRegistration');
        });

        Route::prefix('flex/imprest')->middleware([WorkForce::class])->controller(ImprestController::class)->group(function () {

            Route::any('/confirmed_imprest', 'confirmed_imprest')->name('imprest.confirmed_imprest');
            Route::any('/imprest', 'imprest')->name('imprest.imprest');
            Route::any('/imprest_info/{id}', 'imprest_info')->name('imprest.imprest_info');
            Route::any('/add_imprest_requirement', 'add_imprest_requirement')->name('imprest.add_imprest_requirement');
            Route::any('/uploadRequirementEvidence', 'uploadRequirementEvidence')->name('imprest.uploadRequirementEvidence');
            Route::any('/deleteImprest/{id}', 'deleteImprest')->name('imprest.deleteImprest');
            Route::any('/deleteRequirement', 'deleteRequirement')->name('imprest.deleteRequirement');
            Route::any('/approveRequirement/{id}', 'approveRequirement')->name('imprest.approveRequirement');
            Route::any('/confirmRequirementRetirement', 'confirmRequirementRetirement')->name('imprest.confirmRequirementRetirement');
            Route::any('/unconfirmRequirementRetirement', 'unconfirmRequirementRetirement')->name('imprest.unconfirmRequirementRetirement');
            Route::any('/disapproveRequirement', 'disapproveRequirement')->name('imprest.disapproveRequirement');
            Route::any('/confirmRequirement', 'confirmRequirement')->name('imprest.confirmRequirement');
            Route::any('/unconfirmRequirement', 'unconfirmRequirement')->name('imprest.unconfirmRequirement');
            Route::any('/deleteEvidence', 'deleteEvidence')->name('imprest.deleteEvidence');
            Route::any('/updateImprestTitle', 'updateImprestTitle')->name('imprest.updateImprestTitle');
            Route::any('/updateImprestDescription', 'updateImprestDescription')->name('imprest.updateImprestDescription');
            Route::any('/updateImprestDateRange', 'updateImprestDateRange')->name('imprest.updateImprestDateRange');
            Route::any('/update_imprestRequirement', 'update_imprestRequirement')->name('imprest.update_imprestRequirement');
            Route::any('/confirmImprest', 'confirmImprest')->name('imprest.confirmImprest');
            Route::any('/unconfirmImprest', 'unconfirmImprest')->name('imprest.unconfirmImprest');
            Route::any('/confirmImprestRetirement', 'confirmImprestRetirement')->name('imprest.confirmImprestRetirement');
            Route::any('/resolveImprest', 'resolveImprest')->name('imprest.resolveImprest');
            Route::any('/recommendImprest', 'recommendImprest')->name('imprest.recommendImprest');
            Route::any('/hr_recommendImprest', 'hr_recommendImprest')->name('imprest.hr_recommendImprest');
            Route::any('/holdImprest', 'holdImprest')->name('imprest.holdImprest');
            Route::any('/approveImprest', 'approveImprest')->name('imprest.approveImprest');
            Route::any('/disapproveImprest', 'disapproveImprest')->name('imprest.disapproveImprest');
            Route::any('/requestImprest', 'requestImprest')->name('imprest.requestImprest');
        });

        Route::prefix('flex/performance')->middleware([WorkForce::class])->controller(PerformanceController::class)->group(function () {
            Route::any('/strategy_dashboard', 'strategy_dashboard')->name('performance.strategy_dashboard');
        });
        Route::prefix('flex/performance')->middleware([WorkForce::class])->controller(PerformanceController::class)->group(function () {

            Route::any('/output_info', 'output_info')->name('performance.output_info');
            Route::any('/assign_output', 'assign_output')->name('performance.assign_output');
            Route::any('/updateoutputDescription', 'updateoutputDescription')->name('performance.updateoutputDescription');
            Route::any('/updateOutputDateRange', 'updateOutputDateRange')->name('performance.updateOutputDateRange');
            Route::any('/updateOutputTitle', 'updateOutputTitle')->name('performance.updateOutputTitle');
            Route::any('/addOutcome', 'addOutcome')->name('performance.addOutcome');
            Route::any('/strategy', 'strategy')->name('performance.strategy');
            Route::any('/funder', 'funder')->name('performance.funder');
            Route::any('/addFunder', 'addFunder')->name('performance.addFunder');
            Route::any('/addSegment', 'addSegment')->name('performance.addSegment');
            Route::any('/addCategory', 'addCategory')->name('performance.addCategory');
            Route::any('/addException', 'addException')->name('performance.addException');
            Route::any('/addRequest', 'addRequest')->name('performance.addRequest');
            Route::any('/updateStrategyDateRange', 'updateStrategyDateRange')->name('performance.updateStrategyDateRange');
            Route::any('/updateStrategy', 'updateStrategy')->name('performance.updateStrategy');
            Route::any('/strategy_report', 'strategy_report')->name('performance.strategy_report');
            Route::any('/updateOutcomeDateRange', 'updateOutcomeDateRange')->name('performance.updateOutcomeDateRange');
            Route::any('/updateOutcome', 'updateOutcome')->name('performance.updateOutcome');
            Route::any('/updateOutcomeStrategy_ref', 'updateOutcomeStrategy_ref')->name('performance.updateOutcomeStrategy_ref');
            Route::any('/updateOutcomeAssign', 'updateOutcomeAssign')->name('performance.updateOutcomeAssign');
            Route::any('/reference_output', 'reference_output')->name('performance.reference_output');
            Route::any('/strategy_info', 'strategy_info')->name('performance.strategy_info');
            Route::any('/outcome_info', 'outcome_info')->name('performance.outcome_info');
            Route::any('/selectStrategy', 'selectStrategy')->name('performance.selectStrategy');
            Route::any('/deleteStrategy', 'deleteStrategy')->name('performance.deleteStrategy');
            Route::any('/deleteOutcome', 'deleteOutcome')->name('performance.deleteOutcome');
            Route::any('/deleteOutput', 'deleteOutput')->name('performance.deleteOutput');
            Route::any('/deleteTask', 'deleteTask')->name('performance.deleteTask');
            Route::any('/deleteResource', 'deleteResource')->name('performance.deleteResource');
            Route::any('/cancelTask', 'cancelTask')->name('performance.cancelTask');
            Route::any('/disapproveTask', 'disapproveTask')->name('performance.disapproveTask');
            Route::any('/comment', 'comment')->name('performance.comment');
            Route::any('/addActivity', 'addActivity')->name('performance.addActivity');
            Route::any('/sendCommentOLd', 'sendCommentOLd')->name('performance.sendCommentOLd');
            Route::any('/sendComment', 'sendComment')->name('performance.sendComment');
            Route::any('/assignCostValue', 'assignCostValue')->name('performance.assignCostValue');
            Route::any('/task_approval', 'task_approval')->name('performance.task_approval');
            Route::any('/addTaskResources', 'addTaskResources')->name('performance.addTaskResources');
            Route::any('/task_marking', 'task_marking')->name('performance.task_marking');
            Route::any('/tasksettings', 'tasksettings')->name('performance.tasksettings');
            Route::any('/updateTaskMarkingBasics', 'updateTaskMarkingBasics')->name('performance.updateTaskMarkingBasics');
            Route::any('/updateTaskTimeElapse', 'updateTaskTimeElapse')->name('performance.updateTaskTimeElapse');
            Route::any('/deleteBehaviourParameter', 'deleteBehaviourParameter')->name('performance.deleteBehaviourParameter');
            Route::any('/update_task_behaviour', 'update_task_behaviour')->name('performance.update_task_behaviour');
            Route::any('/update_task_ratings', 'update_task_ratings')->name('performance.update_task_ratings');
            Route::any('/update_task_behaviourSA', 'update_task_behaviourSA')->name('performance.update_task_behaviourSA');
            Route::any('/add_behaviour', 'add_behaviour')->name('performance.add_behaviour');
            Route::any('/productivity', 'productivity')->name('performance.productivity');
            Route::any('/productivity_report', 'productivity_report')->name('performance.productivity_report');
            Route::any('/selectTalent', 'selectTalent')->name('performance.selectTalent');
            Route::any('/talents', 'talents')->name('performance.talents');
            Route::any('/submitTask', 'submitTask')->name('performance.submitTask');
            Route::any('/addtask', 'addtask')->name('performance.addtask');
            Route::any('/createNewTask', 'createNewTask')->name('performance.createNewTask');
            Route::any('/outcome', 'outcome')->name('performance.outcome');
            Route::any('/outcomecompleted', 'outcomecompleted')->name('performance.outcomecompleted');
            Route::any('/outcomeontrack', 'outcomeontrack')->name('performance.outcomeontrack');
            Route::any('/outcomedelayed', 'outcomedelayed')->name('performance.outcomedelayed');
            Route::any('/outcomeoverdue', 'outcomeoverdue')->name('performance.outcomeoverdue');
            Route::any('/addOutput', 'addOutput')->name('performance.addOutput');
            Route::any('/output', 'output')->name('performance.output');
            Route::any('/outputcompleted', 'outputcompleted')->name('performance.outputcompleted');
            Route::any('/outputontrack', 'outputontrack')->name('performance.outputontrack');
            Route::any('/outputdelayed', 'outputdelayed')->name('performance.outputdelayed');
            Route::any('/outputoverdue', 'outputoverdue')->name('performance.outputoverdue');
            Route::any('/alltask', 'alltask')->name('performance.alltask');
            Route::any('/task', 'task')->name('performance.task');
            Route::any('/adhoc_task', 'adhoc_task')->name('performance.adhoc_task');
            Route::any('/paused_task', 'paused_task')->name('performance.paused_task');
            Route::any('/pauseTask', 'pauseTask')->name('performance.pauseTask');
            Route::any('/resumeTask', 'resumeTask')->name('performance.resumeTask');
            Route::any('/taskcompleted', 'taskcompleted')->name('performance.taskcompleted');
            Route::any('/taskoverdue', 'taskoverdue')->name('performance.taskoverdue');
            Route::any('/taskontrack', 'taskontrack')->name('performance.taskontrack');
            Route::any('/taskdelayed', 'taskdelayed')->name('performance.taskdelayed');
            Route::any('/task_info', 'task_info')->name('performance.task_info');
            Route::any('/adhoc_task_info', 'adhoc_task_info')->name('performance.adhoc_task_info');
            Route::any('/update_taskResource', 'update_taskResource')->name('performance.update_taskResource');
            Route::any('/assigntask', 'assigntask')->name('performance.assigntask');
            Route::any('/gettask', 'gettask')->name('performance.gettask');
            Route::any('/edittask', 'edittask')->name('performance.edittask');
            Route::any('/updateTaskTitle', 'updateTaskTitle')->name('performance.updateTaskTitle');
            Route::any('/updateTaskCost', 'updateTaskCost')->name('performance.updateTaskCost');
            Route::any('/updateTaskDescription', 'updateTaskDescription')->name('performance.updateTaskDescription');
            Route::any('/updateTaskDateRange', 'updateTaskDateRange')->name('performance.updateTaskDateRange');
            Route::any('/updateTaskAdvanced', 'updateTaskAdvanced')->name('performance.updateTaskAdvanced');
            Route::any('/updateTaskAdvanced2', 'updateTaskAdvanced2')->name('performance.updateTaskAdvanced2');
            Route::any('/task_notification', 'task_notification')->name('performance.task_notification');
            Route::any('/expire_contracts_notification', 'expire_contracts_notification')->name('performance.expire_contracts_notification');
            Route::any('/retire_notification', 'retire_notification')->name('performance.retire_notification');
            Route::any('/activation_notification', 'activation_notification')->name('performance.activation_notification');
            Route::any('/loan_notification', 'loan_notification')->name('performance.loan_notification');
            Route::any('/allnotifications', 'allnotifications')->name('performance.allnotifications');
            Route::any('/current_task_progress', 'current_task_progress')->name('performance.current_task_progress');

            Route::any('/outcomeGraph', 'outcomeGraph')->name('performance.outcomeGraph');
            Route::any('/printDashboard', 'printDashboard')->name('performance.printDashboard');
            Route::any('/outcome_report', 'outcome_report')->name('performance.outcome_report');
            Route::any('/output_report', 'output_report')->name('performance.output_report');
            Route::any('/task_report', 'task_report')->name('performance.task_report');
            Route::any('/funderInfo', 'funderInfo')->name('performance.funderInfo');
            Route::any('/updateFunderName', 'updateFunderName')->name('performance.updateFunderName');
            Route::any('/updateFunderEmail', 'updateFunderEmail')->name('performance.updateFunderEmail');
            Route::any('/updateFunderPhone', 'updateFunderPhone')->name('performance.updateFunderPhone');
            Route::any('/updateFunderDescription', 'updateFunderDescription')->name('performance.updateFunderDescription');
            Route::any('/deactivateFunder', 'deactivateFunder')->name('performance.deactivateFunder');
            Route::any('/deleteSegment', 'deleteSegment')->name('performance.deleteSegment');
            Route::any('/deleteCategory', 'deleteCategory')->name('performance.deleteCategory');
            Route::any('/deleteException', 'deleteException')->name('performance.deleteException');
        });

        Route::prefix('flex/project')->middleware([WorkForce::class])->controller(ProjectController::class)->group(function () {

            Route::any('/index', 'index')->name('project.index');
            Route::any('/', 'index')->name('project.index');
            Route::any('/employeeTotalPercentAllocation', 'employeeTotalPercentAllocation')->name('project.employeeTotalPercentAllocation');
            Route::any('/employeeRellocation', 'employeeRellocation')->name('project.employeeRellocation');
            Route::any('/fetchActivity', 'fetchActivity')->name('project.fetchActivity');
            Route::any('/fetchGrant', 'fetchGrant')->name('project.fetchGrant');
            Route::any('/fetchEmployee', 'fetchEmployee')->name('project.fetchEmployee');
            Route::any('/newProject', 'newProject')->name('project.newProject');
            Route::any('/addProject', 'addProject')->name('project.addProject');
            Route::any('/evaluateEmployee', 'evaluateEmployee')->name('project.evaluateEmployee');
            Route::any('/addEvaluationResults', 'addEvaluationResults')->name('project.addEvaluationResults');
            Route::any('/printPerformance', 'printPerformance')->name('project.printPerformance');
            Route::any('/saveActivityResult', 'saveActivityResult')->name('project.saveActivityResult');
            Route::any('/saveActivity', 'saveActivity')->name('project.saveActivity');
            Route::any('/saveDeliverable', 'saveDeliverable')->name('project.saveDeliverable');
            Route::any('/updateProject', 'updateProject')->name('project.updateProject');
            Route::any('/editProject', 'editProject')->name('project.editProject');
            Route::any('/projectInfo', 'projectInfo')->name('project.projectInfo');
            Route::any('/deliverableInfo', 'deliverableInfo')->name('project.deliverableInfo');
            Route::any('/updateProjectName', 'updateProjectName')->name('project.updateProjectName');
            Route::any('/updateProjectCode', 'updateProjectCode')->name('project.updateProjectCode');
            Route::any('/updateProjectDescription', 'updateProjectDescription')->name('project.updateProjectDescription');
            Route::any('/newGrant', 'newGrant')->name('project.newGrant');
            Route::any('/addGrant', 'addGrant')->name('project.addGrant');
            Route::any('/grantInfo', 'grantInfo')->name('project.grantInfo');
            Route::any('/updateGrantName', 'updateGrantName')->name('project.updateGrantName');
            Route::any('/updateGrantCode', 'updateGrantCode')->name('project.updateGrantCode');
            Route::any('/updateGrantDescription', 'updateGrantDescription')->name('project.updateGrantDescription');
            Route::any('/newActivity', 'newActivity')->name('project.newActivity');
            Route::any('/addActivity', 'addActivity')->name('project.addActivity');
            Route::any('/activityInfo', 'activityInfo')->name('project.activityInfo');
            Route::any('/updateActivityName', 'updateActivityName')->name('project.updateActivityName');
            Route::any('/updateActivityCode', 'updateActivityCode')->name('project.updateActivityCode');
            Route::any('/allocateGrantToActivity', 'allocateGrantToActivity')->name('project.allocateGrantToActivity');
            Route::any('/updateActivityDescription', 'updateActivityDescription')->name('project.updateActivityDescription');
            Route::any('/allocateActivity', 'allocateActivity')->name('project.allocateActivity');
            Route::any('/deleteActivity', 'deleteActivity')->name('project.deleteActivity');
            Route::any('/deleteActivityGrant', 'deleteActivityGrant')->name('project.deleteActivityGrant');
            Route::any('/deleteAllocation', 'deleteAllocation')->name('project.deleteAllocation');
            Route::any('/deactivateAllocation', 'deactivateAllocation')->name('project.deactivateAllocation');
            Route::any('/deactivateActivity', 'deactivateActivity')->name('project.deactivateActivity');
            Route::any('/deactivateProject', 'deactivateProject')->name('project.deactivateProject');
            Route::any('/assignActivity', 'assignActivity')->name('project.assignActivity');
            Route::any('/assignmentInfo', 'assignmentInfo')->name('project.assignmentInfo');
            Route::any('/timeTrackInfo', 'timeTrackInfo')->name('project.timeTrackInfo');
            Route::any('/commentInfo', 'commentInfo')->name('project.commentInfo');
            Route::any('/updateAssignment', 'updateAssignment')->name('project.updateAssignment');
            Route::any('/deleteEmployeeAssignment', 'deleteEmployeeAssignment')->name('project.deleteEmployeeAssignment');
            Route::any('/addTask', 'addTask')->name('project.addTask');
            Route::any('/addException', 'addException')->name('project.addException');
            Route::any('/approveTask', 'approveTask')->name('project.approveTask');
            Route::any('/commentTask', 'commentTask')->name('project.commentTask');
            Route::any('/deleteComment', 'deleteComment')->name('project.deleteComment');
            Route::any('/addCost', 'addCost')->name('project.addCost');
        });

        Route::prefix('flex/reports')->middleware('auth')->middleware([Report::class])->controller(ReportController::class)->group(function () {

            Route::any('/journalEntryReport', 'journalEntryReport')->name('reports.journalEntryReport');

            Route::any('/payroll_report', 'payroll_report')->name('reports.payroll_report');

            Route::any('/payroll_report1', 'payroll_report1')->name('reports.payroll_report1');
            Route::any('/get_payroll_temp_summary', 'get_payroll_temp_summary')->name('reports.get_payroll_temp_summary');
            Route::any('/get_payroll_temp_summary1', 'get_payroll_temp_summary1')->name('reports.get_payroll_temp_summary1');
            Route::any('/payroll_inputs', 'payroll_inputs')->name('reports.payroll_inputs');
            Route::any('/get_payroll_inputs', 'get_payroll_inputs')->name('reports.get_payroll_inputs');

            Route::any('/payrollReportLogs', 'payrollReportLogs')->name('reports.payrollReportLogs');

            Route::any('/pay_checklist', 'pay_checklist')->name('reports.pay_checklist');
            Route::any('/all_arrears', 'all_arrears')->name('reports.all_arrears');
            Route::any('/employee_arrears', 'employee_arrears')->name('reports.employee_arrears');
            Route::any('/p9', 'p9')->name('reports.p9');
            Route::any('/p10', 'p10')->name('reports.p10');
            Route::any('/heslb', 'heslb')->name('reports.heslb');
            Route::any('/pension', 'pension')->name('reports.pension');
            Route::any('/wcf', 'wcf')->name('reports.wcf');
            Route::any('/employment_cost_old', 'employment_cost_old')->name('reports.employment_cost_old');
            Route::any('/employment_cost', 'employment_cost')->name('reports.employment_cost');
            Route::any('/loanreport', 'loanreport')->name('reports.loanreport');
            Route::any('/customleavereport', 'customleavereport')->name('reports.customleavereport');

            Route::any('/temp_payslip', 'temp_payslip')->name('reports.temp_payslip');
            Route::any('/backup_payslip', 'backup_payslip')->name('reports.backup_payslip');
            Route::any('/kpi', 'kpi')->name('reports.kpi');
            Route::any('/attendance', 'attendance')->name('reports.attendance');
            Route::any('/payrollInputJournalExport', 'payrollInputJournalExport')->name('reports.payrollInputJournalExport');
            Route::any('/payrollInputJournalExportTime', 'payrollInputJournalExportTime')->name('reports.payrollInputJournalExportTime');
            Route::any('/staffPayrollBankExport', 'staffPayrollBankExport')->name('reports.staffPayrollBankExport');
            Route::any('/payrollReconciliationSummary', 'payrollReconciliationSummary')->name('reports.payrollReconciliationSummary');
            Route::any('/payrollReconciliationDetails', 'payrollReconciliationDetails')->name('reports.payrollReconciliationDetails');
            Route::any('/payrollReconciliationDetails_temp', 'payrollReconciliationDetails_temp')->name('reports.payrollReconciliationDetails_temp');

            Route::any('/dynamic_pdf', 'dynamic_pdf')->name('reports.dynamic_pdf');
            Route::any('/employeeReport', 'employeeReport')->name('reports.employeeReport');
            Route::any('/payrolldetails', 'payrolldetails')->name('reports.payrolldetails');

            Route::any('/employeeCostExport', 'employeeCostExport')->name('reports.employeeCostExport');
            Route::any('/employeeCostExport_temp', 'employeeCostExport_temp')->name('reports.employeeCostExport_temp');
            Route::any('/employeeBioDataExport', 'employeeBioDataExport')->name('reports.employeeBioDataExport');
            Route::any('/grossReconciliation', 'grossReconciliation')->name('reports.grossReconciliation');
            Route::any('/netReconciliation', 'netReconciliation')->name('reports.netReconciliation');
            Route::any('/loanReports', 'loanReports')->name('reports.loanReports');
            Route::any('/projectTime', 'projectTime')->name('reports.projectTime');
            // Route::any('/funder','funder')->name('reports.funder');
            Route::any('/annualleave', 'annualleave')->name('reports.annualleave');
            Route::any('/annualleave2', 'annualleave2')->name('reports.annualleave2');
            Route::any('/annualleave-table', 'approvedMonthly')->name('reports.annualleave.data');
            Route::any('/annualleave-table2', 'annualLeaveData2')->name('reports.annualleave.year');
            Route::any('/pendingLeaves', 'pendingLeaves')->name('reports.leave.pending.monthly');
            Route::any('/pendingLeaves1', 'pendingLeaves1')->name('reports.leave.pending.yearly');

            Route::any('/netTotalSummation', 'netTotalSummation')->name('reports.netTotalSummation');
        });

        // new cost center report
        Route::prefix('flex/cost-center')->middleware([WorkForce::class])->controller(CostCenterController::class)->group(function () {
        });
    });
});

Route::get('/leave_days/{emp_id}', [LeaveController::class, 'get_leave_days'])->middleware([WorkForce::class])->name('leave_days');
Route::post('/update_leave_days', [LeaveController::class, 'update_leave_days'])->middleware([WorkForce::class])->name('update_leave_days');


Route::post('upload', [PensionPayslipController::class, 'uploadPensionData'])->name('upload.pension');
Route::get('download-pension-template', [PensionPayslipController::class, 'downloadTemplate'])->name('download.pension.template');


Route::post('/password-reset', [NewPasswordController::class, 'store'])->middleware('guest')->name('password.new');
require __DIR__ . '/auth.php';
