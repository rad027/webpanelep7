<?php

namespace App\Http\Controllers;

use Mail;
use Auth;
use App\Models\Profile;
use App\Models\RanUser\UserInfo4;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Traits\CaptureIpTrait;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\CaptchaTrait;
use App\Traits\ActivationTrait;

class UserController extends Controller
{
    use CaptchaTrait;

    use ActivationTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ipaddress(){
        $ip = new CaptureIpTrait();
        return $ip->getClientIp();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = UserInfo4::count() - User::count();
        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('pages.admin.home',compact('count'));
        }
                if(Auth::user()->UserInfo4()->first()->Activation == 0){
                    return redirect('user/password')->with('error','You must change your password first to fully secure your account from recent attacks that we have been through.');
                }

        return view('pages.user.home');
    }

    public function profilecreate(){
        $profile = new Profile();
        return Auth::user()->profile()->save($profile);
    }

    //USER index
    public function users_view(){
        //$userinfo = UserInfo4::with('user_2','roles')->get();
        $userinfo = new UserInfo4();
        return view('pages.admin.users.index',compact('userinfo'));
    }

    //EDIT USER INFORMATIONS
    public function edit_informations_view($id){
        if($user = User::findOrFail($id)){
            return view('pages.admin.users.edit_informations',compact('user'));
        }else{
            redirect('game/users')->withErrors(['This id doesnt exist.']);
        }
    }

    public function edit_informations_process(Request $req,$id){
        if($user = User::findOrFail($id)){
            $userinfo = UserInfo4::where(['UserID' => $user->name])->first();
            $valid = Validator::make($req->all(),[
                'first_name' => 'required|min:3|max:20',
                'last_name' => 'required|min:3|max:20',
                'email' => 'required|email|min:8|unique:users,email,'.$user->id.'|unique:sqlsrv4.UserInfo,UserEmail,'.$userinfo->UserNum.',UserNum'
            ]);
            if($valid->fails()){
                return back()->withErrors($valid)->withInput();
            }
            //update webpanel db
            $user->first_name = $req->input('first_name');
            $user->last_name = $req->input('last_name');
            $user->email = $req->input('email');
            $user->save();
            //update RanUser db
            $userinfo->UserEmail = $req->input('email');
            $userinfo->save();
            Auth::user()->timeline()->create([
                'content'       =>  'User ['.$user->name.'] has been successfully updated.',
                'remark'        =>  'user_update',
                'ip_address'    => $this->ipaddress()
            ]);
            return redirect('game/users')->with('success','User ['.$user->name.'] has been successfully updated.');
        }else{
            redirect('game/users')->withErrors(['This id doesnt exist.']);
        }
    }
    //END OF EDIT USER INFORMATIONS
    //EDIT USER PASSWORD
    public function edit_password_view($id){
        if($user = User::findOrFail($id)){
            return view('pages.admin.users.edit_password',compact('user'));
        }else{
            return redirect('game/users')->withErrors(['This id doesnt exist.']);
        }
    }

    public function edit_password_process(Request $req,$id){
        if($user = User::findOrFail($id)){
            $valid = Validator::make($req->all(),[
                'password'              => 'required|min:6|max:19|confirmed',
                'password_confirmation' => 'required|same:password',
            ]);
            if($valid->fails()){
                return back()->withErrors($valid)->withInput();
            }
            $user->update([
                'password' => Hash::make($req->input('password'))
            ]);
            UserInfo4::where(['UserName' => $user->name])->update([
                'UserPass' => strtoupper(substr(md5($req->input('password')),0,19))
            ]);
            Auth::user()->timeline()->create([
                'content'       =>  'User ['.$user->name.'] has been successfully updated.',
                'remark'        =>  'user_update',
                'ip_address'    => $this->ipaddress()
            ]);
            return redirect('game/users')->with('success','User ['.$user->name.'] has been successfully updated.');
        }else{
            return redirect('game/users')->withErrors(['This id doesnt exist.']);
        }
    }
    //END OF EDIT USER PASSWORD
    //EDIT ACCOUNT TYPE
    public function edi_acctype_view($id){
        if($user = User::findOrFail($id)){
            $roles = Role::all();
            return view('pages.admin.users.edit_acctype',compact('user','roles'));
        }else{
            return redirect('game/users')->withErrors(['This id doesnt exist.']);
        }
    }
    public function edi_acctype_process(Request $req,$id){
        if($user = User::findOrFail($id)){
            $valid = Validator::make($req->all(),[
                'ingame_role' => 'required',
                'panel_role' => 'required',
                'user_status' => 'required'
            ]);
            if($valid->fails()){
                return back()->withErrors($valid)->withInput();
            }
            //Update ingame role
            UserInfo4::where(['UserID' => $user->name])->update([
                'UserType' => $req->input('ingame_role'),
                'UserBlock' => $req->input('user_status')
            ]);
            //update panel role
            $userRole = $req->input('role');
            switch ($userRole) {
                case 3:
                    $user->activated = 0;
                    break;

                default:
                    $user->activated = 1;
					//Update ingame role
					UserInfo4::where(['UserID' => $user->name])->update([
						'UserAvailable' => 1
					]);
                    break;
            }
            $user->detachAllRoles();
            $user->attachRole($req->input('panel_role'));
            $user->save();
            Auth::user()->timeline()->create([
                'content'       =>  'User ['.$user->name.'] has been successfully updated.',
                'remark'        =>  'user_update',
                'ip_address'    => $this->ipaddress()
            ]);
            return redirect('game/users')->with('success','User ['.$user->name.'] has been successfully updated.');
        }else{
            return redirect('game/users')->withErrors(['This id doesnt exist.']);
        }
    }

    //USERS RESTORE INDEX VIEW
    public function restore_index_view(){
        $users = new UserInfo4();
        return view('pages.admin.users.restore.index',compact('users'));
    }
    //USERS RESTORE VIEW BY ID
    public function restore_view_id($id){
        try{
            $user = UserInfo4::findOrFail($id);
            return view('pages.admin.users.restore.view',compact('user'));
        }catch(ModelNotFoundException $e){
            return back()->with('error','User doesnt exists.');
        }
    }
    //USERS RESTORE PROCESS
    public function restore_user($id,Request $req){
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
        $receiver = $req->input('email');
        Mail::send('vendor.mail.html.custom',$req->input(), function($q) use ($receiver){
            $q->to($receiver,'User')
              ->subject('Your account in '.env('APP_NAME').' was successfully restored by admin.');
            $q->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
        });
        return redirect('game/users/restore')->with('success','You have successfully restored User ['.$req->input('name2').']. His/her new credential has been sent to <b>'.$receiver.'</b>');
    }
}
