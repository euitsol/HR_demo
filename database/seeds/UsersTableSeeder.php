<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        App\User::create([
            'branch_id' => '1',
            'name' => 'Mr Lorem Test',
            'email' => 'a@g.com',
            'password' => bcrypt('123456'),
            'userinfo_id' => 1,
//            'job_id' => 1,
            'job_id' => 2,
            'userjobinfo_id' => 1,
            'userpay_id' => 1,
            'ip_address' => '127.0.0.1',
            'fatal_warning' => 0,
        ]);
        App\User::create([
            'branch_id' => '1',
//            'job_id' => 2,
            'job_id' => 1,
            'name' => 'lolo',
            'email' => 'll@g.com',
            'password' => bcrypt('123456'),
            'ip_address' => '127.0.0.1',
            'fatal_warning' => 0,
        ]);
        App\User::create([
            'branch_id' => '1',
            'job_id' => 3,
            'name' => 'loloe',
            'email' => 'll@g.come',
            'password' => bcrypt('123456'),
            'ip_address' => '127.0.0.1',
            'fatal_warning' => 0,
        ]);
        App\User::create([
            'branch_id' => '1',
//            'job_id' => 4,
            'job_id' => 3,
            'name' => 'qqq',
            'email' => 'q@g.com',
            'password' => bcrypt('123456'),
            'ip_address' => '127.0.0.1',
            'fatal_warning' => 0,
        ]);
//        $faker = Faker\Factory::create();
//        for ($i = 0; $i < 100; $i++) {
//            App\User::create([
//                'branch_id' => 1,
//                'job_id' => rand(1, 26),
//                'name' => $faker->name,
//                'email' => $faker->email,
//                'password' => bcrypt('123456'),
//                'ip_address' => '127.0.0.1',
//                'fatal_warning' => rand(0, 5),
//            ]);
//        }
//        for ($i = 0; $i < 60; $i++) {
//            App\User::create([
//                'branch_id' => 2,
//                'job_id' => rand(1, 26),
//                'name' => $faker->name,
//                'email' => $faker->email,
//                'password' => bcrypt('123456'),
//                'ip_address' => '127.0.0.1',
//                'fatal_warning' => rand(0, 5),
//            ]);
//        }
//        for ($i = 0; $i < 40; $i++) {
//            App\User::create([
//                'branch_id' => 3,
//                'job_id' => rand(1, 26),
//                'name' => $faker->name,
//                'email' => $faker->email,
//                'password' => bcrypt('123456'),
//                'ip_address' => '127.0.0.1',
//                'fatal_warning' => rand(0, 5),
//            ]);
//        }
//        for ($i = 0; $i < 30; $i++) {
//            App\User::create([
//                'branch_id' => 4,
//                'job_id' => rand(1, 20),
//                'name' => $faker->name,
//                'email' => $faker->email,
//                'password' => bcrypt('123456'),
//                'ip_address' => '127.0.0.1',
//                'fatal_warning' => rand(0, 5),
//            ]);
//        }
//        for ($i = 0; $i < 25; $i++) {
//            App\User::create([
//                'branch_id' => 5,
//                'job_id' => rand(1, 15),
//                'name' => $faker->name,
//                'email' => $faker->email,
//                'password' => bcrypt('123456'),
//                'ip_address' => '127.0.0.1',
//                'fatal_warning' => rand(0, 5),
//            ]);
//        }
//        for ($i = 0; $i < 20; $i++) {
//            App\User::create([
//                'branch_id' => 6,
//                'job_id' => rand(1, 10),
//                'name' => $faker->name,
//                'email' => $faker->email,
//                'password' => bcrypt('123456'),
//                'ip_address' => '127.0.0.1',
//                'fatal_warning' => rand(0, 5),
//            ]);
//        } for ($i = 0; $i < 7; $i++) {
//            App\User::create([
//                'branch_id' => 7,
//                'job_id' => rand(1, 5),
//                'name' => $faker->name,
//                'email' => $faker->email,
//                'password' => bcrypt('123456'),
//                'ip_address' => '127.0.0.1',
//                'fatal_warning' => rand(0, 5),
//            ]);
//        }

    }
}
