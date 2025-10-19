<?php

namespace App\Services\Calendar;

use App\Models\User;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CalendarService
{

    private string $apiBase = 'https://www.googleapis.com/calendar/v3/';

    public function saveTokens(User $user, $socialUser): void
    {
        $user->update([
            'google_calendar_access_token' => $socialUser->token,
            'google_calendar_refresh_token' => $socialUser->refreshToken,
            'google_calendar_token_expires_at' => now()->addSeconds($socialUser->expiresIn)
        ]);
    }

    // private function getAccessToken(User $user) {
    //     if(!$user->google_calendar_access_token) {
    //         throw new UnauthorizedHttpException('', 'Google Calendar not connected');
    //     }

    //     if ($user->google_calendar_token_expires_at->isPast()) {
    //         $this->refreshToken($user);
    //     }

    //     return $user->google_calendar_access_token;
    // }
}