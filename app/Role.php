<?php

namespace App;

use Laratrust\LaratrustRole;

class Role extends LaratrustRole
{
    protected $fillable = [
        'name', 'display_name', 'description',
    ];

//    public function jobs(){
//        return $this->belongsToMany('App\Job');
//    }

}
