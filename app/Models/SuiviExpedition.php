<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuiviExpedition extends Model
{
    use HasFactory;

    public function etape()
    {
        return $this->belongsTo(Etape::class, 'etape_id');
    }

    public function expedition()
    {
        return $this->belongsTo(Expedition::class, 'expedition_id');
    }
}
