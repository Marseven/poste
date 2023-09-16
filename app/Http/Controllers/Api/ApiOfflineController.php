<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\DelaiResource;
use App\Http\Resources\EtapeResource;
use App\Http\Resources\ExpedieResource;
use App\Http\Resources\MethodePaiementResource;
use App\Http\Resources\ModeExpeditionResource;
use App\Http\Resources\OnesignalResource;
use App\Http\Resources\PaiementResource;
use App\Http\Resources\PriceExpeditionResource;
use App\Http\Resources\ReclamationResource;
use App\Http\Resources\ReseauResource;
use App\Http\Resources\ServiceExpeditionResource;
use App\Http\Resources\VilleResource;
use App\Http\Resources\ZoneResource;
use App\Models\Etape;
use App\Models\ModeExpedition;
use App\Models\NotificationMobile;
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
use Faker\Factory as FakerFactory;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function messages(Request $request)
    {

        // Get messages
        $messages = NotificationMobile::where('active', 4)->orderBy('id', 'DESC')->get();

        if(!empty($messages) || $messages->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des messages identifies !',
                'nbre_messages' => $messages->count(),
                'messages' => NotificationResource::collection($messages),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucun message pour le moment !',
            'nbre_messages' => 0,
            'messages' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function methodes(Request $request)
    {

        // Get methodes
        $methodes = MethodePaiement::orderBy('id', 'DESC')->get();

        if(!empty($methodes) || $methodes->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des methodes de paiement identifies !',
                'nbre_methodes' => $methodes->count(),
                'methodes' => MethodePaiementResource::collection($methodes),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucune methode de paiement pour le moment !',
            'nbre_methodes' => 0,
            'methodes' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function etapes(Request $request)
    {

        // Get etapes
        $etapes = Etape::orderBy('id', 'DESC')->get();

        if(!empty($etapes) || $etapes->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des etapes identifies !',
                'nbre_etapes' => $etapes->count(),
                'etapes' => EtapeResource::collection($etapes),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucune etape pour le moment !',
            'nbre_etapes' => 0,
            'etapes' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delais(Request $request)
    {

        // Get delais
        $delais = DelaiExpedition::orderBy('id', 'DESC')->get();

        if(!empty($delais) || $delais->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des delais identifies !',
                'nbre_delais' => $delais->count(),
                'delais' => DelaiResource::collection($delais),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucun delai pour le moment !',
            'nbre_delais' => 0,
            'delais' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reservations(Request $request, $id)
    {

        // Get reservations
        $reservations = Reservation::where('client_id', $id)->orderBy('id', 'DESC')->get();

        if(!empty($reservations) || $reservations->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des reservations identifies !',
                'nbre_reservations' => $reservations->count(),
                'reservations' => ReservationResource::collection($reservations),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucune reservation pour le moment !',
            'nbre_reservations' => 0,
            'reservations' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function expeditions(Request $request, $id)
    {

        // Get expeditions
        $expeditions = Expedition::where('client_id', $id)->orderBy('id', 'DESC')->get();


        if(!empty($expeditions) || $expeditions->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des expeditions identifiees !',
                'nbre_expeditions' => $expeditions->count(),
                'expeditions' => ExpedieResource::collection($expeditions),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucune expedition pour le moment !',
            'nbre_expeditions' => 0,
            'expeditions' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function colis(Request $request, $id)
    {

        // Get colis
        $colis = ColisExpedition::where('client_id', $id)->orderBy('id', 'DESC')->get();

        if(!empty($colis) || $colis->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des colis identifies !',
                'nbre_colis' => $colis->count(),
                'colis' => ColisExpeditionResource::collection($colis),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucun colis pour le moment !',
            'nbre_colis' => 0,
            'colis' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notifications(Request $request, $id)
    {

        // Get notifications
        $notifications = NotificationMobile::where('receiver_id', $id)->orderBy('id', 'DESC')->get();

        if(!empty($notifications) || $notifications->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des notifications identifies !',
                'nbre_notifications' => $notifications->count(),
                'notifications' => NotificationResource::collection($notifications),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucune notification pour le moment !',
            'nbre_notifications' => 0,
            'notifications' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reclamations(Request $request, $id)
    {

        // Get reclamations
        $reclamations = Reclamation::where('client_id', $id)->orderBy('id', 'DESC')->get();

        if(!empty($reclamations) || $reclamations->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des reclamations identifies !',
                'nbre_reclamations' => $reclamations->count(),
                'reclamations' => ReclamationResource::collection($reclamations),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucune reclamation pour le moment !',
            'nbre_reclamations' => 0,
            'reclamations' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paiements(Request $request, $id)
    {

        // Get paiements
        //$paiements = Paiement::where('client_id', $id)->orderBy('id', 'DESC')->get();

        $clientId = 15; // Remplacez 123 par l'ID du client que vous souhaitez attribuer

        // Créez une instance de Faker
        $faker = FakerFactory::create();

        $paiements = Paiement::all();


        $paiements->each(function ($paiement) use ($clientId) {
            $paiement->client_id = $clientId;
            $paiement->methode_id = 2;
            $paiement->operator = 'E-Billing';
            $paiement->timeout = 120;
            $paiement->ebilling_id = Carbon::now()->timestamp;
            $paiement->transaction_id = Str::random(7);  // ebilling_id
            $paiement->expired_at = Carbon::now()->format('Y-m-d H:i:s');
            $paiement->paid_at = Carbon::now()->format('Y-m-d H:i:s');
            $paiement->save();
        });

        if(!empty($paiements) || $paiements->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des paiements identifies !',
                'nbre_paiements' => $paiements->count(),
                'paiements' => PaiementResource::collection($paiements),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucun paiement pour le moment !',
            'nbre_paiements' => 0,
            'paiements' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function utilisateurs(Request $request, $id)
    {

        // Get utilisateurs
        $utilisateurs = User::where('id', $id)->orderBy('id', 'DESC')->get();

        if(!empty($utilisateurs) || $utilisateurs->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des utilisateurs identifies !',
                'nbre_utilisateurs' => $utilisateurs->count(),
                'utilisateurs' => UserResource::collection($utilisateurs),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucun utilisateur pour le moment !',
            'nbre_utilisateurs' => 0,
            'utilisateurs' => [],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function appareils(Request $request, $id)
    {

        // Get appareils
        $appareils = Onesignal::where('user_id', $id)->orderBy('id', 'DESC')->get();

        if(!empty($appareils) || $appareils->count() > 0){

            return response([
                'result' => true, 
                'status' => 200,
                'message' => 'Liste des appareils identifies !',
                'nbre_appareils' => $appareils->count(),
                'appareils' => OnesignalResource::collection($appareils),
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Aucun appareil pour le moment !',
            'nbre_appareils' => 0,
            'appareils' => [],
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
