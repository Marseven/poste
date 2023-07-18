<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});


/* route du site */
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('accueil');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/se-connecter', [App\Http\Controllers\SiteController::class, 'connexion'])->name('connexion');
/* Fin routage du site */

Route::middleware(['auth'])->group(function () {

    ################################################################################################################
    #                                                                                                              #
    #   ADMIN                                                                                                      #
    #                                                                                                              #
    ################################################################################################################

    /* Debut routage Admin */

    /* Start Tableau de bord */
    Route::get('dashboard/admin', [App\Http\Controllers\AdminController::class, 'adminHome'])->name('adminHome');
    /* End Tableau de bord */

    /* Start Profil */
    Route::get('dashboard/admin/profil', [App\Http\Controllers\AdminController::class, 'adminProfil'])->name('adminProfil');
    Route::post('dashboard/admin/up-profil', [App\Http\Controllers\AdminController::class, 'adminUpProfil'])->name('adminUpProfil');
    Route::post('dashboard/admin/up-avatar', [App\Http\Controllers\AdminController::class, 'adminUpAvatar'])->name('adminUpAvatar');
    Route::post('dashboard/admin/up-password', [App\Http\Controllers\AdminController::class, 'adminUpPassword'])->name('adminUpPassword');
    /* End Profil */

    /* Start Compte */
    Route::get('dashboard/admin/creer-compte', [App\Http\Controllers\AdminController::class, 'adminNewCompte'])->name('adminNewCompte');
    Route::post('dashboard/admin/add-compte', [App\Http\Controllers\AdminController::class, 'adminAddCompte'])->name('adminAddCompte');
    Route::get('dashboard/admin/comptes', [App\Http\Controllers\AdminController::class, 'adminCompte'])->name('adminCompte');
    Route::post('dashboard/admin/edit-compte', [App\Http\Controllers\AdminController::class, 'adminEditCompte'])->name('adminEditCompte');
    Route::post('dashboard/admin/avatar-compte', [App\Http\Controllers\AdminController::class, 'adminAvatarCompte'])->name('adminAvatarCompte');
    Route::get('dashboard/admin/recherche-compte', [App\Http\Controllers\AdminController::class, 'adminSearchCompte'])->name('adminSearchCompte');
    /* End Compte */

    /* Start Pays */
    Route::get('dashboard/admin/liste-des-pays', [App\Http\Controllers\AdminController::class, 'adminPays'])->name('adminPays');
    Route::post('dashboard/admin/add-pays', [App\Http\Controllers\AdminController::class, 'adminAddPays'])->name('adminAddPays');
    Route::post('dashboard/admin/flag-pays', [App\Http\Controllers\AdminController::class, 'adminFlagPays'])->name('adminFlagPays');
    Route::post('dashboard/admin/edit-pays', [App\Http\Controllers\AdminController::class, 'adminEditPays'])->name('adminEditPays');
    Route::get('dashboard/admin/recherche-pays', [App\Http\Controllers\AdminController::class, 'adminSearchPays'])->name('adminSearchPays');
    /* End Pays */

    /* Start Province */
    Route::get('dashboard/admin/liste-des-provinces', [App\Http\Controllers\AdminController::class, 'adminProvince'])->name('adminProvince');
    Route::post('dashboard/admin/add-province', [App\Http\Controllers\AdminController::class, 'adminAddProvince'])->name('adminAddProvince');
    Route::post('dashboard/admin/edit-province', [App\Http\Controllers\AdminController::class, 'adminEditProvince'])->name('adminEditProvince');
    Route::get('dashboard/admin/recherche-province', [App\Http\Controllers\AdminController::class, 'adminSearchProvince'])->name('adminSearchProvince');
    /* End Province */

    /* Start Ville */
    Route::get('dashboard/admin/liste-des-villes', [App\Http\Controllers\AdminController::class, 'adminVille'])->name('adminVille');
    Route::post('dashboard/admin/add-ville', [App\Http\Controllers\AdminController::class, 'adminAddVille'])->name('adminAddVille');
    Route::post('dashboard/admin/edit-ville', [App\Http\Controllers\AdminController::class, 'adminEditVille'])->name('adminEditVille');
    Route::get('dashboard/admin/recherche-ville', [App\Http\Controllers\AdminController::class, 'adminSearchVille'])->name('adminSearchVille');
    /* End Ville */

    /* Start Societe */
    Route::get('dashboard/admin/la-societe', [App\Http\Controllers\AdminController::class, 'adminSociete'])->name('adminSociete');
    Route::post('dashboard/admin/edit-societe', [App\Http\Controllers\AdminController::class, 'adminEditSociete'])->name('adminEditSociete');
    Route::post('dashboard/admin/logo-societe', [App\Http\Controllers\AdminController::class, 'adminLogoSociete'])->name('adminLogoSociete');
    Route::post('dashboard/admin/icon-societe', [App\Http\Controllers\AdminController::class, 'adminIconSociete'])->name('adminIconSociete');
    /* End Societe */

    /* Start Agence */
    Route::get('dashboard/admin/liste-des-agences', [App\Http\Controllers\AdminController::class, 'adminAgence'])->name('adminAgence');
    Route::post('dashboard/admin/add-agence', [App\Http\Controllers\AdminController::class, 'adminAddAgence'])->name('adminAddAgence');
    Route::post('dashboard/admin/edit-agence', [App\Http\Controllers\AdminController::class, 'adminEditAgence'])->name('adminEditAgence');
    Route::get('dashboard/admin/recherche-agence', [App\Http\Controllers\AdminController::class, 'adminSearchAgence'])->name('adminSearchAgence');
    /* End Agence */

    /* Start Service */
    Route::get('dashboard/admin/services-expedition', [App\Http\Controllers\AdminController::class, 'adminService'])->name('adminService');
    Route::post('dashboard/admin/add-service', [App\Http\Controllers\AdminController::class, 'adminAddService'])->name('adminAddService');
    Route::post('dashboard/admin/edit-service', [App\Http\Controllers\AdminController::class, 'adminEditService'])->name('adminEditService');
    Route::get('dashboard/admin/recherche-service', [App\Http\Controllers\AdminController::class, 'adminSearchService'])->name('adminSearchService');
    /* End Service */

    /* Start Delai */
    Route::get('dashboard/admin/delais-expedition', [App\Http\Controllers\AdminController::class, 'adminDelai'])->name('adminDelai');
    Route::post('dashboard/admin/add-delai', [App\Http\Controllers\AdminController::class, 'adminAddDelai'])->name('adminAddDelai');
    Route::post('dashboard/admin/edit-delai', [App\Http\Controllers\AdminController::class, 'adminEditDelai'])->name('adminEditDelai');
    Route::get('dashboard/admin/recherche-delai', [App\Http\Controllers\AdminController::class, 'adminSearchDelai'])->name('adminSearchDelai');
    /* End Delai */

    /* Start Statut */
    Route::get('dashboard/admin/statuts-expedition', [App\Http\Controllers\AdminController::class, 'adminStatut'])->name('adminStatut');
    Route::post('dashboard/admin/add-statut', [App\Http\Controllers\AdminController::class, 'adminAddStatut'])->name('adminAddStatut');
    Route::post('dashboard/admin/edit-statut', [App\Http\Controllers\AdminController::class, 'adminEditStatut'])->name('adminEditStatut');
    Route::get('dashboard/admin/recherche-statut', [App\Http\Controllers\AdminController::class, 'adminSearchStatut'])->name('adminSearchStatut');
    /* End Statut */

    /* Start Forfait */
    Route::get('dashboard/admin/forfaits-expedition', [App\Http\Controllers\AdminController::class, 'adminForfait'])->name('adminForfait');
    Route::post('dashboard/admin/add-forfait', [App\Http\Controllers\AdminController::class, 'adminAddForfait'])->name('adminAddForfait');
    Route::post('dashboard/admin/edit-forfait', [App\Http\Controllers\AdminController::class, 'adminEditForfait'])->name('adminEditForfait');
    Route::get('dashboard/admin/recherche-forfait', [App\Http\Controllers\AdminController::class, 'adminSearchForfait'])->name('adminSearchForfait');
    /* End Forfait */

    /* Start Tarif */
    Route::get('dashboard/admin/tarifs-expedition', [App\Http\Controllers\AdminController::class, 'adminTarif'])->name('adminTarif');
    Route::post('dashboard/admin/add-tarif', [App\Http\Controllers\AdminController::class, 'adminAddTarif'])->name('adminAddTarif');
    Route::post('dashboard/admin/edit-tarif', [App\Http\Controllers\AdminController::class, 'adminEditTarif'])->name('adminEditTarif');
    Route::get('dashboard/admin/recherche-tarif', [App\Http\Controllers\AdminController::class, 'adminSearchTarif'])->name('adminSearchTarif');
    /* End Tarif */

    /* Start type */
    Route::get('dashboard/admin/types-expedition', [App\Http\Controllers\AdminController::class, 'adminType'])->name('adminType');
    Route::post('dashboard/admin/add-type', [App\Http\Controllers\AdminController::class, 'adminAddType'])->name('adminAddType');
    Route::post('dashboard/admin/edit-type', [App\Http\Controllers\AdminController::class, 'adminEditType'])->name('adminEditType');
    Route::get('dashboard/admin/recherche-type', [App\Http\Controllers\AdminController::class, 'adminSearchType'])->name('adminSearchType');
    /* End Type */

    /* Start Regime */
    Route::get('dashboard/admin/regimes-expedition', [App\Http\Controllers\AdminController::class, 'adminRegime'])->name('adminRegime');
    Route::post('dashboard/admin/add-regime', [App\Http\Controllers\AdminController::class, 'adminAddRegime'])->name('adminAddRegime');
    Route::post('dashboard/admin/edit-regime', [App\Http\Controllers\AdminController::class, 'adminEditRegime'])->name('adminEditRegime');
    Route::get('dashboard/admin/recherche-regime', [App\Http\Controllers\AdminController::class, 'adminSearchRegime'])->name('adminSearchRegime');
    /* End Regime */

    /* Start Category */
    Route::get('dashboard/admin/Categories-expedition', [App\Http\Controllers\AdminController::class, 'adminCategory'])->name('adminCategory');
    Route::post('dashboard/admin/add-category', [App\Http\Controllers\AdminController::class, 'adminAddCategory'])->name('adminAddCategory');
    Route::post('dashboard/admin/edit-category', [App\Http\Controllers\AdminController::class, 'adminEditCategory'])->name('adminEditCategory');
    Route::get('dashboard/admin/recherche-category', [App\Http\Controllers\AdminController::class, 'adminSearchCategory'])->name('adminSearchCategory');
    /* End Category */

    /* Start Price */
    Route::get('dashboard/admin/prices-expedition', [App\Http\Controllers\AdminController::class, 'adminPrice'])->name('adminPrice');
    Route::post('dashboard/admin/add-price', [App\Http\Controllers\AdminController::class, 'adminAddPrice'])->name('adminAddPrice');
    Route::post('dashboard/admin/edit-price', [App\Http\Controllers\AdminController::class, 'adminEditPrice'])->name('adminEditPrice');
    Route::get('dashboard/admin/recherche-price', [App\Http\Controllers\AdminController::class, 'adminSearchPrice'])->name('adminSearchPrice');
    /* End Price */

    Route::get('dashboard/admin/select-data', [App\Http\Controllers\AdminController::class, 'selectData'])->name('adminSelect');

    /* Start Expedition */
    Route::get('dashboard/admin/expeditions', [App\Http\Controllers\AdminController::class, 'adminExpeditionList'])->name('adminExpeditionList');
    Route::get('dashboard/admin/nouvelle-expedition', [App\Http\Controllers\AdminController::class, 'adminNewExpedition'])->name('adminNewExpedition');

    Route::get('dashboard/admin/expedition/etape-1', [App\Http\Controllers\AdminController::class, 'adminStep1'])->name('adminStep1');
    Route::get('dashboard/admin/expedition/etape-2/{code}', [App\Http\Controllers\AdminController::class, 'adminStep2'])->name('adminStep2');
    Route::get('dashboard/admin/expedition/etape-3/{code}', [App\Http\Controllers\AdminController::class, 'adminStep3'])->name('adminStep3');
    Route::get('dashboard/admin/expedition/etape-4/{code}', [App\Http\Controllers\AdminController::class, 'adminStep4'])->name('adminStep4');
    Route::get('dashboard/admin/expedition/recapitulatif/{code}', [App\Http\Controllers\AdminController::class, 'adminStep5'])->name('adminStep5');

    Route::post('dashboard/admin/new-step1', [App\Http\Controllers\AdminController::class, 'adminNewStep1'])->name('adminNewStep1');
    Route::post('dashboard/admin/new-step2', [App\Http\Controllers\AdminController::class, 'adminNewStep2'])->name('adminNewStep2');
    Route::post('dashboard/admin/new-validation', [App\Http\Controllers\AdminController::class, 'adminNewValidation'])->name('adminNewValidation');

    Route::post('dashboard/admin/new-document', [App\Http\Controllers\AdminController::class, 'adminNewDocument'])->name('adminNewDocument');
    Route::post('dashboard/admin/new-paquet', [App\Http\Controllers\AdminController::class, 'adminNewPaquet'])->name('adminNewPaquet');
    Route::post('dashboard/admin/delete-paquet', [App\Http\Controllers\AdminController::class, 'adminDeletePaquet'])->name('adminDeletePaquet');
    Route::post('dashboard/admin/add-expedition', [App\Http\Controllers\AdminController::class, 'adminAddExpedition'])->name('adminAddExpedition');
    /* End Expedition */

    /* Start Facture */
    Route::get('dashboard/admin/facture/expedition/{code}', [App\Http\Controllers\AdminController::class, 'adminFactureExpedition'])->name('adminFactureExpedition');
    Route::get('dashboard/admin/facture/pay/{code}', [App\Http\Controllers\AdminController::class, 'adminFacturePay'])->name('adminFacturePay');
    Route::get('dashboard/admin/imprimer/facture/{code}', [App\Http\Controllers\AdminController::class, 'adminFacturePrint'])->name('adminFacturePrint');

    Route::get('/imprimer/facture/{code}', [App\Http\Controllers\AdminController::class, 'FacturePrint'])->name('FacturePrint');

    /* End Facture */

    /* Start Etiquette */
    Route::get('dashboard/admin/etiquette/expedition/{code}', [App\Http\Controllers\AdminController::class, 'adminEtiquetteExpedition'])->name('adminEtiquetteExpedition');
    Route::get('dashboard/admin/imprimer/etiquette/{code}', [App\Http\Controllers\AdminController::class, 'adminEtiquettePrint'])->name('adminEtiquettePrint');

    Route::get('/imprimer/etiquette/{code}', [App\Http\Controllers\AdminController::class, 'EtiquettePrint'])->name('EtiquettePrint');
    /* End Etiquette */

    /* Start Suivi */
    Route::get('dashboard/admin/suivi/expedition/{code}', [App\Http\Controllers\AdminController::class, 'adminSuiviExpedition'])->name('adminSuiviExpedition');
    /* End Suivi */

    /* Start Package */
    Route::get('dashboard/admin/packages', [App\Http\Controllers\AdminController::class, 'adminPackage'])->name('adminPackage');
    Route::post('dashboard/admin/add-package', [App\Http\Controllers\AdminController::class, 'adminAddPackage'])->name('adminAddPackage');
    Route::post('dashboard/admin/edit-package', [App\Http\Controllers\AdminController::class, 'adminEditPackage'])->name('adminEditPackage');
    Route::get('dashboard/admin/recherche-package', [App\Http\Controllers\AdminController::class, 'adminSearchPackage'])->name('adminSearchPackage');
    Route::get('dashboard/admin/package/{code}', [App\Http\Controllers\AdminController::class, 'adminDetailPackage'])->name('adminDetailPackage');
    Route::post('dashboard/admin/assign-package', [App\Http\Controllers\AdminController::class, 'adminPackageAssign'])->name('adminPackageAssign');
    Route::get('dashboard/admin/suivi/package/{code}', [App\Http\Controllers\AdminController::class, 'adminSuiviPackage'])->name('adminSuiviPackage');
    /* End Package */

    /* Start Mouchard */
    Route::get('dashboard/admin/logs', [App\Http\Controllers\AdminController::class, 'adminMouchard'])->name('adminMouchard');
    Route::get('dashboard/admin/recherche/log', [App\Http\Controllers\AdminController::class, 'adminSearchMouchard'])->name('adminSearchMouchard');
    /* End Mouchard */
});

//Clear Cache facade value:
Route::get('/key', function () {
    $exitCode = Artisan::call('key:generate');
    return '<h1>Key generated with success !</h1>';
});

//Clear Cache facade value:
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cache cleared</h1>';
});

//Storage link:
Route::get('/link-storage', function () {
    $exitCode = Artisan::call('storage:link');
    return '<h1>Clear Config cache cleared</h1>';
});

//Clear Config cache:
Route::get('/proc-open-error', function () {
    $exitCode = Artisan::call('vendor:publish', ['--tag' => 'flare-config']);
    return '<h1>Proc open error resolved -> Think to change parameters in config/flare.php !!!</h1>';
});

//Storage route link
Route::get('/any-route', function () {
    $exitCode = Artisan::call('storage:link');
    echo $exitCode; // 0 exit code for no errors.
});

Auth::routes();
