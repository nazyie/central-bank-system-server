<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\RoleActionMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebAuditTrailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['validate.ability:view-audit-trail'])->only('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auditTrail = DB::table('audit_trails')
            ->selectRaw('audit_trails.id, audit_trails.domain, audit_trails.action, members.code, users.name, audit_trails.created_at')
            ->leftJoin('members', 'members.id', 'audit_trails.member_id')
            ->leftJoin('users', 'users.id', 'audit_trails.created_by')
            ->simplePaginate(10);

        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();

        return view('audittrail.index', [
            'auditTrails' => $auditTrail,
            'previousPageUrl' => $auditTrail->previousPageUrl(),
            'nextPageUrl' => $auditTrail->nextPageUrl(),
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get(),
            'userProfile' => $userProfileInfo
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $auditTrail = DB::table('audit_trails')
            ->selectRaw('audit_trails.id, audit_trails.domain, audit_trails.prev_record, audit_trails.current_record, audit_trails.action, members.code, users.name, audit_trails.created_at')
            ->leftJoin('members', 'members.id', 'audit_trails.member_id')
            ->leftJoin('users', 'users.id', 'audit_trails.created_by')
            ->where('audit_trails.id', $id)
            ->first();
        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();

        if ($auditTrail == null)
            abort(404);

        $prevRecordArray = $auditTrail->prev_record ? json_decode($auditTrail->prev_record, true) : null;
        $currentRecordArray = $auditTrail->current_record ? json_decode($auditTrail->current_record, true) : null;

        return view('audittrail.detail-page', [
            'viewMode' => 'view',
            'hasValue' => true,
            'auditTrail' => $auditTrail,
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get(),
            'userProfile' => $userProfileInfo,
            'prevRecordArray' => $prevRecordArray,
            'currentRecordArray' => $currentRecordArray
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
