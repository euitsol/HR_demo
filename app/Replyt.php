<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replyt extends Model
{
    protected $fillable = [
        'user_id', 'task_id', 'commentt_id', 'replyt', 'file'
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }

    public function task(){
        return $this->belongsTo('App\Task');
    }

    public function commentt(){
        return $this->belongsTo('App\Commentt');
    }

}
