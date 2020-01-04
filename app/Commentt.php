<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commentt extends Model
{
    protected $fillable = [
        'user_id', 'task_id', 'commentt', 'file'
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }

    public function task(){
        return $this->belongsTo('App\Task');
    }

    public function replyts(){
        return $this->hasMany('App\Replyt');
    }

}
