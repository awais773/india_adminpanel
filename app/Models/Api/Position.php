<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $fillable = [
        'position_name',
        'number_opening',
        'salary_range_from',
        'salary_range_to',
        'descripition',
        'client_id',
        'client_name',
    ];

    public function client() {
        return $this->hasOne('App\Models\Api\Client', 'id', 'client_id');
    }
    public function currency() {
        return $this->hasMany('App\Models\Api\Currency', 'id', 'currency_id');
    }
}
