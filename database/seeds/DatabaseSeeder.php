<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(JobsTableSeeder::class);
         $this->call(UserinfosTableSeeder::class);
         $this->call(UserjobinfosTableSeeder::class);
         $this->call(NoticesTableSeeder::class);
         $this->call(LoantypesTableSeeder::class);
         $this->call(PensionsTableSeeder::class);
         $this->call(LeavetypesTableSeeder::class);
         $this->call(BranchesTableSeeder::class);
//         $this->call(ProjectsTableSeeder::class);
         $this->call(LeavesTableSeeder::class);
         $this->call(UserloansTableSeeder::class);
//         $this->call(SalariesTableSeeder::class);
        $this->call(PayscalesTableSeeder::class);
        $this->call(KpisetupsTableSeeder::class);
        $this->call(EmployeeTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
    }
}
