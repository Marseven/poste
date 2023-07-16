<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColisExpedition extends Model
{
    use HasFactory;

    public function price()
    {
        return $this->belongsTo(PriceExpedition::class, 'poids');
    }
}
