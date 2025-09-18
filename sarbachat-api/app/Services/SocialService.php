<?php

declare(strict_types=1);

namespace App\Services;

use stdClass;
use App\Pipelines\SubscribePage;
use App\Pipelines\SyncSocialUser;
use App\Pipelines\SyncFacebookPages;
use App\Pipelines\FetchFacebookPages;
use Illuminate\Support\Facades\Pipeline;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class SocialService
{
    public function redirect(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)
            ->stateless()  // stateless API that does not utilize cookie based sessions:
            ->scopes(config("social.scopes.{$provider}"))
            ->redirect();
    }

    public function authenticateProvideCallback(string $provider): void
    {
        $socialiteUser = Socialite::driver($provider)
            ->stateless()  // stateless API that does not utilize cookie based sessions:
            ->user();

        logger()->info("{$provider} Data : ", [$socialiteUser]);

        $data = new stdClass();
        $data->user = $socialiteUser;
        $data->provider = $provider;

        Pipeline::send($data)
            ->through([
                SyncSocialUser::class,
                FetchFacebookPages::class,
                SyncFacebookPages::class,
                SubscribePage::class,
            ])
            ->thenReturn();
    }
}
