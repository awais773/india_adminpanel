<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'city',
        'contact_number',
        'contact_person',
        'state',
        'address',
        'pincode',
        'start_date',
        'end_date',
        'commercials_type'

    ];
    protected $casts = [
        "commercials_type" => "array",

    ];

}
