<?php

namespace Database\Seeders;
use App\Models\LeaveSubType;
use Illuminate\Database\Seeder;


class LeaveSubCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['id'=>1,'category_id'=>3,'name' => 'Illness of Child','sex'=>'2','max_days'=>'7'],
            ['id'=>2,'category_id'=>3,'name' => 'Death of immediate family member','sex'=>'0','max_days'=>'10'],
            ['id'=>3,'category_id'=>3,'name' => 'Death of grandparent and grandchild','sex'=>'0','max_days'=>'5'],
            ['id'=>4,'category_id'=>4,'name' => '1 child','sex'=>'2','max_days'=>'84'],
            ['id'=>5,'category_id'=>4,'name' => 'Twins','sex'=>'2','max_days'=>'100'],
            ['id'=>6,'category_id'=>6,'name' => 'Preparation','sex'=>'0','max_days'=>'6'],
            ['id'=>7,'category_id'=>6,'name' => 'Exams','sex'=>'0','max_days'=>'6'],
        ];

        foreach ($items as $item) {
            LeaveSubType::firstOrCreate($item);
        }
    }
    
}
