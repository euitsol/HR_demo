<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
    ];

    public function tasks(){
        return $this->hasMany('App\Task');
    }

    public function departments(){
        return $this->hasMany('App\Department');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function replies(){
        return $this->hasMany('App\Reply');
    }
}
