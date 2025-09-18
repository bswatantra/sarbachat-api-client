<?php

declare(strict_types=1);

namespace App\Pipelines;

use Illuminate\Support\Facades\Http;

final class SubscribePage
{
    public function __invoke(object $data): void
    {
        $fields = config('social.facebook.subscribed_fields', 'messages,messaging_postbacks');

        collect($data->userPages)->map(function ($userPage) use ($fields, $data): void {

            $response = Http::post($data->url, [
                'subscribed_fields' => $fields,
                'access_token' => $userPage->access_token,
            ]);

            if (! $response->successful()) {
                logger()->error('Failed to subscribe page', [
                    'page_id' => $userPage->page_id,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
            }
        });
    }
}
