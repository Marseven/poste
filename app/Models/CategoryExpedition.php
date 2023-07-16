<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryExpedition extends Model
{
    use HasFactory;

    public function regime()
    {
        return $this->belongsTo(RegimeExpedition::class, 'regime_id');
    }

    public function type()
    {
        return $this->belongsTo(TypeExpedition::class, 'type_id');
    }
}
