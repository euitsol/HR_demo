<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'project_id', 'user_id', 'comment_id', 'reply', 'file'
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }

    public function comment(){
        return $this->belongsTo('App\Comment');
    }

    public function project(){
        return $this->belongsTo('App\Project');
    }
}
