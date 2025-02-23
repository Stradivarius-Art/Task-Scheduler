<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RefreshTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            try {
                $refreshToken = $request->cookie('refreshToken');
                if (!$refreshToken) {
                    throw new UnauthorizedHttpException('', 'Refresh token not found');
                }

                // Генерируем новый accessToken
                $newAccessToken = JWTAuth::setToken($refreshToken)->claims(['type' => 'access'])->refresh();

                // Обновляем заголовок запроса
                $request->headers->set('Authorization', 'Bearer ' . $newAccessToken);

                // Продолжаем запрос
                $response = $next($request);

                // Возвращаем новый accessToken в теле ответа
                $responseData = $response->getData(true); // Получаем данные ответа
                $responseData['newAccessToken'] = $newAccessToken;

                return response()->json($responseData);
            } catch (\Exception $e) {
                throw new UnauthorizedHttpException('', 'Unable to refresh token');
            }
        } catch (\Exception $e) {
            throw new UnauthorizedHttpException('', 'Invalid token');
        }

        return $next($request);
    }
}