<?php

namespace App\Models;

use App\Common\DynamicListingQueryParam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Logger extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'domain',
        'action',
        'status_code',
        'description',
        'created_by',
        'created_at',
    ];

    public static function getAllObject(Request $request) {
        $results = DynamicListingQueryParam::query('loggers', $request);
        return $results;
    }

    public static function storeObject(array $payloadJson) : Logger {
        $logger = new Logger();
        $logger->fill($payloadJson);
        $logger->save();
        return $logger;
    }

}
