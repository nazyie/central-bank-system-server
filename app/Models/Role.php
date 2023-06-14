<?php

namespace App\Models;

use App\Common\DynamicListingQueryParam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'member_id',
        'created_by',
        'updated_by'
    ];

    /**
     * Relationship and eager loaded
     */
    public function roleActionMapper() {
        return $this->hasMany(RoleActionMapper::class, 'role_id', 'id');
    }

    /**
     * Default static query
     */
    public static function getAllObject(Request $request) {
        $results = DynamicListingQueryParam::query('roles', $request);
        return $results;
    }

    public static function storeObject(array $payloadJson) : Role {
        $role = new Role();
        $role->fill($payloadJson);
        $role->save();

        // store object to roleActionMapper
        foreach($payloadJson['role_action_mapper'] as $key => $value) {
            $value['role_id'] = $role->id;
            RoleActionMapper::storeObject(['role_id' => $role->id, 'action_id' => $value['action_id']] );
        }

        return Role::findObject($role->id);
    }

    public static function updateObject(array $payloadJson, Role $role) : Role {
        $role->fill($payloadJson);
        $role->update();

        // update or create the roleActionMapper
        foreach($payloadJson['role_action_mapper'] as $key => $value) {
            $value['role_id'] = $role->id;
            RoleActionMapper::updateOrCreate(['id' => $value['id']], ['action_id' => $value['action_id'], 'role_id' => $value['role_id']]);
        }

        return Role::findObject($role->id);
    }

    public static function deleteObject(Role $role) : Role {
        $role->delete();
        return $role;
    }

    public static function findObject(string $id) {
        $role = Role::findOrFail($id);
        $role->roleActionMapper;
        return $role;
    }

}
