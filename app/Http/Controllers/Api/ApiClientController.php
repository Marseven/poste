<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

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
use App\Models\Incident;
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
use App\Models\ServiceExpedition;
use App\Models\Societe;
use App\Models\StatutExpedition;
use App\Models\SuiviExpedition;
use App\Models\TarifExpedition;
use App\Models\TempsExpedition;
use App\Models\Ville;

use App\Http\Resources\NotificationResource;
use App\Http\Resources\PackageExpeditionResource;
use App\Http\Resources\PackageResource;
use App\Http\Resources\ExpeditionResource;
use App\Http\Resources\ColisExpeditionResource;
use App\Http\Resources\SuiviExpeditionResource;
use App\Http\Resources\AgenceResource;
use App\Http\Resources\ReclamationResource;
use App\Http\Resources\IncidentResource;
use App\Models\Onesignal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Jenssegers\Agent\Facades\Agent;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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
                    'user' => Auth::user()
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
            'user' => $user_exists
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
                                'user' => $client,
                                'message' => 'Avatar modifiée avec succès !'
                            ]);
                        }
                        return response([
                            'result' => false,
                            'status' => 501,
                            'user' => $client,
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
    public function notifications(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's notifications
            $notifications = Notification::where('receiver_id', $client->id)
                ->orWhere('active', 3)
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
    public function expeditions_actives(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if ($client) {

            // Get client's expeditions
            $expeditions = Expedition::where('active', 1)->orWhere('active', 2)->orWhere('active', 3)->orderBy('id', 'DESC')->get();

            if (!empty($expeditions) || $expeditions->count() > 0) {

                return response([
                    'result' => true,
                    'status' => 200,
                    'message' => 'Liste des expeditions actives !',
                    'nbre_expeditions' => $expeditions->count(),
                    'expeditions' => ExpeditionResource::collection($expeditions),
                ]);
            }
            return response([
                'result' => false,
                'status' => 500,
                'message' => 'Aucune expedition active pour le moment !',
                'nbre_expeditions' => $expeditions->count(),
                'expeditons' => [],
            ]);
        }
        return response([
            'result' => false,
            'status' => 500,
            'nbre_expeditions' => 0,
            'expeditions' => [],
            'message' => 'Impossible d\'accéder aux expeditions actives !'
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function new_reclamation(Request $request, $user_id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_reclamation(Request $request, $user_id)
    {
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
    public function onesignal_client(Request $request)
    {
        // Check if this player or user id already exists !
        $check_player = Onesignal::where('user_id', $request->input('user_id'))->first();

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
                    'message' => 'Player ID soumis avec succès !'
                ]);
            }
            return response([
                'result' => false,
                'status' => 501,
                'message' => 'Impossible de soumettre ce Player ID !'
            ]);
        } else {
            # code...
            return response([
                'result' => false,
                'status' => 502,
                'message' => 'Ce player ID existe deja !'
            ]);
        }
    }
}
