<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Package;
use App\Models\ColisExpedition;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PackageExpeditionResource extends JsonResource
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
        $package = Package::find($this->package_id);
        $colis = ColisExpedition::find($this->colis_id);

        return [
            'id' => $this->id,
            'code' => $this->code,

            'package_code' => $package->code,
            'package_libelle' => $package->libelle,

            'colis_code' => $colis->code,
            'colis_libelle' => $colis->libelle,

            'agent' => $agent->name,

            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('l jS F Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
