<?php

namespace Database\Seeders\Attributes;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Iterate through seeder data and add rows
            [
                'item_code' => trim("1"),
                'item_value' => trim("Male"),
                'description' => trim(""),
                // Add more columns as needed
            ],            [
                'item_code' => trim("2"),
                'item_value' => trim("Female"),
                'description' => trim(""),
                // Add more columns as needed
            ],            [
                'item_code' => trim("3"),
                'item_value' => trim("Not Applicable"),
                'description' => trim("For other than individuals"),
                // Add more columns as needed
            ],        ];

        foreach($data as $attribute){
        DB::table('attribute_genders')->updateOrInsert(
            ['item_value' => $attribute['item_value']],
            $attribute
        );
        }
    }
}