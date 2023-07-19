<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EmplacementContoller;
use App\Http\Controllers\Admin\ExpeditionContoller;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
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

/* route du site */

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('accueil');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/signin', [App\Http\Controllers\HomeController::class, 'login'])->name('signin');
/* Fin routage du site */

Route::middleware(['auth'])->group(function () {
});

/*
| Backend
*/
Route::prefix('admin')->namespace('Admin')->middleware('admin')->group(function () {

    ################################################################################################################
    #                                                                                                              #
    #   ADMIN                                                                                                      #
    #                                                                                                              #
    ################################################################################################################

    /* Debut routage Admin */

    /* Start Tableau de bord */
    Route::get('/', [AdminController::class, 'adminHome'])->name('adminHome');
    /* End Tableau de bord */

    /* Start Profil */
    Route::get('profil', [UserController::class, 'adminProfil'])->name('adminProfil');
    Route::post('up-profil', [UserController::class, 'adminUpProfil'])->name('adminUpProfil');
    Route::post('up-avatar', [UserController::class, 'adminUpAvatar'])->name('adminUpAvatar');
    Route::post('up-password', [UserController::class, 'adminUpPassword'])->name('adminUpPassword');
    /* End Profil */

    /* Start Compte */
    Route::get('creer-compte', [UserController::class, 'adminNewCompte'])->name('adminNewCompte');
    Route::post('add-compte', [UserController::class, 'adminAddCompte'])->name('adminAddCompte');
    Route::get('comptes', [UserController::class, 'adminCompte'])->name('adminCompte');
    Route::post('edit-compte', [UserControllerr::class, 'adminEditCompte'])->name('adminEditCompte');
    Route::post('avatar-compte', [UserController::class, 'adminAvatarCompte'])->name('adminAvatarCompte');
    Route::get('recherche-compte', [UserController::class, 'adminSearchCompte'])->name('adminSearchCompte');
    /* End Compte */

    /* Start Pays */
    Route::get('liste-des-pays', [EmplacementContoller::class, 'adminPays'])->name('adminPays');
    Route::post('add-pays', [EmplacementContoller::class, 'adminAddPays'])->name('adminAddPays');
    Route::post('flag-pays', [EmplacementContoller::class, 'adminFlagPays'])->name('adminFlagPays');
    Route::post('edit-pays', [EmplacementContoller::class, 'adminEditPays'])->name('adminEditPays');
    Route::get('recherche-pays', [EmplacementContoller::class, 'adminSearchPays'])->name('adminSearchPays');
    /* End Pays */

    /* Start Province */
    Route::get('liste-des-provinces', [EmplacementContoller::class, 'adminProvince'])->name('adminProvince');
    Route::post('add-province', [EmplacementContoller::class, 'adminAddProvince'])->name('adminAddProvince');
    Route::post('edit-province', [EmplacementContoller::class, 'adminEditProvince'])->name('adminEditProvince');
    Route::get('recherche-province', [EmplacementContoller::class, 'adminSearchProvince'])->name('adminSearchProvince');
    /* End Province */

    /* Start Ville */
    Route::get('liste-des-villes', [EmplacementContoller::class, 'adminVille'])->name('adminVille');
    Route::post('add-ville', [EmplacementContoller::class, 'adminAddVille'])->name('adminAddVille');
    Route::post('edit-ville', [EmplacementContoller::class, 'adminEditVille'])->name('adminEditVille');
    Route::get('recherche-ville', [EmplacementContoller::class, 'adminSearchVille'])->name('adminSearchVille');
    /* End Ville */

    /* Start Agence */
    Route::get('liste-des-agences', [EmplacementContoller::class, 'adminAgence'])->name('adminAgence');
    Route::post('add-agence', [EmplacementContoller::class, 'adminAddAgence'])->name('adminAddAgence');
    Route::post('edit-agence', [EmplacementContoller::class, 'adminEditAgence'])->name('adminEditAgence');
    Route::get('recherche-agence', [EmplacementContoller::class, 'adminSearchAgence'])->name('adminSearchAgence');
    /* End Agence */

    /* Start Societe */
    Route::get('la-societe', [AdminController::class, 'adminSociete'])->name('adminSociete');
    Route::post('edit-societe', [AdminController::class, 'adminEditSociete'])->name('adminEditSociete');
    Route::post('logo-societe', [AdminController::class, 'adminLogoSociete'])->name('adminLogoSociete');
    Route::post('icon-societe', [AdminController::class, 'adminIconSociete'])->name('adminIconSociete');
    /* End Societe */


    /* Start Expedition */
    Route::get('expeditions', [ExpeditionContoller::class, 'adminExpeditionList'])->name('adminExpeditionList');
    Route::get('nouvelle-expedition', [ExpeditionContoller::class, 'adminNewExpedition'])->name('adminNewExpedition');

    Route::post('new-step1', [ExpeditionContoller::class, 'adminNewStep1'])->name('adminNewStep1');
    Route::post('new-step2', [ExpeditionContoller::class, 'adminNewStep2'])->name('adminNewStep2');
    Route::post('new-validation', [ExpeditionContoller::class, 'adminNewValidation'])->name('adminNewValidation');

    Route::post('new-document', [ExpeditionContoller::class, 'adminNewDocument'])->name('adminNewDocument');
    Route::post('new-paquet', [ExpeditionContoller::class, 'adminNewPaquet'])->name('adminNewPaquet');
    Route::post('delete-paquet', [ExpeditionContoller::class, 'adminDeletePaquet'])->name('adminDeletePaquet');
    Route::post('add-expedition', [ExpeditionContoller::class, 'adminAddExpedition'])->name('adminAddExpedition');
    /* End Expedition */

    /* Start Facture */
    Route::get('facture/expedition/{code}', [ExpeditionContoller::class, 'adminFactureExpedition'])->name('adminFactureExpedition');
    Route::get('facture/pay/{code}', [ExpeditionContoller::class, 'adminFacturePay'])->name('adminFacturePay');
    Route::get('imprimer/facture/{code}', [ExpeditionContoller::class, 'adminFacturePrint'])->name('adminFacturePrint');

    Route::get('/imprimer/facture/{code}', [ExpeditionContoller::class, 'FacturePrint'])->name('FacturePrint');

    /* End Facture */

    /* Start Etiquette */
    Route::get('etiquette/expedition/{code}', [ExpeditionContoller::class, 'adminEtiquetteExpedition'])->name('adminEtiquetteExpedition');
    Route::get('imprimer/etiquette/{code}', [ExpeditionContoller::class, 'adminEtiquettePrint'])->name('adminEtiquettePrint');

    Route::get('/imprimer/etiquette/{code}', [ExpeditionContoller::class, 'EtiquettePrint'])->name('EtiquettePrint');
    /* End Etiquette */

    /* Start Suivi */
    Route::get('suivi/expedition/{code}', [ExpeditionContoller::class, 'adminSuiviExpedition'])->name('adminSuiviExpedition');
    /* End Suivi */

    /* Start Package */
    Route::get('packages', [ExpeditionContoller::class, 'adminPackage'])->name('adminPackage');
    Route::post('add-package', [ExpeditionContoller::class, 'adminAddPackage'])->name('adminAddPackage');
    Route::post('edit-package', [ExpeditionContoller::class, 'adminEditPackage'])->name('adminEditPackage');
    Route::get('recherche-package', [ExpeditionContoller::class, 'adminSearchPackage'])->name('adminSearchPackage');
    Route::get('package/{code}', [ExpeditionContoller::class, 'adminDetailPackage'])->name('adminDetailPackage');
    Route::post('assign-package', [ExpeditionContoller::class, 'adminPackageAssign'])->name('adminPackageAssign');
    Route::get('suivi/package/{code}', [ExpeditionContoller::class, 'adminSuiviPackage'])->name('adminSuiviPackage');
    /* End Package */

    /* Start Service */
    Route::get('services-expedition', [SettingController::class, 'adminService'])->name('adminService');
    Route::post('add-service', [SettingController::class, 'adminAddService'])->name('adminAddService');
    Route::post('edit-service', [SettingController::class, 'adminEditService'])->name('adminEditService');
    Route::get('recherche-service', [SettingController::class, 'adminSearchService'])->name('adminSearchService');
    /* End Service */

    /* Start Delai */
    Route::get('delais-expedition', [SettingController::class, 'adminDelai'])->name('adminDelai');
    Route::post('add-delai', [SettingController::class, 'adminAddDelai'])->name('adminAddDelai');
    Route::post('edit-delai', [SettingController::class, 'adminEditDelai'])->name('adminEditDelai');
    Route::get('recherche-delai', [SettingController::class, 'adminSearchDelai'])->name('adminSearchDelai');
    /* End Delai */

    /* Start Statut */
    Route::get('statuts-expedition', [SettingController::class, 'adminStatut'])->name('adminStatut');
    Route::post('add-statut', [SettingController::class, 'adminAddStatut'])->name('adminAddStatut');
    Route::post('edit-statut', [SettingController::class, 'adminEditStatut'])->name('adminEditStatut');
    Route::get('recherche-statut', [SettingController::class, 'adminSearchStatut'])->name('adminSearchStatut');
    /* End Statut */

    /* Start Price */
    Route::get('prices-expedition', [SettingController::class, 'adminPrice'])->name('adminPrice');
    Route::post('add-price', [SettingController::class, 'adminAddPrice'])->name('adminAddPrice');
    Route::post('edit-price', [SettingController::class, 'adminEditPrice'])->name('adminEditPrice');
    Route::get('recherche-price', [SettingController::class, 'adminSearchPrice'])->name('adminSearchPrice');
    /* End Price */

    Route::get('select-data', [SettingController::class, 'selectData'])->name('adminSelect');

    /* Start Mouchard */
    Route::get('logs', [SettingController::class, 'adminMouchard'])->name('adminMouchard');
    Route::get('recherche/log', [SettingController::class, 'adminSearchMouchard'])->name('adminSearchMouchard');
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
