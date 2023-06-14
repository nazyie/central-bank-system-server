<?php

namespace App\Http\Controllers;

use App\Common\AuditTrailService;
use App\Models\Action;
use App\Models\Member;
use App\Models\Role;
use App\Models\RoleActionMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WebRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = DB::table('roles')
            ->selectRaw('roles.id, roles.name, roles.description, roles.created_by, roles.updated_by, roles.created_at, roles.updated_at, members.code')
            ->leftJoin('members', 'roles.member_id', 'members.id')
            ->where('roles.member_id', Auth::user()->member_id)
            ->simplePaginate(10);

        if (Auth::user()->member_id == 1) {
            $roles = DB::table('roles')
                ->selectRaw('roles.id, roles.name, roles.description, roles.created_by, roles.updated_by, roles.created_at, roles.updated_at, members.code')
                ->leftJoin('members', 'roles.member_id', 'members.id')
                ->simplePaginate(10);
        }

        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();

        return view('role.index', [
            'roles' => $roles,
            'previousPageUrl' => $roles->previousPageUrl(),
            'nextPageUrl' => $roles->nextPageUrl(),
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
        $memberCodeList = Member::select('id', 'code')->where('id', Auth::user()->member_id)->get();
        $functions = Action::select('function')->whereNotIn('function', ['Audit Trail'])->distinct()->get();
        $actions = Action::whereNotIn('function', ['Audit Trail'])->get();

        if(Auth::user()->member_id == 1) {
            $memberCodeList = Member::select('id', 'code')->get();
            $functions = Action::select('function')->distinct()->get();
            $actions = Action::get();
        }

        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();

        return view('role.create-update-page', [
            'viewMode' => 'edit',
            'hasValue' => false,
            'memberCodeList' => $memberCodeList,
            'functions' => $functions,
            'actions' => $actions,
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get(),
            'userProfile' => $userProfileInfo
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $request->request->add(['created_by' => $userId, 'updated_by' => $userId]);

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'member_id' => 'required',
        ]);

        if ($request->member_id != Auth::user()->member_id) {
            abort(403);
        }

        if(!$validated) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $roleId = Role::create($request->all());

        AuditTrailService::create('Role', 'Create', json_encode($roleId), null, Auth::id(), Auth::user()->member_id);

        foreach($request->all() as $key => $value) {
            if($value == 'true') {
                RoleActionMapper::create(['role_id' => $roleId->id, 'action_id' => $key]);
            }
        }

        return redirect('/role');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        $memberCodeList = Member::select('id', 'code')->where('id', Auth::user()->member_id)->get();
        $functions = Action::select('function')->whereNotIn('function', ['Audit Trail'])->distinct()->get();
        $actions = DB::table('actions')
            ->leftJoin(DB::raw('(SELECT role_id, action_id FROM role_action_mappers WHERE role_id = '.$id.') AS role_action_mappers'), 'role_action_mappers.action_id', 'actions.id')
            ->whereNotIn('function', ['Audit Trail'])
            ->get();

        if(Auth::user()->member_id == 1) {
            $memberCodeList = Member::select('id', 'code')->get();
            $functions = Action::select('function')->distinct()->get();
            $actions = DB::table('actions')
                ->leftJoin(DB::raw('(SELECT role_id, action_id FROM role_action_mappers WHERE role_id = '.$id.') AS role_action_mappers'), 'role_action_mappers.action_id', 'actions.id')
                ->get();
        }

        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();

        return view('role.create-update-page', [
            'viewMode' => 'view',
            'hasValue' => true,
            'role' => $role,
            'memberCodeList' => $memberCodeList,
            'functions' => $functions,
            'actions' => $actions,
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get(),
            'userProfile' => $userProfileInfo
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
        $role = Role::findOrFail($id);
        $memberCodeList = Member::select('id', 'code')->where('id', Auth::user()->member_id)->get();
        $functions = Action::select('function')->whereNotIn('function', ['Audit Trail'])->distinct()->get();
        $actions = DB::table('actions')
            ->leftJoin(DB::raw('(SELECT role_id, action_id FROM role_action_mappers WHERE role_id = '.$id.') AS role_action_mappers'), 'role_action_mappers.action_id', 'actions.id')
            ->whereNotIn('function', ['Audit Trail'])
            ->get();

        if(Auth::user()->member_id == 1) {
            $memberCodeList = Member::select('id', 'code')->get();
            $functions = Action::select('function')->distinct()->get();
            $actions = DB::table('actions')
                ->leftJoin(DB::raw('(SELECT role_id, action_id FROM role_action_mappers WHERE role_id = '.$id.') AS role_action_mappers'), 'role_action_mappers.action_id', 'actions.id')
                ->get();
        }

        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();

        return view('role.create-update-page', [
            'viewMode' => 'edit',
            'hasValue' => true,
            'role' => $role,
            'memberCodeList' => $memberCodeList,
            'functions' => $functions,
            'actions' => $actions,
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get(),
            'userProfile' => $userProfileInfo
        ]);
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
        $userId = Auth::id();
        $request->request->add(['updated_by' => $userId]);

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'member_id' => 'required',
        ]);

        if(!$validated) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        if(Auth::user()->member_id != $request->member_id) {
            abort(403);
        }

        $role = Role::findOrFail($id);
        $prevRole = Role::findOrFail($id);

        $role->update($request->all());

        AuditTrailService::create('Role', 'Update', json_encode($prevRole), json_encode($role), Auth::id(), Auth::user()->member_id);

        RoleActionMapper::where('role_id', $role->id)->delete();

        foreach($request->all() as $key => $value) {
            if($value == 'true') {
                RoleActionMapper::create(['role_id' => $role->id, 'action_id' => $key]);
            }
        }

        Session::flash('successAlert', 'The record has successfully updated');

        return redirect('/role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if ($role->member_id !== Auth::user()->member_id) {
            abort(403);
        }
        Session::flash('successAlert', 'The record has successfully deleted');
        $role->delete();
        AuditTrailService::create('Role', 'Delete', json_encode($role), null, Auth::id(), Auth::user()->member_id);
        RoleActionMapper::where('role_id', $id)->delete();
        return redirect()->back();
    }
}
