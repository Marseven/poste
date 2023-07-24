<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\ColisExpedition;
use App\Models\DelaiExpedition;
use App\Models\DocumentExpedition;
use App\Models\Expedition;
use App\Models\FactureExpedition;
use App\Models\ModeExpedition;
use App\Models\Package;
use App\Models\PackageExpedition;
use App\Models\Pays;
use App\Models\PriceExpedition;
use App\Models\Province;
use App\Models\Reseau;
use App\Models\ServiceExpedition;
use App\Models\Societe;
use App\Models\SuiviExpedition;
use App\Models\User;
use App\Models\Ville;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class ExpeditionContoller extends Controller
{
    //
    public function __construct()
    {

        // dd(Auth::user());

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
        $agence = Agence::find(Auth::user()->agence_id);
        $code_aleatoire = $agence->code . '.' . $code_aleatoire;

        $societe = Societe::find(1);
        $reseaux = Reseau::all();
        $services = ServiceExpedition::all();
        $modes = ModeExpedition::all();

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $colis = ColisExpedition::where('agent_id', $admin_id)->get();
        foreach ($colis as $coli) {
            $coli->load(['expedition']);
            if ($coli->expedition == null) $coli->delete();
        }

        return view('admin.adminNewExpedition', compact(
            'page_title',
            'app_name',
            'code_aleatoire',
            'reseaux',
            'services',
            'modes',
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
                        return back()->with('success', 'Document ajoute avec succès !');
                    }
                    return back()->with('failed', 'Impossible de modifier ce document !');
                }
                return back()->with('failed', 'Imposible d\'uploader le fichier vers le répertoire défini !');
            }
            return back()->with('failed', 'L\'extension du fichier doit être soit du, pdf jpg ou du png !');
        }
        return back()->with('failed', 'Aucun fichier téléchargé. Veuillez réessayer svp !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminNewPaquet(Request $request)
    {
        $admin_id = Auth::user()->id;

        if ($request->input('zone') == 0) {
            $response = json_encode(0);
            return response()->json($response);
        }

        if ($request->input('service') == 0) {
            $response = json_encode(1);
            return response()->json($response);
        }

        $paquet = new ColisExpedition();

        $cd = explode('.', $request->input('code'));

        // Store data
        $code_aleatoire = $cd[1];

        // Récupérer les données du formulaire
        $paquet->code = $code_aleatoire;
        $paquet->libelle = $request->input('libelle');
        $paquet->description = $request->input('description');
        $paquet->service_exp_id = $request->input('service');
        $paquet->poids = $request->input('poids');
        if ($request->input('type') != 0) $paquet->type = $request->input('type');

        $price = PriceExpedition::where('type', 'Standard')->where('zone_id', $request->input('zone'))->where('service_id', $request->input('service'))->where('mode_id', $request->input('mode'))->first();

        $first = 0;
        $last = 0;
        $sup = 0;
        $amount = 0;

        if ($price && $price->first == 1) {
            $first = $price->weight;
            $last = $paquet->poids - $first;
            $priceSup = PriceExpedition::where('type', 'Supplémentaire')->where('zone_id', $request->input('zone'))->where('service_id', $request->input('service'))->where('mode_id', $request->input('mode'))->first();
            //dd($priceSup);
            if (!$priceSup) {
                $sup = 0;
            } else {
                $sup = $priceSup->price;
            };
            $amount = $price->price + (round($last / $price->weight, 1) * $sup);
        } else {
            $amount = round($paquet->poids / $price->weight, 1) * $price->price;
        }

        $paquet->amount = $amount;
        $paquet->agent_id = $admin_id;
        $paquet->active = 1;

        if ($paquet->save()) {
            $paquet->load(['service']);
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
            $price = $paquet->amount;
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

        $cd = explode('.', $request->input('code_aleatoire'));

        // Store data
        $code_aleatoire = $cd[1];
        $agence_id = $request->input('agence_id');

        // Check if this expedition have almost one colis
        $paquets = ColisExpedition::where('code', $code_aleatoire)->get();

        if ($paquets->count() > 0) {

            $expedition = new Expedition();

            // Get agence by id
            $agence = Agence::find($agence_id);

            // Set data
            $reference =  $request->input('code_aleatoire') . '.' . $agence->code;

            // Récupérer les données du formulaire
            $expedition->code = $code_aleatoire;
            $expedition->agence_dest_id = $request->input('agence_id');
            $expedition->agence_exp_id = $admin->agence_id;

            $expedition->reference = $reference;

            $expedition->name_exp = $request->input('name_exp');
            $expedition->email_exp = $request->input('email_exp');
            $expedition->phone_exp = $request->input('phone_exp');
            $expedition->adresse_exp = $request->input('adresse_exp');

            $expedition->name_dest = $request->input('name_dest');
            $expedition->email_dest = $request->input('email_dest');
            $expedition->phone_dest = $request->input('phone_dest');
            $expedition->adresse_dest = $request->input('adresse_dest');

            $expedition->mode_exp_id = $request->input('mode_exp_id');
            $expedition->address = $request->input('address');
            $expedition->bp = $request->input('bp');

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


                //notificaitons - expediteurs


                // Redirection
                return redirect('/expeditions')->with('success', 'Expedition ajoutee avec succès !');
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


            // Update Expedition



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
                return redirect('adminExpeditionList')->with('success', 'Validation effectuee avec succès !');
            }
            return back()->with('failed', 'Impossible de valider cette expedition !');
        }
        return back()->with('failed', 'Impossible de valider cette expedition !');
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
        $expedition = Expedition::where('code', $code)->first();
        if (!empty($expedition)) {

            // Récupérer les données
            $expedition_id = intval($expedition->id);
            $paquets = ColisExpedition::where('code', $code)->get();

            $expedition->load(['mode']);

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
        $expedition = Expedition::where('code', $code)->first();
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
            return back()->with('failed', 'Impossible de modifier cette expedition !');
        }
        return back()->with('failed', 'Impossible de trouver cette expedition !');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function FacturePrint($code)
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
        $expedition = Expedition::where('code', $code)->first();
        if (!empty($expedition)) {

            // Récupérer les données
            $expedition_id = intval($expedition->id);
            $paquets = ColisExpedition::where('code', $code)->get();

            // Get facture by expedition_id
            $facture = FactureExpedition::where('expedition_id', $expedition_id)->first();

            $data = compact(
                'page_title',
                'app_name',
                'facture',
                'expedition',
                'societe',
                'paquets',
                'exp',
                'exp_sub',
                'exp2'
            );
            $pdf = PDF::loadView('pdf.facturePrint', $data);

            return $pdf->download('facture-' . $code . '.pdf');
        } else {
            return back()->with('failed', 'Impossible de trouver cette expedition !');
        }
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
        $expedition = Expedition::where('code', $code)->first();
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
            return back()->with('failed', 'Impossible de modifier cette expedition !');
        }
        return back()->with('failed', 'Impossible de trouver cette expedition !');
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
        $expedition = Expedition::where('code', $code)->first();
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
            return back()->with('failed', 'Impossible de modifier cette expedition !');
        }
        return back()->with('failed', 'Impossible de trouver cette expedition !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function EtiquettePrint(Request $request, $code)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $app_name = "La Poste";
        $page_title = "Etiquette Expedition";

        $societe = Societe::find(1);

        // Get expedition by id
        $expedition = Expedition::where('code', $code)->first();
        if (!empty($expedition)) {

            // Récupérer les données
            $expedition_id = intval($expedition->id);
            $paquets = ColisExpedition::where('code', $code)->get();

            // Get facture by expedition_id
            $facture = FactureExpedition::where('expedition_id', $expedition_id)->first();

            if (!empty($facture)) {

                $data = compact(
                    'page_title',
                    'app_name',
                    'facture',
                    'expedition',
                    'societe',
                    'paquets'
                );

                $largeur_etiquette = 5; // en cm
                $hauteur_etiquette = 3; // en cm

                $pdf = PDF::loadView('pdf.etiquettePrint', $data)->setPaper(array(0, 0, 300, 500), 'landscape');

                //$pdf->setPaper([$largeur_etiquette, $hauteur_etiquette], 'cm');

                return $pdf->download('etiquette-' . $code . '.pdf');
                // Redirection
            } else {
                return back()->with('failed', 'Impossible de modifier cette expedition !');
            }
        } else {

            return back()->with('failed', 'Impossible de trouver cette expedition !');
        }
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
        $expedition = Expedition::where('code', $code)->first();
        if (!empty($expedition)) {

            $expedition->load(['mode']);
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

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $packages = Package::orderBy('id', 'DESC')->paginate(10);
        $agences = Agence::where('id', '<>', $admin->agence_id)->get();

        return view('admin.adminPackage', compact(
            'page_title',
            'app_name',
            'packages',
            'agences',
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
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp3 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $packages = Package::where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('description', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);
        $agences = Agence::where('id', '<>', $admin->agence_id)->get();

        return view('admin.adminPackage', compact(
            'page_title',
            'app_name',
            'packages',
            'agences',
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
    public function adminAddPackage(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $code = Carbon::now()->timestamp;
        $agence_origine = Agence::find($admin->agence_id);
        $agence_destination = Agence::find($request->input('agence_dest_id'));

        $package = new Package();

        // Récupérer les données du formulaire
        $package->code = $agence_origine->code . '.' . $code . '.' . $agence_destination->code;

        $package->libelle = $request->input('libelle');
        $package->description = $request->input('description');

        $package->agence_exp_id = $agence_origine->id;
        $package->agence_dest_id = $agence_destination->id;

        $package->agent_id = $admin_id;
        $package->active = $request->input('active');

        if ($package->save()) {
            // Redirection
            return back()->with('success', 'Nouveau Package crée avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce package !');
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

        $agence_origine = Agence::find($admin->agence_id);
        $agence_destination = Agence::find($request->input('agence_dest_id'));

        // Get package by id
        $package = Package::find($request->input('package_id'));
        if (!empty($package)) {

            // Récupérer les données du formulaire
            $package->libelle = $request->input('libelle');
            $package->description = $request->input('description');

            $package->agence_exp_id = $agence_origine->id;
            $package->agence_dest_id = $agence_destination->id;

            $package->agent_id = $admin_id;
            $package->active = $request->input('active');

            if ($package->save()) {

                // Redirection
                return back()->with('success', 'Package modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier ce package !');
        }
        return back()->with('failed', 'Impossible de trouver ce package !');
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
            $today_paquets = ColisExpedition::whereDate('created_at', $today)->paginate(10);

            if (!empty($today_paquets)) {

                $colis = PackageExpedition::where('package_id', $package->id)->paginate(10);
                $colis->load(['colis']);
                // Redirection
                return view('admin.adminDetailPackage', compact(
                    'page_title',
                    'app_name',
                    'today_paquets',
                    'colis',
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
}
