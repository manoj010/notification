<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class Controller
{
    /**
     * Generate a successful response.
     *
     * @param mixed $data The data to include in the response.
     * @param string $message The message to include in the response (default: "Success").
     * @param int $code The HTTP status code to use (default: 200).
     */
    public function success(mixed $data, string $message = 'Success', int $code = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'status' => 'success',
            'code' => $code,
            'message' => $message,
        ];

        if ($data instanceof ResourceCollection) {
            $response['data'] = isset($data->response()->getData(true)['data']) ? $data->response()->getData(true)['data'] : false;
            $response['links'] = isset($data->response()->getData(true)['links']) ? $data->response()->getData(true)['links'] : false;
            $response['meta'] = isset($data->response()->getData(true)['meta']) ? $data->response()->getData(true)['meta'] : false;
        } else {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Generate an error response.
     *
     * @param string $message The message to include in the response (default: "Error").
     * @param int $code The HTTP status code to use (default: 400).
     * @param array $errors An optional array of error details.
     */
    public function error(string $message = 'Error', int $code = Response::HTTP_BAD_REQUEST, array $errors = []): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'code' => $code,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }

    /**
     * Log an exception with detailed information.
     *
     * @param \Throwable $exception The exception to log.
     */
    protected function logException(\Throwable $exception): void
    {
        Log::error('An exception occurred', [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
    }
}
