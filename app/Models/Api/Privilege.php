<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privileg extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'privileges_type',
    ];

    public function client() {
        return $this->hasOne('App\Models\Api\Client', 'id', 'client_id');
    }
    public function currency() {
        return $this->hasMany('App\Models\Api\Currency', 'id', 'currency_id');
    }
}
