<?php

use App\Http\Controllers\Api\NotificationController;
use App\Models\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/notifications', [NotificationController::class, 'store']);
Route::get('/notifications/recent', [NotificationController::class, 'recent']);
Route::get('/notifications/summary', [NotificationController::class, 'summary']);
Route::post('/notifications/processed', [NotificationController::class, 'update']);


