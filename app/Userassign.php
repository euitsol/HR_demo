<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userassign extends Model
{
    protected $fillable = [
        'user_id', 'project_id', 'department_id', 'task_id',
    ];
}
