<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;



    public function agence_exp()
    {
        return $this->hasOne('App\Models\Agence', 'id', 'agence_exp_id');
    }

    public function agence_dest()
    {
        return $this->hasOne('App\Models\Agence', 'id', 'agence_dest_id');
    }

    public function agent()
    {
        return $this->hasOne('App\Models\User', 'id', 'agent_id');
    }

    public function colis()
    {
        return $this->hasMany(PackageExpedition::class, 'package_id');
    }
}
