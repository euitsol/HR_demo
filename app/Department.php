<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'project_id', 'title'
    ];

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function tasks(){
        return $this->hasMany('App\Task');
    }



}
