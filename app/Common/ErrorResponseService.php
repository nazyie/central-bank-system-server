<?php

namespace App\Common;

use App\Constant\ActionConstant;
use App\Constant\StatusCodeConstant;
use Illuminate\Database\Console\Migrations\StatusCommand;

class ErrorResponseService {

    /**
     * Main response method for the user
     */
    public static function responseMessage(int $errorCode, string $errorMessage) {
        return response([
            'msg' => $errorMessage
        ], $errorCode);
    }

    public static function errorPermission() {
        LoggerService::create('SECURITY', 0, ActionConstant::AUTHENTICATE, StatusCodeConstant::UNAUTHORIZED, null, "Unathorized Access");
        return ErrorResponseService::responseMessage(StatusCodeConstant::UNAUTHORIZED, "Unauthorized access");
    }

    public static function errorInternalServer() {
        LoggerService::create('SERVER', 0, ActionConstant::PROCESS, StatusCodeConstant::INTERNAL_SERVER_ERROR, null, "Internal Server Error");
        return ErrorResponseService::responseMessage(StatusCodeConstant::INTERNAL_SERVER_ERROR, "Internal Server Error");
    }

    public static function invalidCredential() {
        LoggerService::create("SECURITY", 0, ActionConstant::AUTHENTICATE, StatusCodeConstant::BAD_REQUEST, null, "Invalid Credential");
        return ErrorResponseService::responseMessage(StatusCodeConstant::BAD_REQUEST, "Invalid Credential");
    }

}