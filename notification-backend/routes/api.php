<?php

use App\Http\Controllers\Api\NotificationController;
use Illuminate\Support\Facades\Route;

Route::post('/notifications', [NotificationController::class, 'store']);
Route::get('/notifications/recent', [NotificationController::class, 'recent']);
Route::get('/notifications/summary', [NotificationController::class, 'summary']);
Route::post('/notifications/processed', [NotificationController::class, 'update']);


