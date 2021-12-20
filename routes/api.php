<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::group([
        'prefix' => 'tipo-plato',
    ], function () {
        Route::apiResource('/', App\Http\Controllers\TipoPlatoController::class);
        Route::get('/{id}/platos', [App\Http\Controllers\TipoPlatoController::class, 'platos']);
    });

    Route::apiResource('/plato', App\Http\Controllers\PlatoController::class);
    Route::apiResource('/ingrediente', App\Http\Controllers\IngredienteController::class);
    Route::apiResource('/plato-ingrediente', App\Http\Controllers\PlatoIngredienteController::class);

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
});

Route::post('/assign-roles', [App\Http\Controllers\AuthController::class, 'assignRoles'])->middleware(['auth:sanctum', 'checkRole:Administrator']);

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

