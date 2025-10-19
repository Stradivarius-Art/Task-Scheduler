<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\JsonResponse login(array $data)
 * @method static \Illuminate\Http\JsonResponse register(array $data)
 * @method static \Illuminate\Http\JsonResponse removeRefreshTokenResponse()
 * @method static \Illuminate\Http\JsonResponse getNewTokens(string $refreshToken)
 * @method static \Illuminate\Http\JsonResponse handleOauthCallback($socialUser, string $provider)
 * @see \App\Services\Auth\AuthService
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'auth.facade';
    }
}
