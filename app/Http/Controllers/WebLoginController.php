<?php

namespace App\Http\Controllers;

use App\Mail\SendOTPMail;
use App\Models\Member;
use App\Models\OtpToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class WebLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main.login-page');
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
     * Retrieve the OTP page
     */
    public function indexOtpPage()
    {
        return view('main.login-page');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /********************
         * THIS IS SECURITY CONTROLLER FOR OTP FLOW
         * ******************
         */
        if (env('ENABLE_OTP', false)) {
            $member = Member::where('code', $request->member_code)->first();

            if ($member != null) {
                $user = User::where('username', $request->username)->where('member_id', $member->id)->first();

                if ($user != null && Hash::check($request->password, $user->password)) {
                    // generate the email
                    $this->generateOtpEmail($user);

                    // return view page with parameter
                    return view('main.verify-otp', [
                        'username' => $request->username,
                        'password' => $request->password,
                        'member_id' => $member->id,
                        'user_id' => $user->id
                    ]);
                }
            }
        } else {
            /********************
             * THIS IS SECURITY CONTROLLER FOR NORMAL FLOW
             * ******************
             */
            $member = Member::where('code', $request->member_code)->first();

            if ($member != null) {
                if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'member_id' => $member->id])) {
                    $request->session()->regenerate();

                    return redirect('/dashboard');
                }
            }
        }

        Session::flash('errorAlert', 'Credentials is incorrect or not exists');
        return back()->withInput(['username', 'member_code']);
    }

    public function verify(Request $request) {
        $sendOtpMail = OtpToken::where('owner', $request->user_id)->where('otp_code', $request->otp)->orderBy('created_at')->first();

        if ($sendOtpMail != null) {

            if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'member_id' => $request->member_id])) {
                $request->session()->regenerate();

                return redirect('/dashboard');
            }

        }

        Session::flash('errorAlert', 'Incorrect OTP Code');
        return redirect('/sign-in');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('sign-in');
    }

    private function generateOtpEmail(User $user) {
        // generate token
        $otpCode = Str::upper(Str::random(10));

        // store token
        OtpToken::create(['owner' => $user->id, 'otp_code' => $otpCode, 'created_at' => Carbon::now()]);

        // send an email
        Mail::to($user->email)->send(new SendOTPMail($otpCode));
    }
}
