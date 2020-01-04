<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    protected $fillable = [
        'user_id', 'type', 'description',
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }
}
