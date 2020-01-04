<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id', 'title', 'deadline', 'remark'
    ];

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function department(){
        return $this->belongsTo('App\Department');
    }

    public function dependencies(){
        return $this->hasMany('App\Dependency');
    }

}
