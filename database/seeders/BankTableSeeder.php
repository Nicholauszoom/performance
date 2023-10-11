<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('bank')->insert([
            [
                'id' => 1,
                'name' => 'Banc ABC',
                'abbr' => 'ABC',
                'bank_code' => '034',
            ],
        ]);
    }
}

