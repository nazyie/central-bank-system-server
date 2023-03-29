<?php

namespace App\Common;

use App\Models\Logger;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LoggerService {

    public static function create(string $domain, string $createdBy, string $action, string $statusCode, string $description) {
        $payload = [
            'domain' => Str::upper($domain),
            'action' => $action,
            'status_code' => $statusCode,
            'description' => $description,
            'created_by' => $createdBy,
            'created_at' => Carbon::now(),
        ];

        Logger::storeObject($payload);
    }

}