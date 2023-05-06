<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpToken extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'owner',
        'otp_code',
        'created_at'
    ];

    public static function createObject(array $payload) : OtpToken {
        $otpToken = new OtpToken;
        $otpToken->fill($payload);
        return $otpToken;
    }

    public static function getObjectByOtpCode(string $otpCode) : OtpToken {
        $otpToken = OtpToken::where('otp_code', $otpCode)->first();
        return $otpToken;
    }
}
