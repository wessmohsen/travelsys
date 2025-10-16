<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramFamily extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_program_id',
        'customer_id',
        'group_name',
        'adults',
        'children',
        'infants',
        'hotel_id',
        'room_number',
        'pickup_time',
        'activity',
        'size',
        'nationality',
        'boat_master',
        'guide_name',
        'transfer_name',
        'transfer_phone',
        'collect_egp',
        'collect_usd',
        'collect_eur',
        'remarks',
    ];

    // Relationships
    public function tripProgram() {
        return $this->belongsTo(TripProgram::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function hotel() {
        return $this->belongsTo(Hotel::class);
    }
}
