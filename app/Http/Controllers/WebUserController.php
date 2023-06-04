<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Role;
use App\Models\RoleActionMapper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class WebUserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['validate.ability:create-user'])->only('create', 'store');
        $this->middleware(['validate.ability:update-user'])->only('edit', 'update');
        $this->middleware(['validate.ability:view-user'])->only('index', 'show');
        $this->middleware(['validate.ability:delete-user'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::simplePaginate(10);
        $users = DB::table('users')
            ->selectRaw('users.id, users.name, users.email, members.code, roles.name as role_name, users.created_at, users.updated_at')
            ->leftJoin('members', 'members.id', 'users.member_id')
            ->leftJoin('roles', 'roles.id', 'users.role_id')
            ->simplePaginate(10);

        return view('user.index', [
            'users' => $users,
            'previousPageUrl' => $users->previousPageUrl(),
            'nextPageUrl' => $users->nextPageUrl(),
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('id', 'name')->get();
        $members = Member::select('id', 'name', 'code')->get();

        return view('user.create-update-page', [
            'viewMode' => 'edit',
            'hasValue' => false,
            'roles' => $roles,
            'members' => $members,
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get()
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
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role_id' => 'required',
            'member_id' => 'required'
        ]);

        $request['password'] = Hash::make($request->password);

        if(!$validated) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        User::create($request->all());

        return redirect('/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::select('id', 'name')->get();
        $members = Member::select('id', 'name', 'code')->get();

        return view('user.create-update-page', [
            'viewMode' => 'view',
            'hasValue' => true,
            'user' => $user,
            'roles' => $roles,
            'members' => $members,
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get()
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
        $user = User::findOrFail($id);
        $roles = Role::select('id', 'name')->get();
        $members = Member::select('id', 'name', 'code')->get();

        return view('user.create-update-page', [
            'viewMode' => 'edit',
            'hasValue' => true,
            'user' => $user,
            'roles' => $roles,
            'members' => $members,
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get()
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
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role_id' => 'required',
            'member_id' => 'required'
        ]);

        if(!$validated) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $user = User::findOrFail($id);

        $user->update($request->all());

        Session::flash('successAlert', 'The record has successfully updated');

        return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Session::flash('successAlert', 'The record has successfully deleted');
        $user->delete();
        return redirect()->back();
    }
}
