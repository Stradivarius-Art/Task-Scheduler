<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\User;

use App\Data\User\UserData;
use App\Facades\User as FacadesUser;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function profile(): array
    {
        return FacadesUser::getByProfile(auth()->id());
    }

    public function updateProfile(UserData $data): array
    {
        /**
         * @var User $user;
         */
        $user = auth()->user();
        return FacadesUser::setUser($user)->updateUser($data->toArray());
    }
}