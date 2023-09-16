<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OnesignalResource extends JsonResource
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
        $utilisateur = User::find($this->user_id);
        

        return [
            'id' => $this->id,
            'player_id' => $this->player_id,
            'user_id' => $this->user_id,
            'utilisateur' => $utilisateur ? $utilisateur->name : 'Non defini',
            'role' => $utilisateur ? $utilisateur->role : 'Non defini',

            'active' => $this->active,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('l jS F Y'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('l jS F Y'),
        ];
    }
}
