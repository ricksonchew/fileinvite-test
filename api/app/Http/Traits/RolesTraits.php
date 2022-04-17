<?php

namespace App\Http\Traits;

trait RolesTraits
{
    static $roleSuperAdmin = 'super-admin';
    static $roleAdmin      = 'admin';
    static $roleGuest      = 'guest';
    static $roleMember     = 'member';

    public function isSuperAdmin()
    {
        return auth()->user()->hasRole(self::$roleSuperAdmin);
    }
}
