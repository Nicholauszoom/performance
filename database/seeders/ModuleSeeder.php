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
            ['slug' => 'manage-access-control'], 
            ['slug' => 'manage-payroll'],
        ];
foreach ($data as $row) {
    SystemModule::updateOrCreate($row);
}
    }
}
