<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // protected $fillable = ['name','email','phone'];
    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'gender',
        'phone',
        'passport_number',
        'passport_nationality',
        'passport_valid_until',
        'languages',
        'dive_center_checkin',
        'dive_center_checkout',
        'next_flight_date',
        'vegetarian',
        'address',
        'city',
        'state',
        'zipcode',
        'country',
        'additional_info',
        'email', // لو عندك ايميل
        'name',  // لو عندك حقل name عام
    ];

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }


    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
