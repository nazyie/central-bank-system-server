<?php

namespace App\Http\Controllers;

use App\Common\ErrorResponseService;
use App\Http\Requests\SignInRequest;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class WebSecurityController extends Controller
{
    /**
     * Authenticate the user by using the membercode, username and password
     *
     * @param memberCode
     * @param username
     * @param password
     *
     */
    public function signIn(SignInRequest $request) {
        $member = Member::where('code', $request->memberCode)->first();

        if (!$member) {
            return ErrorResponseService::invalidCredential();
        }

        $user = User::where('username', $request->username)
            ->where('member_id', $member->id)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ErrorResponseService::invalidCredential();
        }

        // clear the existing access token
        PersonalAccessToken::where('name', $user->id)->delete();

        // reload the ability from the action
        // TODO: need to reload the ability from action
        $abilities = ['create-user'];

        // invoke the token generation thru email
        if (env('ENABLE_OTP', false)) {
            // TODO: need to invoke the OTP
        } else {
            $token = $user->createToken($user->id, $abilities)->plainTextToken;
            return $token;
        }
    }

    /**
     * Verify the OTP after the user sign in into the web
     *
     */
    public function verify() {
        //
    }
}
