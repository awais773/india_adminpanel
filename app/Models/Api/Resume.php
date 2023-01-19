<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;
    protected $fillable = [
        'sr_no',
        'country',
        'client',
        'requirement',
        'cv_shared_date',
        'candidate_name',
        'contact_no',
        'email_id',
        'current_location',
        'highest_qualification',
        'current_organisation',
        'current_designation',
        'exp_in_yrs',
        'current_city',
        'variable',
        'expected_city',
        'notice_period',
        'feedback',
        'candidate_status',
        'status_id',
        'user_id',
        'position_id',
        'state_id',
        'city_id',
        'date',
    


    ];

    public function status() {
        return $this->hasOne('App\Models\Api\Status', 'id', 'status_id');
    }
    public function resumelog() {
        return $this->belongsTo('App\Models\Api\ResumeLog', 'id', 'resume_log_id');
    }

    public function position() {
        return $this->hasOne('App\Models\Api\Position', 'id', 'position_id');
    } 
     public function city() {
        return $this->hasOne('App\Models\Api\City', 'id', 'city_id');
    }
    public function state() {
        return $this->hasOne('App\Models\Api\State', 'id', 'state_id');
    } 
    
    public function currentCity() {
        return $this->hasOne('App\Models\Api\City', 'id', 'current_city');
    }

    public function expectedCity() {
        return $this->hasOne('App\Models\Api\City', 'id', 'expected_city');
    }

    
}
