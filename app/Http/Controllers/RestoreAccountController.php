<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RanUser\UserInfo4;
use App\Models\User;
use App\Models\Profile;
use App\Models\Points;
use App\Traits\CaptchaTrait;
use App\Traits\CaptureIpTrait;
use App\Traits\ActivationTrait;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use Illuminate\Support\Facades\Session;

class RestoreAccountController extends Controller
{
    use CaptchaTrait;

    use ActivationTrait;

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function restore_view(){
        config()->set('adminlte.layout','top-nav');
        config()->set('adminlte.collapse_sidebar',false);
        if($this->count_restore() > 0 && Auth::guest()){
    		return view('pages.restore.index')->with('warning','Welcome to our new Panel.<br> As of now, we have an unrestored account that is currently count <b>'.$this->count_restore().'</b>. If you are one of them please click the link below to restore your current account. If you are a new user please <a href="'.URL("register").'">register</a> a new account. If your account is already restored, just login.<br><a href="'.URL("restore/account").'">'.URL("restore/account").'</a>');
        }else{
    		return view('pages.restore.index');
        }
    }

    private function count_restore(){
        $count = UserInfo4::count();
        foreach(User::all() as $user){
            if(UserInfo4::where(['UserName' => $user->name])->count()){
                $count = $count - 1;
            }else{
                $count = $count;
            }
        }
    	return $count;
    }

    public function restore_process(Request $req){

        $req['captcha'] = $this->captchaCheck();

        if (!config('settings.reCaptchStatus')) {
            $req['captcha'] = true;
        }
    	$valid = Validator::make($req->all(),
            [
                'name2'                  => 'required|max:19|unique:sqlsrv.users,name',
                'first_name'            => 'required',
                'last_name'             => 'required',
                'pin'                   => 'required',
                'secret_question'       => 'required',
                'secret_answer'         => 'required',
                'email'                 => 'required|email|max:255|unique:users',
                'password2'              => 'required|min:6|max:19',
                'g-recaptcha-response'  => '',
                'captcha'               => 'required|min:1',
            ],
            [
                'name2.unique'                   => 'This username was already restored. Please just login.',
                'name2.required'                 => trans('auth.userNameRequired'),
                'first_name.required'           => trans('auth.fNameRequired'),
                'last_name.required'            => trans('auth.lNameRequired'),
                'email.required'                => trans('auth.emailRequired'),
                'email.email'                   => trans('auth.emailInvalid'),
                'password2.required'             => trans('auth.passwordRequired'),
                'password2.min'                  => trans('auth.PasswordMin'),
                'password2.max'                  => trans('auth.PasswordMax'),
                'g-recaptcha-response.required' => trans('auth.captchaRequire'),
                'captcha.min'                   => trans('auth.CaptchaWrong'),
            ]
        );
        if ($valid->fails()) {
            return back()->withErrors($valid)->withInput();
        }
        if(UserInfo4::where(['UserName' => $req->input('name2')])->count() < 1){
        	$error = array(
        		'customMessages' => [
        			'password2' => 'This user is not qualified to restore. You may just register a new account.'
        		]
        	);
        	return back()->withErrors($error)->withInput();
        }
        $userinfo = UserInfo4::where(['UserName' => $req->input('name2')])->first();
        if($userinfo->UserPass !== strtoupper(substr(md5($req->input('password2')),0,19))){
        	$error = array(
        		'customMessages' => [
        			'password2' => 'Your password is incorrect. Please use the password that you were using in logging in to our Ran Client.'
        		]
        	);
        	return back()->withErrors($error)->withInput();
        }
        $ipAddress = new CaptureIpTrait();
        $role = Role::where('slug', '=', 'unverified')->first();
        $profile = new Profile();
        $user = User::create([
            'name'              => $req->input('name2'),
            'first_name'        => $req->input('first_name'),
            'last_name'         => $req->input('last_name'),
            'email'             => $req->input('email'),
            'password'          => Hash::make($req->input('password2')),
            'token'             => str_random(64),
            'signup_ip_address' => $ipAddress->getClientIp(),
            'activated'         => !config('settings.activation'),
        ]);

        $user->points()->create([
            'points'    =>  0,
            'Vpoints'   =>  0
        ]);    
        $user->attachRole($role);
        $user->profile()->save($profile);

        $info = UserInfo4::where(['UserName' => $req->input('name2')])->update([
            'UserName' => $req->input('name2'),
            'UserID' => $req->input('name2'),
            'UserPass' => strtoupper(substr(md5($req->input('password2')),0,19)),
            'UserPass2' => strtoupper(substr(md5($req->input('pin')),0,19)),
            'UserEmail' => $req->input('email'),
            'UserSQ' => $req->input('secret_question'),
            'UserSA' => $req->input('secret_answer'),
            'UserAvailable' => 1,
        ]); 
        
        $this->initiateEmailActivation($user);
        Session::put('set_password',true);
        if(Auth::attempt(['name' => $req->input('name2'), 'password' => $req->input('password2')])){
            return redirect('activate')->with('success','You have successfully restored your account. But before that, please check your email to fully activated your account.');
        }
        return redirect('restore/account')->with('error','Something went wrong. Please try to login or repeat this method.');

    }
}
