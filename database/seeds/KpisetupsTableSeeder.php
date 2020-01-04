<?php

use Illuminate\Database\Seeder;

class KpisetupsTableSeeder extends Seeder
{
    public function run()
    {
        App\Kpisetup::create([
            'attendance' => '20',
            'attendanceTarget' => '15',
            'attitude' => '20',
            'attitudeTarget' => '15',
            'performance' => '20',
            'performanceTarget' => '15',
//            'judgement' => '20',
//            'judgementTarget' => '15',
            'chain' => '50',
        ]);
        App\Bonus::create([
            'percentage' => '50',
        ]);
    }
}
