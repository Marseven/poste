<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Agence;
use App\Models\Package;
use App\Http\Resources\PackageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class SuiviPackageResource extends JsonResource
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

        return [
            'id' => $this->id,
            'code' => $this->code,
            'position' => $this->position,
            'statut' => $this->statut,
            'rapport' => $this->rapport,

            'agent' => $agent->name,
            'package' => PackageResource::make($package),

            'active' => $this->active,

            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d.m.Y | H:m:s'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
