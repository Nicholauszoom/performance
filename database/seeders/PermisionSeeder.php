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

                // Module 1: Work Force Management
                [1, 'view-workforce', 1],
                [2, 'view-employee', 1],
                [3, 'edit-employee', 1],
                [4, 'delete-employee', 1],
                [5, 'add-employee', 1],
                [6, 'activate-employee', 1],
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

                // Module 3: Leave Management
                [64, 'view-leave-management', 3],
                [65, 'view-leave', 3],
                [66, 'view-unpaid-leaves', 3],
                [67, 'add-unpaid-leaves', 3],
                [68, 'edit-unpaid-leaves', 3],
                [69, 'end-unpaid-leaves', 3],
                [70, 'delete-unpaid-leaves', 3],

                // Module 4: Loan Management
                [71, 'view-loan', 4],
                [72, 'edit-loan', 4],
                [73, 'add-loan', 4],
                [74, 'delete-loan', 4],
                [75, 'approve-loan', 4],
                [76, 'view-bank-loan', 4],

                // Module 5: Organization
                [77, 'view-organization', 5],
                [78, 'edit-organization', 5],
                [79, 'add-organization', 5],
                [80, 'delete-organization', 5],

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
                [111, 'view-forfeitings', 3],
                [112, 'view-loan-types', 4],






        ];

        foreach ($data as $permission) {
            Permission::updateOrCreate([
                'id' => $permission[0],
                'slug' => $permission[1],
                'sys_module_id' => $permission[2],
            ]);
        }
    }
}
