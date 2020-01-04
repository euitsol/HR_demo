<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leavedate extends Model
{
    protected $fillable = [
        'user_id', 'leave_id', 'type', 'date', 'approve',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function leave()
    {
        return $this->belongsTo('App\Leave');
    }

    public function leavetype()
    {
        return $this->belongsTo(Leavetype::class);
    }
}
