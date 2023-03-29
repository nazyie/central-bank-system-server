<?php

namespace App\Models;

use App\Common\DynamicListingQueryParam;
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
        return $results;
    }

    public static function storeObject(array $payloadJson) : Member {
        $member = new Member();
        $member->fill($payloadJson);
        $member->save();
        return $member;
    }

    public static function updateObject(array $payloadJson, Member $member) : Member {
        $member->fill($payloadJson);
        $member->update();
        return $member;
    }

    public static function deleteObject(Member $member) : Member {
        $member->delete();
        return $member;
    }

    public static function findObject(string $id) : Member {
        $member = Member::findOrFail($id);
        return $member;
    }
}
