<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

        $date = Carbon::parse($this->created_at)->translatedFormat('l jS F Y | H:i:s');
        $stringDate = Str::of($date)->toString();

        return [
            'id' => $this->id,
            'code' => $this->code,
            'libelle' => $this->libelle,
            'details' => $this->details,
            
            'status' => $this->status,

            'expediteur' => $expediteur ? $expediteur->name : 'Non defini',
            'destinataire' => $destinataire ? $destinataire->name : 'non defini',

            'active' => $this->active,
            
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,

            'created_at' => $stringDate,
            'updated_at' => Carbon::parse($this->updated_at)->diffForHumans(),
        ];
    }
}
