<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Ville;
use App\Models\Agence;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PackageResource extends JsonResource
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
        $responsable = User::find($this->responsable_id);
        $agent = User::find($this->agent_id);
        $ville_origine = Ville::find($this->ville_origine_id);
        $ville_destination = Ville::find($this->ville_destination_id);
        $agence_origine = Agence::find($this->agence_origine_id);
        $agence_destination = Agence::find($this->agence_destination_id);

        return [
            'id' => $this->id,
            'code' => $this->code,
            'libelle' => $this->libelle,
            'description' => $this->description,
            'nbre_colis' => $this->nbre_colis,
            'position' => $this->position,

            'code_ville_origine' => $ville_origine->code ?? '',
            'ville_origine' => $ville_origine->libelle ?? '',

            'code_ville_destination' => $ville_destination->code ?? '',
            'ville_destination' => $ville_destination->libelle ?? '',

            'code_agence_origine' => $agence_origine->code ?? '',
            'agence_origine' => $agence_origine->libelle ?? '',

            'code_agence_destination' => $agence_destination->code ?? '',
            'agence_destination' => $agence_destination->libelle ?? '',

            'responsable' => !empty($responsable) ? $responsable->name : 'Non attribué',
            'agent' => !empty($agent) ? $agent->name : 'Non attribué',

            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('l jS F Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
