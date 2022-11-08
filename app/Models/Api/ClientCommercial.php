<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCommercial extends Model
{
    use HasFactory;
    protected $fillable = [
        'form',
        'to',
        'percentage',
        'currency_id',
        'client_id',
    ];
    public function currency() {
        return $this->hasOne('App\Models\Api\Currency', 'id', 'currency_id');
    }

    public function resume() {
        return $this->hasOne('App\Models\Api\Resume', 'id', 'resume_id');
    }
}
