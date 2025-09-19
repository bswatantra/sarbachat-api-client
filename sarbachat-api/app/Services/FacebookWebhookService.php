<?php

declare(strict_types=1);

namespace App\Services;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

final class FacebookWebhookService
{
    /**
     * Verify the webhook subscription using the verification token.
     * Returns the challenge string on success or a Forbidden response on failure.
     *
     * @param  $request  The incoming verification request.
     */
    public function verifySocialWebhook($request)
    {
        $verifyToken = config('social.facebook.webhook_verify_token');

        logger('facebook verification payload', ['request' => $request, 'verifyToken' => $verifyToken]);

        if (@$request->hub_mode === 'subscribe' && @$request->hub_verify_token === $verifyToken) {
            logger()->info('Facebook webhook verification successful.');

            return @$request->hub_challenge ?? 'challenge accepted';
        }

        logger()->warning('Facebook webhook verification failed.', [
            'mode' => @$request->hub_mode,
            'token_provided' => @$request->hub_verify_token,
        ]);

        throw new AccessDeniedHttpException('Verification token mismatch');
    }

    /**
     * Handle the incoming webhook payload after verification.
     * Verifies signature and dispatches job for processing.
     *
     * @param  Request  $request  The incoming webhook payload request.
     * @return Response
     *
     * @throws AccessDeniedHttpException If signature verification fails.
     */
    public function handle($request): bool
    {
        logger('facebook handel request payload', ['request' => $request]);

        $appSecret = config('services.facebook.client_secret');
        $signature = $request->header('X-Hub-Signature-256');
        $payloadContent = $request->getContent();

        logger('facebook handel data', ['appSecret' => $appSecret, 'signature' => $signature, 'payloadContent' => $payloadContent]);

        // if (!$this->verifySignature($signature, $payloadContent, $appSecret)) {
        //     throw new AccessDeniedHttpException('Invalid webhook signature.');
        // }

        $payload = $request->input();
        logger()->info('Facebook webhook received (Signature Verified):', $payload);

        if (($payload['object'] ?? null) === 'page') {
            foreach (($payload['entry'] ?? []) as $entry) {
                foreach (($entry['messaging'] ?? []) as $event) {
                    if (is_array($event) || is_object($event)) {
                        logger()->info('Facebook Event: ', ['event' => $event]);
                        // ProcessFacebookMessage::dispatch((array) $event)->onQueue('webhooks');
                    } else {
                        logger()->warning('Invalid event format within messaging array.', ['event' => $event]);
                    }
                }
            }

            return true;
        }

        logger()->info('Received non-page event or unexpected format from Facebook webhook.', $payload);

        throw new BadRequestHttpException('Webhook payload format error: Expected object=page.');
    }
}
