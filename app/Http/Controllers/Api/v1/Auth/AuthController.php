<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Auth;

use App\Facades\Auth;
use App\Data\Auth\AuthData;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Auth API",
 *     version="1.0.0",
 *     description="API for user authentication and registration"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AuthData")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="accessToken", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *             @OA\Property(property="refreshToken", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */
    public function register(AuthData $data): JsonResponse
    {
        return Auth::register($data->toArray());
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     summary="Authenticate user and return tokens",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AuthData")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User authenticated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="accessToken", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *             @OA\Property(property="refreshToken", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */
    public function login(AuthData $data): JsonResponse
    {
        return Auth::login($data->toArray());
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login/access-token",
     *     summary="Refresh access token using refresh token",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Tokens refreshed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="accessToken", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *             @OA\Property(property="refreshToken", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid refresh token")
     *         )
     *     )
     * )
     */
    public function getNewTokens(): JsonResponse
    {
        $refreshToken = request()->cookie('refreshToken');

        if (!$refreshToken) {
            Auth::removeRefreshTokenResponse();
            throw new UnauthorizedHttpException('', 'Invalid password');
        }

        return Auth::getNewTokens($refreshToken);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     summary="Logout user and invalidate tokens",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="User logged out successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function logout(): JsonResponse
    {
        return Auth::removeRefreshTokenResponse();
    }

    public function redirectToYandex(): JsonResponse
    {
        $redirectUrl = Socialite::driver('yandex')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return \response()->json([
            'redirect_url' => $redirectUrl
        ]);
    }

    public function handleYandexCallback(): JsonResponse
    {
        try {
            $socialUser = Socialite::driver('yandex')
                ->stateless()
                ->user();
            return Auth::handleOauthCallback($socialUser, 'yandex');
        } catch (\Exception $e) {
            throw new UnauthorizedHttpException('', 'OAuth failed: ' . $e->getMessage());
        }
    }

    public function redirectToGoogle(): JsonResponse
    {
        $redirectUrl = Socialite::driver('google')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return \response()->json([
            'redirect_url' => $redirectUrl
        ]);
    }

    public function handleGoogleCallback(): JsonResponse
    {
        try {
            $socialUser = Socialite::driver('google')
                ->stateless()
                ->user();
            return Auth::handleOauthCallback($socialUser, 'google');
        } catch (\Exception $e) {
            throw new UnauthorizedHttpException('', 'OAuth failed: ' . $e->getMessage());
        }
    }
}