<?php

use App\Http\Controllers\Api\TimetableController;
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

Route::get('organizations/all', [TimetableController::class, 'organizationsAll']);
Route::get('organizations/district/{id}', [TimetableController::class, 'organizationsByDistrict']);
Route::get('organization/search', [TimetableController::class, 'organizationSearch']);

Route::get('timetable/all', [TimetableController::class, 'timetableAll']);
Route::get('timetable/district/{id}', [TimetableController::class, 'timetableByDistrict']);
Route::get('timetable/organization/{code}', [TimetableController::class, 'timetableByOrganization']);