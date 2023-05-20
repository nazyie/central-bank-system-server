<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Member;
use App\Models\Role;
use App\Models\RoleActionMapper;
use App\Models\User;
use Illuminate\Http\Request;
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
        // $roles = Role::simplePaginate(10);
        $roles = DB::table('roles')
            ->selectRaw('roles.id, roles.name, roles.description, roles.created_by, roles.updated_by, roles.created_at, roles.updated_at, members.code')
            ->leftJoin('members', 'roles.member_id', 'members.id')
            ->simplePaginate(10);

        return view('role.index', [
            'roles' => $roles,
            'previousPageUrl' => $roles->previousPageUrl(),
            'nextPageUrl' => $roles->nextPageUrl(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $memberCodeList = Member::select('id', 'code')->get();
        $functions = Action::select('function')->distinct()->get();
        $actions = Action::get();

        return view('role.create-update-page', [
            'viewMode' => 'edit',
            'hasValue' => false,
            'memberCodeList' => $memberCodeList,
            'functions' => $functions,
            'actions' => $actions
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
        // TODO: Need to replace this with actual user id
        $request->request->add(['created_by' => 1, 'updated_by' => 1]);

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

        $roleId = Role::create($request->all());

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
        $memberCodeList = Member::select('id', 'code')->get();
        $functions = Action::select('function')->distinct()->get();
        $actions = DB::table('actions')
            ->leftJoin(DB::raw('(SELECT role_id, action_id FROM role_action_mappers WHERE role_id = '.$id.') AS role_action_mappers'), 'role_action_mappers.action_id', 'actions.id')
            ->get();

        return view('role.create-update-page', [
            'viewMode' => 'view',
            'hasValue' => true,
            'role' => $role,
            'memberCodeList' => $memberCodeList,
            'functions' => $functions,
            'actions' => $actions
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
        $memberCodeList = Member::select('id', 'code')->get();
        $functions = Action::select('function')->distinct()->get();
        $actions = DB::table('actions')
            ->leftJoin(DB::raw('(SELECT role_id, action_id FROM role_action_mappers WHERE role_id = '.$id.') AS role_action_mappers'), 'role_action_mappers.action_id', 'actions.id')
            ->get();

        return view('role.create-update-page', [
            'viewMode' => 'edit',
            'hasValue' => true,
            'role' => $role,
            'memberCodeList' => $memberCodeList,
            'functions' => $functions,
            'actions' => $actions
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
        // TODO: Need to replace this with actual user id
        $request->request->add(['created_by' => 1, 'updated_by' => 1]);

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

        $role = Role::findOrFail($id);

        $role->update($request->all());

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
        Session::flash('successAlert', 'The record has successfully deleted');
        $role->delete();
        RoleActionMapper::where('role_id', $id)->delete();
        return redirect()->back();
    }
}
