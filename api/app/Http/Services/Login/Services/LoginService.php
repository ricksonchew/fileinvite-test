<?php

namespace App\Http\Services\Login\Services;

use App\Http\Services\Login\Resources\LoginResource;
use Exception;
use App\Http\Services\Login\Requests\LoginRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Traits\HttpStatusCodesTrait;

class LoginService implements LoginServiceInterface
{
    use HttpStatusCodesTrait;

    public function login()
    {
        validator()->make(request()->all(), app(LoginRequest::class)->ruleLogin())->validate();

        if (!auth()->attempt(request()->only(['email', 'password']))) {
            throw new Exception(trans('auth.failed'), self::$statusCodeUnauthorized);
        }

        return new LoginResource(['access_token' => auth()->user()->createToken('authToken')->accessToken]);
    }
}

