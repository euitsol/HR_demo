<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
    ];

    public function users(){
//        return $this->belongsToMany('App\User');
        return $this->hasMany('App\User');
    }

    public function notices(){
        return $this->hasMany('App\Notice');
    }

    public function applicants(){
        return $this->hasMany('App\Applicant');
    }


//    public function roles(){
//        return $this->belongsToMany('App\Role');
//    }


}
