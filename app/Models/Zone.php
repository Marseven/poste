<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    public function reseau()
    {
        return $this->belongsTo(Reseau::class, 'reseau_id');
    }
}
