<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_name',
        'privileges_type',

    ];
    protected $casts = [
        "privileges_type" => "array",

    ];
}
