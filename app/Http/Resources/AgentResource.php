<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Agence;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AgentResource extends JsonResource
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
        $bureau = Agence::find($this->agence_id);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'noms' => $this->noms,
            'prenoms' => $this->prenoms,
            'genre' => $this->genre,
            'email ' => $this->email ,
            'phone' => $this->phone,
            'role' => $this->role,
            'adresse' => $this->adresse,

            'bureau_id' => $this->agence_id,
            'bureau' => $bureau ? $bureau->libelle : 'Non attribué',


            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('l jS F Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
