<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Common\DynamicListingQueryParam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_id',
        'role_id',
        'username',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function getAllObject(Request $request) {
        $results = DynamicListingQueryParam::query('users', $request);
        return $results;
    }

    public static function storeObject(array $payloadJson) : User {
        $user = new User();
        $user->fill($payloadJson);
        $hashPassword = Hash::make($user->password);
        $user->password = $hashPassword;
        $user->save();
        return $user;
    }

    public static function updateObject(array $payloadJson, User $user, bool $isUpdatingPassword) : User {
        $user->fill($payloadJson);

        if ($isUpdatingPassword) {
            $hashPassword = Hash::make($user->password);
            $user->password = $hashPassword;
        } else {
            if ($user->isDirty('password')) {
                $user->password = $user->getOriginal('password');
            }
        }

        $user->update();
        return $user;
    }

    public static function deleteObject(User $user) : User {
        $user->delete();
        return $user;
    }

    public static function findObject(string $id) : User {
        $user = User::findOrFail($id);
        return $user;
    }
}
