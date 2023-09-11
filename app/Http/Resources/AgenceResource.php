<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Ville;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AgenceResource extends JsonResource
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
        $ville = Ville::find($this->ville_id);
        

        return [
            'id' => $this->id,
            'code' => $this->code,
            'libelle' => $this->libelle,
            'phone' => $this->phone,
            'ville_id' => $this->ville_id,
            'ville' => $ville ? $ville->libelle : 'Non defini',

            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('l jS F Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
