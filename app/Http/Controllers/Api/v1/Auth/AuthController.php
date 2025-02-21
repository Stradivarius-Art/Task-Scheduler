<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Auth;

use App\Facades\Auth;
use App\Data\Auth\AuthData;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    public function register(AuthData $data): JsonResponse
    {
        return Auth::register($data->toArray());
    }

    public function login(AuthData $data): JsonResponse
    {
        return Auth::login($data->toArray());
    }

    public function getNewTokens(): JsonResponse
    {
        $refreshToken = request()->cookie('refreshToken');

        if (!$refreshToken) {
            Auth::removeRefreshTokenResponse();
            throw new UnauthorizedHttpException('', 'Invalid password');
        }

        return Auth::getNewTokens($refreshToken);
    }

    public function logout(): JsonResponse
    {
        return Auth::removeRefreshTokenResponse();
    }
}