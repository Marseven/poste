<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Expedition;
use App\Models\Package;
use App\Models\Paiement;
use App\Models\Pays;
use App\Models\Province;
use App\Models\Reclamation;
use App\Models\Societe;
use App\Models\Ville;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Jenssegers\Agent\Facades\Agent;

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
        $home = "side-menu--active";

        // Get today carbon date
        $today = Carbon::today();

        $expeditions = Expedition::orderBy('id', 'DESC')->limit(10)->get();
        $paiements = Paiement::where('status', STATUT_PAID)->get();
        $packages = Package::all();

        $exp_j = Expedition::whereDate('created_at', $today)->where('mode_exp_id', 2)->get();
        $exp_j_pending = Expedition::whereDate('created_at', $today)->where('mode_exp_id', 2)->where('etape_id', '<>', 4)->get();
        $exp_j_do = Expedition::whereDate('created_at', $today)->where('mode_exp_id', 2)->where('etape_id', 4)->get();

        $exp = Expedition::all();
        $exp_pending = Expedition::where('etape_id', '<>', 4)->get();
        $exp_do = Expedition::where('etape_id', 4)->get();

        $reservations = Expedition::where('client_id', '<>', null)->get();
        $reclamations = Reclamation::all();

        $ca = Paiement::selectRaw("SUM(amount) as am")->where('status', 3)->first();

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Mouchard
        // $ip_adresse, $os_system, $os_navigator, $action_title, $action_system
        SettingController::mouchard(
            SettingController::getClientIPaddress($request),
            SettingController::getOS(),
            SettingController::getBrowser(),
            "Acces Espace Admin - " . Auth::user()->name . " * ",
            "L'admin nommé " . Auth::user()->name . " a accede a son espace admin à la date du " .
                Carbon::now()->translatedFormat('l jS F Y à H:i:s') . "
            avec l'adresse IP suivante : " .
                SettingController::getClientIPaddress($request) . " le navigateur suivant : " .  SettingController::getBrowser() . "
            depuis la machine : " .  SettingController::getDevice() . " ayant pour systeme d'exploitation : " . SettingController::getOS() . "."
        );


        return view('admin.adminHome', compact(
            'page_title',
            'app_name',
            'expeditions',
            'paiements',
            'packages',
            'home',
            'exp_j',
            'exp_j_pending',
            'exp_j_do',
            'exp',
            'exp_pending',
            'exp_do',
            'reservations',
            'reclamations',
            'ca',
        ));
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
}
