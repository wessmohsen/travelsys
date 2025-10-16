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
        'company_id',
        'guide_id',
        'boat_id',
        'vehicle_id',
        'total_adults',
        'total_children',
        'total_infants',
        'total_amount',
        'remarks',
        'status',
    ];

    // Relationships
    public function trip() {
        return $this->belongsTo(Trip::class);
    }

    public function company() {
        return $this->belongsTo(Agency::class, 'company_id');
    }

    public function guide() {
        return $this->belongsTo(Guide::class);
    }

    public function boat() {
        return $this->belongsTo(Boat::class);
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function families() {
        return $this->hasMany(ProgramFamily::class);
    }
}
