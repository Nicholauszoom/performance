<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\SystemModule;

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
        ];
foreach ($data as $row) {
    SystemModule::updateOrCreate($row);
}
    }
}
