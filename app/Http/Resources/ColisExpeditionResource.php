<?php

namespace App\Http\Resources;

use App\Models\Expedition;
use App\Models\Reservation;
use App\Models\ServiceExpedition;
use App\Models\User;
use App\Models\ColisExpedition;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ColisExpeditionResource extends JsonResource
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

        $service = ServiceExpedition::find($this->service_exp_id);
        $expedition = Expedition::find($this->expedition_id);
        $reservation = Reservation::find($this->reservation_id);

        $date = Carbon::parse($this->created_at)->translatedFormat('l jS F Y | H:i:s');
        $stringDate = Str::of($date)->toString();

        return [
            'id' => $this->id,
            'code' => $this->code,
            'libelle' => $this->libelle,
            'description' => $this->description,
            'modele' => !empty($this->service) ? $this->service->code : 'Non defini',
            'poids' => $this->poids,
            'amount' => $this->amount,

            
            'expedition' => !empty($this->expedition) ? $this->expedition->code : 'Non defini',
            'reservation' => !empty($this->reservation) ? $this->service->code : 'Non defini',

            'client' => $client ? $agent->name : 'Non defini',
            'agent' => $agent ? $agent->name : 'Non defini',

            'service_exp_id' => $this->service_exp_id,
            'expedition_id' => $this->expedition_id,
            'reservation_id' => $this->reservation_id,

            'client_id' => $this->client_id,
            'agent_id' => $this->agent_id,

            'active' => $this->active,
            'created_at' => $stringDate,
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y | H:m:s'),
        ];
    }
}
