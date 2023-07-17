<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageExpedition extends Model
{
    use HasFactory;

    public function colis()
    {
        return $this->belongsTo(ColisExpedition::class, 'colis_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'paquet_id');
    }
}
