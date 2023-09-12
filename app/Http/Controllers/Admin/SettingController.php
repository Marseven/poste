<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\DelaiExpedition;
use App\Models\Etape;
use App\Models\MethodePaiement;
use App\Models\ModeExpedition;
use App\Models\Mouchard;
use App\Models\Pays;
use App\Models\PriceExpedition;
use App\Models\Province;
use App\Models\Reseau;
use App\Models\ServiceExpedition;
use App\Models\User;
use App\Models\Ville;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Facades\Agent;

class SettingController extends Controller
{
    //

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
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting41 = "side-menu--active";

        $services = ServiceExpedition::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminService', compact(
            'page_title',
            'app_name',
            'services',
            'setting',
            'setting_sub',
            'setting_sub4',
            'setting4',
            'setting41',
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
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting41 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $services = ServiceExpedition::where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);

        return view('admin.adminService', compact(
            'page_title',
            'app_name',
            'services',
            'setting',
            'setting_sub',
            'setting_sub4',
            'setting4',
            'setting41',
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
        $service->weight_max = $request->input('weight_max');
        $service->agent_id = $admin_id;
        $service->active = $request->input('active');

        if ($service->save()) {

            // Redirection
            return back()->with('success', 'Nouveau service créee avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce service !');
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
            $service->weight_max = $request->input('weight_max');
            $service->agent_id = $admin_id;
            $service->active = $request->input('active');

            if ($service->save()) {

                // Redirection
                return back()->with('success', 'Service modifiée avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier ce service !');
        }
        return back()->with('failed', 'Impossible de trouver ce service !');
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
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting43 = "side-menu--active";

        $delais = DelaiExpedition::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminDelai', compact(
            'page_title',
            'app_name',
            'delais',
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
    public function adminSearchDelai(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Delais d'expedition";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting43 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $delais = DelaiExpedition::where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);

        return view('admin.adminDelai', compact(
            'page_title',
            'app_name',
            'delais',
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
    public function adminAddDelai(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $delai = new DelaiExpedition();

        // Récupérer les données du formulaire
        $delai->code = $request->input('code');
        $delai->libelle = $request->input('libelle');
        $delai->description = $request->input('description');
        $delai->agent_id = $admin_id;
        $delai->active = $request->input('active');

        if ($delai->save()) {

            // Redirection
            return back()->with('success', 'Nouveau delai créee avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce delai !');
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
        $delai = DelaiExpedition::find($request->input('delai_id'));
        if (!empty($delai)) {

            // Récupérer les données du formulaire
            $delai->code = $request->input('code');
            $delai->libelle = $request->input('libelle');
            $delai->description = $request->input('description');
            $delai->agent_id = $admin_id;
            $delai->active = $request->input('active');

            if ($delai->save()) {

                // Redirection
                return back()->with('success', 'Delai modifiée avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier ce delai !');
        }
        return back()->with('failed', 'Impossible de trouver ce delai !');
    }

    ################################################################################################################
    #                                                                                                              #
    #   ETAPES                                                                                                     #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEtape(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Etapes";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting42 = "side-menu--active";

        $etapes = Etape::paginate(10);
        $modes = ModeExpedition::all();
        $etapes_prev = Etape::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminEtape', compact(
            'page_title',
            'app_name',
            'etapes',
            'etapes_prev',
            'modes',
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
    public function adminSearchEtape(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Etapes";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting42 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $etapes = Etape::where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);
        $modes = ModeExpedition::all();
        $etapes_prev = Etape::all();

        return view('admin.adminEtape', compact(
            'page_title',
            'app_name',
            'etapes',
            'etapes_prev',
            'modes',
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
    public function adminAddEtape(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $etape = new Etape();

        // Récupérer les données du formulaire
        $etape->code = $request->input('code');
        $etape->libelle = $request->input('libelle');
        $etape->description = $request->input('description');
        $etape->code_hexa = $request->input('code_hexa');
        $etape->type = $request->input('type');

        $etape->mode_id = $request->input('mode_id');
        $etape->position = $request->input('position');

        $etape->agent_id = $admin_id;
        $etape->active = $request->input('active');

        if ($etape->save()) {

            // Redirection
            return back()->with('success', 'Nouvelle étape créee avec succès !');
        }
        return back()->with('failed', 'Impossible de creer cette étape !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditEtape(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get statut by id
        $etape = Etape::find($request->input('etape_id'));
        if (!empty($etape)) {

            // Récupérer les données du formulaire
            $etape->code = $request->input('code');
            $etape->libelle = $request->input('libelle');
            $etape->description = $request->input('description');
            $etape->code_hexa = $request->input('code_hexa');
            $etape->type = $request->input('type');

            $etape->mode_id = $request->input('mode_id');
            $etape->position = $request->input('position');

            $etape->agent_id = $admin_id;
            $etape->active = $request->input('active');

            if ($etape->save()) {

                // Redirection
                return back()->with('success', 'Etape modifiée avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier cette étape !');
        }
        return back()->with('failed', 'Impossible de trouver cette étape !');
    }

    ################################################################################################################
    #                                                                                                              #
    #   MODE                                                                                                     #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminMode(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Modes d'expedition";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting45 = "side-menu--active";

        $modes = ModeExpedition::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminMode', compact(
            'page_title',
            'app_name',
            'modes',
            'setting',
            'setting_sub',
            'setting_sub4',
            'setting4',
            'setting45',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchMode(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Modes d'expedition";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting45 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $modes = ModeExpedition::where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);

        return view('admin.adminMode', compact(
            'page_title',
            'app_name',
            'modes',
            'setting',
            'setting_sub',
            'setting_sub4',
            'setting4',
            'setting45',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddMode(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $mode = new ModeExpedition();

        // Récupérer les données du formulaire
        $mode->code = $request->input('code');
        $mode->libelle = $request->input('libelle');
        $mode->description = $request->input('description');
        $mode->agent_id = $admin_id;
        $mode->active = $request->input('active');

        if ($mode->save()) {

            // Redirection
            return back()->with('success', 'Nouveau mode créee avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce mode !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditMode(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get statut by id
        $mode = ModeExpedition::find($request->input('mode_id'));
        if (!empty($mode)) {

            // Récupérer les données du formulaire
            $mode->code = $request->input('code');
            $mode->libelle = $request->input('libelle');
            $mode->description = $request->input('description');
            $mode->agent_id = $admin_id;
            $mode->active = $request->input('active');

            if ($mode->save()) {

                // Redirection
                return back()->with('success', 'Mode modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier ce mode !');
        }
        return back()->with('failed', 'Impossible de trouver ce mode !');
    }

    ################################################################################################################
    #                                                                                                              #
    #   METHODE DE PAIEMENT                                                                                                     #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminMethode(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Méthode de paiement";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub2 = "side-menu__sub-open";
        $setting2 = "side-menu--active";
        $setting21 = "side-menu--active";

        $methodes = MethodePaiement::paginate(10);


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminMethode', compact(
            'page_title',
            'app_name',
            'methodes',
            'setting',
            'setting_sub',
            'setting_sub2',
            'setting2',
            'setting21',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchMethode(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Modes de paiement";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub2 = "side-menu__sub-open";
        $setting2 = "side-menu--active";
        $setting21 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $methodes = MethodePaiement::where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);

        return view('admin.adminMethode', compact(
            'page_title',
            'app_name',
            'methodes',
            'setting',
            'setting_sub',
            'setting_sub2',
            'setting2',
            'setting21',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminAddMethode(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $methode = new MethodePaiement();

        // Récupérer les données du formulaire
        $methode->code = $request->input('code');
        $methode->libelle = $request->input('libelle');
        $methode->description = $request->input('description');
        $methode->agent_id = $admin_id;
        $methode->active = $request->input('active');

        if ($methode->save()) {

            // Redirection
            return back()->with('success', 'Nouvelle méthode de paiement créee avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce mode !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditMethode(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get statut by id
        $methode = MethodePaiement::find($request->input('methode_id'));
        if (!empty($methode)) {

            // Récupérer les données du formulaire
            $methode->code = $request->input('code');
            $methode->libelle = $request->input('libelle');
            $methode->description = $request->input('description');
            $methode->agent_id = $admin_id;
            $methode->active = $request->input('active');

            if ($methode->save()) {

                // Redirection
                return back()->with('success', 'Méthode modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier cette méthode !');
        }
        return back()->with('failed', 'Impossible de trouver cette méthode !');
    }

    ################################################################################################################
    #                                                                                                              #
    #   PRICING                                                                                                    #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPrice(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Tarifs d'expedition";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting44 = "side-menu--active";

        $prices = PriceExpedition::paginate(10);

        $zones = Zone::all();
        $services = ServiceExpedition::all();
        $modes = ModeExpedition::all();

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        return view('admin.adminPrice', compact(
            'page_title',
            'app_name',
            'prices',
            'zones',
            'services',
            'modes',
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
    public function adminSearchPrice(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Tarifs d'expedition";
        $setting = "side-menu--active";
        $setting_sub = "side-menu__sub-open";
        $setting_sub4 = "side-menu__sub-open";
        $setting4 = "side-menu--active";
        $setting44 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $prices = PriceExpedition::where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);
        $zones = Zone::all();
        $services = ServiceExpedition::all();
        $modes = ModeExpedition::all();

        return view('admin.adminPrice', compact(
            'page_title',
            'app_name',
            'princes',
            'zones',
            'services',
            'modes',
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

        // Récupérer les données du formulaire

        $price->price = $request->input('price');

        $price->type = $request->input('type');
        $price->first = $request->input('first');

        if ($request->input('fees_sup') == 1) {
            $price->label_fees = $request->input('label_fees');
        }
        if ($request->input('type_element') == "null") {
            $price->type_element = null;
            $price->weight = $request->input('weight');
        } else {
            $price->type_element = $request->input('type_element');
        }

        $price->fees_sup = $request->input('fees_sup');

        $price->service_id = $request->input('service_id');
        $price->zone_id = $request->input('zone_id');
        $price->mode_id = $request->input('mode_id');


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
        if (!empty($price)) {

            // Récupérer les données du formulaire
            $price->code = $request->input('code');
            $price->weight = $request->input('weight');
            $price->price = $request->input('price');
            $price->type = $request->input('type');
            $price->first = $request->input('first');
            $price->service_id = $request->input('service_id');
            $price->zone_id = $request->input('zone_id');
            $price->mode_id = $request->input('mode_id');
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectData(Request $request)
    {
        $agence = Agence::find(Auth::user()->agence_id);
        $ville = Ville::find($agence->ville_id);
        $province = Province::find($ville->province_id);
        $pays = Pays::find($province->pays_id);
        if ($pays->code == "GA") {
            if ($province->code == "ES") {
                $zone = Zone::find(1);
            } elseif ($province->code == "OM") {
                $zone = Zone::find(2);
            } else {
                $zone = Zone::find(3);
            }
        } else {
            $zone = Zone::find($pays->zone_id);
        }

        $reseau = Reseau::find($zone->reseau_id);
        if ($request->target == 'zone') {
            $organization = Zone::where('reseau_id', $request->id)->get();
            $response = json_encode($organization);
            return response()->json($response);
        } elseif ($request->target == 'pays') {
            if ($request->reseau == 1) {
                $organization = Pays::where('id', 1)->get();
            } else {
                $organization = Pays::where('zone_id', $request->id)->get();
            }
            $response = json_encode($organization);
            return response()->json($response);
        } elseif ($request->target == 'province') {
            if ($province->id == 1) {
                if ($request->zone == 1) {
                    $organization = Province::where('code', "ES")->get();
                } elseif ($request->zone == 2) {
                    $organization = Province::Where('code', "OM")->get();
                } elseif ($request->zone == 3) {
                    $organization = Province::Where('code', '<>', "OM")->Where('code', '<>', "ES")->get();
                } else {
                    $organization = Province::where('pays_id', $request->id)->get();
                }
            } else {
                $organization = Province::where('id', '<>', $province->id)->get();
            }

            $response = json_encode($organization);
            return response()->json($response);
        } elseif ($request->target == 'ville') {
            $agence = Agence::find(Auth::user()->agence_id);
            $organization = Ville::where('province_id', $request->id)->where('id', '<>', $agence->ville_id)->get();
            $response = json_encode($organization);
            return response()->json($response);
        } elseif ($request->target == 'agence') {
            $organization = Agence::where('ville_id', $request->id)->where('id', '<>', Auth::user()->agence_id)->get();
            $response = json_encode($organization);
            return response()->json($response);
        } elseif ($request->target == 'next') {
            $organization = Etape::where('id', '<>', $request->id)->get();
            $response = json_encode($organization);
            return response()->json($response);
        } elseif ($request->target == 'poids_range') {
            $organization = PriceExpedition::where('mode_id', $request->mode)->where('service_id', $request->id)->get();
            $response = json_encode($organization);
            return response()->json($response);
        } elseif ($request->target == 'agent') {
            if ($request->type) {
                $organization = User::where('role', 'Agent')->get();
            } else {
                $organization = User::where('agence_id', $request->agence)->where('role', 'Agent')->get();
            }
            $response = json_encode($organization);
            return response()->json($response);
        }
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


        $mouchards = Mouchard::orderBy('desc', 'created_at')->paginate(10);


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
    static function mouchard($ip_adresse, $os_system, $os_navigator, $action_title, $action_system)
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
        //$mouchard->action_author = $author;
        $mouchard->action_system = $action_system;

        // Sauvegarder
        $mouchard->save();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    static function getClientIPaddress(Request $request)
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
    static function getDevice()
    {

        $device = Agent::device();

        return $device;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    static function getBrowser()
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
    static function getOS()
    {

        $platform = Agent::platform();
        $version = Agent::version($platform);

        $os_system = $platform . ' (' . $version . ') ';

        return $os_system;
    }
}
