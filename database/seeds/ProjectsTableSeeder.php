<?php

use Illuminate\Database\Seeder;
use App\Project;
use App\Department;
use App\Task;
use App\Userassign;
use Illuminate\Support\Facades\DB;


class ProjectsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 5; $i++) {
            Project::create([
                'branch_id' => 1,
                'title' => $faker->unique()->colorName,
            ]);
        }
        $projects = Project::all();
        foreach ($projects as $p) {
            $D = rand(2, 7);
            for ($i = 0; $i < $D; $i++) {
                Department::create([
                    'project_id' => $p->id,
                    'title' => $faker->unique()->colorName,
                ]);
            }
            $departments = Department::where('project_id', $p->id)->get();
            foreach ($departments as $d) {
                $T = rand(2, 7);
                for ($i = 0; $i < $T; $i++) {
                    $S = rand(2, 6);
                    $t = new Task;
                    $t->project_id = $p->id;
                    $t->department_id = $d->id;
                    $t->title = $faker->unique()->userName;
                    $t->deadline = $faker->dateTimeBetween('+5 days', '+70 days');
                    $t->remark = $faker->paragraph($S);
                    $t->progress = rand(0, 1);
                    if ($t->progress == 1){
                        $t->submit = rand(0, 1);
                        if ($t->submit == 1){
                            $t->submit_accept = rand(0, 1);
                        }
                    }
                    $t->save();
                }
                $tasks = Task::where('project_id', $p->id)->where('department_id', $d->id)->get();
                foreach ($tasks as $t) {
                    $U = rand(1, 4);
                    for ($i = 0; $i < $U; $i++) {
                        Userassign::create([
                            'user_id' => rand(1, 4),
                            'project_id' => $p->id,
                            'department_id' => $d->id,
                            'task_id' => $t->id,
                        ]);
                    }
                }
            }
        }
        DB::select( DB::raw('DELETE n1 FROM userassigns n1, userassigns n2 WHERE n1.id < n2.id AND n1.user_id = n2.user_id AND n1.task_id = n2.task_id'));
    }
}
