<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function mode()
    {
        return $this->belongsTo(ModeExpedition::class, 'mode_expedition_id');
    }
}
