<?php
namespace Database\Seeders;

use App\Models\LeaveType;

use Illuminate\Database\Seeder;
class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['id'=>1,'type' => 'Annual','gender'=>'0','max_days'=>'25'],
            ['id'=>2,'type' => 'Sick','gender'=>'0','max_days'=>'126'],
            ['id'=>3,'type' => 'Compassionate','gender'=>'0','max_days'=>'22'],
            ['id'=>4,'type'=> 'Maternity','gender'=>'2','max_days'=>'122'],
            ['id'=>5,'type' => 'Paternity','gender'=>'1','max_days'=>'10'],
            ['id'=>6,'type' => 'Study','gender'=>'0','max_days'=>'12'],
            // ['id'=>7,'type' => 'Widowed','gender'=>'2','max_days'=>'1'],
        ];

        foreach ($items as $item) {
            LeaveType::firstOrCreate($item);
        }
    }
}
