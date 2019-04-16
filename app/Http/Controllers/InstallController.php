<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Rules\license;
use Validator;
use DB;
use Artisan;

class InstallController extends Controller
{
    public function install_step1_view(){
    	if(config('app.app_config') != 1){
    		return view('installer.installer');
    	}else{
    		return redirect('/')->withErrors(['Configuration seems fine.']);
    	}
    }

    public function install_step1_process(Request $req){
    	if(config('app.app_config') === 1){
    		return back()->with('error','Configuration seems fine.');
    	}
    	$valid = Validator::make($req->all(),[
    		'title' 			=> 'required|min:5|max:20',
    		'panel_logo'		=> 'required|min:5|max:30',
    		'panel_mini_logo' 	=> 'required|min:5|max:20'
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
    	}
	    $data = file_get_contents(base_path('.env'));
	    $data = explode("\n", $data);
	    $data[10] = 'PANEL_TITLE="'.$req->input('title').'"';
	    if($req->has('title_postfix')){
	    	$data[12] = 'PANEL_TITLE_POSTFIX="'.$req->input('title_postfix').'"';
	    }
	    $data[13] = 'PANEL_LOGO="'.$req->input('panel_logo').'"';
	    $data[14] = 'PANEL_MINI_LOGO="'.$req->input('panel_mini_logo').'"';
	    file_put_contents(base_path('.env'),implode("\n",$data));
	    Session::put('install',true);
	    return redirect('install/2');
    }

    public function install_step2_view(){
    	Session::forget('install2');
    	Session::forget('install3');
    	Session::forget('install4');
    	Session::forget('install5');
    	Session::forget('install6');
    	Session::forget('install7');
    	Session::forget('install8');
    	if(config('app.app_config') != 1){
	    	if(!Session::has('install')){
	    		return redirect('install')->with('error','Fill up this form first before you proceed to next one.');
	    	}
    		return view('installer.installer_step2');
    	}else{
    		return redirect('/')->withErrors(['Configuration seems fine.']);
    	}
    }

    public function install_step2_process(Request $req){
    	Session::forget('install2');
    	Session::forget('install3');
    	Session::forget('install4');
    	Session::forget('install5');
    	Session::forget('install6');
    	Session::forget('install7');
    	Session::forget('install8');
    	if(config('app.app_config') === 1){
    		return back()->with('error','Configuration seems fine.');
    	}
    	if(!Session::has('install')){
    		return redirect('install')->with('error','Fill up this form first before you proceed to next one.');
    	}
    	$valid = Validator::make($req->all(),[
    		'DB_HOST' 			=> 'required|min:5|max:30',
    		'DB_PORT'			=> 'required|max:30',
    		'DB_DATABASE' 		=> 'required|max:20',
    		'DB_USERNAME' 		=> 'required|max:20',
    		'DB_PASSWORD' 		=> 'required|max:20'
    	],[
    		'DB_HOST.required' 			=> 'The DB HOST field is required.',
    		'DB_PORT.required'			=> 'The DB PORT field is required.',
    		'DB_DATABASE.required' 		=> 'The DB NAME field is required.',
    		'DB_USERNAME.required' 		=> 'The DB USERNAME field is required.',
    		'DB_PASSWORD.required' 		=> 'The DB PASSWORD field is required.'
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
    	}
	    $data = file_get_contents(base_path('.env'));
	    $data = explode("\n", $data);
	    $data[20] = 'DB_HOST="'.$req->input('DB_HOST').'"';
	    $data[21] = 'DB_PORT="'.$req->input('DB_PORT').'"';
	    $data[22] = 'DB_DATABASE="'.$req->input('DB_DATABASE').'"';
	    $data[23] = 'DB_USERNAME="'.$req->input('DB_USERNAME').'"';
	    $data[24] = 'DB_PASSWORD="'.$req->input('DB_PASSWORD').'"';
	    $data[28] = 'DB_HOST_2="'.$req->input('DB_HOST').'"';
	    $data[29] = 'DB_PORT_2="'.$req->input('DB_PORT').'"';
	    $data[30] = 'DB_DATABASE_2="'.$req->input('DB_DATABASE').'"';
	    $data[31] = 'DB_USERNAME_2="'.$req->input('DB_USERNAME').'"';
	    $data[32] = 'DB_PASSWORD_2="'.$req->input('DB_PASSWORD').'"';
	    file_put_contents(base_path('.env'),implode("\n",$data));
        return redirect('install/db/test/sqlsrv')->withInput();
    }

    public function install_step3_view(){
    	Session::forget('install3');
    	Session::forget('install4');
    	Session::forget('install5');
    	Session::forget('install6');
    	Session::forget('install7');
    	Session::forget('install8');
    	if(config('app.app_config') != 1){
	    	if(!Session::has('install2')){
	    		return redirect('install/2')->with('error','Fill up this form first before you proceed to next one.');
	    	}
    		return view('installer.installer_step3');
    	}else{
    		return redirect('/')->withErrors(['Configuration seems fine.']);
    	}
    }

    public function install_step3_process(Request $req){
    	Session::forget('install3');
    	Session::forget('install4');
    	Session::forget('install5');
    	Session::forget('install6');
    	Session::forget('install7');
    	Session::forget('install8');
    	if(config('app.app_config') === 1){
    		return back()->with('error','Configuration seems fine.');
    	}
    	if(!Session::has('install2')){
    		return redirect('install/2')->with('error','Fill up this form first before you proceed to next one.');
    	}
    	$valid = Validator::make($req->all(),[
    		'DB_HOST' 			=> 'required|min:5|max:30',
    		'DB_PORT'			=> 'required|max:30',
    		'DB_DATABASE' 		=> 'required|max:20',
    		'DB_USERNAME' 		=> 'required|max:20',
    		'DB_PASSWORD' 		=> 'required|max:20'
    	],[
    		'DB_HOST.required' 			=> 'The DB HOST field is required.',
    		'DB_PORT.required'			=> 'The DB PORT field is required.',
    		'DB_DATABASE.required' 		=> 'The DB NAME field is required.',
    		'DB_USERNAME.required' 		=> 'The DB USERNAME field is required.',
    		'DB_PASSWORD.required' 		=> 'The DB PASSWORD field is required.'
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
    	}
	    $data = file_get_contents(base_path('.env'));
	    $data = explode("\n", $data);
	    $data[36] = 'DB_HOST_3="'.$req->input('DB_HOST').'"';
	    $data[37] = 'DB_PORT_3="'.$req->input('DB_PORT').'"';
	    $data[38] = 'DB_DATABASE_3="'.$req->input('DB_DATABASE').'"';
	    $data[39] = 'DB_USERNAME_3="'.$req->input('DB_USERNAME').'"';
	    $data[40] = 'DB_PASSWORD_3="'.$req->input('DB_PASSWORD').'"';
	    file_put_contents(base_path('.env'),implode("\n",$data));
        return redirect('install/db/test/sqlsrv3');
    }

    public function install_step4_view(){
    	Session::forget('install4');
    	Session::forget('install5');
    	Session::forget('install6');
    	Session::forget('install7');
    	Session::forget('install8');
    	if(config('app.app_config') != 1){
	    	if(!Session::has('install3')){
	    		return redirect('install/3')->with('error','Fill up this form first before you proceed to next one.');
	    	}
    		return view('installer.installer_step4');
    	}else{
    		return redirect('/')->withErrors(['Configuration seems fine.']);
    	}
    }

    public function install_step4_process(Request $req){
    	Session::forget('install4');
    	Session::forget('install5');
    	Session::forget('install6');
    	Session::forget('install7');
    	Session::forget('install8');
    	if(config('app.app_config') === 1){
    		return back()->with('error','Configuration seems fine.');
    	}
    	if(!Session::has('install3')){
    		return redirect('install/3')->with('error','Fill up this form first before you proceed to next one.');
    	}
    	$valid = Validator::make($req->all(),[
    		'DB_HOST' 			=> 'required|min:5|max:30',
    		'DB_PORT'			=> 'required|max:30',
    		'DB_DATABASE' 		=> 'required|max:20',
    		'DB_USERNAME' 		=> 'required|max:20',
    		'DB_PASSWORD' 		=> 'required|max:20'
    	],[
    		'DB_HOST.required' 			=> 'The DB HOST field is required.',
    		'DB_PORT.required'			=> 'The DB PORT field is required.',
    		'DB_DATABASE.required' 		=> 'The DB NAME field is required.',
    		'DB_USERNAME.required' 		=> 'The DB USERNAME field is required.',
    		'DB_PASSWORD.required' 		=> 'The DB PASSWORD field is required.'
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
    	}
	    $data = file_get_contents(base_path('.env'));
	    $data = explode("\n", $data);
	    $data[44] = 'DB_HOST_4="'.$req->input('DB_HOST').'"';
	    $data[45] = 'DB_PORT_4="'.$req->input('DB_PORT').'"';
	    $data[46] = 'DB_DATABASE_4="'.$req->input('DB_DATABASE').'"';
	    $data[47] = 'DB_USERNAME_4="'.$req->input('DB_USERNAME').'"';
	    $data[48] = 'DB_PASSWORD_4="'.$req->input('DB_PASSWORD').'"';
	    file_put_contents(base_path('.env'),implode("\n",$data));
        return redirect('install/db/test/sqlsrv4');
    }

    public function install_step5_view(){
    	Session::forget('install5');
    	Session::forget('install6');
    	Session::forget('install7');
    	Session::forget('install8');
    	if(config('app.app_config') != 1){
	    	if(!Session::has('install4')){
	    		return redirect('install/4')->with('error','Fill up this form first before you proceed to next one.');
	    	}
    		return view('installer.installer_step5');
    	}else{
    		return redirect('/')->withErrors(['Configuration seems fine.']);
    	}
    }

    public function install_step5_process(Request $req){
    	Session::forget('install5');
    	Session::forget('install6');
    	Session::forget('install7');
    	Session::forget('install8');
    	if(config('app.app_config') === 1){
    		return back()->with('error','Configuration seems fine.');
    	}
    	if(!Session::has('install4')){
    		return redirect('install/4')->with('error','Fill up this form first before you proceed to next one.');
    	}
    	$valid = Validator::make($req->all(),[
    		'DB_HOST' 			=> 'required|min:5|max:30',
    		'DB_PORT'			=> 'required|max:30',
    		'DB_DATABASE' 		=> 'required|max:20',
    		'DB_USERNAME' 		=> 'required|max:20',
    		'DB_PASSWORD' 		=> 'required|max:20'
    	],[
    		'DB_HOST.required' 			=> 'The DB HOST field is required.',
    		'DB_PORT.required'			=> 'The DB PORT field is required.',
    		'DB_DATABASE.required' 		=> 'The DB NAME field is required.',
    		'DB_USERNAME.required' 		=> 'The DB USERNAME field is required.',
    		'DB_PASSWORD.required' 		=> 'The DB PASSWORD field is required.'
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
    	}
	    $data = file_get_contents(base_path('.env'));
	    $data = explode("\n", $data);
	    $data[52] = 'DB_HOST_5="'.$req->input('DB_HOST').'"';
	    $data[53] = 'DB_PORT_5="'.$req->input('DB_PORT').'"';
	    $data[54] = 'DB_DATABASE_5="'.$req->input('DB_DATABASE').'"';
	    $data[55] = 'DB_USERNAME_5="'.$req->input('DB_USERNAME').'"';
	    $data[56] = 'DB_PASSWORD_5="'.$req->input('DB_PASSWORD').'"';
	    file_put_contents(base_path('.env'),implode("\n",$data));
        return redirect('install/db/test/sqlsrv5');
    }

    public function install_step6_view(){
    	Session::forget('install6');
    	Session::forget('install7');
    	Session::forget('install8');
    	if(config('app.app_config') != 1){
	    	if(!Session::has('install5')){
	    		return redirect('install/5')->with('error','Fill up this form first before you proceed to next one.');
	    	}
    		return view('installer.installer_step6');
    	}else{
    		return redirect('/')->withErrors(['Configuration seems fine.']);
    	}
    }

    public function install_step6_process(Request $req){
    	Session::forget('install6');
    	Session::forget('install7');
    	Session::forget('install8');
    	if(config('app.app_config') === 1){
    		return back()->with('error','Configuration seems fine.');
    	}
    	if(!Session::has('install5')){
    		return redirect('install/5')->with('error','Fill up this form first before you proceed to next one.');
    	}
    	$valid = Validator::make($req->all(),[
    		'DB_HOST' 			=> 'required|min:5|max:30',
    		'DB_PORT'			=> 'required|max:30',
    		'DB_DATABASE' 		=> 'required|max:20',
    		'DB_USERNAME' 		=> 'required|max:20',
    		'DB_PASSWORD' 		=> 'required|max:20'
    	],[
    		'DB_HOST.required' 			=> 'The DB HOST field is required.',
    		'DB_PORT.required'			=> 'The DB PORT field is required.',
    		'DB_DATABASE.required' 		=> 'The DB NAME field is required.',
    		'DB_USERNAME.required' 		=> 'The DB USERNAME field is required.',
    		'DB_PASSWORD.required' 		=> 'The DB PASSWORD field is required.'
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
    	}
	    $data = file_get_contents(base_path('.env'));
	    $data = explode("\n", $data);
	    $data[60] = 'DB_HOST_6="'.$req->input('DB_HOST').'"';
	    $data[61] = 'DB_PORT_6="'.$req->input('DB_PORT').'"';
	    $data[62] = 'DB_DATABASE_6="'.$req->input('DB_DATABASE').'"';
	    $data[63] = 'DB_USERNAME_6="'.$req->input('DB_USERNAME').'"';
	    $data[64] = 'DB_PASSWORD_6="'.$req->input('DB_PASSWORD').'"';
	    file_put_contents(base_path('.env'),implode("\n",$data));
		return redirect('install/db/test/sqlsrv6');
    }

    public function install_step7_view(){
    	Session::forget('install7');
    	Session::forget('install8');
    	if(config('app.app_config') != 1){
	    	if(!Session::has('install6')){
	    		return redirect('install/6')->with('error','Fill up this form first before you proceed to next one.');
	    	}
    		return view('installer.installer_step7');
    	}else{
    		return redirect('/')->withErrors(['Configuration seems fine.']);
    	}
    }

    public function install_step7_process(Request $req){
    	Session::forget('install7');
    	Session::forget('install8');
    	if(config('app.app_config') === 1){
    		return back()->with('error','Configuration seems fine.');
    	}
    	if(!Session::has('install6')){
    		return redirect('install/6')->with('error','Fill up this form first before you proceed to next one.');
    	}
    	$valid = Validator::make($req->all(),[
    		'MAIL_DRIVER' 			=> 'required|min:2|max:30',
    		'MAIL_HOST'				=> 'required|max:30',
    		'MAIL_PORT' 			=> 'required|max:6',
    		'MAIL_USERNAME' 		=> 'required|string|max:40',
    		'MAIL_PASSWORD' 		=> 'required|max:20',
    		'MAIL_ENCRYPTION' 		=> 'required|max:20',
    		'MAIL_FROM_ADDRESS' 	=> 'required|email|max:40',
    		'MAIL_FROM_NAME' 		=> 'required|string|max:20'
    	],[
    		'MAIL_DRIVER.required' 			=> 'The MAIL DRIVER field is required.',
    		'MAIL_HOST.required'			=> 'The MAIL HOST field is required.',
    		'MAIL_PORT.required' 			=> 'The MAIL POST field is required.',
    		'MAIL_USERNAME.required' 		=> 'The MAIL USERNAME field is required.',
    		'MAIL_PASSWORD.required' 		=> 'The MAIL PASSWORD field is required.',
    		'MAIL_ENCRYPTION.required' 		=> 'The MAIL ENCRYPTION field is required.',
    		'MAIL_FROM_ADDRESS.required' 	=> 'The MAIL FROM ADDRESS field is required.',
    		'MAIL_FROM_NAME.required' 		=> 'The MAIL FROM NAME field is required.',
    		'MAIL_FROM_ADDRESS.email' 		=> 'The MAIL FROM NAME field should be an email address.'
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
	    Session::put('install7',true);
	    return redirect('install/8');
    }

    public function install_step8_view(){
    	Session::forget('install8');
    	if(config('app.app_config') != 1){
	    	if(!Session::has('install7')){
	    		return redirect('install/7')->with('error','Fill up this form first before you proceed to next one.');
	    	}
	    	$db = array('sqlsrv','sqlsrv2','sqlsrv3','sqlsrv4','sqlsrv5','sqlsrv6');
	    	$dbresult = array();
	    	$i=0;
	    	foreach($db as $dbs){
	    		if(DB::connection($dbs)->getPdo()){
	    			if($dbs === "sqlsrv"){
	    				$dbresult[] = '<span class="text-disabled">WEB PANEL DATABASE...</span><span class="text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
	    			}elseif($dbs === "sqlsrv3"){
	    				$dbresult[] = '<span class="text-disabled">Ran Game DATABASE...</span><span class="text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
	    			}elseif($dbs === "sqlsrv4"){
	    				$dbresult[] = '<span class="text-disabled">Ran User DATABASE...</span><span class="text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
	    			}elseif($dbs === "sqlsrv5"){
	    				$dbresult[] = '<span class="text-disabled">Ran Log DATABASE...</span><span class="text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
	    			}elseif($dbs === "sqlsrv6"){
	    				$dbresult[] = '<span class="text-disabled">Ran Shop DATABASE...</span><span class="text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></span>';
	    			}
	    		}else{
	    			if($dbs === "sqlsrv"){
	    				$dbresult[] = '<span class="text-disabled">WEB PANEL DATABASE...</span><span class="text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>';
	    			}elseif($dbs === "sqlsrv3"){
	    				$dbresult[] = '<span class="text-disabled">Ran Game DATABASE...</span><span class="text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>';
	    			}elseif($dbs === "sqlsrv4"){
	    				$dbresult[] = '<span class="text-disabled">Ran User DATABASE...</span><span class="text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>';
	    			}elseif($dbs === "sqlsrv5"){
	    				$dbresult[] = '<span class="text-disabled">Ran Log DATABASE...</span><span class="text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>';
	    			}elseif($dbs === "sqlsrv6"){
	    				$dbresult[] = '<span class="text-disabled">Ran Shop DATABASE...</span><span class="text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>';
	    			}
	    		}
	    	}
			Artisan::call('migrate');
            $dbresult[] =  Artisan::output();
			Artisan::call('db:seed');
			$dbresult[] =  Artisan::output();
    		return view('installer.installer_step8',compact('dbresult'));
    	}else{
    		return redirect('/')->withErrors(['Configuration seems fine.']);
    	}
    }

    public function check_license(Request $req){
        $valid = Validator::make($req->all(),[
            'license_key'           => ['required',new license(),'max:20'],
        ]);
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
        $data = file_get_contents(base_path('.env'));
        $data = explode("\n", $data);
        $data[184] = 'LICENSE_KEY="'.$req->input('license_key').'"';
        file_put_contents(base_path('.env'),implode("\n",$data));
        return redirect('install/lock');
    }

    public function invalid_license(){
        return view('pages.license.invalid');
    }

    public function db_test($server){
        if($server === "sqlsrv"){
            $redirect = "install/3";
            $session = "install2";
        }elseif($server === "sqlsrv3"){
            $redirect = "install/4";
            $session = "install3";
        }elseif($server === "sqlsrv4"){
            $redirect = "install/5";
            $session = "install4";
        }elseif($server === "sqlsrv5"){
            $redirect = "install/6";
            $session = "install5";
        }else{
            $redirect = "install/7";
            $session = "install6";
        }
        try {
            DB::connection($server)->getPdo();
            DB::connection($server)->getDatabaseName();
            Session::put($session,true);
            return redirect($redirect);
        } catch (\Exception $e) {
            return back()->with('error',sprintf('Could not connect to the database.  Please check your configuration and try again'))->withInput();
        }
    }

    public function lock_installer(){
	    $data = file_get_contents(base_path('.env'));
	    $data = explode("\n", $data);
	    $data[7] = 'APP_INSTALL=1';
	    file_put_contents(base_path('.env'),implode("\n",$data));
	    return redirect('/')->with('success','Thank you for using our ran panel ~R.A.D(iNew Works)');
    }



    public function view_env(){
	    	$data = file_get_contents(base_path('.env'));
	    	$data = explode("\n", $data);
	    	//$data[3] = "APP_DEBUG=false";
	    	//file_put_contents(base_path('.env'),implode("\n",$data));
	    	for($i=0;$i<count($data);$i++){
	    		echo "(".$i.")".$data[$i]."<br>";
	    	}
    }
}
