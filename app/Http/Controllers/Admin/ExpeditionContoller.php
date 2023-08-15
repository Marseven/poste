<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\LinkMessage;
use App\Mail\RegisterEntity;
use App\Models\Agence;
use App\Models\ColisExpedition;
use App\Models\DocumentExpedition;
use App\Models\Etape;
use App\Models\Expedition;
use App\Models\FactureExpedition;
use App\Models\MethodePaiement;
use App\Models\ModeExpedition;
use App\Models\Onesignal;
use App\Models\Package;
use App\Models\PackageExpedition;
use App\Models\Paiement;
use App\Models\PriceExpedition;
use App\Models\Reseau;
use App\Models\Reservation;
use App\Models\ServiceExpedition;
use App\Models\Societe;
use App\Models\SuiviExpedition;
use App\Models\SuiviPackage;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Twilio\Rest\Client;

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
        $methodes = MethodePaiement::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminExpeditionList', compact(
            'page_title',
            'app_name',
            'expeditions',
            'methodes',
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
    public function adminExpeditionJ(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Expeditions";
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp2 = "side-menu--active";

        // Get today carbon date
        $today = Carbon::today();

        $expeditions = Expedition::whereDate('created_at', $today)->where('mode_exp_id', 2)->paginate(10);
        $methodes = MethodePaiement::all();


        $admin = Auth::user();
        $admin_id = Auth::user()->id;


        return view('admin.adminExpeditionJ', compact(
            'page_title',
            'app_name',
            'expeditions',
            'methodes',
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
        $prices = PriceExpedition::where('service_id', 1)->where('mode_id', 1)->get();

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
            'prices',
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

        if ($request->input('zone') == -1) {
            $response = json_encode(0);
            return response()->json($response);
        }

        if ($request->input('service') == -1) {
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

        if ($request->input('type') != 0) $paquet->type = $request->input('type');

        $first = 0;
        $last = 0;
        $sup = 0;
        $amount = 0;

        if ($request->input('mode') == 1) {
            if ($request->input('service') == 1 || $request->input('service') == 2 || $request->input('service') == 6 || $request->input('service') == 7) {
                $price = PriceExpedition::find($request->poids_id);
                $paquet->poids = $price->weight;
                $amount = $price->price;
            } else {
                $price = PriceExpedition::where('type', 'Standard')->where('zone_id', $request->input('zone'))->where('service_id', $request->input('service'))->where('mode_id', $request->input('mode'))->first();
                $paquet->poids = $request->input('poids');
                $amount = round($paquet->poids * $price->price, 1);
            }
        } else {
            if ($request->input('service') == 1) {
                $price = PriceExpedition::where('type', 'Standard')->where('service_id', $request->input('service'))->where('zone_id', $request->input('zone'))->where('mode_id', $request->input('mode'))->first();
                if ($price) {
                    if ($request->poids > 0.5) {
                        if ($price && $price->first == 1) {
                            $price_sup = PriceExpedition::where('type', 'Supplémentaire')->where('service_id', $request->input('service'))->where('zone_id', $request->input('zone'))->where('mode_id', $request->input('mode'))->first();
                            $first = 0.5;
                            $last = $request->poids - $first;
                            $poids_sup = $last / $first;
                            $poids_sup = ceil($poids_sup);
                            $paquet->poids = $request->poids;
                            $amount = round($price->price + ($price_sup->price * $poids_sup));
                        } else {
                            $amount = $price->price;
                        }
                    } else {
                        $amount = $price->price;
                    }
                }
            }
        }

        if ($price == null) {
            $response = json_encode(2);
            return response()->json($response);
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

            $expedition->status = STATUT_PENDING;

            if ($expedition->save()) {

                // Mise a jour Documents et colis
                DB::table('document_expeditions')
                    ->where('code', $code_aleatoire)
                    ->update(['expedition_id' => $expedition->id]);

                foreach ($paquets as $pq) {
                    $pq->code = Carbon::now()->timestamp;
                    $pq->expedition_id = $expedition->id;
                    $pq->save();
                }

                $etapes = Etape::where('type', 'Expédition')->where('mode_id', $expedition->mode_exp_id)->get();

                foreach ($etapes as $etp) {
                    $suivi = new SuiviExpedition();
                    $suivi->expedition_id = $expedition->id;
                    $suivi->etape_id = $etp->id;
                    if ($etp->position == 1) {
                        $suivi->status = STATUT_PENDING;
                    } else {
                        $suivi->status = STATUT_TODO;
                    }
                    $suivi->save();
                }

                // New Facture
                $facture = new FactureExpedition();

                $facture->code = $code_aleatoire;
                $facture->expedition_id = $expedition->id;

                $facture->save();
                $expedition->load(['agence_dest', 'agence_exp']);

                //notificaitons - expediteurs
                try {
                    Mail::to($expedition->email_exp)->send(new RegisterEntity($expedition));
                    return redirect('admin/expeditions')->with('success', 'Expedition ajoutee avec succès !');

                    // $receiverNumber = "+241" . $expedition->phone_exp;
                    // $message = "Bonjour M./Mme. " . $expedition->name_exp . ", Merci pour votre confiance en La Poste Gabonaise. Votre expédition N° " . $expedition->reference . " a été crée et sera enregistré pour l'expédion à " . $expedition->agence_dest->libelle . ".";
                    // try {
                    //     $account_sid = getenv("TWILIO_SID");
                    //     $auth_token = getenv("TWILIO_TOKEN");
                    //     $twilio_number = getenv("TWILIO_FROM");
                    //     $client = new Client($account_sid, $auth_token);
                    //     $client->messages->create($receiverNumber, [
                    //         'from' => $twilio_number,
                    //         'body' => $message
                    //     ]);
                    //     return redirect('admin/expeditions')->with('success', 'Expedition ajoutee avec succès !');
                    // } catch (Exception $e) {
                    //     return redirect('admin/expeditions')->with('failed', "Error: " . $e->getMessage());
                    // }
                } catch (Exception $e) {
                    return redirect('admin/expeditions')->with('success', "Error: " . $e->getMessage());
                }
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
            $paquets = ColisExpedition::where('expedition_id', $expedition->id)->get();

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

    public function adminFacturePay(Request $request, $code)
    {
        $expedition = Expedition::where('code', $code)->first();
        $methode = MethodePaiement::where('code', $request->methode)->first();
        dd($request->methode);
        if ($request->methode == "CA") {
            $payment = new Paiement();
            $payment->expedition_id = $expedition->id;
            $payment->reference = PaymentController::str_reference(6);
            $payment->description = "Paiement en cash.";
            $payment->amount = $expedition->amount;
            $payment->status = STATUT_PAID;
            $payment->methode_id = $methode->id;
            if ($payment->save()) {
                $expedition->status = STATUT_PAID;
                $expedition->save();
                $data['payment'] = $payment;
                return $this->sendResponse($data, 'Envoyé !');
            } else {
                return $this->sendError('Erreur', ['error' => 'Failed']);
            }
        } elseif ($request->methode == "PL") {
            $payment = new Paiement();
            $payment->expedition_id = $expedition->id;
            $payment->reference = PaymentController::str_reference(6);
            $payment->description = "Paiement à la livraison.";
            $payment->amount = $expedition->amount;
            $payment->status = STATUT_PAID_DELIVERY;
            $payment->methode_id = $methode->id;
            if ($payment->save()) {
                $expedition->status = STATUT_PAID_DELIVERY;
                $expedition->save();
                $data['payment'] = $payment;
                return $this->sendResponse($data, 'Envoyé !');
            } else {
                return $this->sendError('Erreur', ['error' => 'Failed']);
            }
        } else {
            $billing_id = PaymentController::ebilling($expedition);
            if ($request->paylink == "link") {
                $link = env('POST_URL') . "?invoice=" . $billing_id;
                try {
                    Mail::to($request->email)->send(new LinkMessage($expedition, $link));
                    Mail::to($expedition->email_exp)->send(new LinkMessage($expedition, $link));
                    $data['link'] = $link;
                    return $this->sendResponse($data, 'Envoyé !');
                } catch (Exception $e) {
                    $data['link'] = $link;
                    return $this->sendResponse($data, 'Envoyé !');
                }
            } else {
                $auth = env('USER_NAME') . ':' . env('SHARED_KEY');
                $base64 = base64_encode($auth);
                $response = Http::withHeaders([
                    "Authorization" => "Basic " . $base64
                ])->post(env('URL_EB') . 'e_bills/' . $billing_id . '/ussd_push', [
                    "payment_system_name" => $request->operator,
                    "payer_msisdn" => $request->phone,
                ]);
                $response = json_decode($response->body());
                if ($response) {
                    if ($response->message == "Accepted") {
                        $data['bill_id'] = $billing_id;
                        return $this->sendResponse($data, 'Envoyé !');
                    } else {
                        return $this->sendError($response->message, ['error' => 'Failed']);
                    }
                } else {
                    return $this->sendError("Echec du Push USSD.", ['error' => 'Failed']);
                }
            }
        }
    }

    public function check_payment(Request $request)
    {
        $payment = Paiement::where('ebilling_id', $request->bill_id)->first();
        if ($payment != null && $payment->status == STATUT_PAID) {
            $data['billing'] = $payment;
            return $this->sendResponse($data, 'Payée !');
        } else {
            return $this->sendError("Facture non payée.", ['error' => 'Failed']);
        }
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
            $paquets = ColisExpedition::where('expedition_id', $expedition->id)->get();



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
            $paquets = ColisExpedition::where('expedition_id', $expedition->id)->get();

            // Get facture by expedition_id
            $facture = FactureExpedition::where('expedition_id', $expedition_id)->first();

            $qrcode = QrCode::format('png')->size(100)->generate($expedition->code, '../public/code-qr/' . $expedition->code . '.png');

            $data = compact(
                'page_title',
                'app_name',
                'facture',
                'expedition',
                'societe',
                'qrcode',
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
        $page_title = "Etiquette Expedition";
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp2 = "side-menu--active";

        $societe = Societe::find(1);

        // Get expedition by id
        $expedition = Expedition::where('code', $code)->first();
        if (!empty($expedition)) {

            // Récupérer les données
            $expedition_id = intval($expedition->id);
            $paquets = ColisExpedition::where('expedition_id', $expedition->id)->get();

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
            $paquets = ColisExpedition::where('expedition_id', $expedition->id)->get();


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
            $paquets = ColisExpedition::where('expedition_id', $expedition->id)->get();

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function EtiquettePackagePrint($id)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $app_name = "La Poste";
        $page_title = "Etiquette Dépêche";

        $societe = Societe::find(1);

        // Get expedition by id
        $package = Package::where('id', $id)->first();

        $qrcode = QrCode::format('png')->size(100)->generate($package->id, '../public/code-qr/' . $package->id . '.png');

        if ($package) {
            // Récupérer les données
            $data = compact(
                'page_title',
                'app_name',
                'package',
                'societe',
                'qrcode'
            );

            $largeur_etiquette = 5; // en cm
            $hauteur_etiquette = 3; // en cm

            $pdf = PDF::loadView('pdf.etiquettePackagePrint', $data)->setPaper(array(0, 0, 300, 500), 'landscape');

            //$pdf->setPaper([$largeur_etiquette, $hauteur_etiquette], 'cm');

            return $pdf->download('etiquette-depeche-' . $id . '.pdf');
            // Redirection

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
            $paquets = ColisExpedition::where('expedition_id', $expedition->id)->get();
            $historiques = SuiviExpedition::where('expedition_id', $expedition->id)->get();

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
        $page_title = "Dépêches";
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
        $page_title = "Dépêches";
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

        $package->responsable_id = $admin_id;
        $package->active = $request->input('active');

        if ($package->save()) {
            $etapes = Etape::where('type', 'Package')->get();

            foreach ($etapes as $etp) {
                $suivi = new SuiviPackage();
                $suivi->package_id = $package->id;
                $suivi->etape_id = $etp->id;
                if ($etp->position == 1) {
                    $suivi->status = STATUT_PENDING;
                } else {
                    $suivi->status = STATUT_TODO;
                }
                $suivi->save();
            }
            // Redirection
            return back()->with('success', 'Nouvelle Dépêche crée avec succès !');
        }
        return back()->with('failed', 'Impossible de creer cette dépêche !');
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
                return back()->with('success', 'Dépêche modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier cette dépêche !');
        }
        return back()->with('failed', 'Impossible de trouver cette dépêche !');
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
        $page_title = "Detail Dépêche";
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
    public function adminPackageAgentAssign(Request $request)
    {
        // Get package by id
        $package = Package::find($request->input('package'));

        if ($package) {
            $package->agent_id = $request->input('agent');
            $package->active = 2;
            $package->save();

            $onesignal = Onesignal::where('user_id', $request->input('agent'))->first();
            $agent = User::find($request->input('agent'));

            $appId = 'eaa5c8b4-3642-40d6-b3e7-8721e5d08a94';
            $restApiKey = 'ZDA0ZTY4YjQtMTMxOC00MzBjLThmZDEtYzYwOTg4YTkzZTAx';

            $playerIds = [$onesignal->player_id]; // Array of player_ids (device tokens)
            $notificationTitle = "Package N° " . $package->code . " Assigné";
            $notificationBody = "M. " . $agent->name . " le package n°" . $package->code . " vous a été assihné pour l'enregistrement des colis.";

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

            return back()->with('success', 'Dépêche assignée avec succès !');
            // Get colis by id
        } else {
            return back()->with('failed', 'Impossible d\'assigner cette dépêche !');
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
        $page_title = "Suivi Dépêche";
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

            $package->load(['agence_dest', 'agence_exp', 'colis']);

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
        return back()->with('failed', 'Impossible de trouver cette expedition !');
    }

    ################################################################################################################
    #                                                                                                              #
    #   RESERVATION                                                                                                    #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminReservationList(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Dépêches";
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp4 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $reservations = Reservation::orderBy('id', 'DESC')->paginate(10);

        return view('admin.adminReservation', compact(
            'page_title',
            'app_name',
            'reservations',
            'exp',
            'exp_sub',
            'exp4'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchReservation(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Dépêches";
        $exp = "side-menu--active";
        $exp_sub = "side-menu__sub-open";
        $exp3 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $reservations = Reservation::where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('name_exp', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('name_dest', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);

        return view('admin.adminReservation', compact(
            'page_title',
            'app_name',
            'reservations',
            'exp',
            'exp_sub',
            'exp4'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminReseravtionAgentAssign(Request $request)
    {
        // Get package by id
        $reservation = Reservation::find($request->input('package'));

        if ($reservation) {
            $reservation->agent_id = $request->input('agent');
            $reservation->active = 2;
            $reservation->save();

            $onesignal = Onesignal::where('user_id', $request->input('agent'))->first();
            $agent = User::find($request->input('agent'));

            $appId = 'eaa5c8b4-3642-40d6-b3e7-8721e5d08a94';
            $restApiKey = 'ZDA0ZTY4YjQtMTMxOC00MzBjLThmZDEtYzYwOTg4YTkzZTAx';

            $playerIds = [$onesignal->player_id]; // Array of player_ids (device tokens)
            $notificationTitle = "Réservation N° " . $reservation->code . " Assigné";
            $notificationBody = "M. " . $agent->name . " la réservation n°" . $reservation->code . " vous a été assihné pour l'enregistrement des colis.";

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

            return back()->with('success', 'Réservation assignée avec succès !');
            // Get colis by id
        } else {
            return back()->with('failed', 'Impossible d\'assigner cette dépêche !');
        }
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 406)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
}
