<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allow extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_allow',
        'client_id',
        'user_id',
        'position_id',

    ];


    public function client() {
        return $this->hasOne('App\Models\Api\Client', 'id', 'client_id');
    }
    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    
    public function position() {
        return $this->hasOne('App\Models\Api\Position', 'id', 'position_id');
    }
    
}
