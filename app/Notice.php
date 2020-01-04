<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'job_id', 'job_title', 'publish', 'notice',
    ];

    public function job(){
        return $this->belongsTo('App\Job');
    }

    public function applicants(){
        return $this->belongsToMany('App\Applicant');
    }
}
