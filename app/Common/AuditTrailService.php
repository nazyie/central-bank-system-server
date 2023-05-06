<?php

namespace App\Common;

use App\Models\AuditTrail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AuditTrailService {

    /**
     * Store the record in the audit trail table when any action being create on the record
     */
    public static function create(string $domain, string $action, $prevRecord, array | null $currentRecord, int $changedBy) {
        $payload = [
            'domain' => Str::upper($domain),
            'action' => $action,
            'prev_record' => $prevRecord ? $prevRecord->toJson() : null,
            'current_record' => $currentRecord ? json_encode($currentRecord) : null, // getOriginal() will retrieve the payload as array of value
            'created_by' => $changedBy,
            'created_at' => Carbon::now()
        ];

        AuditTrail::storeObject($payload);
    }
}
