<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Expedition;
use App\Models\MethodePaiement;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

        $date = Carbon::parse($this->created_at)->translatedFormat('l jS F Y | H:i:s');
        $stringDate = Str::of($date)->toString();

        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'client' => $client ? $client->name : 'Non defini',
            'expedition' => $expedition ? $expedition->reference : 'Non defini',
            'methode' => $methode ? $methode->libelle : 'Non defini',
            
            'amount' => $this->amount,
            'description' => $this->description,
            
            'timeout' => $this->timeout,
            'ebilling_id' => $this->ebilling_id,
            'transaction_id' => $this->transaction_id,
            'operator' => $this->operator,

            'expired_at' => Str::of(Carbon::parse($this->expired_at)->diffForHumans())->toString(),
            'paid_at' => Str::of(Carbon::parse($this->paid_at)->diffForHumans())->toString(),
            
            'status' => $this->status,
            
            'client_id' => $this->client_id,
            'expedition_id' => $this->expedition_id,
            'methode_id' => $this->methode_id,
            
            'created_at' => $stringDate,
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y | H:m:s'),
        ];
    }
}
