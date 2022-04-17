<?php

namespace App\Http\Services\Login\Requests;

class LoginRequest
{
    public function ruleLogin()
    {
        return [
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ];
    }
}
