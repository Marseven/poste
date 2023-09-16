<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Ville;
use App\Models\ModeExpedition;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

        $date = Carbon::parse($this->created_at)->translatedFormat('l jS F Y | H:i:s');
        $stringDate = Str::of($date)->toString();

        return [
            'id' => $this->id,
            'code' => $this->code,

            'ville_origine' => $ville_origine ? $ville_origine->libelle : 'Non defini',
            'ville_destination' => $ville_destination ? $ville_destination->libelle : 'Non defini',

            'mode_expedition' => $mode_expedition ? $mode_expedition->libelle : 'Non defini',

            'mode_livraison' => $this->mode_livraison,
            'boite_postale' => !empty($this->boite_postale) ? $this->boite_postale : 'Non defini',
            'adresse_livraison' => !empty($this->adresse_livraison) ? $this->adresse_livraison : 'Non defini',
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

            'player_id' => !empty($this->player_id) ? $this->player_id : 'Non defini',
            
            'ville_origine_id' => $this->ville_origine_id,
            'ville_destination_id' => $this->ville_destination_id,
            'mode_expedition_id' => $this->mode_expedition_id,
            'client_id' => $this->client_id,

            'active' => $this->active,
            'created_at' => $stringDate,
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y | H:m:s'),
        ];
    }
}
