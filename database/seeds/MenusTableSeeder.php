<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    public function run()
    {
        $ms = [
            0 => ['Home', 'Home', 'Dashboard', 0],
            1 => ['ACL', 'ACL', 'ACL', 0],
            2 => ['permission', 'Permission', 'Permission menu under ACL', 1],
            3 => ['role', 'Role', 'Role menu under ACL', 1],
            4 => ['menu', 'Menu Setup', 'Menu Setup menu under ACL', 1],
            5 => ['user_create', 'User', 'User menu under ACL', 1],
            6 => ['Office_Management', 'Office Management', 'Office Management', 0],
            7 => ['office_setup', 'Office Setup', 'Office Setup menu under Office Management', 1],
            8 => ['branch_setup', 'Branch', 'Branch menu under Office Management', 1],
            9 => ['pay_scale', 'Pay Scale', 'Pay Scale menu under Office Management', 1],
            10 => ['tax', 'Tax Setup', 'Tax Setup menu under Office Management', 1],
            11 => ['designation', 'Designation', 'Designation menu under Office Management', 1],
            12 => ['employee_type', 'Employee Type', 'Employee Type menu under Office Management', 1],
            13 => ['general', 'General', 'General menu under Office Management', 1],
            14 => ['religion', 'Religion Setup', 'Religion Setup menu under Office Management', 1],
            15 => ['leave', 'Leave Setup', 'Leave Setup menu under Office Management', 1],
            16 => ['circular', 'Recruitment', 'Recruitment', 0],
            17 => ['Employee_Management', 'Employee Management', 'Employee Management', 0],
            18 => ['employee_create', 'Employee Create', 'Employee Create menu under Employee Management', 1],
            19 => ['employee_edit', 'Employee Edit', 'Employee Edit menu under Employee Management', 1],
            20 => ['increment_policy', 'Increment Policy', 'Increment Policy menu under Employee Management', 1],
            21 => ['increment', 'Increment', 'Increment menu under Employee Management', 1],
            22 => ['account_close', 'Retirement', 'Retirement menu under Employee Management', 1],
            23 => ['transfer', 'Transfer', 'Transfer menu under Employee Management', 1],
            24 => ['Employee_Management_Transfer_Release', 'Release', 'Transfer Release menu under Employee Management', 2],
            25 => ['Employee_Management_Transfer_Join', 'Join', 'Transfer Join menu under Employee Management', 2],
            26 => ['Leave_Management', 'Leave Management', 'Leave Management', 0],
            27 => ['l_application', 'Application', 'Application menu under Leave Management', 1],
            28 => ['l_HR', 'HR', 'HR menu under Leave Management', 1],
            29 => ['l_supervisor', 'Department Head', 'Department Head menu under Leave Management', 1],
            30 => ['Attendance', 'Attendance', 'Attendance', 0],
            31 => ['Attendance_Attendance', 'Attendance', 'Attendance menu under Attendance', 1],
            32 => ['attendance_edit', 'Edit', 'Edit menu under Attendance', 1],
            33 => ['Payroll', 'Payroll', 'Payroll', 0],
            34 => ['salary_generate', 'Salary Generate', 'Salary Generate menu under Payroll', 1],
            35 => ['bonus', 'Bonus Setup', 'Bonus Setup menu under Payroll', 1],
            36 => ['provident_fund', 'Provident Fund', 'Provident Fund menu under Payroll', 1],
            37 => ['pension', 'Pension', 'Pension menu under Payroll', 1],
            38 => ['loan', 'Loan Scheme', 'Loan Scheme menu under Payroll', 1],
            39 => ['Communication', 'Communication', 'Communication', 0],
            40 => ['communication_global', 'Global', 'Global menu under Communication', 1],
            41 => ['communication_private', 'Private', 'Private menu under Communication', 1],
            42 => ['Dispute_Management', 'Dispute Management', 'Dispute Management', 0],
            43 => ['Dispute_Management_Complain', 'Complain', 'Complain menu under Dispute Management', 1],
            44 => ['warningDH', 'Department Head', 'Department Head menu under Dispute Management', 1],
            45 => ['Dispute_Management_Appeal', 'Appeal', 'Appeal menu under Dispute Management', 1],
            46 => ['warningHR', 'HR', 'HR menu under Dispute Management', 1],
            47 => ['KPI_Voting', 'KPI Voting', 'KPI Voting', 0],
            48 => ['kpi', 'KPI', 'Key Performance Indicator', 0],
            49 => ['KPI_Setup', 'Setup', 'Setup menu under KPI', 1],
            50 => ['KPI_Calculate', 'Calculate', 'Calculate menu under KPI', 1],
            51 => ['Task_Management', 'Task Management', 'Task Management', 0],
            52 => ['Task_Management_Project_Manager', 'Project Manager', 'Project Manager menu under Task Management', 1],
            53 => ['Task_Management_General', 'General', 'General menu under Task Management', 1],
        ];

        foreach ($ms as $m){
            App\Menu::create([
                'name' => $m[0],
                'display_name' => $m[1],
                'description' => $m[2],
                'level' => $m[3],
            ]);
        }

    }
}
