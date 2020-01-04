<?php

use Illuminate\Database\Seeder;

class UserloansTableSeeder extends Seeder
{

    public function run()
    {
        $us = App\User::all();
        foreach ($us as $u){
            App\Userloan::create([
                'user_id' => $u->id,
                'loantype_id' => rand(1, 3),
                'is_paid' => 1,
                'total_amount' => 1,
                'due' => rand(0, 10000),
                'pay_per_month' => 1,
            ]);
        }
    }
}
