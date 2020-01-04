<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replyg extends Model
{
    protected $fillable = [
        'user_id', 'commentg_id', 'replyg', 'file'
    ];
}
