<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseFormattable
{
    protected function dataResponse(mixed $data = null, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $code);
    }

    protected function successResponse(?string $message, mixed $data = null, ?int $code = Response::HTTP_OK): JsonResponse
    {
        $body = [
            'message' => $message,
        ];
        if (! empty($data)) {
            $body['data'] = $data;
        }

        return response()->json($body, $code);
    }

    protected function errorResponse(?string $message, int $code = Response::HTTP_INTERNAL_SERVER_ERROR, ?string $error = null): JsonResponse
    {
        $body = [
            'message' => $message,
        ];
        if ($error !== null && $error !== '' && $error !== '0') {
            $body['errors'] = $error;
        }

        return response()->json($body, $code);
    }
}
