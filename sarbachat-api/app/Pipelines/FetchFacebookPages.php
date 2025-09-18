<?php

declare(strict_types=1);

namespace App\Pipelines;

use Closure;
use stdClass;
use Illuminate\Support\Facades\Http;

final class FetchFacebookPages
{
    private $url;

    public function __construct()
    {
        $this->url = config('urls.facebook,base_path');
    }

    public function __invoke(object $user, Closure $next)
    {
        $response = Http::timeout(30)->withQueryParameters(['access_token' => $user->token])->get("{$this->url}/me/accounts");

        $pages = $response->json('data', []);

        if (empty($pages)) {
            logger()->warning('No pages found for social user', ['user_id' => $user->id]);

            return null;
        }

        $data = new stdClass();
        $data->pages = $pages;
        $data->user_medium = $user->medium;
        $data->user_id = $user->id;
        $data->url = $this->url;

        return $next($data);
    }
}
