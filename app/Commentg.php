<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commentg extends Model
{
    protected $fillable = [
        'user_id', 'commentg', 'file'
    ];
}
