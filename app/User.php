<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use LaratrustUserTrait;


    protected $fillable = [
        'name', 'email', 'userinfo_id', 'userjobinfo_id', 'userpay_id', 'leave_id', 'termination_id', 'password', 'image'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function job(){
//        return $this->hasOne('App\Job');
        return $this->belongsTo('App\Job');
    }

    public function contract(){
        return $this->hasOne('App\Contract');
    }


    public function userinfo(){
        return $this->hasOne('App\Userinfo');
    }

    public function userjobinfo(){
        return $this->hasOne('App\Userjobinfo');
    }

    public function userpay(){
        return $this->hasOne('App\Userpay');
    }

    public function warnings(){
        return $this->hasMany('App\Warning');
    }

    public function termination(){
        return $this->hasOne('App\Termination');
    }

//    public function leave(){
//        return $this->hasOne('App\Leave');
//    }

    public function leavedates(){
        return $this->hasMany('App\Leavedate');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function replies(){
        return $this->hasMany('App\Reply');
    }

    public function getNewMessageCountAttribute()
    {
        return PrivateMessage::where('receiver_id', Auth::id())
            ->where('status', 'pending')->count();
    }

//    public function user_increment()
//    {
//        return $this->hasOne('App\Increment');
//    }

}
