<?php

use Illuminate\Database\Seeder;

class PensionsTableSeeder extends Seeder
{
    public function run()
    {
        App\Pension::create([
            'is_active' => 1,
            'total_pay_months' => 36,
            'salary_percentage' => 10,
            'max_withdraw_percentage' => 33.33,
            'per_month_withdraw_percentage' => 4,
            'is_both' => 0,
            'company_pay_percentage' => 50,
            'is_gross_salary' => 0,
            'max_leave_per_type' => 12,
        ]);

        App\Provident::create([
            'from_user' => 50,
            'from_employer' => 50,
            'is_gross' => 1,
        ]);
    }
}
