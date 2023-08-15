<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Ville;
use App\Models\ModeExpedition;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ReservationResource extends JsonResource
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
        $client = User::find($this->client_id);
        $agent = User::find($this->agent_id);

        $ville_origine = Ville::find($this->ville_origine_id);
        $ville_destination = Ville::find($this->ville_destination_id);

        $mode_expedition = ModeExpedition::find($this->mode_expedition_id);

        return [
            'id' => $this->id,
            'code ' => $this->code,
            'ville_origine' => $ville_origine ? $ville_origine->libelle : 'Non defini',
            'ville_destination' => $ville_destination ? $ville_destination->libelle : 'Non defini',

            'mode_expedition' => $mode_expedition ? $mode_expedition->libelle : 'Non defini',

            'mode_livraison' => $this->mode_livraison,
            'boite_postale' => $this->boite_postale,
            'adresse_livraison' => $this->adresse_livraison,
            'frais_poste' => $this->frais_poste,
            
            'name_exp' => $this->name_exp,
            'email_exp' => $this->email_exp,
            'phone_exp' => $this->phone_exp,

            'name_dest' => $this->name_dest,
            'email_dest' => $this->email_dest,
            'phone_dest' => $this->phone_dest,

            'amount' => $this->amount,
            'nbre_colis' => $this->nbre_colis,
            'status' => $this->status,

            'client' => $client ? $client->name : 'Non defini',
            'agent' => $agent ? $agent->name : 'Non defini',

            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->diffForHumans(),
        ];
    }
}
