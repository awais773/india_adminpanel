<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        'currency_name',
        'symbol',
        'position_id',
        'client_id',
       
    ];

    public function client() {
        return $this->hasMany('App\Models\Api\Client', 'id', 'client_id');
    }
    public function position() {
        return $this->hasMany('App\Models\Api\Position', 'id', 'position_id');
    }
}
