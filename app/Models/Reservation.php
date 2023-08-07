<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public function mode()
    {
        return $this->belongsTo(ModeExpedition::class, 'mode_expedition_id');
    }
}
