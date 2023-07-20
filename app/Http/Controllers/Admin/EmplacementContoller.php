<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\Pays;
use App\Models\Province;
use App\Models\Reseau;
use App\Models\Ville;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmplacementContoller extends Controller
{
    //

    ################################################################################################################
    #                                                                                                              #
    #   RESEAUX                                                                                                       #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminReseaux(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Réseaux";
        $place = "side-menu--active";
        $place_sub = "side-menu__sub-open";
        $place1 = "side-menu--active";

        $reseaux = Reseau::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminReseaux', compact(
            'page_title',
            'app_name',
            'reseaux',
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
    public function adminAddReseau(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $reseau = new Reseau();

        // Récupérer les données du formulaire
        $reseau->code = $request->input('code');
        $reseau->libelle = $request->input('libelle');
        $reseau->active = $request->input('active');

        if ($reseau->save()) {
            // Redirection
            return back()->with('success', 'Nouveau réseau cree avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce pays !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditReseau(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get pays by id
        $reseau = Reseau::find($request->input('reseau_id'));

        if (!empty($reseau)) {

            // Récupérer les données du formulaire
            $reseau->code = $request->input('code');
            $reseau->libelle = $request->input('libelle');
            $reseau->active = $request->input('active');

            if ($reseau->save()) {

                // Redirection
                return back()->with('success', 'Réseau modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier ce pays !');
        }
        return back()->with('failed', 'Impossible de trouver ce pays !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchReseau(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Réseaux";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $reseaux = Reseau::where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);

        return view('admin.adminReseaux', compact(
            'page_title',
            'app_name',
            'reseaux'
        ));
    }

    ################################################################################################################
    #                                                                                                              #
    #   Zones                                                                                                       #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminZones(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Zones";
        $place = "side-menu--active";
        $place_sub = "side-menu__sub-open";
        $place2 = "side-menu--active";

        $zones = Zone::paginate(10);
        $reseaux = Reseau::all();

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        return view('admin.adminZones', compact(
            'page_title',
            'app_name',
            'zones',
            'reseaux',
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
    public function adminAddZone(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $zone = new Zone();

        // Récupérer les données du formulaire
        $zone->code = $request->input('code');
        $zone->libelle = $request->input('libelle');
        $zone->reseau_id = $request->input('reseau_id');
        $zone->active = $request->input('active');

        if ($zone->save()) {

            // Redirection
            return back()->with('success', 'Nouvelle Zone cree avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce pays !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditZone(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get pays by id
        $zone = Zone::find($request->input('zone_id'));
        if (!empty($country)) {

            // Récupérer les données du formulaire
            $zone->code = $request->input('code');
            $zone->libelle = $request->input('libelle');
            $zone->reseau_id = $request->input('reseau_id');
            $zone->active = $request->input('active');

            if ($country->save()) {

                // Redirection
                return back()->with('success', 'Zone modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier cette zone !');
        }
        return back()->with('failed', 'Impossible de trouver cette zone !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchZone(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Zones";
        $place = "side-menu--active";
        $place_sub = "side-menu__sub-open";
        $place2 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $zones = Zone::where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);

        $reseaux = Reseau::all();

        return view('admin.adminPays', compact(
            'page_title',
            'app_name',
            'zones',
            'reseaux',
            'place',
            'place_sub',
            'place2'
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
        $place3 = "side-menu--active";

        $countries = Pays::paginate(10);

        $zones = Zone::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminPays', compact(
            'page_title',
            'app_name',
            'countries',
            'zones',
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
    public function adminAddPays(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $country = new Pays();

        // Récupérer les données du formulaire
        $country->code = $request->input('code');
        $country->libelle = $request->input('libelle');
        $country->zone_id = $request->input('zone_id');
        $country->active = $request->input('active');

        if ($country->save()) {

            // Redirection
            return back()->with('success', 'Nouveau Pays cree avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce pays !');
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
            $country->zone_id = $request->input('zone_id');
            $country->active = $request->input('active');

            if ($country->save()) {

                // Redirection
                return back()->with('success', 'Pays modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier ce pays !');
        }
        return back()->with('failed', 'Impossible de trouver ce pays !');
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
                            return back()->with('success', 'Drapeau modifiée avec succès !');
                        }
                        return back()->with('failed', 'Impossible de modifier votre drapeau !');
                    }
                    return back()->with('failed', 'Imposible d\'uploader le fichier vers le répertoire défini !');
                }
                return back()->with('failed', 'L\'extension du fichier doit être soit du jpg ou du png !');
            }
            return back()->with('failed', 'Aucun fichier téléchargé. Veuillez réessayer svp !');
        }
        return back()->with('failed', 'Impossible de trouver ce pays !');
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
        $place = "side-menu--active";
        $place_sub = "side-menu__sub-open";
        $place3 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $countries = Pays::where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);
        $zones = Zone::all();

        return view('admin.adminPays', compact(
            'page_title',
            'app_name',
            'countries',
            'zones',
            'place',
            'place_sub',
            'place3'
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
        $place4 = "side-menu--active";

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
            'place4'
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
        $place = "side-menu--active";
        $place_sub = "side-menu__sub-open";
        $place4 = "side-menu--active";

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
            'countries',
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
            return back()->with('success', 'Nouvelle Province créee avec succès !');
        }
        return back()->with('failed', 'Impossible de creer cette province !');
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
                return back()->with('success', 'Province modifiée avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier cette province !');
        }
        return back()->with('failed', 'Impossible de trouver cette province !');
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
        $place5 = "side-menu--active";

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
            'place5'
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
        $place = "side-menu--active";
        $place_sub = "side-menu__sub-open";
        $place5 = "side-menu--active";

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
            'provinces',
            'place',
            'place_sub',
            'place5'
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
            return back()->with('success', 'Nouvelle Ville créee avec succès !');
        }
        return back()->with('failed', 'Impossible de creer cette ville !');
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
                return back()->with('success', 'Ville modifiée avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier cette ville !');
        }
        return back()->with('failed', 'Impossible de trouver cette ville !');
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
        $page_title = "Bureaux de Poste";
        $place = "side-menu--active";
        $place_sub = "side-menu__sub-open";
        $place6 = "side-menu--active";

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
            'place6'
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
        $page_title = "Bureaux de Poste";
        $place = "side-menu--active";
        $place_sub = "side-menu__sub-open";
        $place6 = "side-menu--active";

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
            'villes',
            'place',
            'place_sub',
            'place6'
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
        $agence->ville_id = $request->input('ville_id');
        $agence->libelle = $request->input('libelle');
        $agence->phone = $request->input('phone');
        $agence->adresse = $request->input('adresse');
        $agence->active = $request->input('active');

        if ($agence->save()) {

            // Redirection
            return back()->with('success', 'Nouveau bureau créee avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce bureau !');
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
            $agence->ville_id = $request->input('ville_id');
            $agence->libelle = $request->input('libelle');
            $agence->phone = $request->input('phone');
            $agence->adresse = $request->input('adresse');
            $agence->active = $request->input('active');

            if ($agence->save()) {

                // Redirection
                return back()->with('success', 'Bureau modifiée avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier ce bureau !');
        }
        return back()->with('failed', 'Impossible de trouver ce bureau !');
    }
}
