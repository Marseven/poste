<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    use HasFactory;

    public function agence()
    {
        return $this->hasOne('App\Models\Agence', 'id', 'agence_id');
    }

    public function delai()
    {
        return $this->hasOne('App\Models\TempsExpedition', 'id', 'temps_exp_id');
    }

    public function mode()
    {
        return $this->belongsTo(ModeExpedition::class, 'mode_exp_id');
    }
}
