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
        'company_id',
        'vehicle_id',
        'boat_id',
        'guide_id',
        'adults',
        'children',
        'infants',
        'collect_egp',
        'collect_usd',
        'collect_eur',
        'hotel_id',
        'room_number',
        'pickup_time',
        'activity',
        'size',
        'nationality',
        'boat_master',
        'transfer_name',
        'transfer_phone',
        'remarks',
    ];

    /**
     * Relation to the TripProgram model.
     */
    public function tripProgram()
    {
        return $this->belongsTo(TripProgram::class);
    }

    /**
     * Relation to the Customer model.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relation to the Agency model.
     */
    public function company()
    {
        return $this->belongsTo(Agency::class, 'company_id');
    }

    /**
     * Relation to the Vehicle model.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Relation to the Boat model.
     */
    public function boat()
    {
        return $this->belongsTo(Boat::class);
    }

    /**
     * Relation to the Guide model.
     */
    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    /**
     * Relation to the Hotel model.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
