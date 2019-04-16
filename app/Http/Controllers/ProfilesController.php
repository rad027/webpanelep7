<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Theme;
use App\Models\User;
use App\Notifications\SendGoodbyeEmail;
use App\Traits\CaptureIpTrait;
use File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Image;
use jeremykenedy\Uuid\Uuid;
use App\Rules\ValidatePassword;
use Validator;
use View;
use Auth;

class ProfilesController extends Controller
{
    protected $idMultiKey = '618423'; //int
    protected $seperationKey = '****';

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

    public function index(){
        $user = Auth::user();
        return view('pages.user.profile.index',compact('user'));
    }

    /**
     * Upload and Update user avatar.
     *
     * @param $file
     *
     * @return mixed
     */
    public function upload(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($valid->fails()) {
            return back()->withErrors($valid)->withInput();
        }
        $currentUser = \Auth::user();
        $avatar = Input::file('file');
        $filename = 'avatar.'.$avatar->getClientOriginalExtension();
        $save_path = storage_path().'/users/id/'.$currentUser->id.'/uploads/images/avatar/';
        $path = $save_path.$filename;
        $public_path = '/images/profile/'.$currentUser->id.'/avatar/'.$filename;

        // Make the user a folder and set permissions
        File::makeDirectory($save_path, $mode = 0755, true, true);

        // Save the file to the server
        Image::make($avatar)->resize(300, 300)->save($save_path.$filename);

        // Save the public image path
        $currentUser->profile->avatar = $public_path;
        $currentUser->profile->avatar_status = 1;
        $currentUser->profile->save();
            Auth::user()->timeline()->create([
                'content'       =>  'Avatar was successfully updated.',
                'remark'        =>  'avatar_update',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','Avatar was successfully updated.');
    }

    /**
     * Show user avatar.
     *
     * @param $id
     * @param $image
     *
     * @return string
     */
    public function userProfileAvatar($id, $image)
    {
        return Image::make(storage_path().'/users/id/'.$id.'/uploads/images/avatar/'.$image)->response();
    }

    public function getUserByUsername($username)
    {
        return User::with('profile')->wherename($username)->firstOrFail();
    }

    public function profile_validator(array $data)
    {
        return Validator::make($data, [
            'first_name'            => 'required|min:4',
            'last_name'             => 'required|min:4',
            'bio'                   => 'max:500',
            'password'              => ['required','max:20','min:6',new ValidatePassword(auth()->user())]
        ]);
    }

    public function update($username, Request $request){
        $user = $this->getUserByUsername($username);

        $input = Input::only('bio');

        $ipAddress = new CaptureIpTrait();

        $profile_validator = $this->profile_validator($request->all());

        if ($profile_validator->fails()) {
            return back()->withErrors($profile_validator)->withInput();
        }

        if ($user->profile == null) {
            $profile = new Profile();
            $profile->fill($input);
            $user->profile()->save($profile);
        } else {
            $user->profile->fill($input)->save();
        }

        $user->updated_ip_address = $ipAddress->getClientIp();

        $user->save();

        $user = Auth::user();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->save();
            Auth::user()->timeline()->create([
                'content'       =>  trans('profile.updateSuccess'),
                'remark'        =>  'profile_update',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success', trans('profile.updateSuccess'));
    }
}
