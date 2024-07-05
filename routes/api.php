<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/receber-mensagens', [MessageController::class, 'receiveMessages'])->name('receive.messages');
Route::post('/status-mensagens', [MessageController::class, 'statusMessages'])->name('status.messages');
