<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
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
        $account = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $agences = Agence::all();

        return view('admin.adminProfil', compact(
            'page_title',
            'app_name',
            'admin',
            'agences',
            'account'
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
            return back()->with('success', 'Profil modifié avec succès !');
        }
        return back()->with('failed', 'Impossible de modifier votre profil !');
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
                        return back()->with('success', 'Avatar modifiée avec succès !');
                    }
                    return back()->with('failed', 'Impossible de modifier votre avatar !');
                }
                return back()->with('failed', 'Imposible d\'uploader le fichier vers le répertoire défini !');
            }
            return back()->with('failed', 'L\'extension du fichier doit être soit du jpg ou du png !');
        }
        return back()->with('failed', 'Aucun fichier téléchargé. Veuillez réessayer svp !');
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
                    return back()->with('success', 'Mot de passe modifié avec succès !');
                }
                return back()->with('failed', 'Impossible de modifier votre mot de passe !');
            }
            return back()->with('failed', 'Votre ancien mot de passe semble incorrect. Veuillez saisir le bon svp !');
        }
        return back()->with('failed', 'Les mots de passe ne sont pas identiques. Veuillez réessayer svp !');
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

        $email_exist = User::where('email', $request->input('email'))->first();
        if ($email_exist > 0) {
            return back()->with('failed', 'Cette email est déjà utilisé !');
        }
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
            return redirect('comptes')->with('success', 'Nouveau Compte cree avec succès !');
        }
        return back()->with('failed', 'Impossible de creer ce compte !');
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
                            return back()->with('success', 'Avatar modifiée avec succès !');
                        }
                        return back()->with('failed', 'Impossible de modifier votre avatar !');
                    }
                    return back()->with('failed', 'Imposible d\'uploader le fichier vers le répertoire défini !');
                }
                return back()->with('failed', 'L\'extension du fichier doit être soit du jpg ou du png !');
            }
            return back()->with('failed', 'Aucun fichier téléchargé. Veuillez réessayer svp !');
        }
        return back()->with('failed', 'Impossible de trouver ce compte !');
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
                return back()->with('success', 'Compte modifié avec succès !');
            }
            return back()->with('failed', 'Impossible de modifier ce compte !');
        }
        return back()->with('failed', 'Impossible de trouver ce compte !');
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
        $account = "side-menu--active";
        $account_sub = "side-menu__sub-open";
        $account1 = "side-menu--active";

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
            'comptes',
            'account',
            'account_sub',
            'account1'
        ));
    }
}
