<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


use App\Http\Resources\EtapeResource;
use App\Http\Resources\ExpedieResource;
use App\Http\Resources\UserResource;
use App\Models\Etape;
use App\Models\NotificationMobile;
use App\Models\Onesignal;
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
use App\Models\ModeExpedition;
use App\Models\MethodePaiement;
use App\Models\Incident;
use App\Models\Mouchard;
use App\Models\Notification;
use App\Models\Package;
use App\Models\PackageExpedition;
use App\Models\PriceExpedition;
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
use App\Models\TarifExpedition;
use App\Models\TempsExpedition;
use App\Models\Ville;
use App\Models\Zone;
use App\Models\Reseau;

use App\Http\Resources\NotificationResource;
use App\Http\Resources\PackageExpeditionResource;
use App\Http\Resources\PackageResource;
use App\Http\Resources\ExpeditionResource;
use App\Http\Resources\ColisExpeditionResource;
use App\Http\Resources\SuiviExpeditionResource;
use App\Http\Resources\AgenceResource;
use App\Http\Resources\ReclamationResource;
use App\Http\Resources\IncidentResource;
use App\Http\Resources\ReservationResource;

use App\Http\Resources\ZoneResource;
use App\Http\Resources\ReseauResource;
use App\Http\Resources\PaysResource;
use App\Http\Resources\ProvinceResource;
use App\Http\Resources\VilleResource;
use App\Http\Resources\ModeExpeditionResource;
use App\Http\Resources\ServiceExpeditionResource;
use App\Http\Resources\PriceExpeditionResource;
use App\Http\Resources\PaiementResource;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

use Jenssegers\Agent\Facades\Agent;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use WisdomDiala\Countrypkg\Models\Country;
use WisdomDiala\Countrypkg\Models\State;

