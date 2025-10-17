<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'description',
        'phone',
        'address',
        'location_url',
        'location_ordering',
        'website'
    ];

    protected $casts = [
        'location_ordering' => 'integer'
    ];
}
