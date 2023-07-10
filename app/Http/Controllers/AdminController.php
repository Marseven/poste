<?php

namespace App\Http\Controllers;

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


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 

use WisdomDiala\Countrypkg\Models\Country;
use WisdomDiala\Countrypkg\Models\State;

class AdminController extends Controller
{
	################################################################################################################
    #                                                                                                              #
    #   TABLEAU DE BORD                                                                                            #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminHome(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Tableau de bord";

        $expeditions = Expedition::all();
        $paiements = Paiement::all();
        $packages = Package::all();
        $clients = User::where('role', 'Client')->get();

    	$stat_expeditions = Expedition::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(DB::raw("Month(created_at)"))
                    ->pluck('count', 'month_name');
 
        $exp_labels = $stat_expeditions->keys();
        $exp_data = $stat_expeditions->values();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminHome', compact('page_title', 'app_name', 
	    	'expeditions', 'paiements', 'packages', 'clients',
	    	'exp_labels', 'exp_data'
	    ));

    }

	################################################################################################################
    #                                                                                                              #
    #   PAYS                                                                                                       #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPays(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Pays";

        $countries = Pays::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminPays', compact('page_title', 'app_name', 
	    	'countries'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddPays(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $country = new Pays();

        // Récupérer les données du formulaire
        $country->code = $request->input('code');
        $country->libelle = $request->input('libelle');
        $country->active = $request->input('active');

        if($country->save()){

            // Redirection
            return redirect()->back()->with('success', 'Nouveau Pays cree avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de creer ce pays !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditPays(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get pays by id
        $country = Pays::find($request->input('pays_id'));
        if(!empty($country)){

        	// Récupérer les données du formulaire
	        $country->code = $request->input('code');
	        $country->libelle = $request->input('libelle');
	        $country->active = $request->input('active');

	        if($country->save()){

	            // Redirection
	            return redirect()->back()->with('success', 'Pays modifié avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de modifier ce pays !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver ce pays !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminFlagPays(Request $request)
    {
        // Récupérer utilisateur connecté
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get projet by id
        $country = Pays::find($request->input('pays_id'));
        if(!empty($country)){
        
	        // Récupérer le logo
	        $image = $request->file('image');

	        // Vérifier si le fichier n'est pas vide
	        if($image != null){

	            // Recuperer l'extension du fichier
	            $ext = $image->getClientOriginalExtension();

	            // Renommer le fichier
	            $filename = rand(10000, 50000) . '.' . $ext;

	            // Verifier les extensions 
	            if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'jfif'){

	                // Upload le fichier
	                if($image->move(public_path('pays/drapeaux'), $filename)){

	                    // Attribuer l'url
	                    $country->flag = url('pays/drapeaux') . '/' . $filename;
	                    
	                    // Sauvegarde
	                    if($country->save()){

	                        // Redirection
	                        return redirect()->back()->with('success', 'Drapeau modifiée avec succès !');
	                    }
	                    return redirect()->back()->with('failed', 'Impossible de modifier votre drapeau !');
	                }
	                return redirect()->back()->with('failed', 'Imposible d\'uploader le fichier vers le répertoire défini !');
	            }
	            return redirect()->back()->with('failed', 'L\'extension du fichier doit être soit du jpg ou du png !');
	        }
	        return redirect()->back()->with('failed', 'Aucun fichier téléchargé. Veuillez réessayer svp !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver ce pays !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchPays(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Pays";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $countries = Pays::where('code', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
        ->paginate(10);

	    return view('admin.adminPays', compact('page_title', 'app_name', 
	    	'countries'
	    ));

    }

	################################################################################################################
    #                                                                                                              #
    #   PROVINCES                                                                                                  #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminProvince(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Provinces";

        $provinces = Province::paginate(10);
        $countries = Pays::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminProvince', compact('page_title', 'app_name', 
	    	'provinces', 'countries'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchProvince(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Provinces";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $provinces = Province::where('code', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
        ->paginate(10);
        $countries = Pays::all();

	    return view('admin.adminProvince', compact('page_title', 'app_name', 
	    	'provinces', 'countries'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddProvince(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $province = new Province();

        // Récupérer les données du formulaire
        $province->code = $request->input('code');
	    $province->pays_id = $request->input('pays_id');
        $province->libelle = $request->input('libelle');
        $province->active = $request->input('active');

        if($province->save()){

            // Redirection
            return redirect()->back()->with('success', 'Nouvelle Province créee avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de creer cette province !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditProvince(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get province by id
        $province = Province::find($request->input('province_id'));
        if(!empty($province)){

        	// Récupérer les données du formulaire
	        $province->code = $request->input('code');
	        $province->pays_id = $request->input('pays_id');
	        $province->libelle = $request->input('libelle');
	        $province->active = $request->input('active');

	        if($province->save()){

	            // Redirection
	            return redirect()->back()->with('success', 'Province modifiée avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de modifier cette province !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver cette province !');

    }

	################################################################################################################
    #                                                                                                              #
    #   VILLES                                                                                                     #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminVille(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Villes";

        $villes = Ville::paginate(10);
        $provinces = Province::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminVille', compact('page_title', 'app_name', 
	    	'villes', 'provinces'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchVille(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Villes";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $villes = Ville::where('code', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
        ->paginate(10);
        $provinces = Province::all();

	    return view('admin.adminVille', compact('page_title', 'app_name', 
	    	'villes', 'provinces'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddVille(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $ville = new Ville();

        // Récupérer les données du formulaire
        $ville->code = $request->input('code');
	    $ville->province_id = $request->input('province_id');
        $ville->libelle = $request->input('libelle');
        $ville->active = $request->input('active');

        if($ville->save()){

            // Redirection
            return redirect()->back()->with('success', 'Nouvelle Ville créee avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de creer cette ville !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditVille(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get ville by id
        $ville = Ville::find($request->input('ville_id'));
        if(!empty($ville)){

        	// Récupérer les données du formulaire
	        $ville->code = $request->input('code');
	        $ville->province_id = $request->input('province_id');
	        $ville->libelle = $request->input('libelle');
	        $ville->active = $request->input('active');

	        if($ville->save()){

	            // Redirection
	            return redirect()->back()->with('success', 'Ville modifiée avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de modifier cette ville !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver cette ville !');

    }

	################################################################################################################
    #                                                                                                              #
    #   SOCIETE                                                                                                    #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSociete(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Societe";

        $societe = Societe::find(1);
        $countries = Pays::all();
        $provinces = Province::all();
        $villes = Ville::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminSociete', compact('page_title', 'app_name', 
	    	'societe', 'countries', 'provinces', 'villes'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditSociete(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get societe by id
        $societe = Societe::find(1);
        if(!empty($societe)){

        	// Récupérer les données du formulaire
	        $societe->code = $request->input('code');
	        $societe->name = $request->input('name');

	        $societe->email = $request->input('email');
	        $societe->phone1 = $request->input('phone1');
	        $societe->phone2 = $request->input('phone2');

	        $societe->website = $request->input('website');
	        $societe->fax = $request->input('fax');
	        $societe->immatriculation = $request->input('immatriculation');

	        //$societe->pays_id = $request->input('pays_id');
	        //$societe->province_id = $request->input('province_id');
	        $societe->ville_id = $request->input('ville_id');
	        $societe->adresse = $request->input('adresse');

	        //$societe->active = $request->input('active');

	        if($societe->save()){

	            // Redirection
	            return redirect()->back()->with('success', 'Societe modifié avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de modifier cette societe !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver cette societe !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminLogoSociete(Request $request)
    {
        // Récupérer utilisateur connecté
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get societe by id
        $societe = Societe::find(1);
        if(!empty($societe)){
        
	        // Récupérer le logo
	        $image = $request->file('image');

	        // Vérifier si le fichier n'est pas vide
	        if($image != null){

	            // Recuperer l'extension du fichier
	            $ext = $image->getClientOriginalExtension();

	            // Renommer le fichier
	            $filename = rand(10000, 50000) . '.' . $ext;

	            // Verifier les extensions 
	            if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'jfif'){

	                // Upload le fichier
	                if($image->move(public_path('societes/logos'), $filename)){

	                    // Attribuer l'url
	                    $societe->logo = url('societes/logos') . '/' . $filename;
	                    
	                    // Sauvegarde
	                    if($societe->save()){

	                        // Redirection
	                        return redirect()->back()->with('success', 'Logo modifiée avec succès !');
	                    }
	                    return redirect()->back()->with('failed', 'Impossible de modifier votre logo !');
	                }
	                return redirect()->back()->with('failed', 'Imposible d\'uploader le fichier vers le répertoire défini !');
	            }
	            return redirect()->back()->with('failed', 'L\'extension du fichier doit être soit du jpg ou du png !');
	        }
	        return redirect()->back()->with('failed', 'Aucun fichier téléchargé. Veuillez réessayer svp !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver cette societe !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIconSociete(Request $request)
    {
        // Récupérer utilisateur connecté
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get societe by id
        $societe = Societe::find(1);
        if(!empty($societe)){
        
	        // Récupérer le logo
	        $image = $request->file('image');

	        // Vérifier si le fichier n'est pas vide
	        if($image != null){

	            // Recuperer l'extension du fichier
	            $ext = $image->getClientOriginalExtension();

	            // Renommer le fichier
	            $filename = rand(10000, 50000) . '.' . $ext;

	            // Verifier les extensions 
	            if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'jfif'){

	                // Upload le fichier
	                if($image->move(public_path('societes/logos'), $filename)){

	                    // Attribuer l'url
	                    $societe->icon = url('societes/logos') . '/' . $filename;
	                    
	                    // Sauvegarde
	                    if($societe->save()){

	                        // Redirection
	                        return redirect()->back()->with('success', 'Icone modifiée avec succès !');
	                    }
	                    return redirect()->back()->with('failed', 'Impossible de modifier votre icone !');
	                }
	                return redirect()->back()->with('failed', 'Imposible d\'uploader le fichier vers le répertoire défini !');
	            }
	            return redirect()->back()->with('failed', 'L\'extension du fichier doit être soit du jpg ou du png !');
	        }
	        return redirect()->back()->with('failed', 'Aucun fichier téléchargé. Veuillez réessayer svp !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver cette societe !');

    }

	################################################################################################################
    #                                                                                                              #
    #   AGENCE                                                                                                     #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAgence(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Agences";

        $agences = Agence::paginate(10);
        $villes = Ville::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminAgence', compact('page_title', 'app_name', 
	    	'agences', 'villes'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchAgence(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Agences";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $agences = Agence::where('code', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
        ->paginate(10);
        $villes = Ville::all();

	    return view('admin.adminAgence', compact('page_title', 'app_name', 
	    	'agences', 'villes'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddAgence(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $agence = new Agence();

        // Récupérer les données du formulaire
        $agence->code = $request->input('code');
	    $agence->ville = $request->input('ville');
        $agence->libelle = $request->input('libelle');
        $agence->phone = $request->input('phone');
        $agence->adresse = $request->input('adresse');
        $agence->active = $request->input('active');

        if($agence->save()){

            // Redirection
            return redirect()->back()->with('success', 'Nouvelle Agence créee avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de creer cette agence !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditAgence(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get agence by id
        $agence = Agence::find($request->input('agence_id'));
        if(!empty($agence)){

        	// Récupérer les données du formulaire
	        $agence->code = $request->input('code');
		    $agence->ville = $request->input('ville');
	        $agence->libelle = $request->input('libelle');
	        $agence->phone = $request->input('phone');
	        $agence->adresse = $request->input('adresse');
	        $agence->active = $request->input('active');

	        if($agence->save()){

	            // Redirection
	            return redirect()->back()->with('success', 'Agence modifiée avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de modifier cette agence !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver cette agence !');

    }

	################################################################################################################
    #                                                                                                              #
    #   SERVICE                                                                                                    #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminService(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Services";

        $services = ServiceExpedition::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminService', compact('page_title', 'app_name', 
	    	'services', 
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchService(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Services";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $services = ServiceExpedition::where('code', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
        ->paginate(10);

	    return view('admin.adminService', compact('page_title', 'app_name', 
	    	'services'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddService(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $service = new ServiceExpedition();

        // Récupérer les données du formulaire
        $service->code = $request->input('code');
        $service->libelle = $request->input('libelle');
        $service->description = $request->input('description');
        $service->agent_id = $admin_id;
        $service->active = $request->input('active');

        if($service->save()){

            // Redirection
            return redirect()->back()->with('success', 'Nouveau service créee avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de creer ce service !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditService(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get service by id
        $service = ServiceExpedition::find($request->input('service_id'));
        if(!empty($service)){

        	// Récupérer les données du formulaire
	        $service->code = $request->input('code');
	        $service->libelle = $request->input('libelle');
	        $service->description = $request->input('description');
	        $service->agent_id = $admin_id;
	        $service->active = $request->input('active');

	        if($service->save()){

	            // Redirection
	            return redirect()->back()->with('success', 'Service modifiée avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de modifier ce service !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver ce service !');

    }

	################################################################################################################
    #                                                                                                              #
    #   DELAI                                                                                                      #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminDelai(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Delais d'expedition";

        $delais = TempsExpedition::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminDelai', compact('page_title', 'app_name', 
	    	'delais', 
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchDelai(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Delais d'expedition";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $delais = TempsExpedition::where('code', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
        ->paginate(10);

	    return view('admin.adminDelai', compact('page_title', 'app_name', 
	    	'delais', 
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddDelai(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $delai = new TempsExpedition();

        // Récupérer les données du formulaire
        $delai->code = $request->input('code');
        $delai->libelle = $request->input('libelle');
        $delai->description = $request->input('description');
        $delai->agent_id = $admin_id;
        $delai->active = $request->input('active');

        if($delai->save()){

            // Redirection
            return redirect()->back()->with('success', 'Nouveau delai créee avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de creer ce delai !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditDelai(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get delai by id
        $delai = TempsExpedition::find($request->input('delai_id'));
        if(!empty($delai)){

        	// Récupérer les données du formulaire
	        $delai->code = $request->input('code');
	        $delai->libelle = $request->input('libelle');
	        $delai->description = $request->input('description');
	        $delai->agent_id = $admin_id;
	        $delai->active = $request->input('active');

	        if($delai->save()){

	            // Redirection
	            return redirect()->back()->with('success', 'Delai modifiée avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de modifier ce delai !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver ce delai !');

    }

	################################################################################################################
    #                                                                                                              #
    #   STATUT                                                                                                     #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminStatut(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Statuts d'expedition";

        $statuts = StatutExpedition::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminStatut', compact('page_title', 'app_name', 
	    	'statuts', 
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchStatut(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Statuts d'expedition";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $statuts = StatutExpedition::where('code', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
        ->paginate(10);

	    return view('admin.adminStatut', compact('page_title', 'app_name', 
	    	'statuts', 
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddStatut(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $statut = new StatutExpedition();

        // Récupérer les données du formulaire
        $statut->code = $request->input('code');
        $statut->libelle = $request->input('libelle');
        $statut->description = $request->input('description');
        $statut->code_hexa = $request->input('code_hexa');
        $statut->agent_id = $admin_id;
        $statut->active = $request->input('active');

        if($statut->save()){

            // Redirection
            return redirect()->back()->with('success', 'Nouveau statut créee avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de creer ce statut !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditStatut(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get statut by id
        $statut = StatutExpedition::find($request->input('statut_id'));
        if(!empty($statut)){

        	// Récupérer les données du formulaire
	        $statut->code = $request->input('code');
	        $statut->libelle = $request->input('libelle');
	        $statut->description = $request->input('description');
	        $statut->code_hexa = $request->input('code_hexa');
	        $statut->agent_id = $admin_id;
	        $statut->active = $request->input('active');

	        if($statut->save()){

	            // Redirection
	            return redirect()->back()->with('success', 'Statut modifié avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de modifier ce statut !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver ce statut !');

    }

	################################################################################################################
    #                                                                                                              #
    #   FORFAIT                                                                                                    #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminForfait(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Plage de poids";

        $forfaits = ForfaitExpedition::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminForfait', compact('page_title', 'app_name', 
	    	'forfaits', 
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchForfait(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Plage de poids";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $forfaits = ForfaitExpedition::where('code', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
        ->paginate(10);

	    return view('admin.adminForfait', compact('page_title', 'app_name', 
	    	'forfaits', 
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddForfait(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $forfait = new ForfaitExpedition();

        // Récupérer les données du formulaire
        $forfait->code = $request->input('code');
        $forfait->libelle = $request->input('libelle');
        $forfait->description = $request->input('description');
        $forfait->agent_id = $admin_id;
        $forfait->active = $request->input('active');

        if($forfait->save()){

            // Redirection
            return redirect()->back()->with('success', 'Nouvelle plage créee avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de creer cette plage !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditForfait(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get forfait by id
        $forfait = ForfaitExpedition::find($request->input('forfait_id'));
        if(!empty($forfait)){

        	// Récupérer les données du formulaire
	        $forfait->code = $request->input('code');
	        $forfait->libelle = $request->input('libelle');
	        $forfait->description = $request->input('description');
	        $forfait->agent_id = $admin_id;
	        $forfait->active = $request->input('active');

	        if($forfait->save()){

	            // Redirection
	            return redirect()->back()->with('success', 'Plage modifié avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de modifier cette plage !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver cette plage !');

    }

	################################################################################################################
    #                                                                                                              #
    #   TARIF                                                                                                      #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminTarif(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Tarifs expedition";

        $tarifs = TarifExpedition::paginate(10);
        $countries = Pays::all();
        $provinces = Province::all();
        $villes = Ville::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminTarif', compact('page_title', 'app_name', 
	    	'tarifs', 'countries', 'provinces', 'villes'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchTarif(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Tarifs expedition";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $tarifs = TarifExpedition::where('code', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('pays_exp', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('province_exp', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('ville_exp', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('pays_dest', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('province_dest', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('ville_dest', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('poids_min', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('poids_max', 'LIKE', '%' . $request->input('q') . '%')
        ->orWhere('tarif', 'LIKE', '%' . $request->input('q') . '%')
        ->paginate(10);
        $countries = Pays::all();
        $provinces = Province::all();
        $villes = Ville::all();

	    return view('admin.adminTarif', compact('page_title', 'app_name', 
	    	'tarifs', 'countries', 'provinces', 'villes'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddTarif(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $tarif = new TarifExpedition();

        // Récupérer les données du formulaire
        $tarif->code = $request->input('code');
        $tarif->pays_exp = $request->input('pays_exp');
        $tarif->province_exp = $request->input('province_exp');
        $tarif->ville_exp = $request->input('ville_exp');
        $tarif->pays_dest = $request->input('pays_dest');
        $tarif->province_dest = $request->input('province_dest');
        $tarif->ville_dest = $request->input('ville_dest');
        $tarif->poids_min = $request->input('poids_min');
        $tarif->poids_max = $request->input('poids_max');
        $tarif->tarif = $request->input('tarif');
        $tarif->agent_id = $admin_id;
        $tarif->active = $request->input('active');

        if($tarif->save()){

            // Redirection
            return redirect()->back()->with('success', 'Nouveau tarif crée avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de creer ce tarif !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditTarif(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get tarif by id
        $tarif = TarifExpedition::find($request->input('tarif_id'));
        if(!empty($tarif)){

        	// Récupérer les données du formulaire
	        $tarif->code = $request->input('code');
	        $tarif->pays_exp = $request->input('pays_exp');
	        $tarif->province_exp = $request->input('province_exp');
	        $tarif->ville_exp = $request->input('ville_exp');
	        $tarif->pays_dest = $request->input('pays_dest');
	        $tarif->province_dest = $request->input('province_dest');
	        $tarif->ville_dest = $request->input('ville_dest');
	        $tarif->poids_min = $request->input('poids_min');
	        $tarif->poids_max = $request->input('poids_max');
	        $tarif->tarif = $request->input('tarif');
	        $tarif->agent_id = $admin_id;
	        $tarif->active = $request->input('active');

	        if($tarif->save()){

	            // Redirection
	            return redirect()->back()->with('success', 'Tarif modifié avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de modifier ce tarif !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver ce tarif !');

    }

	################################################################################################################
    #                                                                                                              #
    #   EXPEDITION                                                                                                 #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminExpeditionList(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Expeditions";

        $expeditions = Expedition::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminExpeditionList', compact('page_title', 'app_name', 
	    	'expeditions'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminNewExpedition(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Nouvelle Expedition";

        $code_aleatoire = Carbon::now()->timestamp;

        
        $societe = Societe::find(1);

        
        $countries = Pays::all();
        $provinces = Province::all();
        $villes = Ville::all();

        
        $agences = Agence::all();
        $forfaits = ForfaitExpedition::all();
        $services = ServiceExpedition::all();
        $tarifs = TarifExpedition::all();
        $delais = TempsExpedition::all();

        
        $documents = DocumentExpedition::where('code', $code_aleatoire)->get();
        $paquets = ColisExpedition::where('code', $code_aleatoire)->get();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminNewExpedition', compact('page_title', 'app_name', 
	    	'code_aleatoire', 'countries', 'provinces', 'villes', 
	    	'agences', 'forfaits', 'services', 'delais', 'documents', 'paquets',  
	    	'societe'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminStep1(Request $request)
    {

    	$app_name = "La Poste";
        $page_title = "Nouvelle Expedition - Etape 1";

        $code_aleatoire = Carbon::now()->timestamp;

        
        $societe = Societe::find(1);

        
        $countries = Pays::all();
        $provinces = Province::all();
        $villes = Ville::all();

        
        $agences = Agence::all();
        $forfaits = ForfaitExpedition::all();
        $services = ServiceExpedition::all();
        $tarifs = TarifExpedition::all();
        $delais = TempsExpedition::all();

        
        $documents = DocumentExpedition::where('code', $code_aleatoire)->get();
        $paquets = ColisExpedition::where('code', $code_aleatoire)->get();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminStep1', compact('page_title', 'app_name', 
	    	'code_aleatoire', 'countries', 'provinces', 'villes', 
	    	'agences', 'forfaits', 'services', 'delais', 'documents', 'paquets',  
	    	'societe'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminStep2(Request $request, $code)
    {

    	$app_name = "La Poste";
        $page_title = "Nouvelle Expedition - Etape 2";

        $code_aleatoire = $code;

        
        $societe = Societe::find(1);

        
        $countries = Pays::all();
        $provinces = Province::all();
        $villes = Ville::all();

        
        $agences = Agence::all();
        $forfaits = ForfaitExpedition::all();
        $services = ServiceExpedition::all();
        $tarifs = TarifExpedition::all();
        $delais = TempsExpedition::all();

        
        $documents = DocumentExpedition::where('code', $code_aleatoire)->get();
        $paquets = ColisExpedition::where('code', $code_aleatoire)->get();
        $expedition = Expedition::where('code_aleatoire', $code_aleatoire)->first();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminStep2', compact('page_title', 'app_name', 
	    	'code_aleatoire', 'countries', 'provinces', 'villes', 
	    	'agences', 'forfaits', 'services', 'delais', 'documents', 'paquets',  
	    	'societe', 'code', 'expedition'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminStep3(Request $request, $code)
    {

    	$app_name = "La Poste";
        $page_title = "Nouvelle Expedition - Etape 3";

        $code_aleatoire = $code;

        
        $societe = Societe::find(1);

        
        $countries = Pays::all();
        $provinces = Province::all();
        $villes = Ville::all();

        
        $agences = Agence::all();
        $forfaits = ForfaitExpedition::all();
        $services = ServiceExpedition::all();
        $tarifs = TarifExpedition::all();
        $delais = TempsExpedition::all();

        
        $documents = DocumentExpedition::where('code', $code_aleatoire)->get();
        $paquets = ColisExpedition::where('code', $code_aleatoire)->get();
        $expedition = Expedition::where('code_aleatoire', $code_aleatoire)->first();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminStep3', compact('page_title', 'app_name', 
	    	'code_aleatoire', 'countries', 'provinces', 'villes', 
	    	'agences', 'forfaits', 'services', 'delais', 'documents', 'paquets',  
	    	'societe', 'code', 'expedition'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminStep4(Request $request, $code)
    {

    	$app_name = "La Poste";
        $page_title = "Nouvelle Expedition - Etape 4";

        $code_aleatoire = $code;

        
        $societe = Societe::find(1);

        
        $countries = Pays::all();
        $provinces = Province::all();
        $villes = Ville::all();

        
        $agences = Agence::all();
        $forfaits = ForfaitExpedition::all();
        $services = ServiceExpedition::all();
        $tarifs = TarifExpedition::all();
        $delais = TempsExpedition::all();

        
        $documents = DocumentExpedition::where('code', $code_aleatoire)->get();
        $paquets = ColisExpedition::where('code', $code_aleatoire)->get();
        $expedition = Expedition::where('code_aleatoire', $code_aleatoire)->first();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminStep4', compact('page_title', 'app_name', 
	    	'code_aleatoire', 'countries', 'provinces', 'villes', 
	    	'agences', 'forfaits', 'services', 'delais', 'documents', 'paquets',  
	    	'societe', 'code', 'expedition'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminStep5(Request $request, $code)
    {

    	$app_name = "La Poste";
        $page_title = "Nouvelle Expedition - Etape 5";

        $code_aleatoire = $code;

        
        $societe = Societe::find(1);

        
        $countries = Pays::all();
        $provinces = Province::all();
        $villes = Ville::all();

        
        $agences = Agence::all();
        $forfaits = ForfaitExpedition::all();
        $services = ServiceExpedition::all();
        $tarifs = TarifExpedition::all();
        $delais = TempsExpedition::all();

        
        $documents = DocumentExpedition::where('code', $code_aleatoire)->get();
        $paquets = ColisExpedition::where('code', $code_aleatoire)->get();
        $expedition = Expedition::where('code_aleatoire', $code_aleatoire)->first();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


	    return view('admin.adminStep5', compact('page_title', 'app_name', 
	    	'code_aleatoire', 'countries', 'provinces', 'villes', 
	    	'agences', 'forfaits', 'services', 'delais', 'documents', 'paquets',  
	    	'societe', 'code', 'expedition'
	    ));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminNewDocument(Request $request)
    {
        // Récupérer utilisateur connecté
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $document = new DocumentExpedition();

        // Récupérer les données du formulaire
        $document->code = $request->input('code');
        $document->libelle = $request->input('libelle');
        $document->agent_id = $admin_id;
        $document->active = 1;

        // Récupérer le logo
        $image = $request->file('image');

        // Vérifier si le fichier n'est pas vide
        if($image != null){

            // Recuperer l'extension du fichier
            $ext = $image->getClientOriginalExtension();

            // Renommer le fichier
            $filename = rand(10000, 50000) . '.' . $ext;

            // Verifier les extensions 
            if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'jfif' || $ext == 'pdf'){

                // Upload le fichier
                if($image->move(public_path('expeditions/documents'), $filename)){

                    // Attribuer l'url
                    $document->url = url('expeditions/documents') . '/' . $filename;
                    
                    // Sauvegarde
                    if($document->save()){

                        // Redirection
                        return redirect()->back()->with('success', 'Document ajoute avec succès !');
                    }
                    return redirect()->back()->with('failed', 'Impossible de modifier ce document !');
                }
                return redirect()->back()->with('failed', 'Imposible d\'uploader le fichier vers le répertoire défini !');
            }
            return redirect()->back()->with('failed', 'L\'extension du fichier doit être soit du, pdf jpg ou du png !');
        }
        return redirect()->back()->with('failed', 'Aucun fichier téléchargé. Veuillez réessayer svp !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminNewPaquet(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $paquet = new ColisExpedition();

        // Récupérer les données du formulaire
        $paquet->code = $request->input('code');
        $paquet->libelle = $request->input('libelle');
        $paquet->description = $request->input('description');
        $paquet->longeur = $request->input('longeur');
        $paquet->largeur = $request->input('largeur');
        $paquet->hauteur = $request->input('hauteur');
        $paquet->poids = $request->input('poids');
        $paquet->agent_id = $admin_id;
        $paquet->active = 1;

        if($paquet->save()){

            // Redirection
            return redirect()->back()->with('success', 'Colis ajoutee avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de rajouter ce colis !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddExpedition(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Store data
        $code_aleatoire = $request->input('code_aleatoire');
        $agence_id = $request->input('agence_id');

        // Check if this expedition have almost one colis
        $paquets = ColisExpedition::where('code', $code_aleatoire)->get();

        if($paquets->count() > 0) {

        	$expedition = new Expedition();

        	// Get agence by id
	        $agence = Agence::find($agence_id);

	        // Set data
	        $code_agence = $agence->code;
	        $reference = $agence->code . $code_aleatoire;

	        // Récupérer les données du formulaire
	        $expedition->code_aleatoire = $request->input('code_aleatoire');
	        $expedition->agence_id = $request->input('agence_id');
	        $expedition->code_agence = $code_agence;

	        $expedition->reference = $reference;
	       
	        $expedition->name_exp = $request->input('name_exp');
	        $expedition->email_exp = $request->input('email_exp');
	        $expedition->phone_exp = $request->input('phone_exp');
	        $expedition->adresse_exp = $request->input('adresse_exp');

	        $expedition->name_dest = $request->input('name_dest');
	        $expedition->email_dest = $request->input('email_dest');
	        $expedition->phone_dest = $request->input('phone_dest');
	        $expedition->adresse_dest = $request->input('adresse_dest');

	        $expedition->service_exp_id = $request->input('service_exp_id');
	        $expedition->delai_exp_id = $request->input('delai_exp_id');
	        $expedition->forfait_exp_id = $request->input('forfait_exp_id');

	        $expedition->agent_id = $admin_id;
	        $expedition->active = $request->input('active');

	        if($expedition->save()){

	        	// Mise a jour Documents et colis
	        	$documents = DB::table('document_expeditions')
	        	->where('code', $code_aleatoire)
	        	->update(['expedition_id' => $expedition->id]);

	        	// Save
	        	$documents->save();


	        	// Get Sum Poids des colis
	        	$poids_total = ColisExpedition::where('code', $code_aleatoire)->sum('poids');


	        	// Get Tarif
	        	$tarif = TarifExpedition::where('poids_min', '<', $poids_total)->where('poids_max', '>', $poids_total)->first();


	        	// Update Expedition
	        	$expedition = DB::table('expeditions')
	        	->where('code', $code_aleatoire)
	        	->update([
	        		'tarif_exp_id' => $tarif->id,
	        		'amount' => (intval($tarif->tarif) * intval($poids_total)),
	        	]);

	        	// Save
	        	$expedition->save();

	        	// New Facture
	        	$facture = new FactureExpedition();

	        	$facture->code = $code_aleatoire;
	        	$facture->expedition_id = $request->input('service_exp_id');

	        	$facture->save();

	            // Redirection
	            return redirect()->back()->with('success', 'Expedition ajoutee avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de rajouter cette expedition !');

        } else {
        	return redirect()->back()->with('failed', 'Veuillez rajouter aumoins un colis svp !');
        }

        

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminNewStep1(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Store data
        $code_aleatoire = $request->input('code_aleatoire');
        $agence_id = $request->input('agence_id');

        $expedition = new Expedition();

    	// Get agence by id
        $agence = Agence::find($agence_id);

        // Set data
        $code_agence = $agence->code;
        $reference = $agence->code . $code_aleatoire;

        // Récupérer les données du formulaire
        $expedition->code_aleatoire = $request->input('code_aleatoire');
        $expedition->agence_id = $request->input('agence_id');
        $expedition->code_agence = $code_agence;

        $expedition->reference = $reference;
       
        $expedition->name_exp = $request->input('name_exp');
        $expedition->email_exp = $request->input('email_exp');
        $expedition->phone_exp = $request->input('phone_exp');
        $expedition->adresse_exp = $request->input('adresse_exp');

        $expedition->name_dest = $request->input('name_dest');
        $expedition->email_dest = $request->input('email_dest');
        $expedition->phone_dest = $request->input('phone_dest');
        $expedition->adresse_dest = $request->input('adresse_dest');

        //$expedition->service_exp_id = $request->input('service_exp_id');
        //$expedition->delai_exp_id = $request->input('delai_exp_id');
        //$expedition->forfait_exp_id = $request->input('forfait_exp_id');

        $expedition->agent_id = $admin_id;
        $expedition->active = 0;

        if($expedition->save()){

            // Redirection
            return redirect()->route('adminStep2', ['code' => $code_aleatoire])->with('success', 'Etape 1 validee avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de rajouter ce colis !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminNewStep2(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $code_aleatoire = $request->input('code_aleatoire');

        // Get expedition by id
        $expedition = Expedition::where('code_aleatoire', $request->input('code_aleatoire'))->first();
        if(!empty($expedition)){

        	// Récupérer les données du formulaire
	        $expedition->service_exp_id = $request->input('service_exp_id');
        	$expedition->delai_exp_id = $request->input('delai_exp_id');
        	$expedition->forfait_exp_id = $request->input('forfait_exp_id');

	        if($expedition->save()){

	            // Redirection
            	return redirect()->route('adminStep3', ['code' => $code_aleatoire])->with('success', 'Etape 2 validee avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de valider cette etape !');

        }
        return redirect()->back()->with('failed', 'Impossible de valider cette etape !');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminNewValidation(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $code_aleatoire = $request->input('code_aleatoire');

        // Get expedition by id
        $expedition = Expedition::where('code_aleatoire', $request->input('code_aleatoire'))->first();
        if(!empty($expedition)){

        	// Store expedition id
        	$expedition_id = intval($expedition->id);

        	// Mise a jour Documents et colis
        	$documents = DB::table('document_expeditions')
        	->where('code', $code_aleatoire)
        	->update(['expedition_id' => $expedition->id]);


        	// Get Sum Poids des colis
        	$poids_total = ColisExpedition::where('code', $code_aleatoire)->sum('poids');


        	// Get Tarif
        	$tarif = TarifExpedition::where('poids_min', '<', $poids_total)->where('poids_max', '>', $poids_total)->first();


        	// Update Expedition
        	$expedition = DB::table('expeditions')
        	->where('code_aleatoire', $code_aleatoire)
        	->update([
        		'tarif_exp_id' => $tarif->id,
        		'amount' => (intval($tarif->tarif) * intval($poids_total)),
        		'active' => 1
        	]);


        	// New facture
        	$facture = new FactureExpedition();

        	// Récupérer les données du formulaire
	        $facture->code = $request->input('code_aleatoire');
	        $facture->societe_id = 1;
	        $facture->expedition_id = $expedition_id;
	        $facture->agent_id = $admin_id;
	        $facture->active = 1;

	        if($facture->save()){

	            // Redirection
            	return redirect()->route('adminExpeditionList')->with('success', 'Validation effectuee avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de valider cette expedition !');

        }
        return redirect()->back()->with('failed', 'Impossible de valider cette expedition !');

    }

	################################################################################################################
    #                                                                                                              #
    #   FACTURE                                                                                                    #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminFactureExpedition(Request $request, $code)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get expedition by id
        $expedition = Expedition::where('code_aleatoire', $code)->first();
        if(!empty($expedition)){

        	// Récupérer les données
	        $expedition_id = intval($expedition->id);

	        // Get facture by expedition_id
        	$facture = FactureExpedition::where('expedition_id', $expedition_id)->first();

	        if(!empty($facture)){

	            // Redirection
	            return redirect()->back()->with('success', 'Tarif modifié avec succès !');
	        }
	        return redirect()->back()->with('failed', 'Impossible de modifier cette expedition !');

        }
        return redirect()->back()->with('failed', 'Impossible de trouver cette expedition !');

    }











}
