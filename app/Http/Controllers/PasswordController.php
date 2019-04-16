<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;
use App\Rules\ValidatePassword;
use Illuminate\Support\Facades\Hash;
use App\Traits\CaptureIpTrait;
use Illuminate\Support\Facades\Session;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.user.setting.password');
    }

    public function ipaddress(){
        $ip = new CaptureIpTrait();
        return $ip->getClientIp();
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
        $valid = Validator::make($request->all(),[
            'old_password'          => ['required','min:6','max:19',new ValidatePassword(auth()->user())],
            'password'              => 'required|min:6|max:19|confirmed',
            'password_confirmation' => 'required|same:password',
        ],[
            'old_password.required' => 'The Current password is required.'
        ]);

        if ($valid->fails()) {
            return back()->withErrors($valid)->withInput();
        }
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);
        if($user->UserInfo4()->count()){
            $user->UserInfo4()->update([
                'UserPass' => strtoupper(substr(md5($request->input('password')),0,19)),
                'Activation' => 1
            ]);
        }
            Auth::user()->timeline()->create([
                'content'       =>  'Password was successfully updated.',
                'remark'        =>  'password',
                'ip_address'    => $this->ipaddress()
            ]);
        Session::forget('set_password');
        return back()->with('success','Password was successfully updated.');
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
