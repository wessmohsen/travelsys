<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'fileable_id','fileable_type','file_path','file_type','original_name'
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
}
