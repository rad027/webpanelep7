<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Artisan;
use Auth;

class DatabaseController extends Controller
{
    public function webpaneldb_view(){
    	return view('pages.admin.database.webpanel');
    }

    public function webpaneldb_process(Request $req){
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
	    Artisan::call('config:clear');
	    return redirect('check/sqlsrv');
    }

    public function rangame_view(){
    	return view('pages.admin.database.rangame');
    }

    public function rangame_process(Request $req){
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
	    Artisan::call('config:clear');
	    return redirect('check/sqlsrv3');
    }

    public function ranuser_view(){
    	return view('pages.admin.database.ranuser');
    }

    public function ranuser_process(Request $req){
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
	    Artisan::call('config:clear');
	    return redirect('check/sqlsrv4');
    }

    public function ranlog_view(){
    	return view('pages.admin.database.ranlog');
    }

    public function ranlog_process(Request $req){
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
	    Artisan::call('config:clear');
	    return redirect('check/sqlsrv5');
    }

    public function ranshop_view(){
    	return view('pages.admin.database.ranshop');
    }

    public function ranshop_process(Request $req){
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
	    Artisan::call('config:clear');
	    return redirect('check/sqlsrv6');
    }

    public function check_connection($con){
    	try{	
			DB::connection($con)->getPdo();
			DB::connection($con)->getDatabaseName();
		    return back()->with('success','Successfully updated.');
    	}catch(\Exception $e){
		    return back()->with('error',sprintf('Could not connect to the database.  Please check your configuration and try again'))->withInput();
    	}
    }

    //REFRESH DB VIEW
    public function refreshdb_view(){
        return view('pages.admin.database.refresh');
    }
    //REFRESH DB PROCESS
    public function refreshdb_process(){
        //sqlsrv3
        DB::connection('sqlsrv3')->table('ChaInfo')->update([
            'ChaStartGate'          => '6',  
            'ChaStartMap'           => '22',  
            'ChaPosX'               => '0',  
            'ChaPosY'               => '0',  
            'ChaPosZ'               => '0',  
            'ChaSaveMap'            => '-1',  
            'ChaSavePosX'           => '0',  
            'ChaSavePosY'           => '0',  
            'ChaSavePosZ'           => '0',  
            'ChaReturnMap'          => '-1',  
            'ChaReturnPosX'         => '0',  
            'ChaReturnPosY'         => '0',  
            'ChaReturnPosZ'         => '0',    
            'ChaCreateDate'         => '6/12/2009 12:00:00', 
            'ChaDeletedDate'        => '6/12/2009 12:00:00', 
            'ChaStorage2'           => '1970-02-01', 
            'ChaStorage3'           => '1970-02-01', 
            'ChaStorage4'           => '1970-02-01', 
            'ChaGuSecede'           => '1970-02-01', 
            'ChaGuName'             => 'ZGxOverlord RAN', 
            'ChaOnline'             => '0' 
        ]);
        DB::connection('sqlsrv3')->table('PetInfo')->where('PetDeleted','>',0)->delete();
        DB::connection('sqlsrv3')->table('VehicleInfo')->where('VehicleDeleted','>',0)->delete();
        DB::connection('sqlsrv3')->table('ChaInfo')->where('ChaDeleted','>',0)->delete();

        //sqlsrv4
        DB::connection('sqlsrv4')->table('StatLogin')->delete();
        DB::connection('sqlsrv4')->table('LogGameTime')->delete();
        DB::connection('sqlsrv4')->table('LogLogin')->delete();
        DB::connection('sqlsrv4')->table('LogServerState')->delete();
        DB::connection('sqlsrv4')->table('LogAction')->delete();
        DB::connection('sqlsrv4')->table('UserInfo')->update([
            'UserLoginState' => 0,
            'WebLoginState' => 0,
            'UserAvailable' => 1,
            'ChaTestRemain' => 2,
            'CreateDate' => '6/12/2009 12:00:00',
            'LastLoginDate' => '6/12/2009 12:00:00',
            'UserBlockDate' => '6/12/2009 12:00:00',
            'PremiumDate' => '1970-02-01',
            'ChatBlockDate' => '1970-02-01',
            'EndDate' => '1970-02-01'
        ]);

        //sqlsrv5
        DB::connection('sqlsrv5')->table('LogAction')->delete();
        DB::connection('sqlsrv5')->table('LogExchangeFlag')->delete();
        DB::connection('sqlsrv5')->table('LogHackProgram')->delete();
        DB::connection('sqlsrv5')->table('LogItemRandom')->delete();
        DB::connection('sqlsrv5')->table('LogItemExchange')->delete();
        DB::connection('sqlsrv5')->table('LogItemMax')->delete();
        DB::connection('sqlsrv5')->table('LogPetAction')->delete();
        DB::connection('sqlsrv5')->table('LogPetActionFlag')->delete();
        DB::connection('sqlsrv5')->table('LogServerState')->delete();
        DB::connection('sqlsrv5')->table('LogShopPurchase')->delete();
        DB::connection('sqlsrv5')->table('LogVehicleAction')->delete();
        DB::connection('sqlsrv5')->table('LogVehicleActionFlag')->delete();
        DB::connection('sqlsrv5')->table('HackProgramList')->delete();
        DB::connection('sqlsrv5')->table('LogMakeType')->delete();

        //sqlsrv6
        DB::connection('sqlsrv6')->table('ShopPurchase')->where('PurFlag','>',0)->delete();

        return back()->with('success','You have Successfully refreshed your Database Server.');
    }
}
