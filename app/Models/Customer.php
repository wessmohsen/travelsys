<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        // النوع + الفندق + الغرفة
        'customer_type', // كان اسمها type، الآن أفضل نسميها customer_type لتفادي تعارض الكلمات المحجوزة في Laravel
        'hotel_id',
        'room_number',

        // كل الحقول القديمة
        'first_name',
        'last_name',
        'email',
        'phone',
        'dob',
        'gender',
        'vegetarian',
        'customer_type',
        'passport_number',
        'passport_nationality',
        'passport_valid_until',
        'dive_center_checkin',
        'dive_center_checkout',
        'next_flight_date',
        'address',
        'city',
        'state',
        'zipcode',
        'country',
        'languages',
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

    // ✅ العلاقات

    // الفندق
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // العملاء الفرعيين (أفراد العائلة)
    public function subCustomers()
    {
        // return $this->hasMany(SubCustomer::class);
        return $this->hasMany(SubCustomer::class);
    }

    // شهادات الغوص (العلاقة متعددة الأشكال)
    public function certifications()
    {
        return $this->morphMany(CustomerCertification::class, 'certifiable');
    }

    // ملفات العميل (صور / مستندات)
    public function files()
    {
        return $this->morphMany(CustomerFile::class, 'fileable');
    }

    // ✅ Accessor لعرض الاسم الكامل بسهولة
    public function getNameAttribute()
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }
}
