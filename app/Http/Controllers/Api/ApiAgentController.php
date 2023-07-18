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
use App\Models\ServiceExpedition;
use App\Models\Societe;
use App\Models\StatutExpedition;
use App\Models\SuiviExpedition;
use App\Models\TarifExpedition;
use App\Models\TempsExpedition;
use App\Models\Ville;

use App\Http\Resources\NotificationResource;
use App\Http\Resources\ColisExpeditionResource;
use App\Http\Resources\PackageExpeditionResource;
use App\Http\Resources\PackageResource;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

            if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {

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
                'message' => 'Impossible de se conntecter. Veuillez réessayer svp !',
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
            $notifications = Notification::where('receiver_id', $agent->id)->get();

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
    public function packages_actives(Request $request, $user_id)
    {

        // Get agent by id
        $agent = User::find($user_id);

        if($agent){

            // Get agent's packages
            $packages = Package::where('active', 1)->orWhere('active', 2)->orWhere('active', 3)->orderBy('id', 'DESC')->get();

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
                    'message' => 'Liste des packages en cour !',
                    'packages' => PackageResource::collection($packages),
                ]);

            }
            return response([
                'result' => false, 
                'status' => 500,
                'message' => 'Aucun package actif pour le moment !',
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
			        	$sac = DB::table('packages')
			        	->where('id', $request->input('package_id'))
			        	->increment('nbre_colis');

			        	// Update colis
			        	$colis = DB::table('colis_expeditions')
			        	->where('id', $request->input('colis_id'))
			        	->update([
			        		'active' => 2
			        	]);

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
            'message' => 'Impossible pour vous d\'assigner ce colis a ce package !'
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
	                'reclamation' => ColisExpeditionResource::make($colis), // When you get only one element and not a collection
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

	            return response([
	                'result' => true, 
	                'status' => 200,
	                'message' => 'Détails package !',
	                'package' => PackageResource::make($package), // When you get only one element and not a collection
	                'expeditions' => PackageExpeditionResource::collection($expeditions), 
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














}
