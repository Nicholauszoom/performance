<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccessControll\SystemModule;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ['slug' => 'Work Force Management'],
            ['slug' => 'Payroll Management'],
            ['slug' => 'Leave Management'],
            ['slug' => 'Loan Management'],
            ['slug' => 'Organization'],
            ['slug' => 'Reports'],
            ['slug' => 'Settings'],
            ['slug' => 'Dashboard'],
            ['slug' => 'Performance Management'],
            ['slug' => 'Talent Management'],
            ['slug' => 'My Service'],

        ];
foreach ($data as $row) {
    SystemModule::updateOrCreate($row);
}
    }
}
