<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory;

    public function expedition()
    {
        return $this->belongsTo(Expedition::class, 'expedition_id');
    }

    public function colis()
    {
        return $this->belongsTo(ColisExpedition::class, 'colis_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
