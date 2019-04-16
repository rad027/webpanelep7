<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\RanUser\UserInfo4;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->roles()->first()->slug === 'unverified'){
            return redirect('activate');
        }else{
            if(Auth::user()->isAdmin()){
                return view('pages.admin.home');
            }else{
                if(Auth::user()->UserInfo4()->first()->Activation == 0){
                    return redirect('user/password')->with('error','You must change your password first to fully secure your account from recent attacks that we have been through.');
                }
                return view('pages.user.home');
            }
        }
    }
}
