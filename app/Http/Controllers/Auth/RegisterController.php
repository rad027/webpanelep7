<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ActivationTrait;
use App\Traits\CaptchaTrait;
use App\Traits\CaptureIpTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Models\RanUser\UserInfo4;
use App\Models\Points;
use App\Models\RanCP\Verify;
use App\Models\Profile;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use ActivationTrait;
    use CaptchaTrait;
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/activate';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'except' => 'logout',
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['captcha'] = $this->captchaCheck();

        if (!config('settings.reCaptchStatus')) {
            $data['captcha'] = true;
        }
		
		if(UserInfo4::where(['UserName' => $data['name']])->count()){
			$data['check'] = false;
		}else{
			$data['check'] = true;
		}

        return Validator::make($data,
            [
                'name'                  => 'required|min:4|max:19|unique:users',
                'first_name'            => 'required',
                'last_name'             => 'required',
                'pin'                   => 'required',
                'secret_question'       => 'required',
                'secret_answer'         => 'required',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:19|confirmed',
                'password_confirmation' => 'required|same:password',
                'g-recaptcha-response'  => '',
                'captcha'               => 'required|min:1',
				'check'					=> 'required|min:1'
            ],
            [
                'name.unique'                   => trans('auth.userNameTaken'),
                'name.required'                 => trans('auth.userNameRequired'),
                'first_name.required'           => trans('auth.fNameRequired'),
                'last_name.required'            => trans('auth.lNameRequired'),
                'email.required'                => trans('auth.emailRequired'),
                'email.email'                   => trans('auth.emailInvalid'),
                'password.required'             => trans('auth.passwordRequired'),
                'password.min'                  => trans('auth.PasswordMin'),
                'password.max'                  => trans('auth.PasswordMax'),
                'g-recaptcha-response.required' => trans('auth.captchaRequire'),
                'captcha.min'                   => trans('auth.CaptchaWrong'),
				'check.required'				=> 'Username is for restoring process only not allowed in registration.',
				'check.min'				=> 'Username is for restoring process only not allowed in registration.',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $ipAddress = new CaptureIpTrait();
        $role = Role::where('slug', '=', 'unverified')->first();
        $profile = new Profile();
			

        $user = User::create([
                'name'              => $data['name'],
                'first_name'        => $data['first_name'],
                'last_name'         => $data['last_name'],
                'email'             => $data['email'],
                'password'          => Hash::make($data['password']),
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

        UserInfo4::create([
            'UserName' => $data['name'],
            'UserID' => $data['name'],
            'UserPass' => strtoupper(substr(md5($data['password']),0,19)),
            'UserPass2' => strtoupper(substr(md5($data['pin']),0,19)),
            'UserEmail' => $data['email'],
            'UserSQ' => $data['secret_question'],
            'UserSA' => $data['secret_answer'],
            'UserAvailable' => 0,
            'ChaRemain' => 3
        ]);     
        $this->initiateEmailActivation($user);

        return $user;
    }
}
