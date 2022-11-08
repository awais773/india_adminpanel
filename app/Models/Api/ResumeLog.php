<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'resume_id',
        'user_id',
        'type',
        'status_id',
    ];

    public function status() {
        return $this->hasOne('App\Models\Api\Status', 'id', 'status_id');
    }
    public function resume() {
        return $this->hasOne('App\Models\Api\Resume', 'id', 'resume_id');
    }

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
