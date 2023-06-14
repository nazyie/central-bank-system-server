<?php

namespace App\Models;

use App\Common\DynamicListingQueryParam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuditTrail extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'domain',
        'action',
        'prev_record',
        'current_record',
        'created_by',
        'created_at',
        'member_id',
    ];

    public static function getAllObject(Request $request) {
        $results = DynamicListingQueryParam::query('audit_trails', $request);
        return $results;
    }

    public static function storeObject(array $payloadJson) : AuditTrail {
        $auditTrail = new AuditTrail();
        $auditTrail->fill($payloadJson);
        $auditTrail->save();
        return $auditTrail;
    }

}
