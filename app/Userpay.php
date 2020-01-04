<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userpay extends Model
{
    protected $fillable = [
        'user_id', 'pay', 'tax', 'compensation', 'benefit', 'benefit_detail', 'family_support', 'child_family_support_detail',
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }

}
