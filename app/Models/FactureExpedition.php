<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureExpedition extends Model
{
    use HasFactory;

    public function societe(){
        return $this->hasOne('App\Models\Societe', 'id', 'societe_id');
    }

    public function expedition(){
        return $this->hasOne('App\Models\Expedition', 'id', 'expedition_id');
    }
}
