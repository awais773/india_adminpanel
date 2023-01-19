<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'action',
        'module',
        'user_id',
        'client_id',
        'currency_id',
        'position_id',
        'status_id',
        'resume_id',
        'role_id',
        'city_id',
        'state_id',
        'assignPosition_id'
    ];

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function client() {
        return $this->hasOne('App\Models\Api\Client', 'id', 'client_id');
    }
    public function position() {
        return $this->hasOne('App\Models\Api\Position', 'id', 'position_id');
    }
    public function resume() {
        return $this->hasOne('App\Models\Api\Resume', 'id', 'resume_id');
    }
   
    public function currency() {
        return $this->hasOne('App\Models\Api\Currency', 'id', 'currency_id');
    }

    public function role() {
        return $this->hasOne('App\Models\Api\Role', 'id', 'role_id');
    }

    public function status() {
        return $this->hasOne('App\Models\Api\Status', 'id', 'status_id');
    }

    public function city() {
        return $this->hasOne('App\Models\Api\City', 'id', 'city_id');
    }
    
     public function state() {
        return $this->hasOne('App\Models\Api\State', 'id', 'state_id');
    }
    
    public function assignPosition() {
        return $this->hasOne('App\Models\Api\Allow', 'id', 'assignPosition_id');
    }
    
}
