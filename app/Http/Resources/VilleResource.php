<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Pays;
use App\Models\Province;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class VilleResource extends JsonResource
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
        $pays = Pays::find($this->pays_id);
        $province = User::find($this->province_id);
        

        return [
            'id' => $this->id,
            'code' => $this->code,
            'libelle' => $this->libelle,

            'pays' => $pays ? $pays->libelle : 'Non defini',
            'province' => $province ? $province->libelle : 'Non defini',

            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('l jS F Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
