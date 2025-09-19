<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Social;

use Throwable;
use App\Services\SocialService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

final class SocialAuthController extends Controller
{
    protected $client_base_url;

    public function __construct(
        private readonly SocialService $service
    ) {
        $this->client_base_url = config('urls.frontend.base_url');
    }

    public function redirect(string $provider): RedirectResponse
    {
        try {
            return $this->service->redirect($provider);
        } catch (Throwable) {
            return redirect('http:/localhost:300/social-media-manager');
        }
    }

    public function authenticateProvideCallback(string $provider): RedirectResponse
    {
        try {
            $social = $this->service->authenticateProvideCallback($provider);
            logger(__METHOD__.' authenticate provide callback response', ['social' => $social]);

            return redirect($this->client_base_url.'/social-media-manager');
        } catch (Throwable $throwable) {
            logger()->error(__METHOD__, ['error' => $throwable->getMessage()]);

            return redirect($this->client_base_url.'/social-media-manager');
        }
    }
}
