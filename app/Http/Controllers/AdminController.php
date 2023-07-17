<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Adresse;
use App\Models\Agence;
use App\Models\CategoryExpedition;
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
use App\Models\PriceExpedition;
use App\Models\Province;
use App\Models\RegimeExpedition;
use App\Models\ServiceExpedition;
use App\Models\Societe;
use App\Models\StatutExpedition;
use App\Models\SuiviExpedition;
use App\Models\TarifExpedition;
use App\Models\TempsExpedition;
use App\Models\TypeExpedition;
use App\Models\Ville;


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
        $home = "--active";

        $expeditions = Expedition::orderBy('id', 'DESC')->limit(5)->get();
        $paiements = Paiement::all();
        $packages = Package::all();
        $clients = User::where('role', 'Client')->get();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Mouchard
        // $ip_adresse, $os_system, $os_navigator, $action_title, $action_system
        $this->mouchard(
            $this->getClientIPaddress($request),
            $this->getOS(),
            $this->getBrowser(),
            "Acces Espace Admin - " . Auth::user()->name . " * ",
            "L'admin nommé " . Auth::user()->name . " a accede a son espace admin à la date du " .
                Carbon::now()->translatedFormat('l jS F Y à H:i:s') . "
            avec l'adresse IP suivante : " .
                $this->getClientIPaddress($request) . " le navigateur suivant : " . $this->getBrowser() . "
            depuis la machine : " . $this->getDevice() . " ayant pour systeme d'exploitation : " . $this->getOS() . "."

        );


        return view('admin.adminHome', compact(
            'page_title',
            'app_name',
            'expeditions',
            'paiements',
            'packages',
            'clients',
            'home'
        ));
    }

    ################################################################################################################
    #                                                                                                              #
    #   MON PROFIL                                                                                                 #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminProfil(Request $request)
    {

        $app_name = "LA POSTE";
        $page_title = "Profil";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $agences = Agence::all();

        return view('admin.adminProfil', compact(
            'page_title',
            'app_name',
            'admin',
            'agences'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminUpProfil(Request $request)
    {
        $admin = User::find(Auth::user()->id);
        $admin_id = Auth::user()->id;

        // Récupérer les données du formulaire
        $admin->name = $request->input('noms') . ' ' . $request->input('prenoms');
        $admin->noms = $request->input('noms');
        $admin->prenoms = $request->input('prenoms');
        $admin->email = $request->input('email');
        $admin->phone = $request->input('phone');
        $admin->adresse = $request->input('adresse');
        $admin->agence_id = $request->input('agence_id');

        if ($admin->save()) {

            // Redirection
            return redirect()->back()->with('success', 'Profil modifié avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de modifier votre profil !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminUpAvatar(Request $request)
    {
        // Récupérer utilisateur connecté
        $admin = User::find(Auth::user()->id);
        $admin_id = Auth::user()->id;

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
                    $admin->avatar = url('avatars') . '/' . $filename;

                    // Sauvegarde
                    if ($admin->save()) {

                        // Redirection
                        return redirect()->back()->with('success', 'Avatar modifiée avec succès !');
                    }
                    return redirect()->back()->with('failed', 'Impossible de modifier votre avatar !');
                }
                return redirect()->back()->with('failed', 'Imposible d\'uploader le fichier vers le répertoire défini !');
            }
            return redirect()->back()->with('failed', 'L\'extension du fichier doit être soit du jpg ou du png !');
        }
        return redirect()->back()->with('failed', 'Aucun fichier téléchargé. Veuillez réessayer svp !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminUpPassword(Request $request)
    {
        // Récupérer utilisateur connecté
        $admin = User::find(Auth::user()->id);
        $admin_id = Auth::user()->id;

        // Verifier si les mots de passe sont identiques
        if ($request->input('new_password') == $request->input('confirm_password')) {

            // Récupérer les données du formulaire
            if (Hash::check($request->input('old_password'), $admin->password)) {

                // Preparer le mot de passe
                $admin->password = Hash::make($request->input('new_password'));

                // Sauvergarder
                if ($admin->save()) {

                    // Redirection
                    return redirect()->back()->with('success', 'Mot de passe modifié avec succès !');
                }
                return redirect()->back()->with('failed', 'Impossible de modifier votre mot de passe !');
            }
            return redirect()->back()->with('failed', 'Votre ancien mot de passe semble incorrect. Veuillez saisir le bon svp !');
        }
        return redirect()->back()->with('failed', 'Les mots de passe ne sont pas identiques. Veuillez réessayer svp !');
    }

    ################################################################################################################
    #                                                                                                              #
    #   COMPTE                                                                                                     #
    #                                                                                                              #
    ################################################################################################################


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminCompte(Request $request)
    {

        $app_name = "LA POSTE";
        $page_title = "Compte";
        $account = "side-menu--active";
        $account_sub = "side-menu__sub-open";
        $account2 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $comptes = User::orderBy('id', 'DESC')->paginate(10);
        $agences = Agence::all();

        return view('admin.adminCompte', compact(
            'page_title',
            'app_name',
            'admin',
            'agences',
            'comptes',
            'account',
            'account_sub',
            'account2'
        ));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminNewCompte(Request $request)
    {

        $app_name = "LA POSTE";
        $page_title = "Nouveau Compte";
        $account = "side-menu--active";
        $account_sub = "side-menu__sub-open";
        $account1 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $agences = Agence::all();

        return view('admin.adminNewCompte', compact(
            'page_title',
            'app_name',
            'admin',
            'agences',
            'account',
            'account_sub',
            'account1'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddCompte(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $user = new User();

        // Récupérer les données du formulaire
        $user->name = $request->input('noms') . ' ' . $request->input('prenoms');
        $user->noms = $request->input('noms');
        $user->prenoms = $request->input('prenoms');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->agence_id = $request->input('agence_id');
        $user->adresse = $request->input('adresse');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->active = $request->input('active');
        $user->avatar = url('avatars/avatar.jpg');
        $user->api_token = Str::random(100);
        $user->abonne = 1;

        if ($user->save()) {

            // Redirection
            return redirect()->route('adminCompte')->with('success', 'Nouveau Compte cree avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de creer ce compte !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAvatarCompte(Request $request)
    {
        // Récupérer utilisateur connecté
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get user by id
        $user = User::find($request->input('compte_id'));
        if (!empty($user)) {

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
                        $user->avatar = url('avatars') . '/' . $filename;

                        // Sauvegarde
                        if ($user->save()) {

                            // Redirection
                            return redirect()->back()->with('success', 'Avatar modifiée avec succès !');
                        }
                        return redirect()->back()->with('failed', 'Impossible de modifier votre avatar !');
                    }
                    return redirect()->back()->with('failed', 'Imposible d\'uploader le fichier vers le répertoire défini !');
                }
                return redirect()->back()->with('failed', 'L\'extension du fichier doit être soit du jpg ou du png !');
            }
            return redirect()->back()->with('failed', 'Aucun fichier téléchargé. Veuillez réessayer svp !');
        }
        return redirect()->back()->with('failed', 'Impossible de trouver ce compte !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditCompte(Request $request)
    {
        $root = Auth::user();

        $root_id = Auth::user()->id;

        // Get user by id
        $user = User::find($request->input('compte_id'));
        if (!empty($user)) {

            // Récupérer les données du formulaire
            $user->name = $request->input('noms') . ' ' . $request->input('prenoms');
            $user->noms = $request->input('noms');
            $user->prenoms = $request->input('prenoms');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->agence_id = $request->input('agence_id');
            $user->adresse = $request->input('adresse');
            $user->password = Hash::make($request->input('password'));
            $user->role = $request->input('role');
            $user->active = $request->input('active');
            $user->api_token = Str::random(100);
            $user->abonne = 1;

            if ($user->save()) {

                // Redirection
                return redirect()->back()->with('success', 'Compte modifié avec succès !');
            }
            return redirect()->back()->with('failed', 'Impossible de modifier ce compte !');
        }
        return redirect()->back()->with('failed', 'Impossible de trouver ce compte !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchCompte(Request $request)
    {

        $app_name = "LA POSTE";
        $page_title = "Compte";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $comptes = User::where('name', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('noms', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('prenoms', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('phone', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('role', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('adresse', 'LIKE', '%' . $request->input('q') . '%')
            ->simplePaginate(10);
        $agences = Agence::all();

        // Mouchard
        // $ip_adresse, $os_system, $os_navigator, $action_title, $action_system
        $this->mouchard(
            $this->getClientIPaddress($request),
            $this->getOS(),
            $this->getBrowser(),
            "Recherche Compte Par Mot-Cle - " . $request->input('q') . "*",
            "L'admin nommé " . Auth::user()->name . " a effectue une recherche de compte avec pour mot-cle
            " . $request->input('q') . " à la date du " .
                Carbon::now()->translatedFormat('l jS F Y à H:i:s') . "
            avec l'adresse IP suivante : " .
                $this->getClientIPaddress($request) . " le navigateur suivant : " . $this->getBrowser() . "
            depuis la machine : " . $this->getDevice() . " ayant pour systeme d'exploitation : " . $this->getOS() . "."

        );

        return view('admin.adminCompte', compact(
            'page_title',
            'app_name',
            'admin',
            'agences',
            'comptes'
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
        $place = "side-menu--active";
        $place_sub = "side-menu__sub-open";
        $place1 = "side-menu--active";

        $countries = Pays::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminPays', compact(
            'page_title',
            'app_name',
            'countries',
            'place',
            'place_sub',
            'place1'
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

        if ($country->save()) {

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
        if (!empty($country)) {

            // Récupérer les données du formulaire
            $country->code = $request->input('code');
            $country->libelle = $request->input('libelle');
            $country->active = $request->input('active');

            if ($country->save()) {

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
        if (!empty($country)) {

            // Récupérer le logo
            $image = $request->file('image');

            // Vérifier si le fichier n'est pas vide
            if ($image != null) {

                // Recuperer l'extension du fichier
                $ext = $image->getClientOriginalExtension();

                // Renommer le fichier
                $filename = rand(10000, 50000) . '.' . $ext;

                // Verifier les extensions
                if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'jfif') {

                    // Upload le fichier
                    if ($image->move(public_path('pays/drapeaux'), $filename)) {

                        // Attribuer l'url
                        $country->flag = url('pays/drapeaux') . '/' . $filename;

                        // Sauvegarde
                        if ($country->save()) {

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

        return view('admin.adminPays', compact(
            'page_title',
            'app_name',
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
        $place = "side-menu--active";
        $place_sub = "side-menu__sub-open";
        $place2 = "side-menu--active";

        $provinces = Province::paginate(10);
        $countries = Pays::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminProvince', compact(
            'page_title',
            'app_name',
            'provinces',
            'countries',
            'place',
            'place_sub',
            'place2'
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

        return view('admin.adminProvince', compact(
            'page_title',
            'app_name',
            'provinces',
            'countries'
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

        if ($province->save()) {

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
        if (!empty($province)) {

            // Récupérer les données du formulaire
            $province->code = $request->input('code');
            $province->pays_id = $request->input('pays_id');
            $province->libelle = $request->input('libelle');
            $province->active = $request->input('active');

            if ($province->save()) {

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
        $place = "side-menu--active";
        $place_sub = "side-menu__sub-open";
        $place3 = "side-menu--active";

        $villes = Ville::paginate(10);
        $provinces = Province::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminVille', compact(
            'page_title',
            'app_name',
            'villes',
            'provinces',
            'place',
            'place_sub',
            'place3'
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

        return view('admin.adminVille', compact(
            'page_title',
            'app_name',
            'villes',
            'provinces'
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

        if ($ville->save()) {

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
        if (!empty($ville)) {

            // Récupérer les données du formulaire
            $ville->code = $request->input('code');
            $ville->province_id = $request->input('province_id');
            $ville->libelle = $request->input('libelle');
            $ville->active = $request->input('active');

            if ($ville->save()) {

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


        return view('admin.adminSociete', compact(
            'page_title',
            'app_name',
            'societe',
            'countries',
            'provinces',
            'villes'
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
        if (!empty($societe)) {

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

            if ($societe->save()) {

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
        if (!empty($societe)) {

            // Récupérer le logo
            $image = $request->file('image');

            // Vérifier si le fichier n'est pas vide
            if ($image != null) {

                // Recuperer l'extension du fichier
                $ext = $image->getClientOriginalExtension();

                // Renommer le fichier
                $filename = rand(10000, 50000) . '.' . $ext;

                // Verifier les extensions
                if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'jfif') {

                    // Upload le fichier
                    if ($image->move(public_path('societes/logos'), $filename)) {

                        // Attribuer l'url
                        $societe->logo = url('societes/logos') . '/' . $filename;

                        // Sauvegarde
                        if ($societe->save()) {

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
        if (!empty($societe)) {

            // Récupérer le logo
            $image = $request->file('image');

            // Vérifier si le fichier n'est pas vide
            if ($image != null) {

                // Recuperer l'extension du fichier
                $ext = $image->getClientOriginalExtension();

                // Renommer le fichier
                $filename = rand(10000, 50000) . '.' . $ext;

                // Verifier les extensions
                if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'jfif') {

                    // Upload le fichier
                    if ($image->move(public_path('societes/logos'), $filename)) {

                        // Attribuer l'url
                        $societe->icon = url('societes/logos') . '/' . $filename;

                        // Sauvegarde
                        if ($societe->save()) {

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
        $place = "side-menu--active";
        $place_sub = "side-menu__sub-open";
        $place4 = "side-menu--active";

        $agences = Agence::paginate(10);
        $villes = Ville::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminAgence', compact(
            'page_title',
            'app_name',
            'agences',
            'villes',
            'place',
            'place_sub',
            'place4'
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

        return view('admin.adminAgence', compact(
            'page_title',
            'app_name',
            'agences',
            'villes'
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

        if ($agence->save()) {

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
        if (!empty($agence)) {

            // Récupérer les données du formulaire
            $agence->code = $request->input('code');
            $agence->ville = $request->input('ville');
            $agence->libelle = $request->input('libelle');
            $agence->phone = $request->input('phone');
            $agence->adresse = $request->input('adresse');
            $agence->active = $request->input('active');

            if ($agence->save()) {

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


        return view('admin.adminService', compact(
            'page_title',
            'app_name',
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

        return view('admin.adminService', compact(
            'page_title',
            'app_name',
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

        if ($service->save()) {

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
        if (!empty($service)) {

            // Récupérer les données du formulaire
            $service->code = $request->input('code');
            $service->libelle = $request->input('libelle');
            $service->description = $request->input('description');
            $service->agent_id = $admin_id;
            $service->active = $request->input('active');

            if ($service->save()) {

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


        return view('admin.adminDelai', compact(
            'page_title',
            'app_name',
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

        return view('admin.adminDelai', compact(
            'page_title',
            'app_name',
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

        if ($delai->save()) {

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
        if (!empty($delai)) {

            // Récupérer les données du formulaire
            $delai->code = $request->input('code');
            $delai->libelle = $request->input('libelle');
            $delai->description = $request->input('description');
            $delai->agent_id = $admin_id;
            $delai->active = $request->input('active');

            if ($delai->save()) {

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


        return view('admin.adminStatut', compact(
            'page_title',
            'app_name',
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

        return view('admin.adminStatut', compact(
            'page_title',
            'app_name',
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

        if ($statut->save()) {

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
        if (!empty($statut)) {

            // Récupérer les données du formulaire
            $statut->code = $request->input('code');
            $statut->libelle = $request->input('libelle');
            $statut->description = $request->input('description');
            $statut->code_hexa = $request->input('code_hexa');
            $statut->agent_id = $admin_id;
            $statut->active = $request->input('active');

            if ($statut->save()) {

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


        return view('admin.adminForfait', compact(
            'page_title',
            'app_name',
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

        return view('admin.adminForfait', compact(
            'page_title',
            'app_name',
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

        if ($forfait->save()) {

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
        if (!empty($forfait)) {

            // Récupérer les données du formulaire
            $forfait->code = $request->input('code');
            $forfait->libelle = $request->input('libelle');
            $forfait->description = $request->input('description');
            $forfait->agent_id = $admin_id;
            $forfait->active = $request->input('active');

            if ($forfait->save()) {

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


        return view('admin.adminTarif', compact(
            'page_title',
            'app_name',
            'tarifs',
            'countries',
            'provinces',
            'villes'
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

        return view('admin.adminTarif', compact(
            'page_title',
            'app_name',
            'tarifs',
            'countries',
            'provinces',
            'villes'
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

        if ($tarif->save()) {

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
        if (!empty($tarif)) {

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

            if ($tarif->save()) {

                // Redirection
                return redirect()->back()->with('success', 'Tarif modifié avec succès !');
            }
            return redirect()->back()->with('failed', 'Impossible de modifier ce tarif !');
        }
        return redirect()->back()->with('failed', 'Impossible de trouver ce tarif !');
    }

    ################################################################################################################
    #                                                                                                              #
    #   PRICING                                                                                                      #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminType(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Types d'expedition";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting43 = "side-menu--active";

        $types = TypeExpedition::paginate(10);

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        return view('admin.adminType', compact(
            'page_title',
            'app_name',
            'types',
            'setting',
            'setting_sub',
            'setting_sub4',
            'setting4',
            'setting43',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddType(Request $request)
    {
        $admin_id = Auth::user()->id;

        $tarif = new TypeExpedition();

        // Récupérer les données du formulaire
        $tarif->code = $request->input('code');
        $tarif->libelle = $request->input('libelle');
        $tarif->agent_id = $admin_id;
        $tarif->active = $request->input('active');

        if ($tarif->save()) {
            // Redirection
            return back()->with('success', 'Nouveau Type crée avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce Type !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditType(Request $request)
    {
        $admin_id = Auth::user()->id;

        // Get tarif by id
        $type = TypeExpedition::find($request->input('type_id'));
        if (!empty($type)) {

            // Récupérer les données du formulaire
            $type->code = $request->input('code');
            $type->libelle = $request->input('libelle');
            $type->agent_id = $admin_id;
            $type->active = $request->input('active');

            if ($type->save()) {
                // Redirection
                return back()->with('success', 'Type modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier ce type !');
        }
        return back()->with('failed', 'Impossible de trouver ce type !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminRegime(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Régimes d'expedition";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting42 = "side-menu--active";

        $regimes = RegimeExpedition::paginate(10);
        $types = TypeExpedition::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminRegime', compact(
            'page_title',
            'app_name',
            'regimes',
            'types',
            'setting',
            'setting_sub',
            'setting_sub4',
            'setting4',
            'setting42',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddRegime(Request $request)
    {
        $admin_id = Auth::user()->id;

        $regime = new RegimeExpedition();

        // Récupérer les données du formulaire
        $regime->code = $request->input('code');
        $regime->libelle = $request->input('libelle');
        $regime->agent_id = $admin_id;
        $regime->type_id = $request->input('type_exp');
        $regime->active = $request->input('active');

        if ($regime->save()) {
            // Redirection
            return back()->with('success', 'Nouveau Régime crée avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce tarif !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditRegime(Request $request)
    {
        $admin_id = Auth::user()->id;

        // Get tarif by id
        $regime = TarifExpedition::find($request->input('regime_id'));
        if (!empty($regime)) {

            // Récupérer les données du formulaire
            $regime->code = $request->input('code');
            $regime->libelle = $request->input('libelle');
            $regime->agent_id = $admin_id;
            $regime->type_id = $request->input('type_exp');
            $regime->active = $request->input('active');

            if ($regime->save()) {
                // Redirection
                return back()->with('success', 'Régime modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier ce tarif !');
        }
        return back()->with('failed', 'Impossible de trouver ce tarif !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminCategory(Request $request)
    {
        $app_name = "La Poste";
        $page_title = "Catégories d'expedition";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting43 = "side-menu--active";

        $categories = CategoryExpedition::paginate(10);
        $regimes = RegimeExpedition::all();

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        return view('admin.adminCategory', compact(
            'page_title',
            'app_name',
            'categories',
            'regimes',
            'setting',
            'setting_sub',
            'setting_sub4',
            'setting4',
            'setting43',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddCategory(Request $request)
    {
        $admin_id = Auth::user()->id;

        $category = new CategoryExpedition();
        $regime = RegimeExpedition::find($request->input('regime_exp'));

        // Récupérer les données du formulaire
        $category->code = $request->input('code');
        $category->libelle = $request->input('libelle');
        $category->type_id = $regime->type_id;
        $category->regime_id = $regime->id;
        $category->agent_id = $admin_id;
        $category->active = $request->input('active');

        if ($category->save()) {
            // Redirection
            return back()->with('success', 'Nouvelle catégorie crée avec succès !');
        }
        return back()->with('failed', 'Impossible de creer  cette catégorie !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditCategory(Request $request)
    {
        $admin_id = Auth::user()->id;

        // Get tarif by id
        $category = CategoryExpedition::find($request->input('category_id'));
        $regime = RegimeExpedition::find($request->input('regime_exp'));
        if (!empty($category)) {

            // Récupérer les données du formulaire
            $category->code = $request->input('code');
            $category->libelle = $request->input('libelle');
            $category->type_id = $regime->type_id;
            $category->regime_id = $regime->id;
            $category->agent_id = $admin_id;
            $category->active = $request->input('active');

            if ($category->save()) {
                // Redirection
                return back()->with('success', 'catégorie modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier  cette catégorie !');
        }
        return back()->with('failed', 'Impossible de trouver cette catégorie !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPrice(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Tarifs expedition";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting44 = "side-menu--active";

        $prices = PriceExpedition::paginate(10);
        $categories = CategoryExpedition::all();

        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminPrice', compact(
            'page_title',
            'app_name',
            'prices',
            'categories',
            'setting',
            'setting_sub',
            'setting_sub4',
            'setting4',
            'setting44',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddPrice(Request $request)
    {
        $admin_id = Auth::user()->id;

        $price = new PriceExpedition();
        $category = CategoryExpedition::find($request->input('category_exp'));

        // Récupérer les données du formulaire
        $price->code = $request->input('code');
        $price->weight = $request->input('weight');
        $price->price = $request->input('price');
        $price->type_id = $category->type_id;
        $price->category_id = $category->id;
        $price->regime_id = $category->regime_id;
        $price->agent_id = $admin_id;
        $price->active = $request->input('active');

        if ($price->save()) {
            // Redirection
            return back()->with('success', 'Nouveau tarif crée avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce tarif !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditPrice(Request $request)
    {
        $admin_id = Auth::user()->id;

        // Get tarif by id
        $price = PriceExpedition::find($request->input('price_id'));
        $category = CategoryExpedition::find($request->input('category_exp'));
        if (!empty($price)) {

            // Récupérer les données du formulaire
            $price->code = $request->input('code');
            $price->weight = $request->input('weight');
            $price->price = $request->input('price');
            $price->type_id = $category->type_id;
            $price->category_id = $category->id;
            $price->regime_id = $category->regime_id;
            $price->agent_id = $admin_id;
            $price->active = $request->input('active');

            if ($price->save()) {
                // Redirection
                return back()->with('success', 'Tarif modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier ce tarif !');
        }
        return back()->with('failed', 'Impossible de trouver ce tarif !');
    }

    public function selectData(Request $request)
    {
        if ($request->target == 'regime') {
            $organization = RegimeExpedition::where('type_id', $request->id)->get();
            $response = json_encode($organization);

            return response()->json($response);
        } elseif ($request->target == 'category') {
            $organization = CategoryExpedition::where('regime_id', $request->id)->get();
            $response = json_encode($organization);

            return response()->json($response);
        } elseif ($request->target == 'price') {
            $organization = PriceExpedition::where('category_id', $request->id)->get();
            $response = json_encode($organization);

            return response()->json($response);
        }
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
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp2 = "side-menu--active";

        $expeditions = Expedition::orderBy('id', 'DESC')->paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminExpeditionList', compact(
            'page_title',
            'app_name',
            'expeditions',
            'exp',
            'exp_sub',
            'exp2'
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
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp1 = "side-menu--active";

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

        $types = TypeExpedition::all();


        $documents = DocumentExpedition::where('code', $code_aleatoire)->get();
        $paquets = ColisExpedition::where('code', $code_aleatoire)->get();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminNewExpedition', compact(
            'page_title',
            'app_name',
            'code_aleatoire',
            'countries',
            'provinces',
            'villes',
            'agences',
            'forfaits',
            'services',
            'delais',
            'documents',
            'paquets',
            'types',
            'societe',
            'exp',
            'exp1',
            'exp_sub'
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


        return view('admin.adminStep1', compact(
            'page_title',
            'app_name',
            'code_aleatoire',
            'countries',
            'provinces',
            'villes',
            'agences',
            'forfaits',
            'services',
            'delais',
            'documents',
            'paquets',
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


        return view('admin.adminStep2', compact(
            'page_title',
            'app_name',
            'code_aleatoire',
            'countries',
            'provinces',
            'villes',
            'agences',
            'forfaits',
            'services',
            'delais',
            'documents',
            'paquets',
            'societe',
            'code',
            'expedition'
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


        return view('admin.adminStep3', compact(
            'page_title',
            'app_name',
            'code_aleatoire',
            'countries',
            'provinces',
            'villes',
            'agences',
            'forfaits',
            'services',
            'delais',
            'documents',
            'paquets',
            'societe',
            'code',
            'expedition'
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


        return view('admin.adminStep4', compact(
            'page_title',
            'app_name',
            'code_aleatoire',
            'countries',
            'provinces',
            'villes',
            'agences',
            'forfaits',
            'services',
            'delais',
            'documents',
            'paquets',
            'societe',
            'code',
            'expedition'
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


        return view('admin.adminStep5', compact(
            'page_title',
            'app_name',
            'code_aleatoire',
            'countries',
            'provinces',
            'villes',
            'agences',
            'forfaits',
            'services',
            'delais',
            'documents',
            'paquets',
            'societe',
            'code',
            'expedition'
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
        if ($image != null) {

            // Recuperer l'extension du fichier
            $ext = $image->getClientOriginalExtension();

            // Renommer le fichier
            $filename = rand(10000, 50000) . '.' . $ext;

            // Verifier les extensions
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'jfif' || $ext == 'pdf') {

                // Upload le fichier
                if ($image->move(public_path('expeditions/documents'), $filename)) {

                    // Attribuer l'url
                    $document->url = url('expeditions/documents') . '/' . $filename;

                    // Sauvegarde
                    if ($document->save()) {

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
        $admin_id = Auth::user()->id;

        $paquet = new ColisExpedition();
        $price = PriceExpedition::find($request->input('poids'));

        // Récupérer les données du formulaire
        $paquet->code = $request->input('code');
        $paquet->libelle = $request->input('libelle');
        $paquet->description = $request->input('description');
        $paquet->poids = $price->id;
        $paquet->agent_id = $admin_id;
        $paquet->active = 1;

        if ($paquet->save()) {
            $paquet->load(['price']);
            $response = json_encode($paquet);
            return response()->json($response);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminDeletePaquet(Request $request)
    {
        $admin_id = Auth::user()->id;
        $paquet = ColisExpedition::find($request->input('id'));

        if ($paquet) {
            $id = $paquet->id;
            $price = PriceExpedition::find($paquet->poids);
            $paquet->delete();
            $response = json_encode([$id, $price]);
            return response()->json($response);
        } else {
            $response = json_encode(0);
            return response()->json($response);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddExpedition(Request $request)
    {
        $admin = User::find(Auth::user()->id);
        $admin_id = Auth::user()->id;

        // Store data
        $code_aleatoire = $request->input('code_aleatoire');
        $agence_id = $request->input('agence_id');

        // Check if this expedition have almost one colis
        $paquets = ColisExpedition::where('code', $code_aleatoire)->get();

        if ($paquets->count() > 0) {

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
            $expedition->type_exp_id = $request->input('type_id');
            $expedition->regime_exp_id = $request->input('regime_id');
            $expedition->category_exp_id = $request->input('category_id');

            $expedition->amount = $request->input('amount');

            $expedition->agent_id = $admin_id;
            $expedition->active = 1;

            if ($expedition->save()) {

                // Mise a jour Documents et colis
                DB::table('document_expeditions')
                    ->where('code', $code_aleatoire)
                    ->update(['expedition_id' => $expedition->id]);

                // Get Sum Poids des colis
                $poids_total = ColisExpedition::where('code', $code_aleatoire)->sum('poids');

                // New Facture
                $facture = new FactureExpedition();

                $facture->code = $code_aleatoire;
                $facture->expedition_id = $expedition->id;

                $facture->save();

                // Redirection
                return redirect('/dashboard/admin/expeditions')->with('success', 'Expedition ajoutee avec succès !');
            }
            return back()->with('failed', 'Impossible de rajouter cette expedition !');
        } else {
            return back()->with('failed', 'Veuillez rajouter aumoins un colis svp !');
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

        if ($expedition->save()) {

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
        if (!empty($expedition)) {

            // Récupérer les données du formulaire
            $expedition->service_exp_id = $request->input('service_exp_id');
            $expedition->delai_exp_id = $request->input('delai_exp_id');
            $expedition->forfait_exp_id = $request->input('forfait_exp_id');

            if ($expedition->save()) {

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
        if (!empty($expedition)) {

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
            $facture->active = 0;

            if ($facture->save()) {

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

        $app_name = "La Poste";
        $page_title = "Facture Expedition";
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp2 = "side-menu--active";

        $societe = Societe::find(1);

        // Get expedition by id
        $expedition = Expedition::where('code_aleatoire', $code)->first();
        if (!empty($expedition)) {

            // Récupérer les données
            $expedition_id = intval($expedition->id);
            $paquets = ColisExpedition::where('code', $code)->get();

            $expedition->load(['type', 'regime', 'category']);

            // Get facture by expedition_id
            $facture = FactureExpedition::where('expedition_id', $expedition_id)->first();

            if (!empty($facture)) {

                // Redirection
                return view('admin.adminFactureExpedition', compact(
                    'page_title',
                    'app_name',
                    'facture',
                    'expedition',
                    'societe',
                    'paquets',
                    'exp',
                    'exp_sub',
                    'exp2'
                ));
            }
            return back()->with('failed', 'Impossible de modifier cette expedition !');
        }
        return back()->with('failed', 'Impossible de trouver cette expedition !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminFacturePrint(Request $request, $code)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $app_name = "La Poste";
        $page_title = "Facture Expedition";
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp2 = "side-menu--active";

        $societe = Societe::find(1);

        // Get expedition by id
        $expedition = Expedition::where('code_aleatoire', $code)->first();
        if (!empty($expedition)) {

            // Récupérer les données
            $expedition_id = intval($expedition->id);
            $paquets = ColisExpedition::where('code', $code)->get();

            // Get facture by expedition_id
            $facture = FactureExpedition::where('expedition_id', $expedition_id)->first();

            if (!empty($facture)) {

                // Redirection
                return view('admin.adminFacturePrint', compact(
                    'page_title',
                    'app_name',
                    'facture',
                    'expedition',
                    'societe',
                    'paquets',
                    'exp',
                    'exp_sub',
                    'exp2'
                ));
            }
            return redirect()->back()->with('failed', 'Impossible de modifier cette expedition !');
        }
        return redirect()->back()->with('failed', 'Impossible de trouver cette expedition !');
    }

    ################################################################################################################
    #                                                                                                              #
    #   ETIQUETTE                                                                                                  #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEtiquetteExpedition(Request $request, $code)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $app_name = "La Poste";
        $page_title = "Facture Expedition";

        $societe = Societe::find(1);

        // Get expedition by id
        $expedition = Expedition::where('code_aleatoire', $code)->first();
        if (!empty($expedition)) {

            // Récupérer les données
            $expedition_id = intval($expedition->id);
            $paquets = ColisExpedition::where('code', $code)->get();

            // Get facture by expedition_id
            $facture = FactureExpedition::where('expedition_id', $expedition_id)->first();

            if (!empty($facture)) {

                // Redirection
                return view('admin.adminEtiquetteExpedition', compact(
                    'page_title',
                    'app_name',
                    'facture',
                    'expedition',
                    'societe',
                    'paquets'
                ));
            }
            return redirect()->back()->with('failed', 'Impossible de modifier cette expedition !');
        }
        return redirect()->back()->with('failed', 'Impossible de trouver cette expedition !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEtiquettePrint(Request $request, $code)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $app_name = "La Poste";
        $page_title = "Etiquette Expedition";

        $societe = Societe::find(1);

        // Get expedition by id
        $expedition = Expedition::where('code_aleatoire', $code)->first();
        if (!empty($expedition)) {

            // Récupérer les données
            $expedition_id = intval($expedition->id);
            $paquets = ColisExpedition::where('code', $code)->get();

            // Get facture by expedition_id
            $facture = FactureExpedition::where('expedition_id', $expedition_id)->first();

            if (!empty($facture)) {

                // Redirection
                return view('admin.adminEtiquettePrint', compact(
                    'page_title',
                    'app_name',
                    'facture',
                    'expedition',
                    'societe',
                    'paquets'
                ));
            }
            return redirect()->back()->with('failed', 'Impossible de modifier cette expedition !');
        }
        return redirect()->back()->with('failed', 'Impossible de trouver cette expedition !');
    }

    ################################################################################################################
    #                                                                                                              #
    #   SUIVI                                                                                                      #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSuiviExpedition(Request $request, $code)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $app_name = "La Poste";
        $page_title = "Suivi Expedition";
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp2 = "side-menu--active";

        $societe = Societe::find(1);

        // Get expedition by id
        $expedition = Expedition::where('code_aleatoire', $code)->first();
        if (!empty($expedition)) {

            $expedition->load(['type', 'regime', 'category']);
            // Récupérer les données
            $expedition_id = intval($expedition->id);
            $paquets = ColisExpedition::where('code', $code)->get();
            $historiques = SuiviExpedition::where('code', $code)->get();

            // Get facture by expedition_id
            $facture = FactureExpedition::where('expedition_id', $expedition_id)->first();

            if (!empty($facture)) {

                // Redirection
                return view('admin.adminSuiviExpedition', compact(
                    'page_title',
                    'app_name',
                    'facture',
                    'expedition',
                    'societe',
                    'paquets',
                    'historiques',
                    'exp',
                    'exp_sub',
                    'exp2'
                ));
            }
            return back()->with('failed', 'Impossible de modifier cette expedition !');
        }
        return back()->with('failed', 'Impossible de trouver cette expedition !');
    }

    ################################################################################################################
    #                                                                                                              #
    #   PACKAGE                                                                                                    #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPackage(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Packages";
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp3 = "side-menu--active";

        $packages = Package::orderBy('id', 'DESC')->paginate(10);
        $agences = Agence::all();
        $villes = Ville::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminPackage', compact(
            'page_title',
            'app_name',
            'packages',
            'agences',
            'villes',
            'exp',
            'exp_sub',
            'exp3'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchPackage(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Packages";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $packages = Package::where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('description', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);
        $agences = Agence::all();
        $villes = Ville::all();

        return view('admin.adminPackage', compact(
            'page_title',
            'app_name',
            'packages',
            'agences',
            'villes'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddPackage(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $code = Carbon::now()->timestamp;
        $agence_origine = Agence::find($request->input('agence_origine_id'));
        $agence_destination = Agence::find($request->input('agence_destination_id'));

        $package = new Package();

        // Récupérer les données du formulaire
        $package->code = $code . '.' . $agence_origine->code . '.' . $agence_destination->code;

        $package->libelle = $request->input('libelle');
        $package->description = $request->input('description');

        $package->ville_origine_id = $request->input('ville_origine_id');
        $package->ville_destination_id = $request->input('ville_destination_id');

        $package->agence_origine_id = $request->input('agence_origine_id');
        $package->agence_destination_id = $request->input('agence_destination_id');


        $package->agent_id = $admin_id;
        $package->active = $request->input('active');

        if ($package->save()) {

            // Redirection
            return redirect()->back()->with('success', 'Nouveau Package crée avec succès !');
        }
        return redirect()->back()->with('failed', 'Impossible de creer ce package !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditPackage(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get package by id
        $package = Package::find($request->input('package_id'));
        if (!empty($package)) {

            // Récupérer les données du formulaire
            $package->libelle = $request->input('libelle');
            $package->description = $request->input('description');

            $package->ville_origine_id = $request->input('ville_origine_id');
            $package->ville_destination_id = $request->input('ville_destination_id');

            $package->agence_origine_id = $request->input('agence_origine_id');
            $package->agence_destination_id = $request->input('agence_destination_id');


            $package->agent_id = $admin_id;
            $package->active = $request->input('active');

            if ($package->save()) {

                // Redirection
                return redirect()->back()->with('success', 'Package modifié avec succès !');
            }
            return redirect()->back()->with('failed', 'Impossible de modifier ce package !');
        }
        return redirect()->back()->with('failed', 'Impossible de trouver ce package !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminDetailPackage(Request $request, $code)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $app_name = "La Poste";
        $page_title = "Detail Package";
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp3 = "side-menu--active";

        $societe = Societe::find(1);

        // Get package by code
        $package = Package::where('code', $code)->first();
        if (!empty($package)) {

            // Get today carbon date
            $today = Carbon::today();

            // Get colis du jours
            $today_paquets = PackageExpedition::where('package_id', $package->id)->paginate(10);

            if (!empty($today_paquets)) {

                $today_paquets->load(['colis']);
                // Redirection
                return view('admin.adminDetailPackage', compact(
                    'page_title',
                    'app_name',
                    'today_paquets',
                    'societe',
                    'package',
                    'exp',
                    'exp_sub',
                    'exp3'
                ));
            }
            return redirect()->back()->with('failed', 'Aucun colis expedie pour le moment !');
        }
        return redirect()->back()->with('failed', 'Impossible de trouver cette expedition !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPackageAssign(Request $request)
    {
        $admin_id = Auth::user()->id;

        // Get package by id
        $package = Package::find($request->input('package'));
        if (!empty($package)) {

            foreach ($request->input('colis') as $colis) {
                $paquet = ColisExpedition::find($colis);

                if (!empty($paquet)) {

                    // Check if this colis is already assigned
                    $old_assign = PackageExpedition::where('colis_id', $paquet->id)->get();
                    if (empty($old_assign) || count($old_assign) == 0) {

                        $code = Carbon::now()->timestamp;
                        $code_package = $package->code;
                        $code_colis = $paquet->code;

                        $assign = new PackageExpedition();

                        // Récupérer les données du formulaire
                        $assign->code = $code . '.' . $code_package . '.' . $code_colis;
                        $assign->package_id = $request->input('package');
                        $assign->colis_id = $colis;

                        $assign->agent_id = $admin_id;
                        $assign->active = 1;

                        if ($assign->save()) {

                            // Update package
                            DB::table('packages')
                                ->where('id', $package->id)
                                ->increment('nbre_colis');

                            // Update colis
                            $colis = DB::table('colis_expeditions')
                                ->where('id', $paquet->id)
                                ->update([
                                    'active' => 2
                                ]);

                            $assigns = PackageExpedition::where('package_id', $package->id)->get();

                            $assigns->load(['colis']);

                            // Redirection
                            $response = json_encode($assigns);
                            return response()->json($response);
                        }
                    } else {
                        $response = json_encode(0);
                        return response()->json($response);
                    }
                }
            }
            // Get colis by id
        } else {
            $response = json_encode(1);
            return response()->json($response);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSuiviPackage(Request $request, $code)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $app_name = "La Poste";
        $page_title = "Suivi Package";
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp3 = "side-menu--active";

        $societe = Societe::find(1);

        // Get package by code
        $package = Package::where('code', $code)->first();
        if (!empty($package)) {

            // Get today carbon date
            $today = Carbon::today();

            // Get colis du jours
            $today_paquets = PackageExpedition::where('package_id', $package->id)->paginate(10);

            if (!empty($today_paquets)) {
                $today_paquets->load(['colis']);
                // Redirection
                return view('admin.adminSuiviPackage', compact(
                    'page_title',
                    'app_name',
                    'today_paquets',
                    'societe',
                    'package',
                    'exp',
                    'exp_sub',
                    'exp3'
                ));
            }
            return back()->with('failed', 'Aucun colis expedie pour le moment !');
        }
        return back()->with('failed', 'Impossible de trouver cette expedition !');
    }

    ################################################################################################################
    #                                                                                                              #
    #   MOUCHARD                                                                                                   #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminMouchard(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Logs Systeme";


        $mouchards = Mouchard::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminMouchard', compact(
            'page_title',
            'app_name',
            'mouchards'
        ));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchMouchard(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Logs Systeme";


        $mouchards = Mouchard::where('action_author', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('action_title', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('action_system', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('ip_adresse', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('os_navigator', 'LIKE', '%' . $request->input('q') . '%')
            ->simplePaginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminMouchard', compact(
            'page_title',
            'app_name',
            'mouchards'
        ));
    }


    ################################################################################################################
    #                                                                                                              #
    #   FONCTIONS UTILES                                                                                           #
    #                                                                                                              #
    ################################################################################################################


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mouchard($ip_adresse, $os_system, $os_navigator, $action_title, $action_system)
    {
        // Get user's
        $author = Auth::user() ? Auth::user()->name : "Admin Inconnu";

        // Instancier mouchard
        $mouchard = new Mouchard();

        // Préparer la requete
        $mouchard->ip_adresse = $ip_adresse;
        $mouchard->os_system = $os_system;
        $mouchard->os_navigator = $os_navigator;
        $mouchard->action_title = $action_title;
        $mouchard->action_author = $author;
        $mouchard->action_system = $action_system;

        // Sauvegarder
        $mouchard->save();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClientIPaddress(Request $request)
    {

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $clientIp = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $clientIp = $forward;
        } else {
            $clientIp = $remote;
        }

        return $clientIp;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDevice()
    {

        $device = Agent::device();

        return $device;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBrowser()
    {

        $browser = Agent::browser();
        $version = Agent::version($browser);

        $navigator = $browser . ' (' . $version . ') ';

        return $navigator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOS()
    {

        $platform = Agent::platform();
        $version = Agent::version($platform);

        $os_system = $platform . ' (' . $version . ') ';

        return $os_system;
    }
}
