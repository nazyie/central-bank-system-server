<?php

namespace App\Common;

use App\Models\Logger;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LoggerService {

    public static function create(string $domain, int $createdBy, string $action, string $statusCode, string | null $recordId, string $description) {
        $payload = [
            'domain' => Str::upper($domain),
            'action' => $action,
            'status_code' => $statusCode,
            'record_id' => $recordId,
            'description' => $description,
            'created_by' => $createdBy,
            'created_at' => Carbon::now(),
        ];

        Logger::storeObject($payload);
    }

}