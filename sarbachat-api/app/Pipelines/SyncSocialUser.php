<?php

declare(strict_types=1);

namespace App\Pipelines;

use Closure;
use App\Models\SocialUser;
use Illuminate\Support\Arr;

final readonly class SyncSocialUser
{
    public function __construct(
        private SocialUser $socialUser
    ) {}

    public function __invoke(object $data, Closure $next): object
    {
        $user = $this->socialUser->updateOrCreate(
            ['social_id' => $data->user->id],
            [
                'nickname' => $data->user->nickname ?? null,
                'name' => $data->user->name,
                'email' => $data->user->email,
                'medium' => $data->provider,
                'profile_url' => Arr::get($data->user->attributes, 'avatar_original', null),
                'token' => $data->user->token,
                'refresh_token' => $data->user->refreshToken ?? null,
                'expires_in' => $data->user?->expiresIn ? now()->addSeconds($data->user->expiresIn) : null,
            ]
        );

        return $next($user);
    }
}
