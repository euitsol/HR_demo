<?php

use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    // total 20
    public function run()
    {
        App\Job::create([
            'title' => 'CEO',
            'supervisor_id' => 1,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'Director',
            'supervisor_id' => 1,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'HR (Grade I)',
            'supervisor_id' => 2,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'HR (Grade II)',
            'supervisor_id' => 3,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'HR (Grade III)',
            'supervisor_id' => 3,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'Accountant (Grade I)',
            'supervisor_id' => 2,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'General Manager',
            'supervisor_id' => 2,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'Project Manager (Grade I)',
            'supervisor_id' => 7,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'Senior Web Developer (Grade I)',
            'supervisor_id' => 8,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'Senior Web Developer (Grade II)',
            'supervisor_id' => 8,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'Web Developer (Grade I)',
            'supervisor_id' => 8,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'Web Developer (Grade II)',
            'supervisor_id' => 8,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'Jr. Web Developer (Grade I)',
            'supervisor_id' => 8,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
        App\Job::create([
            'title' => 'Jr. Web Developer (Grade II)',
            'supervisor_id' => 8,
            'payscale_id' => '1',
            'maxLoanInPercentage' => 50,
            'provident' => 1,
        ]);
    }
}
