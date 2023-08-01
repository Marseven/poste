<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




/* Routing de gestion d'authentification */

Route::post('se-connecter', [App\Http\Controllers\Api\ApiAgentController::class, 'seconnecter']);
Route::post('mot-de-passe-oublie', [App\Http\Controllers\Api\ApiAgentController::class, 'forgotpassword']);
Route::post('reinitialiser-mot-de-passe', [App\Http\Controllers\Api\ApiAgentController::class, 'resetpassword']);

Route::post('connexion', [App\Http\Controllers\Api\ApiClientController::class, 'seconnecter']);
Route::post('creer-un-compte', [App\Http\Controllers\Api\ApiClientController::class, 'creeruncompte']);
Route::post('mot-de-passe', [App\Http\Controllers\Api\ApiClientController::class, 'forgotpassword']);
Route::post('reinitialiser', [App\Http\Controllers\Api\ApiClientController::class, 'resetpassword']);
Route::post('avatar', [App\Http\Controllers\Api\ApiClientController::class, 'modifieravatar']);
/* Routing de gestion d'authentification */

Route::post('onesignal-client', [App\Http\Controllers\Api\ApiClientController::class, 'onesignal_client']);
Route::post('onesignal-agent', [App\Http\Controllers\Api\ApiAgentController::class, 'onesignal_agent']);


Route::middleware(['auth:sanctum'])->group(function () {

    /* Routing de gestion Agent */
    Route::post('mon-profil', [App\Http\Controllers\Api\ApiAgentController::class, 'getprofil']);
    Route::post('modifier-profil/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'modifierprofil']);
    Route::post('modifier-avatar/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'modifieravatar']);
    Route::post('modifier-mot-de-passe/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'modifierpassword']);

    Route::get('notifications/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'notifications']);

    Route::post('agents-actives/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'agents_actives']);
    Route::get('bureaux-actifs/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'bureaux_actives']);

    Route::get('packages-actives/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'packages_actives']);
    Route::get('packages-completes/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'packages_completes']);

    Route::get('colis-du-jour/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'today_colis']);
    Route::get('expeditions-du-jour/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'today_packages_expedition']);

    Route::post('assigner-colis/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'assign_colis']);
    Route::post('supprimer-colis/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'delete_colis']);
    Route::post('cloturer-assignation/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'close_assignation']);

    Route::post('detail-colis/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'detail_colis']);
    Route::post('detail-package/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'detail_package']);
    Route::post('scan-package/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'scan_package']);
    Route::post('operation-package/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'operation_package']);
    Route::post('action-package/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'action_package']);
    Route::post('suivi-package/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'suivi_package']);
    Route::post('complete-package/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'complete_package']);
    Route::post('agent-package/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'agent_package']);


    Route::get('incidents/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'incidents']);
    Route::post('new-incident/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'new_incident']);
    Route::post('update-incident/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'update_incident']);
    Route::get('search-incident/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'search_incident']);
    Route::post('delete-incident/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'delete_incident']);
    Route::post('detail-incident/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'detail_incident']);
    /* Routing de gestion Agent */

    /* Routing de gestion Client */
    Route::post('mon-profil', [App\Http\Controllers\Api\ApiClientController::class, 'getprofil']);
    Route::post('modifier-profil/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'modifierprofil']);
    Route::post('modifier-mot-de-passe/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'modifierpassword']);
    Route::post('avatar/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'modifieravatar']);

    Route::get('notifications/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'notifications']);

    Route::get('expeditions-actives/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'expeditions_actives']);
    Route::get('expeditions-completes/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'expeditions_completes']);

    Route::post('new-expedition/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'new_expedition']);
    Route::post('update-expedition/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'update_expedition']);
    Route::get('search-expedition/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'search_expedition']);
    Route::post('delete-expedition/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'delete_expedition']);
    Route::post('track-expedition/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'track_expedition']);

    Route::post('detail-colis/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'detail_colis']);
    Route::post('colis-expedition/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'colis_expedition']);
    Route::post('suivi-expedition/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'suivi_expedition']);


    Route::get('reclamations/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'reclamations']);
    Route::post('new-reclamation/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'new_reclamation']);
    Route::post('update-reclamation/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'update_reclamation']);
    Route::get('search-reclamation/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'search_reclamation']);
    Route::post('delete-reclamation/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'delete_reclamation']);
    Route::post('detail-reclamation/{user_id}', [App\Http\Controllers\Api\ApiClientController::class, 'detail_reclamation']);
    /* Routing de gestion Client */
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
