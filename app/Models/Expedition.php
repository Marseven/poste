<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    use HasFactory;

    public function agence()
    {
        return $this->hasOne('App\Models\Agence', 'id', 'agence_id');
    }

    public function service()
    {
        return $this->hasOne('App\Models\ServiceExpedition', 'id', 'service_exp_id');
    }

    public function delai()
    {
        return $this->hasOne('App\Models\TempsExpedition', 'id', 'temps_exp_id');
    }

    public function forfait()
    {
        return $this->hasOne('App\Models\ForfaitExpedition', 'id', 'forfait_exp_id');
    }

    public function tarif()
    {
        return $this->hasOne('App\Models\TarifExpedition', 'id', 'tarif_exp_id');
    }

    public function regime()
    {
        return $this->belongsTo(RegimeExpedition::class, 'regime_exp_id');
    }

    public function type()
    {
        return $this->belongsTo(TypeExpedition::class, 'type_exp_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryExpedition::class, 'category_exp_id');
    }
}
