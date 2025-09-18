<?php

declare(strict_types=1);

namespace App\Pipelines;

use Closure;
use App\Models\SocialUserPage;

final readonly class SyncFacebookPages
{
    public function __construct(
        private SocialUserPage $socialUserPage
    ) {}

    public function __invoke(object $payload, Closure $next)
    {
        $userPages = collect($payload->pages)->map(fn ($page) => $this->socialUserPage->updateOrCreate(
            [
                'social_user_id' => $payload->user_id,
                'page_id' => $page['id'],
            ],
            [
                'name' => $page['name'],
                'access_token' => $page['access_token'],
                'category' => $page['category'] ?? null,
                'medium' => $payload->user_medium,
            ]
        ));

        return $next($userPages);
    }
}
