<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'date',
        'organizer_id',
        'remarks',
        'status',
        'last_modified_at',
    ];

    protected $casts = [
        'date' => 'date',
        'last_modified_at' => 'datetime',
    ];

    /**
     * Booted method to handle model events.
     */
    protected static function booted()
    {
        static::creating(function ($tripProgram) {
            $tripProgram->last_modified_at = now();
        });

        static::updating(function ($tripProgram) {
            $tripProgram->last_modified_at = now();
        });
    }

    /**
     * Relation to the Trip model.
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Relation to the ProgramFamily model.
     */
    public function families()
    {
        return $this->hasMany(ProgramFamily::class)->orderBy('ordering');
    }

    /**
     * Relation to the User model (organizer).
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
}
    // {
    //     return $this->hasMany(ProgramFamily::class);
    // }

