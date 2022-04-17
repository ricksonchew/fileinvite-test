<?php

namespace App\Http\Traits;

trait HttpStatusCodesTrait
{
    static $statusCodeOk           = 200;
    static $statusCodeBadRequest   = 400;
    static $statusCodeUnauthorized = 401;
    static $statusCodeForbidden    = 403;
    static $statusCodeNotFound     = 404;
    static $statusCodeUnprocessableEntity = 422;
    static $statusCodeInternalServerError = 500;
    static $statusCodeServiceUnavailable  = 503;
    static $statusGatewayTimeout          = 504;
}
