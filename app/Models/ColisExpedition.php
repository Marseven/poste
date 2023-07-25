<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColisExpedition extends Model
{
    use HasFactory;

    public function service()
    {
        return $this->belongsTo(ServiceExpedition::class, 'service_exp_id');
    }

    public function expedition()
    {
        return $this->belongsTo(Expedition::class, 'expedition_id');
    }
}
