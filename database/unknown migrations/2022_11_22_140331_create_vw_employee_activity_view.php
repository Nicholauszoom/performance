<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVwEmployeeActivityView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    private function createView()
    {
        return <<<SQL
            CREATE VIEW `vw_employee_activity` AS (select `performance`.`employee`.`emp_id` AS `empID`,if(`eag`.`empID` is null,1,`eag`.`isActive`) AS `isActive`,if(`eag`.`empID` is null,(select `performance`.`project`.`code` from `performance`.`project` where `performance`.`project`.`id` = 1),(select `performance`.`activity`.`project_ref` from `performance`.`activity` where `performance`.`activity`.`code` = `eag`.`activity_code` limit 1)) AS `project_code`,if(`eag`.`empID` is null,100,`eag`.`percent`) AS `percent`,if(`eag`.`empID` is null,(select `performance`.`grants`.`code` from `performance`.`grants` where `performance`.`grants`.`id` = 1),`eag`.`grant_code`) AS `grant_code`,if(`eag`.`empID` is null,(select `performance`.`activity`.`code` from `performance`.`activity` where `performance`.`activity`.`id` = 1),`eag`.`activity_code`) AS `activity_code`,`eag`.`payroll_date` AS `payroll_date` from (`performance`.`employee` left join (select `performance`.`vw_employee_auto_activity_allocation`.`id` AS `id`,`performance`.`vw_employee_auto_activity_allocation`.`empID` AS `empID`,`performance`.`vw_employee_auto_activity_allocation`.`activity_code` AS `activity_code`,`performance`.`vw_employee_auto_activity_allocation`.`grant_code` AS `grant_code`,`performance`.`vw_employee_auto_activity_allocation`.`percent` AS `percent`,`performance`.`vw_employee_auto_activity_allocation`.`isActive` AS `isActive`,`performance`.`vw_employee_auto_activity_allocation`.`isActive` AS `payroll_date` from `performance`.`vw_employee_auto_activity_allocation` union select `performance`.`employee_activity_grant_logs`.`id` AS `id`,`performance`.`employee_activity_grant_logs`.`empID` AS `empID`,`performance`.`employee_activity_grant_logs`.`activity_code` AS `activity_code`,`performance`.`employee_activity_grant_logs`.`grant_code` AS `grant_code`,`performance`.`employee_activity_grant_logs`.`percent` AS `percent`,`performance`.`employee_activity_grant_logs`.`isActive` AS `isActive`,`performance`.`employee_activity_grant_logs`.`payroll_date` AS `payroll_date` from `performance`.`employee_activity_grant_logs`) `eag` on(`performance`.`employee`.`emp_id` = `eag`.`empID`)))
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `vw_employee_activity`;
        SQL;
    }
}
