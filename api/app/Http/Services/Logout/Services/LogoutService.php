<?php

namespace App\Http\Services\Logout\Services;

use App\Http\Services\Logout\Services\LogoutServiceInterface;

class LogoutService implements LogoutServiceInterface
{
    public function logout()
    {
        $token = auth()->user()->token();
        $token->revoke();
    }
}
