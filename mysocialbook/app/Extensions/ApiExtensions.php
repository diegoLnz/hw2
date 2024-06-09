<?php

namespace App\Extensions;

use App\Extensions\Models\ApiResult;

class ApiExtensions
{
    public static function setResponse(string $message, string $error, int $code): ApiResult
    {
        $response = new ApiResult(["message" => $message], [$error]);
        http_response_code($code);
        return $response;
    }
}