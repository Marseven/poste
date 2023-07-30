<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Expedition;
use App\Http\Resources\ExpeditionResource; 
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class SuiviExpeditionResource extends JsonResource
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
        $agent = User::find($this->user_id);
        $expedition = Expedition::find($this->expedition_id);

        return [
            'id' => $this->id,
            'code' => $this->code,
            'action' => $this->action,

            'expedition' => ExpeditionResource::make($expedition),

            'agent' => $agent->name,

            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d.m.Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
