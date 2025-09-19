<?php

declare(strict_types=1);

namespace App\Pipelines;

use Illuminate\Support\Facades\Http;

final class SubscribePage
{
    public function __invoke(object $data): void
    {

        $fields = config('social.facebook.subscribed_fields', 'messages,messaging_postbacks');

        collect($data->pages)->map(function ($page) use ($fields, $data): void {

            $response = Http::post($data->url, [
                'subscribed_fields' => $fields,
                'access_token' => $page->access_token,
            ]);

            if (! $response->successful()) {
                logger()->error('Failed to subscribe page', [
                    'page_id' => $page->page_id,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
            }
        });
    }
}
