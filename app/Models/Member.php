<?php

namespace App\Models;

use App\Common\AuditTrailService;
use App\Common\DynamicListingQueryParam;
use App\Common\LoggerService;
use App\Constant\ActionConstant;
use App\Constant\StatusCodeConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Member extends Model 
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
        'member_type',
        'created_by',
        'updated_by'
    ];

    public static function getAllObject(Request $request) {
        $results = DynamicListingQueryParam::query('members', $request);

        LoggerService::create('MEMBER', 1, ActionConstant::GET, StatusCodeConstant::OK, null, 'OK');

        return $results;
    }

    public static function storeObject(array $payloadJson) : Member {
        $member = new Member();
        $member->fill($payloadJson);
        $member->save();

        LoggerService::create('MEMBER', 1, ActionConstant::CREATE, StatusCodeConstant::CREATED, $member->id, 'CREATED');
        AuditTrailService::create('MEMBER', ActionConstant::CREATE, $member, null, 1);

        return $member;
    }

    public static function updateObject(array $payloadJson, Member $member) : Member {
        $member->fill($payloadJson);
        $member->update();

        LoggerService::create('MEMBER', 1, ActionConstant::UPDATE, StatusCodeConstant::CREATED, $member->id, 'CREATED');
        AuditTrailService::create('MEMBER', ActionConstant::UPDATE, $member, $member->getOriginal() , 1);

        return $member;
    }

    public static function deleteObject(Member $member) : Member {
        $member->delete();

        LoggerService::create('MEMBER', 1, ActionConstant::DELETE, StatusCodeConstant::OK, $member->id, 'OK');
        AuditTrailService::create('MEMBER', ActionConstant::DELETE, $member, null, 1);

        return $member;
    }

    public static function findObject(string $id) : Member {
        $member = Member::findOrFail($id);

        LoggerService::create('MEMBER', 1, ActionConstant::GET, StatusCodeConstant::OK, $member->id, 'OK');

        return $member;
    }
}
