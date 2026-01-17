<?php

use App\Http\Controllers\Api\KidsevBotController;
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

Route::get('organizations/all', [KidsevBotController::class, 'organizationsAll']);
Route::get('organizations/district/{id}', [KidsevBotController::class, 'organizationsByDistrict']);
Route::get('organization/search', [KidsevBotController::class, 'organizationSearch']);

Route::get('timetable/all', [KidsevBotController::class, 'timetableAll']);
Route::get('timetable/district/{id}', [KidsevBotController::class, 'timetableByDistrict']);
Route::get('timetable/organization/{code}', [KidsevBotController::class, 'timetableByOrganization']);
