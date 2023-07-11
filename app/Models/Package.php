<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

	public function ville_origine(){
        return $this->hasOne('App\Models\Ville', 'id', 'ville_origine_id');
    }

	public function ville_destination(){
        return $this->hasOne('App\Models\Ville', 'id', 'ville_destination_id');
    }

	public function agence_origine(){
        return $this->hasOne('App\Models\Agence', 'id', 'agence_origine_id');
    }

	public function agence_destination(){
        return $this->hasOne('App\Models\Agence', 'id', 'agence_destination_id');
    }

	public function agent(){
        return $this->hasOne('App\Models\User', 'id', 'agent_id');
    }
}
