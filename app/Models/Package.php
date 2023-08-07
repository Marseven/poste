<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    public function agence_exp()
    {
        return $this->belongsTo(Agence::class, 'agence_exp_id');
    }

    public function agence_dest()
    {
        return $this->belongsTo(Agence::class, 'agence_dest_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function colis()
    {
        return $this->hasMany(PackageExpedition::class, 'package_id');
    }

    public function mode()
    {
        return $this->belongsTo(ModeExpedition::class, 'mode_exp_id');
    }
}
