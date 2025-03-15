<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    public function run()
    {
        LeaveType::insert([
            ['name' => 'Sick Leave', 'description' => 'Leave for medical reasons'],
            ['name' => 'Casual Leave', 'description' => 'Leave for personal reasons'],
            ['name' => 'Annual Leave', 'description' => 'Yearly vacation leave'],
        ]);
    }
}
