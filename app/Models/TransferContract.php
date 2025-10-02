<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'vehicle_id',
        'company_name',
        'from',
        'to',
        'contract_type',
        'contract_date',
        'status',
        'notes',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // public function company()
    // {
    //     return $this->belongsTo(Agency::class, 'company_id');
    // }
}
