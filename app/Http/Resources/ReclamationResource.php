<?php

namespace App\Http\Resources;

use App\Models\ColisExpedition;
use App\Models\Expedition;
use App\Models\Package;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ReclamationResource extends JsonResource
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

        $expedition = Expedition::find($this->expedition_id);
        $colis = ColisExpedition::find($this->colis_id);
        $depeche = Package::find($this->package_id);
        $paiement = Paiement::find($this->paiement_id);

        return [
            'id' => $this->id,
            'code' => $this->code,
            'libelle' => $this->libelle,
            'details' => $this->details,

            'agent' => $agent ? $agent->name : 'Non defini',
            'client' => $client ? $client->name : 'Non defini',

            'expedition' => $expedition ? $expedition->reference : 'Non defini',
            'colis' => $colis ? $colis->code : 'Non defini',
            'depeche' => $depeche ? $depeche->code : 'Non defini',
            'paiement' => $paiement ? $paiement->reference : 'Non defini',

            'status' => $this->status,

            'active' => $this->active,

            'expedition_id' => $this->expedition_id,
            'colis_id' => $this->colis_id,
            'package_id' => $this->package_id,
            'paiement_id' => $this->paiement_id,

            'client_id' => $this->client_id,

            'created_at' => Carbon::parse($this->created_at)->translatedFormat('l jS F Y | H:m:s'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y | H:m:s'),
        ];
    }
}
