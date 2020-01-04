<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependency extends Model
{
    protected $fillable = [
        'task_id', 'dependency'
    ];


    public function task(){
        return $this->belongsTo('App\Task');
    }

}
