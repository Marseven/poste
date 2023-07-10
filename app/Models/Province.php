<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

	public function pays(){
        return $this->hasOne('App\Models\Pays', 'id', 'pays_id');
    }
}
