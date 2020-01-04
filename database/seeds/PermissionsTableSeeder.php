<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class PermissionsTableSeeder extends Seeder
{

    public function run()
    {
        $ps = [
            0 => ["permission", "Permission", "Permission menu that goes under ACL", 3],
            1 => ["role", "Role", "Role menu that goes under ACL", 4],
            2 => ["menu", "Menu Setup", "Menu that goes under ACL", 5],
            3 => ["user_create", "User", "User_create menu that goes under ACL", 6],
            4 => ["office_setup", "Office Setup", "Office_Setup menu that goes under Office Management", 8],
            5 => ["branch_setup", "Branch", "Branch_Setup menu that goes under Office Management", 9],
            6 => ["pay_scale", "Pay Scale", "Pay_Scale menu that goes under Office Management", 10],
            7 => ["tax", "Tax Setup", "Tax Setup menu that goes under Office Management", 11],
            8 => ["designation", "Designation", "Designation menu that goes under Office Management", 12],
            9 => ["employee_type", "Employee Type", "Employee Type menu that goes under Office Management", 13],
            10 => ["general", "General", "General Setup menu that goes under Office Management", 14],
            11 => ["religion", "Religion Setup", "Religion Setup menu that goes under Office Management", 15],
            12 => ["leave", "Leave Setup", "Leave Setup menu that goes under Office Management", 16],
            13 => ["circular", "Recruitment", "Circular menu that goes under Recruitment", 17],
            14 => ["employee_create", "Employee Create", "Employee Create menu that goes under Employee Management", 19],
            15 => ["employee_edit", "Employee Edit", "Employee Edit menu that goes under Employee Management", 20],
            16 => ["increment_policy", "Increment Policy", "Increment Policy menu that goes under Employee Management", 21],
            17 => ["increment", "Increment", "Increment menu that goes under Employee Management", 22],
            18 => ["account_close", "Retirement", "Retirement or Termination menu that goes under Employee Management", 23],
            19 => ["transfer", "Transfer", "Transfer menu that goes under Employee Management", 24],
            20 => ["l_application", "Application", "Leave Application menu that goes under Leave Management", 28],
            21 => ["l_HR", "HR", "Leave HR menu that goes under Leave Management", 29],
            22 => ["l_supervisor", "Department Head", "Leave Supervisor menu that goes under Leave Management", 30],
            23 => ["attendance_edit", "Edit", "Attendance Edit menu that goes under Attendance", 33],
            24 => ["salary_generate", "Salary Generate", "Salary Generate menu that goes under Payroll", 35],
            25 => ["bonus", "Bonus Setup", "Bonus Setup menu that goes under Payroll", 36],
            26 => ["provident_fund", "Provident Fund", "Provident Fund menu that goes under Payroll", 37],
            27 => ["pension", "Pension", "Pension menu that goes under Payroll", 38],
            28 => ["loan", "Loan Scheme", "Loan Scheme menu that goes under Payroll", 39],
            29 => ["communication_global", "Global", "Global message menu that goes under Communication", 41],
            30 => ["communication_private", "Private", "Private message menu that goes under Communication", 42],
            31 => ["warningDH", "Department Head", "Complain Management menu that goes under Employee Management", 45],
            32 => ["warningHR", "HR", "Complain Management menu that goes under Employee Management", 47],
            33 => ["kpi", "KPI", "KPI menu", 49],
            34 => ["project_manager", "Project Manager", "Project Manager menu under Task Management", 53],
        ];
        $superAdmin = Role::find(1);
        foreach ($ps as $p){
            $a = new Permission();
            $a->name = $p[0];
            $a->display_name = $p[1];
            $a->description = $p[2];
            $a->menu_id = $p[3];
            $a->save();
            $superAdmin->attachPermission($a);
        }

        // weekend is excluded now
        $weekend = new Permission();
        $weekend->name = "weekend";
        $weekend->display_name = "Office Management Weekend Setup";
        $weekend->description = "Weekend Setup menu that goes under Office Management";
        $weekend->is_menu = 0;
        $weekend->save();
        // holiday is excluded now
        $holiday = new Permission();
        $holiday->name = "holiday";
        $holiday->display_name = "Office Management Holiday Setup";
        $holiday->description = "Holiday Setup menu that goes under Office Management";
        $holiday->is_menu = 0;
        $holiday->save();


        $test = new Permission();
        $test->name = "test";
        $test->display_name = "test";
        $test->is_menu = 0;
        $test->save();


        $superAdmin->attachPermissions([$test]);


        $Admin = Role::find(2);
        $Admin->attachPermissions([$test]);

        $ge = Role::find(3);
        $ge->attachPermissions([$test]);
//        $ge->attachPermission(30);

        $gu = Role::find(4);
        $gu->attachPermission(30);






    }
}