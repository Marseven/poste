<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Agence;
use App\Models\ServiceExpedition;
use App\Models\ForfaitExpedition;
use App\Models\DelaiExpedition;
use App\Models\TarifExpedition;
use App\Models\SuiviExpedition;
use App\Models\ColisExpedition;
use App\Http\Resources\ColisExpeditionResource;
use App\Http\Resources\SuiviExpeditionResource; 
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ExpeditionResource extends JsonResource
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
        $agence = Agence::find($this->agence_id);
        $service = ServiceExpedition::find($this->service_exp_id);
        $forfait = ForfaitExpedition::find($this->forfait_exp_id);
        $delai = DelaiExpedition::find($this->delai_exp_id);
        $tarif = TarifExpedition::find($this->tarif_exp_id);

        // Get suivis of this expedition
        $suivis = SuiviExpedition::where('expedition_id', $this->id)->get();

        // Get colis of this expedition
        $colis = ColisExpedition::where('code', $this->code_aleatoire)->get();

        return [
            'id' => $this->id,
            'code_agence' => $this->code_agence,
            'code_aleatoire' => $this->code_aleatoire,
            'reference' => $this->reference,

            'agence' => $this->agence->libelle,

            'name_exp' => $this->name_exp,
            'phone_exp' => $this->phone_exp,
            'email_exp' => $this->email_exp,
            'adresse_exp' => $this->adresse_exp,

            'name_dest' => $this->name_dest,
            'phone_dest' => $this->phone_dest,
            'email_dest' => $this->email_dest,
            'adresse_dest' => $this->adresse_dest,


            'service' => $this->service->libelle,
            'forfait' => $this->forfait->libelle,
            'delai' => $this->delai->libelle,
            'tarif' => $this->tarif->libelle,
            
            'amount' => $this->amount,

            'agent' => $agent->name,

            'active' => $this->active,

            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d.m.Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
