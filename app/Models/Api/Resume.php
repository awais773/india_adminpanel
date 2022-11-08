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
        'current_ctc',
        'variable',
        'expected_ctc',
        'notice_period',
        'feedback',
        'candidate_status',
        'status_id',
        'user_id',

    ];

    public function status() {
        return $this->hasOne('App\Models\Api\Status', 'id', 'status_id');
    }
    public function resumelog() {
        return $this->belongsTo('App\Models\Api\ResumeLog', 'id', 'resume_log_id');
    }
}
