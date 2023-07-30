<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AgenceResource extends JsonResource
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
        

        return [
            'id' => $this->id,
            'code' => $this->code,
            'libelle' => $this->libelle,
            'phone' => $this->phone,
            'ville' => $this->ville,

            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('l jS F Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
