<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Throwable;


class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService) {}

    public function store(NotificationRequest $request): JsonResponse
    {
        try {
            $result = $this->notificationService->processStore($request);

            return $this->success(new NotificationResource($result), 'Message saved successfully');
        } catch (Throwable $th) {
            $this->logException($th);

            return response()->json('Internal server error', 500);
        }
    }

    public function recent(): JsonResponse
    {
        $recent = $this->notificationService->processRecent();

        return $this->success(NotificationResource::collection($recent), 'Recent Messages');
    }

    public function summary(): JsonResponse
    {
        $summary = $this->notificationService->processSummary();

        return $this->success(NotificationResource::collection($summary), 'Summary');
    }
}
