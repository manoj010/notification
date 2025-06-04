<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Throwable;


class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService) {}

    public function store(NotificationRequest $request)
    {
        try {
            return $this->notificationService->processStore($request);
        } catch (Throwable $th) {
            $this->logException($th);

            return response()->json('Internal server error', 500);
        }
    }

    public function recent()
    {
        return $this->notificationService->processRecent();
    }

    public function summary()
    {
        return $this->notificationService->processSummary();
    }
}
