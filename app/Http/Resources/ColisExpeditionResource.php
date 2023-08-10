<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\ColisExpedition;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ColisExpeditionResource extends JsonResource
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
        $agent = User::find($this->agent_id);

        return [
            'id' => $this->id,
            'code' => $this->code,
            'libelle' => $this->libelle,
            'description' => $this->description,
            'modele' => $this->modele,
            'poids' => $this->poids,

            'agent' => $agent ? $agent->name : 'Non defini',

            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('l jS F Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
