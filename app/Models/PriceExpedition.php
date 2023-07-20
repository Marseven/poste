<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceExpedition extends Model
{
    use HasFactory;

    public function service()
    {
        return $this->belongsTo(ServiceExpedition::class, 'service_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function mode()
    {
        return $this->belongsTo(ModeExpedition::class, 'mode_id');
    }
}
