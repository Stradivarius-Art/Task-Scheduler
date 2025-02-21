<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Facades\User;
use Illuminate\Http\JsonResponse;
use App\Models\User as ModelsUser;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{
    public function login(array $data): JsonResponse
    {
        $user = $this->validateUser($data);

        $tokens = $this->issueTokens($user);

        $userArray = $user->toArray();
        unset($userArray['password']);

        $cookie = cookie('refreshToken', $tokens['refreshToken'], 10080, null, 'localhost', true, true, sameSite: 'none');

        return response()->json([
            'user' => $userArray,
            'accessToken' => $tokens['accessToken'],
        ])->withCookie($cookie);
    }

    private function issueTokens(ModelsUser $user): array
    {
        // dd($user);
        JWTAuth::factory()->setTTL(15);
        $accessToken = JWTAuth::claims(['type' => 'access', 'sub' => $user->id])->fromUser($user);

        JWTAuth::factory()->setTTL(10080);
        $refreshToken = JWTAuth::claims(['type' => 'refresh', 'sub' => $user->id])->fromUser($user);

        return [
            'accessToken' => $accessToken,
            'refreshToken' => $refreshToken,
        ];
    }

    private function validateUser(array $data): ModelsUser
    {
        /**
         * @var ModelsUser $user
         */
        $user = User::getByEmail($data['email']);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $isValid = Hash::check($data['password'], $user->password);

        if (!$isValid) {
            throw new UnauthorizedHttpException('', 'Invalid password');
        }

        return $user;
    }

    public function removeRefreshTokenResponse(): JsonResponse
    {
        $cookie = cookie('refreshToken', '', 0, '/', 'localhost', true, true, false, 'none');
        return response()->json(['message' => 'Refresh token removed'])->withCookie($cookie);
    }

    public function getNewTokens(string $refreshToken): JsonResponse
    {
        try {
            $userVerify = JWTAuth::setToken($refreshToken)->authenticate();

            $payload = JWTAuth::getPayload();
            if ($payload->get('type') !== 'refresh') {
                return response()->json(['error' => 'Invalid token type'], 401);
            }

            /**
             * @var ModelsUser $user
             */
            $user = $userVerify;

            $tokens = $this->issueTokens($user);

            $userArray = $user->toArray();
            unset($userArray['password']);

            $cookie = cookie('refreshToken', $tokens['refreshToken'], 10080, null, 'localhost', true, true, sameSite: 'none');

            return response()->json([
                'user' => $userArray,
                'accessToken' => $tokens['accessToken'],
            ])->withCookie($cookie);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid refresh token'], 401);
        }
    }

    public function register(array $data): JsonResponse
    {
        /**
         * @var ModelsUser $user
         */
        $oldUser = User::getByEmail($data['email']);

        if ($oldUser) {
            throw new BadRequestException('User already exists');
        }

        /**
         * @var ModelsUser $user
         */
        $user = User::createUser($data);

        $tokens = $this->issueTokens($user);

        $userArray = $user->toArray();
        unset($userArray['password']);

        $cookie = cookie('refreshToken', $tokens['refreshToken'], 10080, null, 'localhost', true, true, sameSite: 'none');

        return response()->json([
            'user' => $userArray,
            'accessToken' => $tokens['accessToken'],
        ])->withCookie($cookie);
    }
}