<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegimeExpedition extends Model
{
    use HasFactory;

    public function type()
    {
        return $this->belongsTo(TypeExpedition::class, 'type_id');
    }
}
