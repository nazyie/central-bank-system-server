<?php

namespace App\Common;

use App\Models\AuditTrail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AuditTrailService {

    /**
     * Store the record in the audit trail table when any action being create on the record
     */
    public static function create(string $domain, string $action, $prevRecord, $currentRecord, int $changedBy) {
        $payload = [
            'domain' => Str::upper($domain),
            'action' => $action,
            'prev_record' => json_encode($prevRecord->toArray()),
            'current_record' => json_encode($currentRecord->toArray()),
            'created_by' => $changedBy,
            'created_at' => Carbon::now()
        ];

        AuditTrail::storeObject($payload);
    }
}
