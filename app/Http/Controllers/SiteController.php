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


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 

class SiteController extends Controller
{

    ################################################################################################################
    #                                                                                                              #
    #   ACCUEIL                                                                                                    #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function accueil(Request $request)
    {

        $app_name = "LA POSTE";
        $page_title = "Accueil";

        return view('site.accueil', compact('page_title', 'app_name'
        ));
    }

    ################################################################################################################
    #                                                                                                              #
    #   CONNEXION                                                                                                  #
    #                                                                                                              #
    ################################################################################################################ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function connexion(Request $request)
    {

        // Récupérer les données du formulaire
        $email = $request->input('email');
        $password = $request->input('password');
 
        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $request->session()->regenerate();

            $role = Auth::user()->role; 

            //dd($role);
            //die();

            switch ($role) {

                case 'Admin':
                    # code...
                    if (intval(Auth::user()->active) == 1) {
                        # code...
                        return redirect()->intended('dashboard/admin');
                    } else {
                        # code...
                        return redirect()->intended('accueil')->with('failed', 'Votre compte a été désactivé. Veuillez contacter votre administrateur !');
                    }
                    break;

                default:
                    # code...
                    return redirect()->intended('accueil')->with('failed', 'Erreur systeme. Veuillez reessayer svp !');
                    break;
            }
        }

        return redirect()->back()->with([
            'failed' => 'Les identifiants fournies ne correspondent pas !',
        ]);

        
    }



}
