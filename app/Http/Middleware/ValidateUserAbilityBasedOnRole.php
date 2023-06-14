<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ValidateUserAbilityBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $ability)
    {

        $roleId = Auth::user()->role_id;

        // check for value with condition where roleId and ability from user
        $result = DB::table('roles')
                    ->selectRaw('roles.id')
                    ->leftJoin('role_action_mappers', 'role_action_mappers.role_id', 'roles.id')
                    ->where('roles.id', $roleId)
                    ->where('role_action_mappers.action_id', $ability)
                    ->count();

        if ($result == 0) {
            // TODO: need to update this
            dd("unathorized page");
        }

        return $next($request);
    }
}
