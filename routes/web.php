<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NicheController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SpreadsheetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {

    /* Recursos */
    Route::post('/get-cities', [ResourceController::class, 'cities'])->name('get.cities');
    /* Recursos */

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/buscar-leads', [LeadController::class, 'leadsSearch'])->name('leads.search');

    /* Consfigurações */
    Route::get('/configuracoes', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/configuracos/editar', [SettingController::class, 'update'])->name('settings.update');

    /* Status */
    Route::get('/status', [StatusController::class, 'index'])->name('statuses.index');
    Route::post('/status/search', [StatusController::class, 'search'])->name('statuses.search');
    Route::get('/status/criar', [StatusController::class, 'create'])->name('statuses.create');
    Route::post('/status/criar', [StatusController::class, 'store'])->name('statuses.store');
    Route::get('/status/editar/{status}', [StatusController::class, 'edit'])->name('statuses.edit');
    Route::put('/status/editar/{status}', [StatusController::class, 'update'])->name('statuses.update');
    Route::get('/status/deletar/{status}', [StatusController::class, 'destroy'])->name('statuses.destroy');
    Route::get('/status/{status}', [StatusController::class, 'show'])->name('statuses.show');
    /* Status */

    /* Leads */
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::post('/leads/search', [LeadController::class, 'search'])->name('leads.consult');
    Route::get('/leads/criar', [LeadController::class, 'create'])->name('leads.create');
    Route::post('/leads/criar', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/leads/editar/{lead}', [LeadController::class, 'edit'])->name('leads.edit');
    Route::put('/leads/editar/{lead}', [LeadController::class, 'update'])->name('leads.update');
    Route::get('/leads/deletar/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
    Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');

    // Operações por planilhas do excel
    Route::get('/leads/planilha/upload', [SpreadsheetController::class, 'create'])->name('leads.spreadsheet.upload');
    Route::post('/leads/planilha/store', [SpreadsheetController::class, 'store'])->name('leads.spreadsheet.store');
    /* Leads */

    /* Finanças */
    Route::get('/financas', [AdminController::class, 'index'])->name('finances.index');

    /* Mensagens */
    Route::get('/mensagens-leads', [LeadController::class, 'leadsMessage'])->name('leads.message');
    Route::get('/enviar-mensagens', [MessageController::class, 'sendMessages'])->name('send.messages');
    /* Mensagens */

    /* Chat */
    Route::get('/chat/{lead}', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/store/{lead}', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/total-status', [ChatController::class, 'totalStatus'])->name('status.total');
    /* Chat */

    /* Finanças */

    /* Nichos */
    Route::get('/nichos', [NicheController::class, 'index'])->name('niches.index');
    Route::post('/nichos/search', [NicheController::class, 'search'])->name('niches.search');
    Route::get('/nichos/criar', [NicheController::class, 'create'])->name('niches.create');
    Route::post('/nichos/criar', [NicheController::class, 'store'])->name('niches.store');
    Route::get('/nichos/editar/{niche}', [NicheController::class, 'edit'])->name('niches.edit');
    Route::put('/nichos/editar/{niche}', [NicheController::class, 'update'])->name('niches.update');
    Route::get('/nichos/deletar/{niche}', [NicheController::class, 'destroy'])->name('niches.destroy');
    Route::get('/nichos/{niche}', [NicheController::class, 'show'])->name('niches.show');
    /* Nichos */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
