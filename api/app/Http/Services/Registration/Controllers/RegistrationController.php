<?php

namespace App\Http\Services\Registration\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Services\Registration\Services\RegistrationService;
use Illuminate\Validation\ValidationException;
use App\Exceptions\DatabaseException;

class RegistrationController extends Controller
{
    public function registration(RegistrationService $service)
    {
        try {
            $statusCode = parent::$statusCodeOk;
            $response = $service->registration();
        } catch (ValidationException $e) {
            $statusCode = parent::$statusCodeUnprocessableEntity;
            $response   = $e->errors();
        } catch (DatabaseException $e) {
            $statusCode = parent::$statusCodeInternalServerError;
            $response   = $e->getMessage();
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $response   = $e->getMessage();
        }

        return response()->json($this->buildJsonResponse($response, $statusCode), $statusCode);
    }
}