class ApiClientController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function seconnecter(Request $request)
    {
        // Get data received
        $email = $request->input('email');
        $password = $request->input('password');

        // Get user who have this email
        $user_exists = User::where('email', $email)->first();

        if (!empty($user_exists) || $user_exists != null) {

            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'active' => 1])) {

                // Get user who have this email
                $user = Auth::user();

                // Create token
                $token = $user->createToken('Laravel Password Grant Client')->plainTextToken;

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Bienvenue !',
                    'token' => $token,
                    'user' => UserResource::make($user)
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Impossible de se connecter. Veuillez réessayer svp !',
                'user' => []
            ]);
        }
        return response([
            'result' => false,
            'status' => 501,
            'message' => 'Vos identifiants semblent incorrects. Veuillez réessayer svp !',
            'user' => []
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function creeruncompte(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->status = $request->input('status');
        $user->password = Hash::make($request->input('password'));
        $user->role = 'Client';
        $user->api_token = Str::random(100);
        $user->avatar = url("avatars/avatar.png");
        $user->active = 1;

        //var_dump($user->numero_decodeur);
        //die();

        // Check if password are same
        $new_password = $request->input('password');
        $confirm_password = $request->input('confirm_password');
        if ($new_password != $confirm_password) {
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Les mots de passe ne sont pas identiques !',
                'user' => []
            ]);
        }

        // Check if someone's get this email
        $name_exists = User::where('name', $request->input('name'))->first();
        if ($name_exists) {
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Ce nom est déjà enregistré. Veuillez en saisir un autre svp !',
                'user' => []
            ]);
        }

        // Check if someone's get this email
        $email_exists = User::where('email', $request->input('email'))->first();
        if ($email_exists) {
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Cet email est déjà enregistré. Veuillez en saisir un autre svp !',
                'user' => []
            ]);
        }

        // Check if someone's get this number's phone
        $phone_exists = User::where('phone', $request->input('phone'))->first();
        if ($phone_exists) {
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Ce numéro de téléphone est déjà enregistré. Veuillez en saisir un autre svp !',
                'user' => []
            ]);
        }

        if ($user->save()) {
            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'active' => 1])) {

                // Send SMS or notification here !

                // Create token
                $token = $user->createToken('Laravel Password Grant Client')->plainTextToken;

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Compte crée avec succès. Bienvenue sur La Poste !',
                    'token' => $token,
                    'user' => Auth::user()
                ]);
            }
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible de créer ce compte !',
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgotpassword(Request $request)
    {

        // Get data
        $email_send = $request->input('email');

        // Get user who have this email's number
        $user_exists = User::where('email', $request->input('email'))->first();
        if ($user_exists) {

            // Create code_secret
            $code_secret = Carbon::now()->timestamp;


            // Update user's secret code
            $user_exists->code_secret = $code_secret;
            if ($user_exists->save()) {

                // Send secret code to user by SMS here !
                $phone_agent = $user_exists->phone;
                $message_to_send = "Hi Mr/Mme " . $user_exists->name . ", veuillez utiliser le code de reinitialisation suivant pour changer votre mot de passe : " . $user_exists->code_secret . " !";

                $details = [
                    'title' => 'Code de reinitialisation',
                    'body' => "Hi Mr/Mme " . $user_exists->name . ", veuillez utiliser le code de reinitialisation suivant pour changer votre mot de passe : " . $user_exists->code_secret . " !"
                ];


                //\Mail::to($request->input('email'))->send(new \App\Mail\ForgotMail($details));

                return response([
                    'result' => true,
                    'status' => 200,
                    'email' => $email_send,
                    'code_reset' => $code_secret,
                    'message' => 'Cher agent, un code de réinitialisation vous a été renvoyé par email !',
                    'user' => $user_exists
                ]);
            }
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Cet email ne figure pas dans la base de données de La Poste !',
            'user' => Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetpassword(Request $request)
    {
        // Get user's who have this secret code
        $user_exists = User::where('code_secret', $request->input('code_secret'))->first();

        if ($user_exists) {

            // Check if passwords are same
            $new_password = $request->input('new_password');
            $confirm_password = $request->input('confirm_password');

            if ($new_password == $confirm_password) {

                // Prepare data to save
                $user_exists->password = Hash::make($new_password);

                if ($user_exists->save()) {

                    // Connect user
                    if (Auth::attempt(['email' => $user_exists->email, 'password' => $new_password, 'active' => 1])) {

                        //$user = Auth::user();

                        // Create token
                        $token = $user_exists->createToken('Laravel Password Grant Client')->plainTextToken;

                        return response([
                            'result' => true,
                            'status' => 200,
                            'message' => 'Mot de passe reinitialise !',
                            'token' => $token,
                            'user' => Auth::user()
                        ]);
                    }
                    return response([
                        'result' => false,
                        'status' => 500,
                        'message' => 'Impossible de se connecter. Veuillez réessayer svp !',
                        'user' => $user_exists
                    ]);
                }
                return response([
                    'result' => false,
                    'status' => 500,
                    'message' => 'Une erreur est survenue. Veuillez réessayer !',
                    'user' => $user_exists
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Les mots de passe ne sont pas identiques !',
                'user' => []
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Votre code secret est incorrect. Veuillez demander un nouveau code de réinitialisation !',
            'user' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getprofil(Request $request)
    {

        // Get user by id
        $profil = User::find($request->input('user_id'));

        if ($profil) {

            return response([
                'result' => true,
                'status' => 200,
                'message' => 'Données personnelles récupérées avec succès !',
                'user' => $profil
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible d\'accéder à vos informations personnelles !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function modifierprofil(Request $request, $user_id)
    {

        // Get agent to update firstly
        $client = User::find($user_id);

        if ($client) {

            // Data to save
            $client->name = $request->input('name');
            $client->email = $request->input('email');
            $client->phone = $request->input('phone');
            $client->adresse = $request->input('adresse');

            if ($client->save()) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Vos données personnelles ont été modifiés avec succès !',
                    'user' => $client
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Impossible de modifier vos données personnelles !'
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible de modifier vos informations personnelles !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function modifierpassword(Request $request, $user_id)
    {

        // Get agent to update firstly
        $client = User::find($user_id);

        if ($client) {

            // Verifier si les mots de passe sont identiques
            if ($request->input('new_password') == $request->input('confirm_password')) {

                // Récupérer les données du formulaire
                if (Hash::check($request->input('old_password'), $client->password)) {

                    // Preparer le mot de passe
                    $client->password = Hash::make($request->input('new_password'));

                    // Sauvergarder
                    if ($client->save()) {

                        // Redirection
                        return response([
                            'result' => true,
                            'status' => 200,
                            'message' => 'Mot de passe modifié avec succès !'
                        ]);
                    }
                    return response([
                        'result' => false,
                        'status' => 500,
                        'message' => 'Impossible de modifier votre mot de passe !'
                    ]);
                }
                return response([
                    'result' => false,
                    'status' => 500,
                    'message' => 'Votre ancien mot de passe semble incorrect !'
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Les mots de passe ne sont pas identiques !'
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible de modifier votre mot de passe !'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function modifieravatar(Request $request, $user_id)
    {

        // Get client to update firstly
        $client = User::find($user_id);

        if ($client) {

            // Récupérer le logo
            $image = $request->file('avatar');

            // Vérifier si le fichier n'est pas vide
            if ($image != null) {

                // Recuperer l'extension du fichier
                $ext = $image->getClientOriginalExtension();

                // Renommer le fichier
                $filename = rand(10000, 50000) . '.' . $ext;

                // Verifier les extensions
                if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'jfif') {

                    // Upload le fichier
                    if ($image->move(public_path('avatars'), $filename)) {

                        // Attribuer l'url
                        $client->avatar = url('avatars') . '/' . $filename;

                        // Sauvegarde
                        if ($client->save()) {

                            // Redirection
                            return response([
                                'result' => true,
                                'status' => 200,
                                'user' => UserResource::make($client),
                                'message' => 'Avatar modifiée avec succès !'
                            ]);
                        }
                        return response([
                            'result' => false,
                            'status' => 501,
                            'user' => UserResource::make($client),
                            'message' => 'Impossible de modifier votre avatar !'
                        ]);
                    }
                    return response([
                        'result' => false,
                        'status' => 502,
                        'user' => $client,
                        'message' => 'Imposible d\'uploader le fichier vers le répertoire défini !'
                    ]);
                }
                return response([
                    'result' => false,
                    'status' => 503,
                    'user' => $client,
                    'message' => 'L\'extension du fichier doit être soit du jpg ou du png !'
                ]);
            }
            return response([
                'result' => false,
                'status' => 504,
                'user' => $client,
                'message' => 'Aucun fichier téléchargé. Veuillez réessayer svp !'
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible de modifier votre avatar !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notifications(Request $request)
    {

        // Get client's notifications
        $notifications = NotificationMobile::where('receiver_id', 0)
            ->orderBy('id', 'DESC')
            ->get();

        // Count elements
        $nombre_notifs = $notifications->count();

        if (!empty($notifications) || $notifications->count() > 0) {

            return response([
                'result' => true,
                'status' => 200,
                'message' => 'Liste des notifications !',
                'nombre_notifs' => $nombre_notifs,
                'notifications' => NotificationResource::collection($notifications),
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'nombre_notifs' => $nombre_notifs,
            'message' => 'Aucune notification pour le moment !',
            'notifications' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notifications_mobile(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's notifications
            $notifications = NotificationMobile::where('receiver_id', $client->id)
                ->orderBy('id', 'DESC')
                ->get();

            // Count elements
            $nombre_notifs = $notifications->count();

            if (!empty($notifications) || $notifications->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste de vos notifications !',
                    'nombre_notifs' => $nombre_notifs,
                    'notifications' => NotificationResource::collection($notifications),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'nombre_notifs' => $nombre_notifs,
                'message' => 'Aucune notification pour le moment !',
                'notifications' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible d\'accéder à vos notifications !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function expeditions(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's expeditions
            $expeditions = Expedition::where('client_id', $client->id)->orderBy('id', 'DESC')->get();

            if (!empty($expeditions) || $expeditions->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste des expeditions !',
                    'nbre_expeditions' => $expeditions->count(),
                    'expeditions' => ExpedieResource::collection($expeditions),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucune expedition pour le moment !',
                'nbre_expeditions' => $expeditions->count(),
                'expeditons' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'nbre_expeditions' => 0,
            'expeditions' => [],
            'message' => 'Impossible d\'accéder aux expeditions !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function expeditions_completes(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's expeditions
            $expeditions = Expedition::where('active', 4)->orderBy('id', 'DESC')->get();

            if (!empty($expeditions) || $expeditions->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste des expeditions completes !',
                    'nbre_expeditions' => $expeditions->count(),
                    'expeditions' => ExpeditionResource::collection($expeditions),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucune expedition complete pour le moment !',
                'nbre_expeditions' => $expeditions->count(),
                'expeditons' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'nbre_expeditions' => 0,
            'expeditions' => [],
            'message' => 'Impossible d\'accéder aux expeditions completes !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function colis_expedition(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get code expedition
            $code_expedition = $request->input('code_expedition');

            // Get client's colis
            $colis = ColisExpedition::where('code',  $code_expedition)->get();

            if (!empty($colis) || $colis->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste des colis de cette expedition !',
                    'colis' => ColisExpeditionResource::collection($colis),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucun colis pour le moment !',
                'colis' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible d\'accéder aux colis de cette expedition !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function expedition_colis(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's colis
            $colis = ColisExpedition::where('expedition_id', $request->input('expedition_id'))->get();

            if (!empty($colis) || $colis->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste des colis de cette expedition !',
                    'colis' => ColisExpeditionResource::collection($colis),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucun colis pour le moment !',
                'colis' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible d\'accéder aux colis de cette expedition !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reservation_colis(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's colis
            $colis = ColisExpedition::where('reservation_id', $request->input('reservation_id'))->get();

            if (!empty($colis) || $colis->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste des colis de cette reservation !',
                    'colis' => ColisExpeditionResource::collection($colis),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucun colis pour le moment !',
                'colis' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible d\'accéder aux colis de cette reservation !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function suivi_expedition(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get id expedition
            $id_expedition = $request->input('id_expedition');

            // Get client's suivis
            $suivis = SuiviExpedition::where('expedition_id',  $id_expedition)->get();

            if (!empty($suivis) || $suivis->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Historique de cette expedition !',
                    'historique' => SuiviExpeditionResource::collection($suivis),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucun mouvement pour le moment !',
                'historique' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible d\'accéder au suivi de cette expedition !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detail_colis(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get colis by id
            $colis = ColisExpedition::find($request->input('colis_id'));

            if ($colis) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Détails colis !',
                    'colis' => ColisExpeditionResource::make($colis), // When you get only one element and not a collection
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Impossible d\'accéder aux détails de ce colis !'
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous d\'accéder aux détails de ce colis !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function track_expedition(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get expedition by id or code
            $expedition = Expedition::where('code_aleatoire', $request->input('expedition_code'))->first();

            if ($expedition) {

                // Get code of this expedition
                $code_expedition = $expedition->code;

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Détails expedition !',
                    'expedition' => ExpeditionResource::make($expedition), // When you get only one element and not a collection
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Impossible d\'accéder aux détails de cette expedition !'
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous d\'accéder aux détails de cette expedition !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function new_expedition(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Check mode expedition
            $bp = $request->input('boite_postale');
            if (!empty($bp)) {

                $expedition = new Expedition();

                // Get agence's codes
                $bureau_origine = Agence::find($request->input('agence_exp_id'));
                $bureau_destination = Agence::find($request->input('agence_dest_id'));

                // Data to save
                $expedition->code = $request->input('code');
                $expedition->reference = $bureau_origine->code . '.' . $request->input('code') . '.' . $bureau_destination->code;

                $expedition->ville_exp_id = $request->input('ville_exp_id');
                $expedition->agence_exp_id = $request->input('agence_exp_id');

                $expedition->ville_dest_id = $request->input('ville_dest_id');
                $expedition->agence_dest_id = $request->input('agence_dest_id');

                $expedition->name_exp = $request->input('name_exp');
                $expedition->phone_exp = $request->input('phone_exp');
                $expedition->email_exp = $request->input('email_exp');
                $expedition->adresse_exp = $request->input('adresse_exp');

                $expedition->name_dest = $request->input('name_dest');
                $expedition->phone_dest = $request->input('phone_dest');
                $expedition->email_dest = $request->input('email_dest');
                $expedition->adresse_dest = $request->input('adresse_dest');

                $expedition->bp = $request->input('bp');
                $expedition->bp_frais = intval(1500);
                $expedition->amount = intval(1500);

                $expedition->nbre_colis = 0;

                $expedition->mode_exp_id = $request->input('mode_exp_id');

                $expedition->client_id = $request->input('client_id');

                $expedition->active = 0;
                $expedition->status = 0;

                if ($expedition->save()) {

                    return response([
                        'result' => true,
                        'status' => 200,
                        'message' => 'Nouvelle reservation effectuee !',
                        'expedition' => ExpeditionResource::make($expedition),
                    ]);
                }
                return response([
                    'result' => false,
                    'status' => 500,
                    'message' => 'Impossible de soumettre votre expedition pour le moment !',
                    'expedition' => [],
                ]);
            } else {

                $expedition = new Expedition();

                // Get agence's codes
                $bureau_origine = Agence::find($request->input('agence_exp_id'));
                $bureau_destination = Agence::find($request->input('agence_dest_id'));

                // Data to save
                $expedition->code = $request->input('code');
                $expedition->reference = $bureau_origine->code . '.' . $request->input('code') . '.' . $bureau_destination->code;

                $expedition->ville_exp_id = $request->input('ville_exp_id');
                $expedition->agence_exp_id = $request->input('agence_exp_id');

                $expedition->ville_dest_id = $request->input('ville_dest_id');
                $expedition->agence_dest_id = $request->input('agence_dest_id');

                $expedition->name_exp = $request->input('name_exp');
                $expedition->phone_exp = $request->input('phone_exp');
                $expedition->email_exp = $request->input('email_exp');
                $expedition->adresse_exp = $request->input('adresse_exp');

                $expedition->name_dest = $request->input('name_dest');
                $expedition->phone_dest = $request->input('phone_dest');
                $expedition->email_dest = $request->input('email_dest');
                $expedition->adresse_dest = $request->input('adresse_dest');

                $expedition->amount = 0;

                $expedition->nbre_colis = 0;

                $expedition->mode_exp_id = $request->input('mode_exp_id');

                $expedition->client_id = $request->input('client_id');

                $expedition->active = 0;
                $expedition->status = 0;

                if ($expedition->save()) {

                    return response([
                        'result' => true,
                        'status' => 200,
                        'message' => 'Nouvelle reservation effectuee !',
                        'expedition' => ExpeditionResource::make($expedition),
                    ]);
                }
                return response([
                    'result' => false,
                    'status' => 500,
                    'message' => 'Impossible de soumettre votre expedition pour le moment !',
                    'expedition' => [],
                ]);
            }
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous de soumettre votre expedition !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function new_colis(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Check reservation
            $reservation = Reservation::find($request->input('reservation_id'));
            if (!empty($reservation)) {

                $colis = new ColisExpedition();

                // Data to save
                $colis->code = $request->input('code');

                $colis->service_exp_id = $request->input('service_exp_id');

                $colis->libelle = $request->input('libelle');
                $colis->description = $request->input('description');

                $colis->type = $request->input('type');
                $colis->poids = $request->input('poids');
                $colis->longeur = $request->input('longeur');
                $colis->largeur = $request->input('largeur');
                $colis->hauteur = $request->input('hauteur');

                $colis->amount = $request->input('amount');

                $colis->reservation_id = $request->input('reservation_id');

                $colis->client_id = $request->input('client_id');

                $colis->active = 0;
                $colis->status = 0;

                if ($colis->save()) {

                    // Update reservation
                    $reservation = Reservation::find($request->input('reservation_id'));
                    $reservation->amount += $colis->amount;
                    $reservation->nbre_colis += 1;
                    $reservation->save();

                    return response([
                        'result' => true,
                        'status' => 200,
                        'message' => 'Nouveau colis ajoute !',
                        'reservation' => ReservationResource::make($reservation),
                        'colis' => ColisExpeditionResource::make($colis),
                    ]);
                }
                return response([
                    'result' => false,
                    'status' => 500,
                    'message' => 'Impossible de soumettre votre colis pour le moment !',
                    'reservation' => [],
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Impossible de soumettre votre expedition pour le moment !',
                'reservation' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous de soumettre votre reservation !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function supprimer_colis(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if ($agent) {

            // Get expedition by id
            $expedition = Expedition::find($request->input('expedition_id'));

            if (!empty($expedition)) {

                // Get data
                $expedition_id = intval($expedition->id);
                $colis_id = intval($expedition->colis_id);

                // Update package
                $expedition->nbre_colis -= 1;
                $expedition->save();

                // Update colis
                $colis = ColisExpedition::find($colis_id);
                $colis->delete();

                // Reponse
                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Colis supprime avec succès !'
                ]);
            }
            return response([
                'result' => false,
                'status' => 501,
                'message' => 'Impossible de supprimer ce colis a ce package !'
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous de supprimer ce colis a ce package !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_expedition(Request $request, $user_id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search_expedition(Request $request, $user_id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_expedition(Request $request, $user_id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reclamations(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's reclamations
            $reclamations = Reclamation::where('client_id', $client->id)
                ->orderBy('id', 'DESC')
                ->get();

            // Count elements
            $nombre_reclamations = $reclamations->count();

            if (!empty($reclamations) || $reclamations->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste de vos reclamations !',
                    'nombre_reclamations' => $nombre_reclamations,
                    'reclamations' => ReclamationResource::collection($reclamations),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'nombre_reclamations' => $nombre_reclamations,
                'message' => 'Aucune reclamation pour le moment !',
                'reclamations' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible d\'accéder à vos reclamations !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function new_reclamation(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            $reclamation = new Reclamation();
            $reclamation->code = $request->input('code');
            $reclamation->libelle = $request->input('libelle');
            $reclamation->details = $request->input('details');
            $reclamation->client_id = $request->input('client_id');
            $reclamation->status = 0;
            $reclamation->active = 0;

            if ($reclamation->save()) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Reclamation envoyée avec succès !',
                    'reclamation' => ReclamationResource::make($reclamation)
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Impossible de créer ce compte !',
                'reclamation' => $reclamation
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous d\'effectuer cette operation !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paie_reclamation(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            $reclamation = new Reclamation();
            $reclamation->code = $request->input('code');
            $reclamation->libelle = $request->input('libelle');
            $reclamation->details = $request->input('details');
            $reclamation->client_id = $request->input('client_id');
            $reclamation->paiement_id = $request->input('paiement_id');
            $reclamation->status = 0;
            $reclamation->active = 0;

            if ($reclamation->save()) {

                // Update paiement
                $paiement = Paiement::find($request->input('paiement_id'));
                if (!empty($paiement) || $paiement != null) {

                    // Change status
                    $paiement->status = 1;
                    $paiement->save();

                    return response([
                        'result' => true,
                        'status' => 200,
                        'message' => 'Reclamation envoyée avec succès !',
                        'reclamation' => ReclamationResource::make($reclamation)
                    ]);
                }
                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Reclamation envoyée avec succès !',
                    'reclamation' => ReclamationResource::make($reclamation)
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Impossible de créer ce compte !',
                'reclamation' => $reclamation
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous d\'effectuer cette operation !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exp_reclamation(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            $reclamation = new Reclamation();
            $reclamation->code = $request->input('code');
            $reclamation->libelle = $request->input('libelle');
            $reclamation->details = $request->input('details');
            $reclamation->client_id = $request->input('client_id');
            $reclamation->expedition_id = $request->input('expedition_id');
            $reclamation->status = 0;
            $reclamation->active = 0;

            if ($reclamation->save()) {

                // Update expedition
                $expedition = Expedition::find($request->input('expedition_id'));
                if (!empty($expedition) || $expedition != null) {

                    // Change status
                    $expedition->status = 1;
                    $expedition->save();

                    return response([
                        'result' => true,
                        'status' => 200,
                        'message' => 'Reclamation envoyée avec succès !',
                        'reclamation' => ReclamationResource::make($reclamation)
                    ]);
                }
                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Reclamation envoyée avec succès !',
                    'reclamation' => ReclamationResource::make($reclamation)
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Impossible de créer ce compte !',
                'reclamation' => $reclamation
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous d\'effectuer cette operation !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_reclamation(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            $reclamation = Reclamation::find($request->input('reclamation_id'));

            if (!empty($reclamation) || $reclamation != null) {

                //$reclamation->code = $request->input('code');
                $reclamation->libelle = $request->input('libelle');
                $reclamation->details = $request->input('details');
                $reclamation->client_id = $request->input('client_id');
                $reclamation->status = 0;
                $reclamation->active = 0;

                if ($reclamation->save()) {

                    return response([
                        'result' => true,
                        'status' => 200,
                        'message' => 'Reclamation modifiée avec succès !',
                        'reclamation' => ReclamationResource::make($reclamation)
                    ]);
                }
                return response([
                    'result' => false,
                    'status' => 500,
                    'message' => 'Impossible de modifier cette reclamation !',
                    'reclamation' => ReclamationResource::make($reclamation)
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Impossible pour vous d\'effectuer cette operation !'
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous d\'effectuer cette operation !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search_reclamation(Request $request, $user_id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_reclamation(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            $reclamation = Reclamation::find($request->input('reclamation_id'));

            if (!empty($reclamation) || $reclamation != null) {

                if ($reclamation->delete()) {

                    return response([
                        'result' => true,
                        'status' => 200,
                        'message' => 'Reclamation supprimée avec succès !',
                        'reclamation' => ReclamationResource::make($reclamation)
                    ]);
                }
                return response([
                    'result' => false,
                    'status' => 500,
                    'message' => 'Impossible de supprimer cette reclamation !',
                    'reclamation' => ReclamationResource::make($reclamation)
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Impossible pour vous d\'effectuer cette operation !'
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous d\'effectuer cette operation !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detail_reclamation(Request $request, $user_id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reservations(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's reservations
            $reservations = Reservation::where('client_id', $client->id)
                ->orderBy('id', 'DESC')
                ->get();

            // Count elements
            $nombre_reservations = $reservations->count();

            if (!empty($reservations) || $reservations->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste de vos reservations !',
                    'nombre_reservations' => $nombre_reservations,
                    'reservations' => ReservationResource::collection($reservations),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'nombre_reservations' => $nombre_reservations,
                'message' => 'Aucune reservation pour le moment !',
                'reservations' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible d\'accéder à vos reservations !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function new_reservation(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            $reservation = new Reservation();

            $reservation->code = $request->input('code');

            $reservation->ville_origine_id = $request->input('ville_origine_id');
            $reservation->ville_destination_id = $request->input('ville_destination_id');

            $reservation->mode_expedition_id = $request->input('mode_expedition_id');
            $reservation->mode_livraison = $request->input('mode_livraison');
            $reservation->boite_postale = $request->input('boite_postale');
            $reservation->adresse_livraison = $request->input('adresse_livraison');

            $reservation->name_exp = $request->input('name_exp');
            $reservation->email_exp = $request->input('email_exp');
            $reservation->phone_exp = $request->input('phone_exp');

            $reservation->name_dest = $request->input('name_dest');
            $reservation->email_dest = $request->input('email_dest');
            $reservation->phone_dest = $request->input('phone_dest');

            //$reservation->nbre_colis = $request->input('nbre_colis');
            $reservation->frais_poste = $request->input('mode_livraison') == "Oui" ? 0 : 1500.0;
            $reservation->nbre_colis = 0;

            $reservation->client_id = $request->input('client_id');

            $reservation->status = $request->input('status');
            $reservation->active = 0;

            if ($reservation->save()) {

                // Send notification
                $idPlayer = $request->input('player_id');
                $title = "Nouvelle Reservation";
                $body = "Votre reservation a ete soumis avec succes";
                $this->sendNotification($title, $body, $idPlayer);

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Reservation envoyée avec succès !',
                    'reservation_id' => $reservation->id,
                    'reservation' => ReservationResource::make($reservation)
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Impossible de créer ce compte !',
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous d\'effectuer cette operation !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function colis(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's colis
            $colis = ColisExpedition::where('client_id', $client->id)
                ->orderBy('id', 'DESC')
                ->get();

            // Count elements
            $nombre_colis = $colis->count();

            if (!empty($colis) || $colis->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste de vos colis !',
                    'nombre_colis' => $nombre_colis,
                    'colis' => ColisExpeditionResource::collection($colis),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'nombre_colis' => $nombre_colis,
                'message' => 'Aucun colis pour le moment !',
                'colis' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible d\'accéder à vos colis !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function colis_reservation(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Check reservation
            $reservation = Reservation::find($request->input('reservation_id'));
            if (!empty($reservation)) {

                // Get price expedition
                //$tarification = PriceExpedition::find($request->input('price_expedition_id'));

                $colis = new ColisExpedition();

                // Data to save
                $colis->code = $request->input('code');

                $colis->service_exp_id = $request->input('service_exp_id');

                $colis->libelle = $request->input('libelle');
                $colis->description = $request->input('description');

                $colis->type = $request->input('type');
                $colis->poids = $request->input('poids');

                $colis->longeur = 0.00;
                $colis->largeur = 0.00;
                $colis->hauteur = 0.00;

                $colis->amount = $request->input('amount');

                //$colis->price_expedition_id = $request->input('price_expedition_id');
                $colis->reservation_id = $request->input('reservation_id');

                $colis->client_id = $request->input('client_id');

                $colis->active = 0;
                $colis->status = 0;

                if ($colis->save()) {

                    // Update reservation
                    $reservation = Reservation::find($request->input('reservation_id'));
                    $reservation->amount += $colis->amount;
                    $reservation->nbre_colis += 1;
                    $reservation->save();

                    return response([
                        'result' => true,
                        'status' => 200,
                        'message' => 'Nouveau colis ajoute !',
                        'reservation' => ReservationResource::make($reservation),
                        'colis' => ColisExpeditionResource::make($colis),
                    ]);
                }
                return response([
                    'result' => false,
                    'status' => 500,
                    'message' => 'Impossible de soumettre votre colis pour le moment !',
                    'reservation' => [],
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Impossible de soumettre votre reservation pour le moment !',
                'reservation' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous de soumettre votre reservation !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detail_tarif(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get tarif by id
            $tarif = PriceExpedition::where('service_id', $request->input('service_id'))
                ->where('weight', $request->input('weight'))
                ->first();

            if ($tarif) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Détails tarif !',
                    'prix' => $tarif->price,
                    'tarification' => PriceExpeditionResource::make($tarif), // When you get only one element and not a collection
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'type' => $tarif->libelle,
                'message' => 'Impossible d\'accéder aux détails de ce tarif !'
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous d\'accéder aux détails de ce tarif !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detail_mode_expedition(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get mode_expedition by id
            $mode_expedition = ModeExpedition::find($request->input('mode_expedition_id'));

            if ($mode_expedition) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Détails mode expedition !',
                    'mode_expedition' => $mode_expedition->libelle,
                    'mode' => ModeExpeditionResource::make($mode_expedition), // When you get only one element and not a collection
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'mode_expedition' => $mode_expedition->libelle,
                'message' => 'Impossible d\'accéder aux détails de ce mode_expedition !'
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous d\'accéder aux détails de ce mode_expedition !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detail_ville(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get ville by id
            $ville = Ville::find($request->input('ville_id'));

            if ($ville) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Détails ville !',
                    'ville' => $ville->libelle,
                    'town' => VilleResource::make($ville), // When you get only one element and not a collection
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'ville' => $ville->libelle,
                'message' => 'Impossible d\'accéder aux détails de cette ville !'
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible pour vous d\'accéder aux détails de cette ville !'
        ]);
    }















    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reseaux(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's reseaux
            $reseaux = Reseau::orderBy('id', 'DESC')->get();

            if (!empty($reseaux) || $reseaux->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 202,
                    'message' => 'Liste des reseaux !',
                    'nbre_reseaux' => $reseaux->count(),
                    'reseaux' => ReseauResource::collection($reseaux),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucun reseau pour le moment !',
                'nbre_reseaux' => 0,
                'reseaux' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'nbre_reseaux' => 0,
            'reseaux' => [],
            'message' => 'Impossible d\'accéder aux reseaux !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function zones(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's zones
            $zones = Zone::where('reseau_id', $request->input('reseau_id'))->orderBy('id', 'DESC')->get();

            if (!empty($zones) || $zones->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste des zones !',
                    'nbre_zones' => $zones->count(),
                    'zones' => ZoneResource::collection($zones),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucune zone pour le moment !',
                'nbre_zones' => 0,
                'zones' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'nbre_zones' => 0,
            'expeditions' => [],
            'message' => 'Impossible d\'accéder aux zones !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function countries(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's countries
            $countries = Pays::orderBy('name', 'asc')->get();

            if (!empty($countries) || $countries->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste des pays !',
                    'nbre_countries' => $countries->count(),
                    'countries' => PaysResource::collection($countries),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucun pays pour le moment !',
                'nbre_countries' => 0,
                'countries' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'nbre_countries' => 0,
            'countries' => [],
            'message' => 'Impossible d\'accéder aux pays !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function provinces(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's provinces
            $provinces = Province::where('pays_id', $request->input('pays_id'))->orderBy('id', 'DESC')->get();

            if (!empty($provinces) || $provinces->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste des provinces !',
                    'nbre_provinces' => $provinces->count(),
                    'provinces' => ProvinceResource::collection($provinces),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucune province pour le moment !',
                'nbre_provinces' => 0,
                'provinces' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'nbre_provinces' => 0,
            'provinces' => [],
            'message' => 'Impossible d\'accéder aux provinces !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function villes(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's villes
            $villes = Ville::where('province_id', $request->input('province_id'))->orderBy('libelle', 'ASC')->get();

            if (!empty($villes) || $villes->count() > 0) {

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
        return response([
            'result' => false,
            'status' => 500,
            'nbre_villes' => 0,
            'villes' => [],
            'message' => 'Impossible d\'accéder aux villes !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function gabon_villes(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's villes
            $villes = Ville::whereIn('province_id', [1, 2, 3, 4, 5, 6, 7, 8, 9])->orderBy('id', 'DESC')->get();

            if (!empty($villes) || $villes->count() > 0) {

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
        return response([
            'result' => false,
            'status' => 500,
            'nbre_villes' => 0,
            'villes' => [],
            'message' => 'Impossible d\'accéder aux villes !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function gabon_villes_origines(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's villes
            $villes = Ville::whereIn('province_id', [1, 2, 3, 4, 5, 6, 7, 8, 9])->orderBy('id', 'DESC')->get();

            if (!empty($villes) || $villes->count() > 0) {

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
        return response([
            'result' => false,
            'status' => 500,
            'nbre_villes' => 0,
            'villes' => [],
            'message' => 'Impossible d\'accéder aux villes !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function gabon_villes_destinations(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's villes
            $villes = Ville::where('pays_id', 1)->orderBy('id', 'DESC')->get();

            if (!empty($villes) || $villes->count() > 0) {

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
        return response([
            'result' => false,
            'status' => 500,
            'nbre_villes' => 0,
            'villes' => [],
            'message' => 'Impossible d\'accéder aux villes !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agences(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's agences
            $agences = Agence::orderBy('id', 'DESC')->get();

            if (!empty($agences) || $agences->count() > 0) {

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
        return response([
            'result' => false,
            'status' => 500,
            'nbre_agences' => 0,
            'agences' => [],
            'message' => 'Impossible d\'accéder aux bureaux !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function modes_expeditions(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's modes_expeditions
            $modes_expeditions = ModeExpedition::orderBy('id', 'DESC')->get();

            if (!empty($modes_expeditions) || $modes_expeditions->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste des modes expedition !',
                    'nbre_modes_expeditions' => $modes_expeditions->count(),
                    'modes_expeditions' => ModeExpeditionResource::collection($modes_expeditions),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucun mode expedition pour le moment !',
                'nbre_modes_expeditions' => 0,
                'modes_expeditions' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'nbre_modes_expeditions' => 0,
            'agences' => [],
            'message' => 'Impossible d\'accéder aux modes expedition !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function services_expeditions(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's services_expeditions
            $services_expeditions = ServiceExpedition::orderBy('id', 'DESC')->get();

            if (!empty($services_expeditions) || $services_expeditions->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste des services expedition !',
                    'nbre_services_expeditions' => $services_expeditions->count(),
                    'services_expeditions' => ServiceExpeditionResource::collection($services_expeditions),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucun service expedition pour le moment !',
                'nbre_services_expeditions' => 0,
                'services_expeditions' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'nbre_services_expeditions' => 0,
            'agences' => [],
            'message' => 'Impossible d\'accéder aux services expedition !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function prices_expeditions(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's prices_expeditions
            $prices_expeditions = PriceExpedition::where('service_id', $request->input('service_id'))->orderBy('id', 'DESC')->get();

            if (!empty($prices_expeditions) || $prices_expeditions->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste des tarifs expedition !',
                    'nbre_prices_expeditions' => $prices_expeditions->count(),
                    'prices_expeditions' => PriceExpeditionResource::collection($prices_expeditions),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucun tarif expedition pour le moment !',
                'nbre_prices_expeditions' => 0,
                'prices_expeditions' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'nbre_prices_expeditions' => 0,
            'agences' => [],
            'message' => 'Impossible d\'accéder aux tarifs expedition !'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paiements(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's paiements
            $paiements = Paiement::where('client_id', $client->id)
                ->orderBy('id', 'DESC')
                ->get();

            // Count elements
            $nombre_paiements = $paiements->count();

            if (!empty($paiements) || $paiements->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste de vos paiements !',
                    'nombre_paiements' => $nombre_paiements,
                    'paiements' => PaiementResource::collection($paiements),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'nombre_paiements' => $nombre_paiements,
                'message' => 'Aucun paiement pour le moment !',
                'paiements' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'message' => 'Impossible d\'accéder à vos paiements !'
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function etapes(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's etapes
            $etapes = Etape::orderBy('id', 'DESC')->get();

            if (!empty($etapes) || $etapes->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 202,
                    'message' => 'Liste des etapes !',
                    'nbre_etapes' => $etapes->count(),
                    'etapes' => EtapeResource::collection($etapes),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucune etape pour le moment !',
                'nbre_etapes' => 0,
                'reseaux' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'nbre_etapes' => 0,
            'etapes' => [],
            'message' => 'Impossible d\'accéder aux etapes !'
        ]);
    }











    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendNotification($title, $body, $idPlayer)
    {
        $appId = '6e26c563-30e7-4296-b6de-2a22098bc16b';
        $restApiKey = 'ZWUyMTgzN2ItOGZkYi00MTFiLTk1NTctMGVjMDJhNDk5ZDVk';

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function onesignal_client(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Check if this player or user id already exists !
            //$check_player = Onesignal::where('player_id', $request->input('player_id'))->orWhere('user_id', $request->input('user_id'))->first();
            $check_player = Onesignal::where('player_id', $request->input('player_id'))->first();

            if (empty($check_player)) {

                // Instancier une nouvelle one signal
                $player = new Onesignal();

                // Préparer la requete
                $player->user_id = $request->input('user_id');
                $player->player_id = $request->input('player_id');
                $player->role = $request->input('role');
                $player->active = 1;

                // Sauvegarde
                if ($player->save()) {

                    // Send notification to this player
                    $title = "Bienvenue";
                    $body = "La Poste, votre agence postale en ligne";
                    $idPlayer = $request->input('player_id');
                    $this->sendNotification($title, $body, $idPlayer);

                    // Reponse
                    return response([
                        'result' => true,
                        'status' => 200,
                        'message' => 'La Poste, votre agence postale en ligne !'
                    ]);
                }
                return response([
                    'result' => false,
                    'status' => 501,
                    'message' => 'La Poste - pour vous servir ** !'
                ]);
            } else {
                # code...
                return response([
                    'result' => false,
                    'status' => 502,
                    'message' => 'La Poste - pour vous servir *** !'
                ]);
            }
        }
        return response([
            'result' => false,
            'status' => 500,
            'nbre_etapes' => 0,
            'etapes' => [],
            'message' => 'Impossible d\'accéder aux etapes !'
        ]);
    }
}
