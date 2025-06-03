<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class NotificationService
{
    public function processStore($request): JsonResponse
    {
        $notification = Notification::create($request);

        Redis::publish('notifications', json_encode($notification));

        return response()->json(['message' => 'Notification queued', 'data' => $notification]);
    }

    public function processRecent(): JsonResponse
    {
        return Notification::latest()->limit(10)->get();
    }

    public function processSummary(): JsonResponse
    {
        $total = Notification::count();
        $processed = Notification::where('processed', true)->count();

        return response()->json([
            'total' => $total,
            'processed' => $processed,
            'pending' => $total - $processed,
        ]);
    }
}
