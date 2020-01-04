<?php

use Illuminate\Database\Seeder;

class LoantypesTableSeeder extends Seeder
{

    public function run()
    {
        App\Loantype::create([
            'type' => 'Advance Payment',
        ]);
        App\Loantype::create([
            'type' => 'Home Loan',
        ]);
        App\Loantype::create([
            'type' => 'Car Loan',
        ]);
        App\EmployeeType::create([
            'type' => 'Full Time',
        ]);
        App\EmployeeType::create([
            'type' => 'Part Time',
        ]);
        App\EmployeeType::create([
            'type' => 'Contractual',
        ]);
        App\Religion::create([
            'name' => 'Islam',
        ]);
        App\Religion::create([
            'name' => 'Hinduism',
        ]);
        App\Religion::create([
            'name' => 'Christianity',
        ]);
    }
}
