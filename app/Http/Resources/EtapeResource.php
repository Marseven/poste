<?php

namespace App\Http\Resources;

use App\Models\ModeExpedition;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class EtapeResource extends JsonResource
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
        $mode = ModeExpedition::find($this->mode_id);
        $agent = User::find($this->agent_id);
        

        return [
            'id' => $this->id,
            'code' => $this->code,
            'libelle' => $this->libelle,
            'description' => $this->description,
            'code_hexa' => $this->code_hexa,
            'type' => $this->type,
            'position' => $this->position,

            'mode_id' => $this->mode_id,
            'mode' => $mode ? $mode->libelle : 'Non defini',

            'agent_id' => $this->agent_id,
            'agent' => $agent ? $agent->name : 'Non defini',

            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('l jS F Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
