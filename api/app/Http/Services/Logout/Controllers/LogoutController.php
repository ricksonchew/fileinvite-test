<?php

namespace App\Http\Services\Logout\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Services\Logout\Services\LogoutServiceInterface;

class LogoutController extends Controller
{
    public function logout(LogoutServiceInterface $service)
    {
        try {
            $statusCode = parent::$statusCodeOk;
            $service->logout();
            $response = helperCustomMessages('sysMsgApiLogoutSuccess');
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $response   = $e->getMessage();
        }

        return response()->json($this->buildJsonResponse($response, $statusCode), $statusCode);
    }
}
