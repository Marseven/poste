<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DelaiExpedition;
use App\Models\Mouchard;
use App\Models\PriceExpedition;
use App\Models\ServiceExpedition;
use App\Models\StatutExpedition;
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

        $delais = DelaiExpedition::paginate(10);


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

        $delais = DelaiExpedition::where('code', 'LIKE', '%' . $request->input('q') . '%')
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

        $delai = new DelaiExpedition();

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
    #   PRICING                                                                                                      #
    #                                                                                                              #
    ################################################################################################################

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
        $price->code = $request->input('code');
        $price->weight = $request->input('weight');
        $price->price = $request->input('price');
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
        if ($request->target == 'regime') {
        } elseif ($request->target == 'category') {
        } elseif ($request->target == 'price') {
            $organization = PriceExpedition::where('category_id', $request->id)->get();
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
