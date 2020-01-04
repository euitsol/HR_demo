<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userjobinfo extends Model
{
    protected $fillable = [
        'user_id', 'job_id', 'contract_id', 'job_description', 'offer_letter', 'resume', 'contract_length',
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }

}
