<?php

namespace App\Common;

use App\Models\AuditTrail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AuditTrailService {

    /**
     * Store the record in the audit trail table when any action being create on the record
     */
    public static function create(string $domain, string $action, $prevRecord, $currentRecord, int $changedBy, int $memberId) {
        $payload = [
            'domain' => Str::upper($domain),
            'action' => $action,
            'prev_record' => $prevRecord,
            'current_record' => $currentRecord, // getOriginal() will retrieve the payload as array of value
            'created_by' => $changedBy,
            'member_id' => $memberId,
            'created_at' => Carbon::now()
        ];

        AuditTrail::storeObject($payload);
    }
}
