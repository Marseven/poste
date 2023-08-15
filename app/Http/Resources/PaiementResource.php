<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Expedition;
use App\Models\MethodePaiement;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PaiementResource extends JsonResource
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
        $expedition = Expedition::find($this->expedition_id);
        $methode = MethodePaiement::find($this->methode_id);

        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'client ' => $client ? $client->name : 'Non defini',
            'expedition' => $expedition ? $expedition->reference : 'Non defini',
            'methode' => $methode ? $methode->libelle : 'Non defini',
            
            'amount' => $this->amount,
            'description' => $this->description,
            'status' => $this->status,
            'timeout' => $this->timeout,
            'ebilling_id' => $this->ebilling_id,
            'transaction_id' => $this->transaction_id,
            'operator' => $this->operator,

            'expired_at' => Carbon::parse($this->expired_at)->diffForHumans(),
            'paid_at' => Carbon::parse($this->paid_at)->diffForHumans(),
            

            //'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->diffForHumans(),
        ];
    }
}
