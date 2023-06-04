<?php

namespace App\Http\Controllers;

use App\Common\AuditTrailService;
use App\Models\Member;
use App\Models\RoleActionMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WebMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware(['validate.ability:create-member'])->only('create', 'store');
        $this->middleware(['validate.ability:update-member'])->only('edit', 'update');
        $this->middleware(['validate.ability:view-member'])->only('index', 'show');
        $this->middleware(['validate.ability:delete-member'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::simplePaginate(10);

        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();

        return view('member.index', [
            'members' => $members,
            'previousPageUrl' => $members->previousPageUrl(),
            'nextPageUrl' => $members->nextPageUrl(),
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
        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();

        return view('member.create-update-page', [
            'viewMode' => 'edit',
            'hasValue' => false,
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
            'code' => 'required',
            'description' => 'required',
            'status' => 'required',
            'member_type' => 'required'
        ]);

        if(!$validated) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $member = Member::create($request->all());

        AuditTrailService::create('Member', 'Create', json_encode($member), null, Auth::id(), Auth::user()->member_id);

        return redirect('/member');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Member::findOrFail($id);

        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();

        return view('member.create-update-page', [
            'viewMode' => 'view',
            'hasValue' => true,
            'member' => $member,
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
        $member = Member::findOrFail($id);

        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();

        return view('member.create-update-page', [
            'viewMode' => 'edit',
            'hasValue' => true,
            'member' => $member,
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
            'code' => 'required',
            'description' => 'required',
            'status' => 'required',
            'member_type' => 'required',
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get()
        ]);

        if(!$validated) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $member = Member::findOrFail($id);
        $memberPrev = Member::findOrFail($id);

        $member->update($request->all());

        AuditTrailService::create('Member', 'Update', json_encode($memberPrev), json_encode($member), Auth::id(), Auth::user()->member_id);

        Session::flash('successAlert', 'The record has successfully updated');

        return redirect('/member');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        Session::flash('successAlert', 'The record has successfully deleted');
        AuditTrailService::create('Member', 'Delete', json_encode($member), null, Auth::id(), Auth::user()->member_id);
        $member->delete();
        return redirect()->back();
    }
}
