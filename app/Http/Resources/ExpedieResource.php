<?php

namespace App\Http\Resources;

use App\Models\Etape;
use App\Models\MethodePaiement;
use App\Models\ModeExpedition;
use App\Models\PriceExpedition;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Agence;
use App\Models\Ville;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

        $reservation = Reservation::find($this->reservation_id);
        $etape = Etape::find($this->etape_id);

        $date = Carbon::parse($this->created_at)->translatedFormat('l jS F Y | H:i:s');
        $stringDate = Str::of($date)->toString();

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


            'address' => !empty($this->address) ? $this->address : 0,
            'bp' => !empty($this->bp) ? $this->bp : 'Non defini',
            'bp_frais' => !empty($this->bp_frais) ? $this->bp_frais : 0,

            'amount' => $this->amount,
            'nbre_colis' => !empty($this->nbre_colis) ? $this->nbre_colis : 0,

            'methode_paiement' => $methode_paiement ? $methode_paiement->libelle : 'Non defini',
            'reservation' => $reservation ? $reservation->code : 'Non defini',
            'etape' => $etape ? $etape->libelle : 'Non defini',
            

            'agent' => $agent ? $agent->name : 'Non defini',
            'client' => $client ? $client->name : 'Non defini',

            'status' => $this->status,
            'active' => $this->active,

            'agent_id' => $this->agent_id,
            'client_id' => $this->client_id,

            'ville_exp_id' => !empty($this->ville_exp_id) ? $this->ville_exp_id : 0,
            'agence_exp_id' => !empty($this->agence_exp_id) ? $this->agence_exp_id : 0,

            'ville_dest_id' => !empty($this->ville_dest_id) ? $this->ville_dest_id : 0,
            'agence_dest_id' => !empty($this->agence_dest_id) ? $this->agence_dest_id : 0,

            'mode_exp_id' => !empty($this->mode_exp_id) ? $this->mode_exp_id : 0,
            'delai_exp_id' => !empty($this->delai_exp_id) ? $this->delai_exp_id : 0,

            'methode_paiement_id' => !empty($this->methode_paiement_id) ? $this->methode_paiement_id : 0,

            'reservation_id' => !empty($this->reservation_id) ? $this->reservation_id : 0,
            'etape_id' => !empty($this->etape_id) ? $this->etape_id : 0,

            'created_at' => $stringDate,
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y | H:m:s'),
        ];
    }
}
