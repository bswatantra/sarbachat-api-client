<?php

declare(strict_types=1);

namespace App\Http\Controllers\Webhook;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseFormattable;
use App\Services\FacebookWebhookService;
use App\Http\Requests\VerifyFacebookWebhookRequest;

final class FacebookWebhookController extends Controller
{
    use ApiResponseFormattable;

    public function __construct(
        protected FacebookWebhookService $facebookWebhookService
    ) {}

    public function verify(VerifyFacebookWebhookRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $response = $this->facebookWebhookService->verifySocialWebhook(request: (object) $validated);

        return $this->successResponse(message: $response);
    }

    public function handle(VerifyFacebookWebhookRequest $request): JsonResponse
    {
        $request->validated();

        $response = $this->facebookWebhookService->handle(request: $request);

        return $this->successResponse(message: 'Facebook webhook received.', data: $response);
    }
}
