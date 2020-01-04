<?php

use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
{

    public function run()
    {
        App\Employee::create([
            'user_id' => '3',
            'employeeType_id' => '1',
            'religion_id' => '1',
            'dob' => '1990-10-10',
            'FathersName' => 'Father One',
            'MothersName' => 'Mother One',
            'mobile' => '123456789',
            'nationality' => 'Bangladeshi',
            'about_me' => 'about me and ....',
            'address' => 'Address One',
            'education' => 'Education One',
            'employment' => 'Employment One',
            'skills' => 'Skills One',
            'languages' => 'Language One',
            'reference' => 'Reference One',
        ]);
        App\Employee::create([
            'user_id' => '4',
            'employeeType_id' => '1',
            'religion_id' => '1',
            'dob' => '1990-10-11',
            'FathersName' => 'Father Two',
            'MothersName' => 'Mother Two',
            'mobile' => '123456789',
            'nationality' => 'Bangladeshi',
            'about_me' => 'about me and ....',
            'address' => 'Address Two',
            'education' => 'Education Two',
            'employment' => 'Employment Two',
            'skills' => 'Skills Two',
            'languages' => 'Language Two',
            'reference' => 'Reference Two',
        ]);
        App\Incrementpolicy::create([
            'below' => '10',
            'increment_1' => '5',
            'above_1' => '10',
            'increment_2' => '10',
            'above_2' => '20',
            'increment_3' => '20',
            'increment_max' => '30',
        ]);
    }
}
