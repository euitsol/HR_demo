<?php

use Illuminate\Database\Seeder;

class UserinfosTableSeeder extends Seeder
{

    public function run()
    {
        App\Userinfo::create([
            'user_id' => 1,
//            'name' => 'Mr Lorem Test',
            'dob' => '1990-02-26',
            'address' => 'Mirpur DOHS, Dhaka',
            'mobile' => '+8801711369874',
            'emergency_contract' => 'Mr Faruk (father), +8801723696369',
            'blood_group' => 'O+',
            'reference' => 'Mr Chairman of Test Company, +8801756325632',
            'academic_skills' => 'H.S.C in 2004, A+; S.S.C in 2006, A+; B.Sc in EEE from BUET 3.4; HTML,CSS,PHP,JS',
        ]);
    }
}
