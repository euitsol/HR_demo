<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'user_id', 'sick', 'casual', 'earn', 'year',
    ];

//    public function user(){
//        return $this->belongsTo('App\User');
//    }

    public function leavedates(){
        return $this->hasMany('App\Leavedate');
    }

}
