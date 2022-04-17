<?php

namespace App\Http\Services\Bookings\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Services\Bookings\Services\BookingsServiceInterface;
use Illuminate\Validation\ValidationException;

class BookingsController extends Controller
{
    public function list(BookingsServiceInterface $service)
    {
        try {
            $statusCode = parent::$statusCodeOk;
            $response = $service->list();
        } catch (ValidationException $e) {
            $statusCode = parent::$statusCodeUnprocessableEntity;
            $response   = $e->errors();
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $response   = $e->getMessage();
        }

        return response()->json($this->buildJsonResponse($response, $statusCode), $statusCode);
    }

    public function create(BookingsServiceInterface $service)
    {
        try {
            $statusCode = parent::$statusCodeOk;
            $response = $service->create();
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
