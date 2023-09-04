<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\ReservationResource;
use App\Http\Resources\UserResource;
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

use App\Http\Resources\NotificationResource;
use App\Http\Resources\ColisExpeditionResource;
use App\Http\Resources\PackageExpeditionResource;
use App\Http\Resources\PackageResource;
use App\Http\Resources\SuiviPackageResource;
use App\Http\Resources\AgentResource;
use App\Http\Resources\AgenceResource;


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

class ApiAgentController extends Controller
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

        if(!empty($user_exists) || $user_exists != null){

            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'active' => 1])) {

		        // Get user who have this email
		        $user = Auth::user();

		        // Create token
            	$token = $user->createToken('Laravel Password Grant User')->plainTextToken;
            
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
                'message' => 'Impossible de se conntecter. Veuillez réessayer svp !',
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
    public function forgotpassword(Request $request)
    {

    	// Get data
    	$email_send = $request->input('email');

        // Get user who have this email's number
        $user_exists = User::where('email', $request->input('email'))->first();
        if($user_exists){

            // Create code_secret
            $code_secret = Carbon::now()->timestamp;
                                

            // Update user's secret code 
            $user_exists->code_secret = $code_secret;
            if($user_exists->save()){

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

        if($user_exists){

            // Check if passwords are same 
            $new_password = $request->input('new_password');
            $confirm_password = $request->input('confirm_password');

            if($new_password == $confirm_password){

                // Prepare data to save
                $user_exists->password = Hash::make($new_password);

                if($user_exists->save()){

                    // Connect user
                    if (Auth::attempt(['email' => $user_exists->email, 'password' => $new_password, 'active' => 1])) {
            
                        return response([
                            'result' => true, 
                            'status' => 200,
                            'message' => 'Bienvenue sur La Poste !',
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
                'user' => $user_exists
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

        if($profil){

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
        $agent = User::find($user_id);

        if($agent){

            // Data to save
            $agent->name = $request->input('name');
            $agent->email = $request->input('email');
            $agent->phone = $request->input('phone');
            $agent->adresse = $request->input('adresse');

            if($agent->save()){

                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Vos données personnelles ont été modifiés avec succès !',
                    'user' => $agent
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
        $agent = User::find($user_id);

        if($agent){

            // Verifier si les mots de passe sont identiques
            if($request->input('new_password') == $request->input('confirm_password')){

                // Récupérer les données du formulaire
                if (Hash::check($request->input('old_password'), $agent->password)) {

                    // Preparer le mot de passe
                    $agent->password = Hash::make($request->input('new_password'));

                    // Sauvergarder 
                    if($agent->save()){

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notifications(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get client's notifications
            $notifications = Notification::where('receiver_id', $agent->id)
            ->orWhere('active', 3)
            ->orderBy('id', 'DESC')
            ->get();

            // Count elements
            $nombre_notifs = $notifications->count();

            if(!empty($notifications) || $notifications->count() > 0){

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
    public function agents_actives(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        // Get bureau by id
        $bureau = Agence::where('libelle', $request->input('bureau'))->first();

        if($agent){

            // Get agents
            $agents = User::where('active', 1)
            ->where('role', 'Agent')
            ->where('agence_id', $bureau->id)
            ->orderBy('id', 'DESC')->get();

            if(!empty($agents) || $agents->count() > 0){

                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Liste des agents actifs !',
                    'nbre_agents' => $agents->count(),
                    'agents' => AgentResource::collection($agents),
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Aucun agent actif pour le moment !',
                'nbre_agents' => $agents->count(),
                'agents' => [],
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'nbre_packages' => 0,
            'message' => 'Impossible d\'accéder aux agents actifs !'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bureaux_actives(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get bureaux
            $bureaux = Agence::where('active', 1)->orderBy('id', 'DESC')->get();

            if(!empty($bureaux) || $bureaux->count() > 0){

                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Liste des bureaux actifs !',
                    'nbre_bureaux' => $bureaux->count(),
                    'bureaux' => AgenceResource::collection($bureaux),
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Aucun bureau actif pour le moment !',
                'nbre_bureaux' => $bureaux->count(),
                'bureaux' => [],
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'nbre_bureaux' => 0,
            'message' => 'Impossible d\'accéder aux bureaux actifs !'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function packages_actives(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get agent's packages
            $packages = Package::where('active', 0)->orWhere('active', 1)->orWhere('active', 2)->orWhere('active', 3)->orderBy('id', 'DESC')->get();

            if(!empty($packages) || $packages->count() > 0){

                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Liste des packages actifs !',
                    'nbre_packages' => $packages->count(),
                    'packages' => PackageResource::collection($packages),
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Aucun package actif pour le moment !',
                'nbre_packages' => $packages->count(),
                'packages' => [],
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'nbre_packages' => 0,
            'message' => 'Impossible d\'accéder aux packages actifs !'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function packages_completes(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get agent's packages
            $packages = Package::where('active', 4)->orderBy('id', 'DESC')->get();

            if(!empty($packages) || $packages->count() > 0){

                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Liste des packages completes !',
                    'packages' => PackageResource::collection($packages),
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Aucun package complete pour le moment !',
                'packages' => [],
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible d\'accéder aux packages actifs !'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function today_colis(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get agent's colis
            $colis = ColisExpedition::where('created_at', '=', Carbon::today())->get();

            if(!empty($colis) || $colis->count() > 0){

                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Liste des colis du jour !',
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
            'message' => 'Impossible d\'accéder aux colis du jour !'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function today_packages_expedition(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get agent's packages expedition
            $expeditions = PackageExpedition::where('created_at', '=', Carbon::today())->get();

            if(!empty($expeditions) || $expeditions->count() > 0){

                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Liste des expeditions du jour !',
                    'expeditions' => PackageExpedition::collection($expeditions),
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Aucune expedition pour le moment !',
                'colis' => [],
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible d\'accéder aux expeditions du jour !'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assign_colis(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

	        // Instancier une nouvelle expedition
	        $expedition = new PackageExpedition();

	        // Check ids
	        $package = Package::find($request->input('package_id'));
	        $colis = ColisExpedition::find($request->input('colis_id'));

            // Get expedition
            $this_expedition = Expedition::find($colis->expedition_id);

            // Check if not null
            if(!empty($this_expedition) && $this_expedition->status == 3 || $this_expedition->status == 4) {

                // Code
                $ext = 'EXP.';
                $code = Carbon::now()->timestamp;

                // Préparer la requete
                $expedition->code = $code .  '-' . $package->code . '-' . $colis->code;
                $expedition->package_id = $request->input('package_id');
                $expedition->colis_id = $request->input('colis_id');
                $expedition->agent_id = $request->input('agent_id');
                $expedition->active = 1;

                if (!empty($package) && !empty($colis)) {

                    // Check if you already have assign this colis
                    $check_expedition = PackageExpedition::where('colis_id', $request->input('colis_id'))->first();
                    if(empty($check_expedition)) {

                        // Sauvegarde
                        if($expedition->save()){

                            // Update package
                            $package = Package::find($request->input('package_id'));
                            $package->nbre_colis += 1;
                            $package->save();

                            // Update colis
                            $colis = ColisExpedition::find($request->input('colis_id'));
                            $colis->active = 2;
                            $colis->save();

                            // Reponse
                            return response([
                                'result' => true, 
                                'status' => 200,
                                'message' => 'Colis assigné avec succès !'
                            ]);
                        }
                        return response([
                            'result' => false, 
                            'status' => 500,
                            'message' => 'Impossible d\'assginer ce colis a ce package !'
                        ]);

                    }
                    return response([
                        'result' => false, 
                        'status' => 500,
                        'message' => 'Ce colis a deja ete assigne !'
                    ]);
                }
                return response([
                    'result' => false, 
                    'status' => 500,
                    'message' => 'Impossible d\'assigner ce colis a ce package !'
                ]);

            } 
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Impossible d\'assigner ce colis expedition !'
            ]);

	        

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous d\'assigner ce colis a ce package !'
        ]);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_colis(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get expedition by id
            $expedition = PackageExpedition::find($request->input('expedition_id'));

            if (!empty($expedition)) {

                // Get data
                $package_id = intval($expedition->package_id);
                $colis_id = intval($expedition->colis_id);

                // Update package
                $package = Package::find($package_id);
                $package->nbre_colis -= 1;
                $package->save();

                // Update colis
                $colis = ColisExpedition::find($colis_id);
                $colis->active = 1;
                $colis->save();

                // Delete
                $expedition->delete();

                // Reponse
                return response([
                    'result' => true, 
                    'status' => 200,
                    'package_id' => $request->input('package_id'),
                    'message' => 'Colis supprime avec succès !'
                ]);
            }
            return response([
                'result' => false, 
                'status' => 501,
                'package_id' => $request->input('package_id'),
                'message' => 'Impossible de supprimer ce colis a ce package !'
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'package_id' => $request->input('package_id'),
            'message' => 'Impossible pour vous de supprimer ce colis a ce package !'
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

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

	        // Get colis by id
	        $colis = ColisExpedition::where('code', $request->input('colis_code'))
	        ->orWhere('id', $request->input('colis_code'))
	        ->first();

	        if($colis){

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
    public function detail_package(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

	        // Get package by id
	        $package = Package::find($request->input('package_id'));

	        if($package){

	        	// Get package id
	        	$package_id = $package->id;

	        	// Get all expedition package
	        	$expeditions = PackageExpedition::where('package_id', $package_id)->get();

                // Get all suivi package
                $historiques = SuiviPackage::where('package_id', $package_id)->get();

	            return response([
	                'result' => true, 
	                'status' => 200,
	                'message' => 'Détails package !',
	                'package' => PackageResource::make($package), // When you get only one element and not a collection
	                'expeditions' => PackageExpeditionResource::collection($expeditions), 
                    'historiques' => SuiviPackageResource::collection($historiques), 
	            ]);

	        }
	        return response([
	            'result' => false, 
	            'status' => 500,
	            'message' => 'Impossible d\'accéder aux détails de ce package !'
	        ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous d\'accéder aux détails de ce package !'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function scan_package(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get package by id
            $package = Package::find($request->input('package_id'));

            if($package){

                // Get package id
                $package_id = $package->id;

                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Détails package !',
                    'package' => PackageResource::make($package), // When you get only one element and not a collection
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Impossible d\'accéder aux détails de ce package !'
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous d\'accéder aux détails de ce package !'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function operation_package(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get package by id
            $package = Package::find($request->input('package_id'));

            if($package){

                // Get package id
                $package_id = $package->id;


                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Détails package !',
                    'package' => PackageResource::make($package), // When you get only one element and not a collection
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Impossible d\'accéder aux détails de ce package !'
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous d\'accéder aux détails de ce package !'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function action_package(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Instancier suivi
            $suivi = new SuiviPackage();

            // Code
            $ext = 'SVP.';
            $code = Carbon::now()->timestamp;

            // Préparer la requete
            $suivi->code = $ext .  '-' . $code;
            $suivi->position = $request->input('position');
            $suivi->statut = $request->input('statut');
            $suivi->rapport = $request->input('rapport');
            $suivi->package_id = $request->input('package_id');

            $suivi->agent_id = $request->input('agent_id');
            $suivi->active = intval($request->input('active_value'));

            // Sauvegarde
            if($suivi->save()){

                // Update package
                $package = Package::find($request->input('package_id'));
                $package->position = $request->input('position');
                $package->active = intval($request->input('active_value'));
                $package->save();

                // Reponse
                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Suivi soumis avec succès !'
                ]);
            }
            return response([
                'result' => false, 
                'status' => 501,
                'message' => 'Impossible de soumettre ce suivi !'
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous de soumettre ce suivi !'
        ]);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function complete_package(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Instancier suivi
            $suivi = new SuiviPackage();

            // Code
            $ext = 'SVP.';
            $code = Carbon::now()->timestamp;

            // Préparer la requete
            $suivi->code = $ext .  '-' . $code;
            $suivi->position = $request->input('position');
            $suivi->statut = $request->input('statut');
            $suivi->rapport = $request->input('rapport');
            $suivi->package_id = $request->input('package_id');

            $suivi->agent_id = $request->input('agent_id');
            $suivi->active = intval($request->input('active_value'));

            // Sauvegarde
            if($suivi->save()){

                // Update package
                $package = Package::find($request->input('package_id'));
                $package->position = $request->input('position');
                $package->active = 4;
                $package->save();

                // Reponse
                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Suivi soumis avec succès !'
                ]);
            }
            return response([
                'result' => false, 
                'status' => 501,
                'message' => 'Impossible de soumettre ce suivi !'
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous de soumettre ce suivi !'
        ]);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function suivi_package(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Instancier suivi
            $suivi = new SuiviPackage();

            // Code
            $ext = 'SVP.';
            $code = Carbon::now()->timestamp;

            // Préparer la requete
            $suivi->code = $ext .  '-' . $code;
            $suivi->position = $request->input('position');
            $suivi->statut = $request->input('statut');
            $suivi->rapport = $request->input('rapport');
            $suivi->package_id = $request->input('package_id');

            $suivi->agent_id = $request->input('agent_id');
            $suivi->active = intval($request->input('active_value'));

            // Sauvegarde
            if($suivi->save()){

                // Update package
                $package = Package::find($request->input('package_id'));
                $package->position = $request->input('position');
                $package->save();

                // Reponse
                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Suivi soumis avec succès !'
                ]);
            }
            return response([
                'result' => false, 
                'status' => 501,
                'message' => 'Impossible de soumettre ce suivi !'
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous de soumettre ce suivi !'
        ]);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agent_package(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get agent in charge by name
            $agent_in_charge = User::where('name', $request->input('name_agent'))->first();


            // Sauvegarde
            if($agent_in_charge){

                // Update package
                $package = Package::find(intval($request->input('package_id')));
                $package->agent_id = $agent_in_charge->id;
                $package->active = 2;

                if($package->save()){

                    // Reponse
                    return response([
                        'result' => true, 
                        'status' => 200,
                        'message' => 'Dépêche attribuée a Mr/Mlle '. $agent_in_charge->name .' avec succès !'
                    ]);

                }
                return response([
                    'result' => false, 
                    'status' => 501,
                    'message' => 'Impossible d\'attribuer cette dépêche a  l\'agent '. $agent_in_charge->name .' !'
                ]);
            }
            return response([
                'result' => false, 
                'status' => 502,
                'message' => 'Impossible d\'attribuer cette dépêche a  l\'agent '. $request->input('name_agent') .' !'
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous de soumettre ce suivi !'
        ]);

        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function close_assignation(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

	        // Get package by id
	        $package = Package::find($request->input('package_id'));

	        if (!empty($package)) {
	        	// Update package
	        	$package = DB::table('packages')
	        	->where('id', $request->input('package_id'))
	        	->update([
	        		'active' => 3
	        	]);

	            // Reponse
	            return response([
	                'result' => true, 
	                'status' => 200,
	                'package' => $package,
	                'message' => 'Procedure d\'assignation cloturée avec succès !'
	            ]);
	        }
	        return response([
	            'result' => false, 
	            'status' => 500,
	            'message' => 'Impossible de cloturer la procedure d\'assignation de ce package !'
	        ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous de cloturer la procedure d\'assignation de ce package !'
        ]);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function incidents(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get agent's reclamations
            $reclamations = Reclamation::where('active', 1)
            ->orWhere('active', 2)
            ->orWhere('active', 3)
            ->orderBy('id', 'DESC')->get();

            if(!empty($reclamations) || $reclamations->count() > 0){

                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Liste des reclamations !',
                    'nbre_packages' => $reclamations->count(),
                    'reclamations' => ReclamationResource::collection($reclamations),
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Aucune reclamation pour le moment !',
                'nbre_reclamations' => $reclamations->count(),
                'reclamations' => [],
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'nbre_reclamations' => 0,
            'message' => 'Impossible d\'accéder aux reclamations !'
        ]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function new_incident(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Instancier une nouvelle reclamation
            $reclamation = new Reclamation();

            // Code
            $ext = 'RCL.';
            $code = Carbon::now()->timestamp;

            // Préparer la requete
            $reclamation->code = $ext .  '-' . $code;
            $reclamation->libelle = $request->input('libelle');
            $reclamation->details = $request->input('details');
            $reclamation->client_id = $agent->id;
            $reclamation->active = 1;

            // Sauvegarde
            if($reclamation->save()){

                // Reponse
                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Reclamation soumis avec succès !'
                ]);
            }
            return response([
                'result' => false, 
                'status' => 501,
                'message' => 'Impossible de soumettre cette reclamation !'
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous de soumettre cette reclamation !'
        ]);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_incident(Request $request, $user_id)
    {
    	
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search_incident(Request $request, $user_id)
    {
    	
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_incident(Request $request, $user_id)
    {
    	
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detail_incident(Request $request, $user_id)
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

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get agent's reservations
            $reservations = Reservation::where('agent_id', $agent->id)->orderBy('id', 'DESC')->get();

            // Count elements
            $nombre_reservations = $reservations->count();

            if(!empty($reservations) || $reservations->count() > 0){

                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Liste des reservations !',
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
    public function scan_reservation(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get reservation by id
            $reservation = Reservation::find($request->input('reservation_id'));

            if($reservation){

                // Get reservation id
                $reservation_id = $reservation->id;

                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Détails reservation !',
                    'reservation' => ReservationResource::make($reservation), // When you get only one element and not a collection
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Impossible d\'accéder aux détails de cette reservation !'
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous d\'accéder aux détails de cette reservation !'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function up_reservation(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get reservation by id
            $reservation = Reservation::find($request->input('reservation_id'));

            if($reservation){

                // Update Reservation by Agent
                //$reservation->code = $request->input('code');

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
                $reservation->frais_poste = $request->input('mode_livraison') == "Oui" ? 1500.0 : 0.0;
                $reservation->nbre_colis = 0;

                $reservation->client_id = $request->input('client_id');
                $reservation->player_id = $request->input('player_id');

                $reservation->status = $request->input('status');
                $reservation->active = 0;

                if($reservation->save()){

                    // Send notification

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
                    'message' => 'Impossible de créer cette reservation !',
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Impossible d\'accéder aux détails de cette reservation !'
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous d\'accéder aux détails de cette reservation !'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function up_reservation_colis(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get reservation by id
            $reservation = Reservation::find($request->input('reservation_id'));

            if($reservation){

                // Check colis
                $colis = ColisExpedition::find($request->input('reservation_id'));
                if(!empty($colis)) {
    
                    //$colis = new ColisExpedition();
    
                    // Data to save
                    $colis->code = $request->input('code');
    
                    $colis->service_exp_id = $request->input('service_exp_id');
    
                    $colis->libelle = $request->input('libelle');
                    $colis->description = $request->input('description');
    
                    $colis->type = $request->input('type');
                    $colis->poids = $request->input('poids');
                    //$colis->longeur = $request->input('longeur');
                    //$colis->largeur = $request->input('largeur');
                    //$colis->hauteur = $request->input('hauteur');
    
                    $colis->amount = $request->input('amount');
    
                    $colis->reservation_id = $request->input('reservation_id');
    
                    $colis->client_id = $request->input('client_id');
    
                    $colis->active = 0;
                    $colis->status = 0;
    
                    if($colis->save()){
    
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
                    'message' => 'Impossible de soumettre votre colis pour le moment !',
                    'reservation' => [],
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
    public function del_reservation_colis(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get reservation by id
            $reservation = Reservation::find($request->input('reservation_id'));

            if($reservation){

                // Check colis
                $colis = ColisExpedition::find($request->input('reservation_id'));
                if(!empty($colis)) {
    
                    if($colis->delete()){
    
                        // Update reservation
                        $reservation = Reservation::find($request->input('reservation_id'));
                        $reservation->amount += $colis->amount;
                        $reservation->nbre_colis -= 1;
                        $reservation->save();
    
                        return response([
                            'result' => true, 
                            'status' => 200,
                            'message' => 'Colis supprime avec succes !',
                            'reservation' => ReservationResource::make($reservation),
                            //'colis' => ColisExpeditionResource::make($colis),
                        ]);
        
                    }
                    return response([
                        'result' => false, 
                        'status' => 500,
                        'message' => 'Impossible de supprimer votre colis pour le moment !',
                        'reservation' => [],
                    ]);
                    
    
                }
                return response([
                    'result' => false, 
                    'status' => 500,
                    'message' => 'Impossible de supprimer votre colis pour le moment !',
                    'reservation' => [],
                ]); 

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Impossible de supprimer ce colis !'
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
    public function new_colis(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if($client){

            // Check reservation
            $reservation = Reservation::find($request->input('reservation_id'));
            if(!empty($reservation)) {

                $colis = new ColisExpedition();

                // Data to save
                $colis->code = $request->input('code');

                $colis->service_exp_id = $request->input('service_exp_id');

                $colis->libelle = $request->input('libelle');
                $colis->description = $request->input('description');

                $colis->type = $request->input('type');
                $colis->poids = $request->input('poids');
                //$colis->longeur = $request->input('longeur');
                //$colis->largeur = $request->input('largeur');
                //$colis->hauteur = $request->input('hauteur');

                $colis->amount = $request->input('amount');

                $colis->reservation_id = $request->input('reservation_id');

                $colis->client_id = $request->input('client_id');

                $colis->active = 0;
                $colis->status = 0;

                if($colis->save()){

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
    public function reservation_colis(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Check reservation
            $reservation = Reservation::find($request->input('reservation_id'));
            if(!empty($reservation)) {

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

                if($colis->save()){

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
    public function conversion(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){
    
            // Get reservation by id
            $reservation = Reservation::find($request->input('reservation_id'));

            // New Expedition
            $expedition = new Expedition();

            // Get agence's codes
            $bureau_origine = Agence::find($agent->agence_id);
            $bureau_destination = Agence::find($reservation->ville_destination_id);

            // Data to save
            $expedition->code = $request->input('code');
            $expedition->reference = $bureau_origine->code . '.' . $request->input('code') . '.' . $bureau_destination->code;

            $expedition->ville_exp_id = $reservation->ville_origine_id;
            $expedition->agence_exp_id = $bureau_origine->id;

            $expedition->ville_dest_id = $reservation->ville_destination_id;
            $expedition->agence_dest_id = $bureau_destination->id;

            $expedition->name_exp = $reservation->name_exp;
            $expedition->phone_exp = $reservation->phone_exp;
            $expedition->email_exp = $reservation->email_exp;
            $expedition->adresse_exp = !empty($reservation->adresse_exp) ? $reservation->adresse_exp : 'Non defini';

            $expedition->name_dest = $reservation->name_dest;
            $expedition->phone_dest = $reservation->phone_dest;
            $expedition->email_dest = $reservation->email_dest;
            $expedition->adresse_dest = !empty($reservation->adresse_livraison) ? $reservation->adresse_livraison : 'Non defini';

            $expedition->address = !empty($reservation->adresse_livraison) ? $reservation->adresse_livraison : 0;
            $expedition->bp = !empty($reservation->bp) ? $reservation->bp : 'Non defini';
            $expedition->bp_frais = !empty($reservation->bp_frais) ? $reservation->bp_frais : 0;

            $expedition->amount = $reservation->amount;

            $expedition->nbre_colis = $reservation->nbre_colis;

            $expedition->mode_exp_id = $reservation->mode_expedition_id;
            //$expedition->methode_paiement_id = $paiement->methode_id;
            $expedition->reservation_id = $reservation->id;

            $expedition->client_id = $reservation->client_id;
            $expedition->agent_id = $reservation->agent_id;

            $expedition->active = 0;
            $expedition->status = 0;

            if($expedition->save()){

                // Update colis
                ColisExpedition::where('reservation_id', $expedition->reservation_id)->update(['expedition_id' => $expedition->id]);

                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Conversion effectue avec succes !',
                    //'reservation' => ReservationResource::make($reservation),
                    //'colis' => ColisExpeditionResource::make($colis),
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Impossible de soumettre votre paiement !',
                'reservation' => [],
            ]);

        }
        return response([
            'result' => false, 
            'status' => 502,
            'message' => 'Impossible pour vous d\'effectuer ce paiements !'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function new_paiement(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){
    
            $paiement = new Paiement();

            // Data to save
            $paiement->reference = $request->input('reference');

            $paiement->client_id = $request->input('client_id');
            $paiement->reservation_id = $request->input('reservation_id');
            $paiement->expedition_id = $request->input('expedition_id');
            $paiement->methode_id = $request->input('methode_id');

            $paiement->amount = $request->input('amount');
            $paiement->description = $request->input('description');

            $paiement->status = $request->input('status');
            $paiement->timeout = $request->input('timeout');

            $paiement->ebilling_id = $request->input('ebilling_id');
            $paiement->transaction_id = $request->input('transaction_id');
            $paiement->operator = $request->input('operator');

            $paiement->expired_at = $request->input('expired_at');
            $paiement->paid_at = $request->input('paid_at');
    
            if($paiement->save()){

                // Update Expedition - status, active, methode_paiement_id

                // Update Reservation - status, active

                // Update Colis - status, active


                return response([
                    'result' => true, 
                    'status' => 200,
                    'message' => 'Paiement effectue avec succes !',
                    //'reservation' => ReservationResource::make($reservation),
                    //'colis' => ColisExpeditionResource::make($colis),
                ]);

                

            }
            return response([
                'result' => false, 
                'status' => 501,
                'message' => 'Impossible de soumettre votre paiement !',
                'reservation' => [],
            ]);

        }
        return response([
            'result' => false, 
            'status' => 502,
            'message' => 'Impossible pour vous d\'effectuer ce paiements !'
        ]);

    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function localisation_rsv(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Check reservation
            $reservation = Reservation::find($request->input('reservation_id'));
            if(!empty($reservation)) {

                $reservation->ville_origine_id = $request->input('ville_origine_id');
                $reservation->ville_destination_id = $request->input('ville_destination_id');

                if($reservation->save()){

                    return response([
                        'result' => true, 
                        'status' => 200,
                        'message' => 'Modification effectuée avec succès !',
                        'reservation_id' => $reservation->id,
                        'reservation' => ReservationResource::make($reservation)
                    ]);
                }
                return response([
                    'result' => false, 
                    'status' => 500,
                    'message' => 'Impossible de modifier cette reservation !',
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Impossible de soumettre votre modification pour le moment !',
                'reservation' => [],
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
    public function service_rsv(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Check reservation
            $reservation = Reservation::find($request->input('reservation_id'));
            if(!empty($reservation)) {

                $reservation->mode_expedition_id = $request->input('mode_expedition_id');
                $reservation->mode_livraison = $request->input('mode_livraison');
                $reservation->boite_postale = $request->input('boite_postale');
                $reservation->adresse_livraison = $request->input('adresse_livraison');

                //$reservation->amount += $request->input('mode_livraison') == 'Oui' ? 1500 : 0;

                if($reservation->save()){

                    return response([
                        'result' => true, 
                        'status' => 200,
                        'message' => 'Modification effectuée avec succès !',
                        'reservation_id' => $reservation->id,
                        'reservation' => ReservationResource::make($reservation)
                    ]);
                }
                return response([
                    'result' => false, 
                    'status' => 500,
                    'message' => 'Impossible de modifier cette reservation !',
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Impossible de soumettre votre modification pour le moment !',
                'reservation' => [],
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
    public function destinataire_rsv(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Check reservation
            $reservation = Reservation::find($request->input('reservation_id'));
            if(!empty($reservation)) {

                $reservation->name_dest = $request->input('name_dest');
                $reservation->email_dest = $request->input('email_dest');
                $reservation->phone_dest = $request->input('phone_dest');

                if($reservation->save()){

                    return response([
                        'result' => true, 
                        'status' => 200,
                        'message' => 'Modification effectuée avec succès !',
                        'reservation_id' => $reservation->id,
                        'reservation' => ReservationResource::make($reservation)
                    ]);
                }
                return response([
                    'result' => false, 
                    'status' => 500,
                    'message' => 'Impossible de modifier cette reservation !',
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Impossible de soumettre votre modification pour le moment !',
                'reservation' => [],
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
    public function new_colis_rsv(Request $request, $user_id)
    {

        // Get client by id
        $client = User::find($user_id);

        if($client){

            // Check reservation
            $reservation = Reservation::find($request->input('reservation_id'));
            if(!empty($reservation)) {

                $colis = new ColisExpedition();

                // Data to save
                $colis->code = $request->input('code');

                $colis->service_exp_id = $request->input('service_exp_id');

                $colis->libelle = $request->input('libelle');
                $colis->description = $request->input('description');

                $colis->type = $request->input('type');
                $colis->poids = $request->input('poids');

                $colis->amount = $request->input('amount');

                $colis->reservation_id = $request->input('reservation_id');

                $colis->client_id = $request->input('client_id');

                $colis->active = 0;
                $colis->status = 0;

                if($colis->save()){

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
    public function up_colis_rsv(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get reservation by id
            $reservation = Reservation::find($request->input('reservation_id'));

            if($reservation){

                // Check colis
                $colis = ColisExpedition::find($request->input('reservation_id'));
                if(!empty($colis)) {
    
                    //$colis = new ColisExpedition();
    
                    // Data to save
                    $colis->code = $request->input('code');
    
                    $colis->service_exp_id = $request->input('service_exp_id');
    
                    $colis->libelle = $request->input('libelle');
                    $colis->description = $request->input('description');
    
                    $colis->type = $request->input('type');
                    $colis->poids = $request->input('poids');
    
                    $colis->amount = $request->input('amount');
    
                    $colis->reservation_id = $request->input('reservation_id');
    
                    $colis->client_id = $request->input('client_id');
    
                    $colis->active = 0;
                    $colis->status = 0;
    
                    if($colis->save()){
    
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
                    'message' => 'Impossible de soumettre votre colis pour le moment !',
                    'reservation' => [],
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
    public function del_colis_rsv(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get reservation by id
            $reservation = Reservation::find($request->input('reservation_id'));

            if($reservation){

                // Check colis
                $colis = ColisExpedition::find($request->input('reservation_id'));
                if(!empty($colis)) {
    
                    if($colis->delete()){
    
                        // Update reservation
                        $reservation = Reservation::find($request->input('reservation_id'));
                        $reservation->amount -= $colis->amount;
                        $reservation->nbre_colis -= 1;
                        $reservation->save();
    
                        return response([
                            'result' => true, 
                            'status' => 200,
                            'message' => 'Colis supprime avec succes !',
                            'reservation' => ReservationResource::make($reservation),
                            //'colis' => ColisExpeditionResource::make($colis),
                        ]);
        
                    }
                    return response([
                        'result' => false, 
                        'status' => 500,
                        'message' => 'Impossible de supprimer votre colis pour le moment !',
                        'reservation' => [],
                    ]);
                    
    
                }
                return response([
                    'result' => false, 
                    'status' => 500,
                    'message' => 'Impossible de supprimer votre colis pour le moment !',
                    'reservation' => [],
                ]); 

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Impossible de supprimer ce colis !'
            ]);

        }
        return response([
            'result' => false, 
            'status' => 500,
            'message' => 'Impossible pour vous d\'accéder aux détails de ce colis !'
        ]);

    }

















    public function sendNotification($title, $body, $idPlayer)
    {
        $appId = 'eaa5c8b4-3642-40d6-b3e7-8721e5d08a94';
        $restApiKey = 'ZDA0ZTY4YjQtMTMxOC00MzBjLThmZDEtYzYwOTg4YTkzZTAx';

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
    public function onesignal_agent(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

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
                if($player->save()){

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
            'message' => 'Impossible d\'effectuer cette operation !'
        ]);

        
    }














}
