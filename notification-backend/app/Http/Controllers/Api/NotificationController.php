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

    public function store(NotificationRequest $request): JsonResponse
    {
        try {
            return $this->success($this->notificationService->processStore($request), 'Message saved successfully');
        } catch (Throwable $th) {
            $this->logException($th);

            return response()->json('Internal server error', 500);
        }
    }

    public function recent(): JsonResponse
    {
        return $this->success($this->notificationService->processRecent(), 'Recent Messages');
    }

    public function summary(): JsonResponse
    {
        return $this->success($this->notificationService->processSummary(), 'Summary');
    }
}
