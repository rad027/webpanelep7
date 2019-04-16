<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\license;
use App\Traits\CaptureIpTrait;
use Validator;
use Artisan;
use Auth;

class WebInfoController extends Controller
{
    public function informations(){
    	return view('pages.admin.webinfo.informations');
    }

    public function ipaddress(){
        $ip = new CaptureIpTrait();
        return $ip->getClientIp();
    }

    public function informations_process(Request $req){
    	$valid = Validator::make($req->all(),[
    		'APP_NAME' 			        => 'required|min:5|max:30',
    		'APP_URL'			        => 'required|max:30|url',
            'APP_DEBUG'                 => 'required|max:20',
            'PANEL_TITLE'               => 'required|max:20',
            'PANEL_TITLE_POSTFIX'       => 'required|max:20',
            'PANEL_LOGO'                => 'required|max:20',
            'PANEL_MINI_LOGO'            => 'required|max:20',
    	],[
    		'APP_NAME.required' 		          => 'The APP TITLE field is required.',
    		'APP_URL.required'			          => 'The APP URL field is required.',
    		'APP_DEBUG.required' 		          => 'The APP DEBUG field is required.',
    		'APP_URL.url'				          => 'The APP URL field must be an URL.',
            'PANEL_TITLE.required'                => 'The APP TITLE field is required.',
            'PANEL_TITLE_POSTFIX.required'        => 'The APP POSTFIX TITLE field is required.',
            'PANEL_LOGO.required'                 => 'The APP LOGO field is required.',
            'PANEL_MINI_LOGO.required'             => 'The APP MINI LOGO field is required.',
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
    	}
	    $data = file_get_contents(base_path('.env'));
	    $data = explode("\n", $data);
	    $data[0] = 'APP_NAME="'.$req->input('APP_NAME').'"';
	    $data[4] = 'APP_URL="'.$req->input('APP_URL').'"';
        $data[3] = 'APP_DEBUG="'.$req->input('APP_DEBUG').'"';
        $data[10] = 'PANEL_TITLE="'.$req->input('PANEL_TITLE').'"';
        $data[12] = 'PANEL_TITLE_POSTFIX="'.$req->input('PANEL_TITLE_POSTFIX').'"';
        $data[13] = 'PANEL_LOGO="'.$req->input('PANEL_LOGO').'"';
        $data[14] = 'PANEL_MINI_LOGO="'.$req->input('PANEL_MINI_LOGO').'"';
	    file_put_contents(base_path('.env'),implode("\n",$data));
        Artisan::call('config:clear');
            Auth::user()->timeline()->create([
                'content'       =>  'Web Information Update was successful.',
                'remark'        =>  'webinfo',
                'ip_address'    => $this->ipaddress()
            ]);
	    return back()->with('success','Update was successful.');
    }

    public function meta(){
        return view('pages.admin.webinfo.meta');
    }

    public function meta_process(Request $req){
        $valid = Validator::make($req->all(),[
            'OG_URL'                => 'required|url',
            'OG_TITLE'              => 'required',
            'OG_IMAGE'              => 'required|url',
            'OG_DESCRIPTION'        => 'required|max:200',
        ],[
            'OG_URL.required'               => 'The URL field is required.',
            'OG_TITLE.required'             => 'The Title field is required.',
            'OG_IMAGE.required'             => 'The IMAGE LINK field is required.',
            'OG_DESCRIPTION.required'       => 'The DESCRIPTION field is required.',
            'OG_URL.url'                    => 'The URL field must be an URL.',
            'OG_IMAGE.url'                  => 'The IMAGE LINK field must be an URL.'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
        $data = file_get_contents(base_path('.env'));
        $data = explode("\n", $data);
        $data[178] = 'OG_URL="'.$req->input('OG_URL').'"';
        $data[179] = 'OG_TITLE="'.$req->input('OG_TITLE').'"';
        $data[180] = 'OG_IMAGE="'.$req->input('OG_IMAGE').'"';
        $data[181] = 'OG_DESCRIPTION="'.$req->input('OG_DESCRIPTION').'"';
        file_put_contents(base_path('.env'),implode("\n",$data));
        Artisan::call('config:clear');
            Auth::user()->timeline()->create([
                'content'       =>  'Meta Information Update was successful.',
                'remark'        =>  'metainfo',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','Update was successful.');
    }

    public function mail(){
        return view('pages.admin.webinfo.mail');
    }

    public function mail_process(Request $req){
        $valid = Validator::make($req->all(),[
            'MAIL_DRIVER'           => 'required|min:2|max:30',
            'MAIL_HOST'             => 'required|max:30',
            'MAIL_PORT'             => 'required|max:6',
            'MAIL_USERNAME'         => 'required|string|max:40',
            'MAIL_PASSWORD'         => 'required|max:20',
            'MAIL_ENCRYPTION'       => 'required|max:20',
            'MAIL_FROM_ADDRESS'     => 'required|email|max:40',
            'MAIL_FROM_NAME'        => 'required|string|max:30'
        ],[
            'MAIL_DRIVER.required'          => 'The MAIL DRIVER field is required.',
            'MAIL_HOST.required'            => 'The MAIL HOST field is required.',
            'MAIL_PORT.required'            => 'The MAIL POST field is required.',
            'MAIL_USERNAME.required'        => 'The MAIL USERNAME field is required.',
            'MAIL_PASSWORD.required'        => 'The MAIL PASSWORD field is required.',
            'MAIL_ENCRYPTION.required'      => 'The MAIL ENCRYPTION field is required.',
            'MAIL_FROM_ADDRESS.required'    => 'The MAIL FROM ADDRESS field is required.',
            'MAIL_FROM_NAME.required'       => 'The MAIL FROM NAME field is required.',
            'MAIL_FROM_ADDRESS.email'       => 'The MAIL FROM NAME field should be an email address.'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
        $data = file_get_contents(base_path('.env'));
        $data = explode("\n", $data);
        $data[76] = 'MAIL_DRIVER="'.$req->input('MAIL_DRIVER').'"';
        $data[77] = 'MAIL_HOST="'.$req->input('MAIL_HOST').'"';
        $data[78] = 'MAIL_PORT="'.$req->input('MAIL_PORT').'"';
        $data[79] = 'MAIL_USERNAME="'.$req->input('MAIL_USERNAME').'"';
        $data[80] = 'MAIL_PASSWORD="'.$req->input('MAIL_PASSWORD').'"';
        $data[81] = 'MAIL_ENCRYPTION="'.$req->input('MAIL_ENCRYPTION').'"';
        $data[83] = 'MAIL_FROM_ADDRESS="'.$req->input('MAIL_FROM_ADDRESS').'"';
        $data[84] = 'MAIL_FROM_NAME="'.$req->input('MAIL_FROM_NAME').'"';
        file_put_contents(base_path('.env'),implode("\n",$data));
        Artisan::call('config:clear');
            Auth::user()->timeline()->create([
                'content'       =>  'Mail Server Information Update was successful.',
                'remark'        =>  'mailserver',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','Update was successful.');
    }

    public function license_info(){
        $file = @file_get_contents('http://roldhandasalla.cf/license/'.$_SERVER['SERVER_NAME'].'.license.php');
        $file = json_decode($file);
        return view('pages.license.info',compact('file'));
    }

    public function license_process(Request $req){
        $valid = Validator::make($req->all(),[
            'license_key' => ['required',new license(),'max:20']
        ]);
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
        $data = file_get_contents(base_path('.env'));
        $data = explode("\n", $data);
        $data[184] = 'LICENSE_KEY="'.$req->input('license_key').'"';
        file_put_contents(base_path('.env'),implode("\n",$data));
            Auth::user()->timeline()->create([
                'content'       =>  'License was successfully validated.',
                'remark'        =>  'license_update',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','License was successfully validated.');
    }
}
