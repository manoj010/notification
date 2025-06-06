<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class NotificationService
{
    public function __construct(
        protected Notification $notification
    ) {}

    public function processStore($request)
    {
        $validatedData = $request->validated();

        $validatedData['processed'] = false;

        $notification = Notification::create($validatedData);

        Redis::publish('notifications', json_encode($notification));

        return $notification;
    }

    public function processRecent()
    {
        return Notification::latest()->limit(10)->get();
    }

    public function processSummary(): array
    {
        $total = Notification::count();
        $processed = Notification::where('processed', true)->count();

        return [
            'total' => $total,
            'processed' => $processed,
            'pending' => $total - $processed,
        ];
    }

    public function processUpdate(int $id): JsonResponse
    {
        $updated = Notification::where('id', $id)->update(['processed' => true]);

        if ($updated) {
            return response()->json(['status' => 'updated']);
        } else {
            return response()->json(['status' => 'not found or already processed'], 404);
        }
    }
}
