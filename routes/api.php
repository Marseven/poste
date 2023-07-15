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
Route::post('login', [App\Http\Controllers\Api\ApiAgentController::class, 'login']);
Route::post('forgotpassword', [App\Http\Controllers\Api\ApiAgentController::class, 'forgotpassword']);
Route::post('resetpassword', [App\Http\Controllers\Api\ApiAgentController::class, 'resetpassword']);
/* Routing de gestion d'authentification */


Route::middleware(['auth:api'])->group(function() {

	Route::get('getprofil/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'getprofil']);
	Route::post('modifierpassword/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'modifierpassword']);

	Route::get('notifications/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'notifications']);

	Route::get('packages-actives/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'packages_actives']);
	Route::get('packages-completes/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'packages_completes']);

	Route::get('colis-du-jour/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'today_colis']);
	Route::get('expeditions-du-jour/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'today_packages_expedition']);

	Route::post('assigner-colis/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'assign_colis']);
	Route::post('cloturer-assignation/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'close_assignation']);

	Route::post('detail-colis/{user_id}', [App\Http\Controllers\Api\ApiAgentController::class, 'detail_colis']);


});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
