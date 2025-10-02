<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'tax_number', 'is_partner',
        'street', 'number', 'zipcode', 'city', 'state', 'country', 'notes'
    ];
}

