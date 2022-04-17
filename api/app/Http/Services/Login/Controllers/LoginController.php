<?php

namespace App\Http\Services\Login\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Services\Login\Services\LoginServiceInterface;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(LoginServiceInterface $service)
    {
        try {
            $statusCode = parent::$statusCodeOk;
            $response = $service->login();
        } catch (ValidationException $e) {
            $statusCode = parent::$statusCodeUnprocessableEntity;
            $response   = $e->errors();
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $response   = $e->getMessage();
        }

        return response()->json($this->buildJsonResponse($response, $statusCode), $statusCode);
    }
}
