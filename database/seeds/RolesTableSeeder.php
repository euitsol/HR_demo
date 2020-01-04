<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class RolesTableSeeder extends Seeder
{

    public function run()
    {
        $sa = new Role();
        $sa->name = 'super_admin';
        $sa->display_name = "Super Admin";
        $sa->save();
        $a = new Role();
        $a->name = 'admin';
        $a->display_name = "Admin";
        $a->save();
        $nr = new Role();
        $nr->name = 'no_permission';
        $nr->display_name = "No Permission";
        $nr->save();
        $gu = new Role();
        $gu->name = 'general_user';
        $gu->display_name = "General User";
        $gu->save();
        $ge = new Role();
        $ge->name = 'general_employee';
        $ge->display_name = "General Employee";
        $ge->save();

        $u1 = User::find(1);
//        $u1->detachRole($sa);
        $u1->attachRole($sa);

        $u2 = User::find(2);
        $u2->attachRole($a);
        $u2 = User::find(3);
        $u2->attachRole($gu);
        $u2 = User::find(4);
        $u2->attachRole($gu);







//        $a = new Role();
//        $a->name = "admin";
//        $a->display_name = "ADMIN_ROLE";
//        $a->save();
//        $s = new Role();
//        $s->name = "setup";
//        $s->display_name = "SETUP_ROLE";
//        $s->save();
//        $su = new Role();
//        $su->name = "setup_user";
//        $su->display_name = "SETUP_USER_ROLE";
//        $su->save();
//        $sj = new Role();
//        $sj->name = "setup_job";
//        $sj->display_name = "SETUP_JOB_ROLE";
//        $sj->save();
//        $sp = new Role();
//        $sp->name = "setup_pay";
//        $sp->display_name = "SETUP_PAY_ROLE";
//        $sp->save();
//        $sl = new Role();
//        $sl->name = "setup_leave";
//        $sl->display_name = "SETUP_LEAVE_ROLE";
//        $sl->save();
//        $sc = new Role();
//        $sc->name = "setup_contract";
//        $sc->display_name = "SETUP_CONTRACT_ROLE";
//        $sc->save();
//        $sn = new Role();
//        $sn->name = "setup_notice";
//        $sn->display_name = "SETUP_NOTICE_ROLE";
//        $sn->save();
//        $slt = new Role();
//        $slt->name = "setup_loanType";
//        $slt->display_name = "SETUP_LoanType_ROLE";
//        $slt->save();
//        $spe = new Role();
//        $spe->name = "setup_pension";
//        $spe->display_name = "SETUP_PENSION_ROLE";
//        $spe->save();
//        $ss = new Role();
//        $ss->name = "setup_salary";
//        $ss->display_name = "SETUP_SALARY_ROLE";
//        $ss->save();
//        $sb = new Role();
//        $sb->name = "setup_branch";
//        $sb->display_name = "SETUP_BRANCH_ROLE";
//        $sb->save();
//        $info = new Role();
//        $info->name = "info";
//        $info->display_name = "INFO_ROLE";
//        $info->save();
//        $iu = new Role();
//        $iu->name = "info_user";
//        $iu->display_name = "INFO_USER_ROLE";
//        $iu->save();
//        $iuj = new Role();
//        $iuj->name = "info_user_job";
//        $iuj->display_name = "INFO_USER_JOB_ROLE";
//        $iuj->save();
//        $iup = new Role();
//        $iup->name = "info_user_pay";
//        $iup->display_name = "INFO_USER_PAY_ROLE";
//        $iup->save();
//        $iul = new Role();
//        $iul->name = "info_user_loan";
//        $iul->display_name = "INFO_USER_LOAN_ROLE";
//        $iul->save();
//        $iupf = new Role();
//        $iupf->name = "info_user_provident_fund";
//        $iupf->display_name = "INFO_USER_PROVIDENT_FUND_ROLE";
//        $iupf->save();
//        $role = new Role();
//        $role->name = "info_user_role";
//        $role->display_name = "INFO_USER_RoleAssign_ROLE";
//        $role->save();
//        $leave = new Role();
//        $leave->name = "leave";
//        $leave->display_name = "LEAVE_ROLE";
//        $leave->save();
//        $la = new Role();
//        $la->name = "leave_application";
//        $la->display_name = "LEAVE_APPLICATION_ROLE";
//        $la->save();
//        $lhr = new Role();
//        $lhr->name = "leave_hr";
//        $lhr->display_name = "LEAVE_HR_ROLE";
//        $lhr->save();
//        $ldh = new Role();
//        $ldh->name = "leave_dh";
//        $ldh->display_name = "LEAVE_DH_ROLE";
//        $ldh->save();
//        // task only ProjectManager
//        $tpm = new Role();
//        $tpm->name = "task_project_manager";
//        $tpm->display_name = "TASK_PROJECT_MANAGER_ROLE";
//        $tpm->save();
//        $wdh = new Role();
//        $wdh->name = "warning_dh";
//        $wdh->display_name = "WARNING_DH_ROLE";
//        $wdh->save();
//        $whr = new Role();
//        $whr->name = "warning_hr";
//        $whr->display_name = "WARNING_HR_ROLE";
//        $whr->save();
//        $ahr = new Role();
//        $ahr->name = "attendance_hr";
//        $ahr->display_name = "ATTENDANCE_HR_ROLE";
//        $ahr->save();
//        $message = new Role();
//        $message->name = "message";
//        $message->display_name = "MESSAGE_ROLE";
//        $message->save();
//        $salary = new Role();
//        $salary->name = "salary";
//        $salary->display_name = "SALARY_ROLE";
//        $salary->save();
//        $promotion = new Role();
//        $promotion->name = "promotion";
//        $promotion->display_name = "PROMOTION_ROLE";
//        $promotion->save();
//        $idh = new Role();
//        $idh->name = "increment_dh";
//        $idh->display_name = "INCREMENT_DH_ROLE";
//        $idh->save();
//        $ihr = new Role();
//        $ihr->name = "increment_hr";
//        $ihr->display_name = "INCREMENT_HR_ROLE";
//        $ihr->save();
//        $iceo = new Role();
//        $iceo->name = "increment_ceo";
//        $iceo->display_name = "INCREMENT_CEO_ROLE";
//        $iceo->save();
//        $gc = new Role();
//        $gc->name = "global_comment";
//        $gc->display_name = "GLOBAL_COMMENT_ROLE";
//        $gc->save();
//        $ac = new Role();
//        $ac->name = "account_close";
//        $ac->display_name = "ACCOUNT_CLOSE_ROLE";
//        $ac->save();
//
//        // task for department head /////////////////////////////////////////////////////////////////
//
//
//
//
//
//        $u1 = User::find(1);
//        $u1->detachRole($a);


    }
}
