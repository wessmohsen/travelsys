<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCertification extends Model
{
    use HasFactory;

    protected $fillable = [
        'certifiable_id','certifiable_type','certification_id','dives_count'
    ];

    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    public function certifiable()
    {
        return $this->morphTo();
    }
}
