<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\ModeExpeditionResource;
use App\Http\Resources\PriceExpeditionResource;
use App\Http\Resources\ReseauResource;
use App\Http\Resources\ServiceExpeditionResource;
use App\Http\Resources\VilleResource;
use App\Http\Resources\ZoneResource;
use App\Models\ModeExpedition;
use App\Models\Onesignal;
use App\Models\PriceExpedition;
use App\Models\Reseau;
use App\Models\User;
use App\Models\Adresse;
use App\Models\Agence;
use App\Models\ColisExpedition;
use App\Models\DelaiExpedition;
use App\Models\Devise;
use App\Models\DocumentExpedition;
use App\Models\Expedition;
use App\Models\FactureExpedition;
use App\Models\ForfaitExpedition;
use App\Models\MethodeExpedition;
use App\Models\MethodePaiement;
use App\Models\Mouchard;
use App\Models\Notification;
use App\Models\Package;
use App\Models\PackageExpedition;
use App\Models\Paiement;
use App\Models\ParametreGlobal;
use App\Models\ParametrePaiement;
use App\Models\ParametreSms;
use App\Models\ParametreWhatsapp;
use App\Models\Pays;
use App\Models\Province;
use App\Models\Reclamation;
use App\Models\Reservation;
use App\Models\ServiceExpedition;
use App\Models\Societe;
use App\Models\StatutExpedition;
use App\Models\SuiviExpedition;
use App\Models\SuiviPackage;
use App\Models\TarifExpedition;
use App\Models\TempsExpedition;
use App\Models\Ville;
use App\Models\Zone;

use App\Http\Resources\NotificationResource;
use App\Http\Resources\ColisExpeditionResource;
use App\Http\Resources\PackageExpeditionResource;
use App\Http\Resources\PackageResource;
use App\Http\Resources\SuiviPackageResource;
use App\Http\Resources\AgentResource;
use App\Http\Resources\AgenceResource;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\UserResource;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Jenssegers\Agent\Facades\Agent;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 

use WisdomDiala\Countrypkg\Models\Country;
use WisdomDiala\Countrypkg\Models\State;

class ApiOfflineController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agences(Request $request)
    {

        // Get agences
        $agences = Agence::orderBy('id', 'DESC')->get();

        if(!empty($agences) || $agences->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des bureaux !',
                'nbre_agences' => $agences->count(),
                'agences' => AgenceResource::collection($agences),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucun bureau pour le moment !',
            'nbre_agences' => 0,
            'agences' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function villes(Request $request)
    {

        // Get villes
        $villes = Ville::orderBy('id', 'DESC')->get();

        if(!empty($villes) || $villes->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des villes !',
                'nbre_villes' => $villes->count(),
                'villes' => VilleResource::collection($villes),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucune ville pour le moment !',
            'nbre_villes' => 0,
            'villes' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function services(Request $request)
    {

        // Get services
        $services = ServiceExpedition::orderBy('id', 'DESC')->get();

        if(!empty($services) || $services->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des services expedition !',
                'nbre_services' => $services->count(),
                'services' => ServiceExpeditionResource::collection($services),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucun service d\'expedition pour le moment !',
            'nbre_services' => 0,
            'services' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function modalites(Request $request)
    {

        // Get modalites
        $modalites = ModeExpedition::orderBy('id', 'DESC')->get();

        if(!empty($modalites) || $modalites->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des modalites d\'expedition !',
                'nbre_modalites' => $modalites->count(),
                'modalites' => ModeExpeditionResource::collection($modalites),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucune modalite d\'expedition pour le moment !',
            'nbre_modalites' => 0,
            'modalites' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function zones(Request $request)
    {

        // Get zones
        $zones = Zone::orderBy('id', 'DESC')->get();

        if(!empty($zones) || $zones->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des zones d\'expedition !',
                'nbre_zones' => $zones->count(),
                'zones' => ZoneResource::collection($zones),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucune zone d\'expedition pour le moment !',
            'nbre_zones' => 0,
            'zones' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reseaux(Request $request)
    {

        // Get reseaux
        $reseaux = Reseau::orderBy('id', 'DESC')->get();

        if(!empty($reseaux) || $reseaux->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des reseaux d\'expedition !',
                'nbre_reseaux' => $reseaux->count(),
                'reseaux' => ReseauResource::collection($reseaux),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucun reseau d\'expedition pour le moment !',
            'nbre_reseaux' => 0,
            'reseaux' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tarifications(Request $request)
    {

        // Get tarifications
        $tarifications = PriceExpedition::orderBy('id', 'DESC')->get();

        if(!empty($tarifications) || $tarifications->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des tarifications d\'expedition !',
                'nbre_tarifications' => $tarifications->count(),
                'tarifications' => PriceExpeditionResource::collection($tarifications),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucune tarification d\'expedition pour le moment !',
            'nbre_tarifications' => 0,
            'tarifications' => [],
        ]);

    }







    public function sendNotification($title, $body, $idPlayer)
    {
        $appId = 'abeaad4b-7a89-4768-9dee-683b58e4aa00';
        $restApiKey = 'OWM4NTgzZDgtZGM5MS00MTVkLTkzNDQtZWUzMjhmNjQ3ZDFm';

        $playerIds = [$idPlayer]; // Array of player_ids (device tokens)
        $notificationTitle = $title;
        $notificationBody = $body;

        $headers = [
            'Content-Type' => 'application/json; charset=utf-8',
            'Authorization' => 'Basic ' . $restApiKey,
        ];

        $data = [
            'app_id' => $appId,
            'include_player_ids' => $playerIds,
            'headings' => ['en' => $notificationTitle],
            'contents' => ['en' => $notificationBody],
        ];

        $response = Http::withHeaders($headers)->post('https://onesignal.com/api/v1/notifications', $data);

        return $response->json();
    }

    /**
     * Store a newly created resource in storage.
     *
     * 
     * 
     */
    public function onesignal_message($title, $body, $idPlayer)
    {
        $this->sendNotification($title, $body, $idPlayer);
    }
}
