<?php

use Illuminate\Database\Seeder;
use App\Branch;

class BranchesTableSeeder extends Seeder
{

    public function run()
    {
        $branches = ['Main', 'Dhaka', 'Khulna', 'Cryptograms', 'Sirajganj', 'Dinazpur', 'Rangpur'];
        foreach ($branches as $b){
            App\Branch::create([
                'title' => $b
            ]);
        }
        $bs = Branch::all();
        $taxes = [0 => [1, 250000, 0], 1 => [250001, 400000, 10], 2 => [400001, 500000, 15], 3 => [500001, 600000, 20], 4 => [600001, 3000000, 25]];
        foreach ($bs as $b){
            foreach ($taxes as $t){
                App\Tax::create([
                    'branch_id' => $b->id,
                    'from' => $t[0],
                    'to' => $t[1],
                    'tax' => $t[2],
                ]);
            }
        }


    }
}
