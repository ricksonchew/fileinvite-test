<?php

namespace App\Http\Services\Registration\Requests;

class RegistrationRequest
{
    public function ruleRegistration()
    {
        return [
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:6|confirmed',
        ];
    }
}
