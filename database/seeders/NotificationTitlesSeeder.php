<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NotificationTitle;

class NotificationTitlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            'payslip_arrival',
            'leave_request',
            'leave_approval',
            'overtime_request',
            'overtime_approval',
            'leave_revoke',
            'leave_revoke_approval',
        ];

        foreach ($titles as $title) {
            NotificationTitle::create(['title' => $title]);
        }
    }
}
