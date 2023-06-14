<?php

namespace App\Models;

use App\Common\DynamicListingQueryParam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Action extends Model
{
    use HasFactory;

    public $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'function'
    ];

    public static function getAllObject(Request $request) {
        $results = DynamicListingQueryParam::query('actions', $request);
        return $results;
    }

    public static function storeObject(array $payloadJson) : Action {
        $action = new Action();
        $action->fill($payloadJson);
        $action->save();
        return $action;
    }

    public static function updateObject(array $payloadJson, Action $action) : Action {
        $action->fill($payloadJson);
        $action->update();
        return $action;
    }

    public static function deleteObject(Action $action) : Action {
        $action->delete();
        return $action;
    }

    public static function findObject(string $id) : Action {
        $action = Action::findOrFail($id);
        return $action;
    }
}