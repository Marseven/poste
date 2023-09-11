<?php

namespace App\Http\Resources;

use App\Models\ModeExpedition;
use App\Models\ServiceExpedition;
use App\Models\Zone;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PriceExpeditionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Set locale
        Carbon::setLocale('fr');
        
        // Get relation data
        $zone = Zone::find($this->zone_id);
        $service = ServiceExpedition::find($this->service_id);
        $mode = ModeExpedition::find($this->mode_id);

        return [
            'id' => $this->id,

            'zone' => $zone ? $zone->libelle : 'Non defini',
            'service' => $service ? $service->libelle : 'Non defini',
            'mode' => $mode ? $mode->libelle : 'Non defini',

            'code' => $this->code,
            'libelle' => $this->libelle,

            'zone_id' => $this->zone_id,
            'service_id' => $this->service_id,
            'mode_id' => $this->mode_id,

            'type' => $this->type,
            'first' => $this->first,

            'weight' => $this->weight,
            'price' => $this->price,

            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('l jS F Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
