<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Admin\Permission;

class PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
               //my service

                [113, 'apply-leave', 11],
                [114, 'view-leaves', 11],
                [115, 'apply-overtime', 11],
                [116, 'print-pension-summary', 11],
                [119, 'print-payslip', 11],
                // Module 1: Work Force Management
                [1, 'view-workforce', 1],
                [2, 'view-employee', 1],
                [3, 'edit-employee', 1],
                [4, 'delete-employee', 1],
                [5, 'add-employee', 1],
                [6, 'activate-employee', 1],
                [141,'deactivate-employee', 1],

                [7, 'suspend-employee', 1],
                [8, 'transfer-employee', 1],
                [9, 'view-termination', 1],
                [10, 'add-termination', 1],
                [11, 'edit-termination', 1],
                [12, 'delete-termination', 1],
                [13, 'confirm-termination', 1],
                [14, 'print-termination', 1],

                [15, 'view-promotions', 1],
                [16, 'add-promotion', 1],
                [17, 'add-increment', 1],
                [18, 'edit-promotion', 1],
                [19, 'edit-increment', 1],
                [20, 'delete-promotion', 1],

                [21, 'view-overtime', 1],
                [22, 'add-overtime', 1],
                [23, 'edit-overtime', 1],
                [24, 'delete-overtime', 1],
                [25, 'view-my-overtime', 1],
                [26, 'view-others-overtime', 1],
                [27, 'approve-overtime', 1],
                [28, 'cancel-overtime', 1],

                [121, 'add-overtime-setting',1],
                [140, 'apply-overtime-onbehalf', 1],

                [29, 'view-imprest', 1],
                [30, 'add-imprest', 1],
                [31, 'edit-imprest', 1],
                [32, 'delete-imprest', 1],
                [33, 'employee-approval', 1],
                [34, 'view-transfer', 1],
                [35, 'confirm-transfer', 1],
                [36, 'view-grivance', 1],
                [37, 'add-grivance', 1],
                [38, 'edit-grivance', 1],
                [39, 'delete-grivance', 1],

                // Module 2: Payroll Management
                [40, 'view-payroll-management', 2],
                [41, 'view-payroll', 2],
                [42, 'add-payroll', 2],
                [43, 'edit-payroll', 2],
                [44, 'cancel-payroll', 2],
                [45, 'recommend-payroll', 2],
                [46, 'view-comment', 2],
                [47, 'download-approval', 2],
                [48, 'download-summary', 2],
                [49, 'hr-recommend-payroll', 2],
                [50, 'finance-recommend-payroll', 2],
                [51, 'approve-payroll', 2],
                [52, 'mail-payroll', 2],
                [53, 'view-payslip', 2],
                [54, 'view-employee-payslip', 2],
                [55, 'view-incentives', 2],
                [56, 'add-incentives', 2],
                [57, 'view-pending-payments', 2],
                [58, 'check-overtime', 2],
                [59, 'view-pending', 2],
                [60, 'view-comments', 2],
                [61, 'view-payroll-info', 2],
                [62, 'view-gross', 2],
                [63, 'view-net', 2],

                [120, 'add-package-group', 2],
                [122, 'add-allowance', 2],
                [123, 'view-allowance', 2],
                [124, 'view-pension-funds', 2],
                [125, 'view-deduction-funds', 2],
                [126, 'edit-deduction-funds', 2],
                [127, 'add-payee-range', 2],
                [128, 'view-payee-ranges', 2],
                [129, 'add-deduction', 2],
                [130, 'view-deductions', 2],
                [131, 'add-allowance-category', 2],
                [132, 'view-allowance-category', 2],
                [138, 'update-employee-opening-balance', 2],
                [142, 'view-overtime-setting', 2],


                // Module 3: Leave Management
                [64, 'view-leave-management', 3],
                // [65, 'view-leave', 3],
                [66, 'view-unpaid-leaves', 3],
                [67, 'add-unpaid-leaves', 3],
                [68, 'edit-unpaid-leaves', 3],
                [69, 'end-unpaid-leaves', 3],
                [70, 'delete-unpaid-leaves', 3],

                [133, 'apply-leave-onbehalf', 3],
                [134, 'view-new-leave-applications', 3],
                [135, 'view-aproved-leave-applications', 3],
                [136, 'view-revoked-leave-applications', 3],
                [111, 'view-forfeitings', 3],
                [137, 'add-leave-forfeit', 3],
                [139, 'edit-leave-forfeit', 3],

                // Module 4: Loan Management
                [71, 'view-loan', 4],
                [72, 'edit-loan', 4],
                [73, 'add-loan', 4],
                [74, 'delete-loan', 4],
                [75, 'approve-loan', 4],
                [76, 'view-bank-loan', 4],
                [117, 'view-loans', 4],
                [118, 'view-aproved-loans', 4],
                [201, 'delete-bank-loan', 4],
                [202, 'insert-direct-deduction', 4],
                [203, 'view-aproved-loan', 4],
                [204, 'add-loan-type', 4],
                [205, 'view-loan-types', 4],




                // Module 5: Organization
                [77, 'view-organization', 5],
                [78, 'edit-organization', 5],
                [79, 'add-organization', 5],
                [80, 'delete-organization', 5],
                [220, 'add-department', 5],
                [221, 'view-department', 5],
                [221, 'view-disabled-department', 5],

                [223, 'view-department-cost', 5],
                [224, 'add-department-cost', 5],
                [225, 'add-bank-branch', 5],
                [226, 'can-view-bank-branch', 5],
                [227, 'add-position', 5],
                [228, 'edit-position', 5],
                [229, 'delete-position', 5],

                // Module 6: Reports
                [81, 'view-report', 6],
                [82, 'view-statutory-report', 6],
                [83, 'edit-organization-report', 6],

                // Module 7: Settings
                [84, 'view-setting', 7],
                [85, 'view-financial-setting', 7],
                [86, 'view-Banking-information', 7],
                [87, 'view-Roles', 7],
                [88, 'view-Permission', 7],
                [89, 'view-audit-trail', 7],
                [90, 'view-mail-configuration', 7],
                [108, 'delete-logs', 7],
                [109, 'view-password-reset', 7],
                [110, 'view-endpoints', 7],

                // Module 8: Dashboard
                [91, 'view-dashboard', 8],

                // Module 9: Performance Management
                [98, 'view-Performance', 9],
                [99, 'add-Performance', 9],
                [100, 'edit-Performance', 9],
                [101, 'delete-Performance', 9],
                [102, 'view-Performance-matrix', 9],

                // Module 10: Talent Management
                [103, 'view-Talent', 10],
                [104, 'add-Talent', 10],
                [105, 'edit-Talent', 10],
                [106, 'delete-Talent', 10],
                [107, 'view-Talent-matrix', 10],
                [202, 'add-target-range', 10],
                [203, 'view-target-range', 10],
                [204, 'add-behavior-range', 10],
                [205, 'view-behavior-range', 10],
                [206, 'add-time-range', 10],
                [207, 'view-time-range', 10],

        ];

        foreach ($data as $permission) {
            Permission::updateOrCreate([
                // 'id' => $permission[0],
                'slug' => $permission[1],
                'sys_module_id' => $permission[2],
            ]);
        }
    }
}
