<?php

namespace App\Http\Controllers;

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

        return view('member.index', [
            'members' => $members,
            'previousPageUrl' => $members->previousPageUrl(),
            'nextPageUrl' => $members->nextPageUrl(),
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
        return view('member.create-update-page', [
            'viewMode' => 'edit',
            'hasValue' => false,
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

        Member::create($request->all());

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

        return view('member.create-update-page', [
            'viewMode' => 'view',
            'hasValue' => true,
            'member' => $member,
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
        $member = Member::findOrFail($id);

        return view('member.create-update-page', [
            'viewMode' => 'edit',
            'hasValue' => true,
            'member' => $member,
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

        $member->update($request->all());

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
        $member->delete();
        return redirect()->back();
    }
}
