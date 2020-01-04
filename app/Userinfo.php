<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{
    protected $fillable = [
        'user_id', 'dob', 'address', 'mobile', 'emergency_contract', 'blood_group', 'reference', 'academic_skills',
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }

}
