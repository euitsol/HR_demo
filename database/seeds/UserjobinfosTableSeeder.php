<?php

use Illuminate\Database\Seeder;

class UserjobinfosTableSeeder extends Seeder
{

    public function run()
    {
        App\Userjobinfo::create([
            'user_id' => 1,
//            'branch_id' => 1,
            'job_id' => 1,
            'contract_id' => 1,
            'job_description' => 'Responsible for ADB online app modification, backend development of new web app.',
            'contract_length' => '2 years',
        ]);
    }
}
