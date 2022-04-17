<?php

namespace App\Http\Services\Registration\Services;

use App\Exceptions\DatabaseException;
use Exception;
use App\Http\Services\Registration\Resources\RegistrationResource;
use App\Http\Services\Registration\Services\RegistrationServiceInterface;
use App\Http\Services\Registration\Requests\RegistrationRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Traits\RolesTraits;

class RegistrationService implements RegistrationServiceInterface
{
    use RolesTraits;

    private $_request;

    public function __construct()
    {
        $this->_request = request();
    }

    public function registration()
    {
        validator()->make(request()->all(), app(RegistrationRequest::class)->ruleRegistration())->validate();

        try {
            DB::beginTransaction();
            $user = User::create([
                'email'    => $this->_request->email,
                'password' => bcrypt($this->_request->password),
                'first_name' => $this->_request->first_name,
                'last_name'  => $this->_request->last_name,
            ]);

            $user->assignRole((empty($this->_request->role_name)) ? self::$roleAdmin : $this->_request->role_name);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw new DatabaseException($e->getMessage());
        }

        return new RegistrationResource(['access_token' => $user->createToken('authToken')->accessToken]);
    }
}

