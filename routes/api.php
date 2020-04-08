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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/** Patients API Routes */
Route::get('patients', 'PatientsController@index');
Route::get('patients/{patient}', 'PatientsController@show');
Route::post('patients', 'PatientsController@store');
Route::put('patients/{patient}', 'PatientsController@update');
Route::delete('patients/{patient}', 'PatientsController@delete');

/** Providers API Routes */
Route::get('provider', 'ProviderController@index');
Route::get('provider/{patient}', 'ProviderController@show');
Route::post('provider', 'ProviderController@store');
Route::put('provider/{patient}', 'ProviderController@update');
Route::delete('provider/{patient}', 'ProviderController@delete');


// ingest Stats
Route::get('ingest', 'IngestController@index');