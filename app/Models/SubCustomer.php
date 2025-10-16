<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'relation_type',
        'responsible_name',
        'first_name',
        'last_name',
        'dob',
        'gender',
        'nationality',
        'email',
        'phone',
        'passport_number',
        'passport_nationality',
        'passport_valid_until',
        'languages',
        'dive_center_checkin',
        'dive_center_checkout',
        'next_flight_date',
        'vegetarian',
        'hotel_id',
        'room_number',
        'address',
        'city',
        'state',
        'zipcode',
        'country',
        'additional_info',
    ];

    protected $casts = [
        'dob' => 'date',
        'passport_valid_until' => 'date',
        'dive_center_checkin' => 'date',
        'dive_center_checkout' => 'date',
        'next_flight_date' => 'date',
        'vegetarian' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function certifications()
    {
        return $this->morphMany(CustomerCertification::class, 'certifiable');
    }

    public function files()
    {
        return $this->morphMany(CustomerFile::class, 'fileable');
    }

    public function getNameAttribute()
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }
}
