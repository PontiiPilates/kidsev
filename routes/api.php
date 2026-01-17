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

Route::get('timetable/all', [TimetableController::class, 'all']);
Route::get('timetable/district/{id}', [TimetableController::class, 'district']);

Route::get('timetable/organization/exists', [TimetableController::class, 'organizationExists']);
Route::get('timetable/organization/{code}', [TimetableController::class, 'organization']);
Route::get('timetable/organizations', [TimetableController::class, 'organizations']);

Route::get('timetable/events', [TimetableController::class, 'events']);
