<?php

use Illuminate\Database\Seeder;

class LeavetypesTableSeeder extends Seeder
{

    public function run()
    {
        App\Leavetype::create([
            'type' => 'Without Pay',
        ]);
        App\Leavetype::create([
            'type' => 'Sick',
        ]);
        App\Leavetype::create([
            'type' => 'Casual',
        ]);
    }
}
