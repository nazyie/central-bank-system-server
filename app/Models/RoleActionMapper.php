<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleActionMapper extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'action_id',
    ];
    public $timestamps = false;

    public static function storeObject(array $payloadJson) : RoleActionMapper {
        $roleActionMapper = new RoleActionMapper();
        $roleActionMapper->fill($payloadJson);
        $roleActionMapper->save();
        return $roleActionMapper;
    }
}
