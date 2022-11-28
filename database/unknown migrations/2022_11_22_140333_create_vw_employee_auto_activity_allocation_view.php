<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVwEmployeeAutoActivityAllocationView extends Migration
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
            CREATE VIEW `vw_employee_auto_activity_allocation` AS (select 0 AS `id`,`secondaryquery`.`empID` AS `empID`,'AC0018' AS `activity_code`,'VSO' AS `grant_code`,100 - `secondaryquery`.`sumPercent` AS `percent`,1 AS `isActive`,`secondaryquery`.`payroll_date` AS `payroll_date` from (select `performance`.`employee_activity_grant_logs`.`empID` AS `empID`,`performance`.`employee_activity_grant_logs`.`payroll_date` AS `payroll_date`,sum(`performance`.`employee_activity_grant_logs`.`percent`) AS `sumPercent` from `performance`.`employee_activity_grant_logs` where `performance`.`employee_activity_grant_logs`.`isActive` = 1 group by `performance`.`employee_activity_grant_logs`.`empID`,`performance`.`employee_activity_grant_logs`.`payroll_date`) `secondaryquery` where `secondaryquery`.`sumPercent` < 100)
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `vw_employee_auto_activity_allocation`;
        SQL;
    }
}
