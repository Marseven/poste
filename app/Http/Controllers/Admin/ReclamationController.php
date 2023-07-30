<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReclamationController extends Controller
{
    //
    ################################################################################################################
    #                                                                                                              #
    #   AGENT                                                                                                   #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminReclamationAgent(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Réclamations Agent";
        $reclamation = "side-menu--active";
        $reclamation_sub = "side-menu__sub-open";
        $reclamation1 = "side-menu--active";

        $reclamations = Reclamation::where('agent_id', '<>', null)->paginate(10);

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        return view('admin.adminReclamationAgent', compact(
            'page_title',
            'app_name',
            'reclamations',
            'reclamation',
            'reclamation_sub',
            'reclamation1',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchReclamationAgent(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Réclamations Agent";
        $reclamation = "side-menu--active";
        $reclamation_sub = "side-menu__sub-open";
        $reclamation1 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $reclemations = Reclamation::where('agent_id', '<>', null)->where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);

        return view('admin.adminReclamationAgent', compact(
            'page_title',
            'app_name',
            'reclamations',
            'reclamation',
            'reclamation_sub',
            'reclamation1',
        ));
    }

    ################################################################################################################
    #                                                                                                              #
    #   CLIENT                                                                                                     #
    #                                                                                                              #
    ################################################################################################################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminReclamationClient(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Réclamations Client";
        $reclamation = "side-menu--active";
        $reclamation_sub = "side-menu__sub-open";
        $reclamation2 = "side-menu--active";

        $methodes = Reclamation::where('client_id', '<>', null)->paginate(10);

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        return view('admin.adminReclamationClient', compact(
            'page_title',
            'app_name',
            'reclamations',
            'reclamation',
            'reclamation_sub',
            'reclamation2',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSearchReclamationClient(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Modes de paiement";
        $reclamation = "side-menu--active";
        $reclamation_sub = "side-menu__sub-open";
        $reclamation2 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $methodes = Reclamation::where('client_id', '<>', null)->where('code', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('libelle', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);

        return view('admin.adminReclamationClient', compact(
            'page_title',
            'app_name',
            'reclamations',
            'reclamation',
            'reclamation_sub',
            'reclamation2',
        ));
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminEditReclamation(Request $request)
    {
        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        // Get package by id
        $reclemation = Reclamation::find($request->input('reclamation_id'));
        if (!empty($package)) {

            // Récupérer les données du formulaire

            $reclemation->agent_id = $admin_id;
            $reclemation->active = $request->input('active');

            if ($package->save()) {

                // Redirection
                return back()->with('success', 'Réclamation modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier cette réclamation !');
        }
        return back()->with('failed', 'Impossible de trouver cette réclamation !');
    }
}
