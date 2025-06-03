<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Services\NotificationService;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService) {}

    public function store(NotificationRequest $request): JsonResponse
    {
        dd('tyest');
        try {
            return $this->notificationService->processStore($request->validated());
        } catch (\Throwable $th) {
            $this->logException($th);

            return response()->json('Internal server error', 500);
        }
    }

    public function recent(): JsonResponse
    {
        return $this->notificationService->processRecent();
    }

    public function summary(): JsonResponse
    {
        return $this->notificationService->processSummary();
    }
}
