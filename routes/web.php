<?php

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

Route::get('/', function () {
    return view('welcome');
});

/**
 * Telegram-бот.
 */

// вебхук
Route::post('/tg/webhook', [App\Http\Controllers\Telegram\WebhookController::class, 'webhook']);
// установка вебхука
Route::get('/tg/set/webhook', [App\Http\Controllers\Telegram\WebhookController::class, 'set']);
// удаление вебхука
Route::get('/tg/delete/webhook', [App\Http\Controllers\Telegram\WebhookController::class, 'delete']);
// информация о вебхуке
Route::get('/tg/info/webhook', [App\Http\Controllers\Telegram\WebhookController::class, 'info']);

/**
 * SquirrelKidsBot.
 * При добавлениие нового вебхука не забудь исключить маршрут из csrf-добавлений.
 */

// вебхук
Route::post('/tg/6bf533cfeff238e0d7d265a69a7018ad/webhook', [App\Http\Controllers\Telegram\SquirrelKidsBotController::class, 'webhook']);
// установка вебхука
Route::get('/tg/6bf533cfeff238e0d7d265a69a7018ad/set/webhook', [App\Http\Controllers\Telegram\SquirrelKidsBotController::class, 'set']);
// удаление вебхука
Route::get('/tg/6bf533cfeff238e0d7d265a69a7018ad/delete/webhook', [App\Http\Controllers\Telegram\SquirrelKidsBotController::class, 'delete']);
// информация о вебхуке
Route::get('/tg/6bf533cfeff238e0d7d265a69a7018ad/info/webhook', [App\Http\Controllers\Telegram\SquirrelKidsBotController::class, 'info']);

/**
 * Маршруты админки.
 */

Route::get('/6bf533cfeff238e0d7d265a69a7018ad/admin/home', [App\Http\Controllers\Telegram\SquirrelKidsBotController::class, 'admin'])->name('admin.home');

/**
 * Маршруты управления программами.
 */

use App\Http\Controllers\ProgramController;

// список программ
Route::get('/6bf533cfeff238e0d7d265a69a7018ad/admin/index/programs', [ProgramController::class, 'index'])->name('admin.programs.index');

// добавление программы
Route::match(['get', 'post'], '/6bf533cfeff238e0d7d265a69a7018ad/admin/create/program', [ProgramController::class, 'create'])->name('admin.program.create');
// редактирование программы
Route::match(['get', 'post'], '/6bf533cfeff238e0d7d265a69a7018ad/admin/edit/program/{id}', [ProgramController::class, 'edit'])->name('admin.program.edit');
// удаление программы
Route::post('/6bf533cfeff238e0d7d265a69a7018ad/admin/destroy/program/{id}', [ProgramController::class, 'destroy'])->name('admin.program.destroy');

// просмотр программы
Route::get('/6bf533cfeff238e0d7d265a69a7018ad/admin/show/program/{id}', [ProgramController::class, 'show'])->name('admin.program.show');
// просмотр расписания
Route::get('/6bf533cfeff238e0d7d265a69a7018ad/admin/show/timetable/programs', [ProgramController::class, 'show'])->name('admin.timetable.programs.show');

/**
 * Маршруты мероприятиями.
 */

use App\Http\Controllers\EventController;

// список мероприятий
Route::get('/6bf533cfeff238e0d7d265a69a7018ad/admin/index/events', [EventController::class, 'index'])->name('admin.events.index');

// добавление мероприятия
Route::match(['get', 'post'], '/6bf533cfeff238e0d7d265a69a7018ad/admin/create/event', [EventController::class, 'create'])->name('admin.event.create');
// редактирование мероприятия
Route::match(['get', 'post'], '/6bf533cfeff238e0d7d265a69a7018ad/admin/edit/event/{id}', [EventController::class, 'edit'])->name('admin.event.edit');
// удаление мероприятия
Route::post('/6bf533cfeff238e0d7d265a69a7018ad/admin/destroy/event/{id}', [EventController::class, 'destroy'])->name('admin.event.destroy');

// просмотр мероприятия
Route::get('/6bf533cfeff238e0d7d265a69a7018ad/admin/show/event/{id}', [EventController::class, 'show'])->name('admin.event.show');
// просмотр расписания мероприятий
Route::get('/6bf533cfeff238e0d7d265a69a7018ad/admin/show/timetable/events', [EventController::class, 'show'])->name('admin.timetable.events.show');

/**
 * Маршруты акций.
 */

use App\Http\Controllers\PromotionController;

// список акций
Route::get('/6bf533cfeff238e0d7d265a69a7018ad/admin/index/promotions', [PromotionController::class, 'index'])->name('admin.promotions.index');

// добавление акции
Route::match(['get', 'post'], '/6bf533cfeff238e0d7d265a69a7018ad/admin/create/promotion', [PromotionController::class, 'create'])->name('admin.promotion.create');
// редактирование акции
Route::match(['get', 'post'], '/6bf533cfeff238e0d7d265a69a7018ad/admin/edit/promotion/{id}', [PromotionController::class, 'edit'])->name('admin.promotion.edit');
// удаление акции
Route::post('/6bf533cfeff238e0d7d265a69a7018ad/admin/destroy/promotion/{id}', [PromotionController::class, 'destroy'])->name('admin.promotion.destroy');

// просмотр акции
Route::get('/6bf533cfeff238e0d7d265a69a7018ad/admin/show/promotion/{id}', [PromotionController::class, 'show'])->name('admin.promotion.show');
// просмотр акций
Route::get('/6bf533cfeff238e0d7d265a69a7018ad/admin/show/promotions', [PromotionController::class, 'show'])->name('admin.promotions.show');

/**
 * Маршруты о нас.
 */

use App\Http\Controllers\AboutController;

// просмотр о нас
Route::get('/6bf533cfeff238e0d7d265a69a7018ad/admin/index/about', [AboutController::class, 'index'])->name('admin.about.index');
// редактирование о нас
Route::match(['get', 'post'], '/6bf533cfeff238e0d7d265a69a7018ad/admin/edit/about', [AboutController::class, 'edit'])->name('admin.about.edit');

// TODO: 1. Программы и мероприятия следует объединить в один модуль - entity || timetable