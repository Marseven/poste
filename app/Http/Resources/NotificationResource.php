<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NotificationResource extends JsonResource
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
        $expediteur = User::find($this->sender_id);
        $destinataire = User::find($this->receiver_id);

        return [
            'id' => $this->id,
            'code' => $this->code,
            'libelle' => $this->libelle,
            'details' => $this->details,
            
            'status' => $this->status,

            'expediteur' => $expediteur ? $expediteur->name : 'Non defini',
            'destinataire' => $destinataire ? $destinataire->name : 'non defini',

            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->diffForHumans(),
        ];
    }
}
