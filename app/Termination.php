<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
    protected $fillable = [
        'user_id', 'document',
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }
}
