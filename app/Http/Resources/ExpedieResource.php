<?php

namespace App\Http\Resources;

use App\Models\MethodePaiement;
use App\Models\ModeExpedition;
use App\Models\PriceExpedition;
use App\Models\User;
use App\Models\Agence;
use App\Models\Ville;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ExpedieResource extends JsonResource
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
        $client = User::find($this->client_id);

        $ville_exp = Ville::find($this->ville_exp_id);
        $agence_exp = Agence::find($this->agence_exp_id);

        $ville_dest = Ville::find($this->ville_dest_id);
        $agence_dest = Agence::find($this->agence_dest_id);

        $mode_exp = ModeExpedition::find($this->mode_exp_id);
        $delai_exp = PriceExpedition::find($this->delai_exp_id);

        $methode_paiement = MethodePaiement::find($this->methode_paiement_id);

        $reservation = User::find($this->reservation_id);
        $etape = User::find($this->etape_id);

        return [
            'id' => $this->id,
            'code' => $this->code,
            'reference' => $this->reference,

            'ville_exp' => $ville_exp ? $ville_exp->libelle : 'Non defini',
            'agence_exp' => $agence_exp ? $agence_exp->libelle : 'Non defini',

            'ville_dest' => $ville_dest ? $ville_dest->libelle : 'Non defini',
            'agence_dest' => $agence_dest ? $agence_dest->libelle : 'Non defini',

            'mode_exp' => $mode_exp ? $mode_exp->libelle : 'Non defini',
            'delai_exp' => $delai_exp ? $delai_exp->libelle : 'Non defini',

            'name_exp' => $this->name_exp,
            'phone_exp' => $this->phone_exp,
            'email_exp' => $this->email_exp,
            'adresse_exp' => $this->adresse_exp,

            'name_dest' => $this->name_dest,
            'phone_dest' => $this->phone_dest,
            'email_dest' => $this->email_dest,
            'adresse_dest' => $this->adresse_dest,


            'address' => $this->address ? $this->address : 0,
            'bp' => $this->bp ? $this->bp : 'Non defini',
            'bp_frais' => $this->bp_frais ? $this->bp_frais : 0,

            'amount' => $this->amount,
            'nbre_colis' => $this->nbre_colis ? $this->nbre_colis : 0,

            'methode_paiement' => $methode_paiement ? $methode_paiement->libelle : 'Non defini',
            'reservation' => $reservation ? $reservation->code : 'Non defini',
            'etape' => $etape ? $etape->libelle : 'Non defini',
            

            'agent' => $agent ? $agent->name : 'Non defini',
            'client' => $client ? $client->name : 'Non defini',

            'status' => $this->status,
            'active' => $this->active,

            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d.m.Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
