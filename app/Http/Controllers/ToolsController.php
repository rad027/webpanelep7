<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RanGame1\ChaInfo;
use App\Models\RanUser\UserInfo4;
use App\Rules\ValidatePassword;
use App\Traits\CaptureIpTrait;
use App\Models\Points;
use App\Models\User;
use Validator;
use Auth;

class ToolsController extends Controller
{
    public function reborn_view(){
    	$users = UserInfo4::all();
    	return view('pages.admin.tools.reborn',compact('users'));
    }

    public function ipaddress(){
        $ip = new CaptureIpTrait();
        return $ip->getClientIp();
    }

    public function reborn_settings_view(){
    	return view('pages.admin.tools.reborn_setting');
    }

    public function reborn_form_process(Request $req){
    	$valid = Validator::make($req->all(),[
    		'status' => 'required',
    		'REBORN1_LEVEL' => 'required',
    		'REBORN1_GOLD' => 'required',
    		'REBORN1_REWARD' => 'required',
    		'REBORN1_COUNT_FROM' => 'required',
    		'REBORN1_COUNT_TO' => 'required',
    		'REBORN3_STATUS' => 'required',
     		'REBORN3_LEVEL' => 'required',
    		'REBORN3_GOLD' => 'required',
    		'REBORN3_REWARD' => 'required',
    		'REBORN3_COUNT_FROM' => 'required',
    		'REBORN3_COUNT_TO' => 'required',
    		'REBORN4_STATUS' => 'required',
     		'REBORN4_LEVEL' => 'required',
    		'REBORN4_GOLD' => 'required',
    		'REBORN4_REWARD' => 'required',
    		'REBORN4_COUNT_FROM' => 'required',
    		'REBORN4_COUNT_TO' => 'required',
    		'REBORN5_STATUS' => 'required',
     		'REBORN5_LEVEL' => 'required',
    		'REBORN5_GOLD' => 'required',
    		'REBORN5_REWARD' => 'required',
    		'REBORN5_COUNT_FROM' => 'required',
    		'REBORN5_COUNT_TO' => 'required'
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid);
    	}
	    $data = file_get_contents(base_path('.env'));
	    $data = explode("\n", $data);
	    $data[193] = 'REBORN_SYSTEM="'.$req->input('status').'" //NOTE : 1 to turn on, 0 to turn off';
	    //REBORN STAGE 1
	    $data[196] = 'REBORN1_LEVEL="'.$req->input('REBORN1_LEVEL').'"';
	    $data[197] = 'REBORN1_GOLD="'.$req->input('REBORN1_GOLD').'"';
	    $data[198] = 'REBORN1_REWARD="'.$req->input('REBORN1_REWARD').'"';
	    $data[199] = 'REBORN1_COUNT_FROM="'.$req->input('REBORN1_COUNT_FROM').'"';
	    $data[200] = 'REBORN1_COUNT_TO="'.$req->input('REBORN1_COUNT_TO').'"';
	    //REBORN STAGE 2
	    $data[203] = 'REBORN2_STATUS="'.$req->input('REBORN2_STATUS').'"';
	    $data[204] = 'REBORN2_LEVEL="'.$req->input('REBORN2_LEVEL').'"';
	    $data[205] = 'REBORN2_GOLD="'.$req->input('REBORN2_GOLD').'"';
	    $data[206] = 'REBORN2_REWARD="'.$req->input('REBORN2_REWARD').'"';
	    $data[207] = 'REBORN2_COUNT_FROM="'.$req->input('REBORN2_COUNT_FROM').'"';
	    $data[208] = 'REBORN2_COUNT_TO="'.$req->input('REBORN2_COUNT_TO').'"';
	    //REBORN STAGE 3
	    $data[211] = 'REBORN3_STATUS="'.$req->input('REBORN3_STATUS').'"';
	    $data[212] = 'REBORN3_LEVEL="'.$req->input('REBORN3_LEVEL').'"';
	    $data[213] = 'REBORN3_GOLD="'.$req->input('REBORN3_GOLD').'"';
	    $data[214] = 'REBORN3_REWARD="'.$req->input('REBORN3_REWARD').'"';
	    $data[215] = 'REBORN3_COUNT_FROM="'.$req->input('REBORN3_COUNT_FROM').'"';
	    $data[216] = 'REBORN3_COUNT_TO="'.$req->input('REBORN3_COUNT_TO').'"';
	    //REBORN STAGE 4
	    $data[219] = 'REBORN4_STATUS="'.$req->input('REBORN4_STATUS').'"';
	    $data[220] = 'REBORN4_LEVEL="'.$req->input('REBORN4_LEVEL').'"';
	    $data[221] = 'REBORN4_GOLD="'.$req->input('REBORN4_GOLD').'"';
	    $data[222] = 'REBORN4_REWARD="'.$req->input('REBORN4_REWARD').'"';
	    $data[223] = 'REBORN4_COUNT_FROM="'.$req->input('REBORN4_COUNT_FROM').'"';
	    $data[224] = 'REBORN4_COUNT_TO="'.$req->input('REBORN4_COUNT_TO').'"';
	    //REBORN STAGE 5
	    $data[227] = 'REBORN5_STATUS="'.$req->input('REBORN5_STATUS').'"';
	    $data[228] = 'REBORN5_LEVEL="'.$req->input('REBORN5_LEVEL').'"';
	    $data[229] = 'REBORN5_GOLD="'.$req->input('REBORN5_GOLD').'"';
	    $data[230] = 'REBORN5_REWARD="'.$req->input('REBORN5_REWARD').'"';
	    $data[231] = 'REBORN5_COUNT_FROM="'.$req->input('REBORN5_COUNT_FROM').'"';
	    $data[232] = 'REBORN5_COUNT_TO="'.$req->input('REBORN5_COUNT_TO').'"';
	    file_put_contents(base_path('.env'),implode("\n",$data));
            Auth::user()->timeline()->create([
                'content'       =>  'Reborn System Status was successfully updated.',
                'remark'        =>  'reborn',
                'ip_address'    => $this->ipaddress()
            ]);
	    return back()->with('success','Reborn System Status was successfully updated.');
    }

    public function reborn_charinfo_process(Request $req){
    	if($req->ajax()){
	    	$chars = ChaInfo::where(['UserNum' => $req->input('UserNum')])->where(['ChaDeleted' => 0])->get();
	    	if($chars->count()> 0){
		    	$msg = '<option value="">SELECT A CHARACTER</option>';
		    	foreach($chars as $char){
                    if($char->ChaClass == 256 || $char->ChaClass == 4){
                        if($char->ChaClass == 256){
                            $gender =   "M";
                        }else{
                            $gender =   "F";
                        }
                        $name = "ARCHER";

                    }else if($char->ChaClass == 1 || $char->ChaClass == 64){
                        if($char->ChaClass == 1){
                            $gender =   "M";
                        }else{
                            $gender =   "F";
                        }
                        $name = "BRAWLER";
                    }else if($char->ChaClass == 2 || $char->ChaClass == 128){
                        if($char->ChaClass == 2){
                            $gender =   "M";
                        }else{
                            $gender =   "F";
                        }
                        $name = "SWORDSMAN";
                    }else if($char->ChaClass == 512 || $char->ChaClass == 8){
                        if($char->ChaClass == 512){
                            $gender =   "M";
                        }else{
                            $gender =   "F";
                        }
                        $name = "SHAMAN";
                    }else{
                        if($char->ChaClass == 16){
                            $gender =   "M";
                        }else{
                            $gender =   "F";
                        }
                        $name = "GUNNER";
                    }
		    		$msg .= '<option value="'.$char->ChaNum.'">'.$char->ChaName.'(RB : '.$char->ChaReborn.'/ LvL : '.$char->ChaLevel.')['.$name.' : '.$gender.']</option>';
		    	}
		    	return response()->json(array(
		    		'status' => 1,
		    		'msg' => $msg
		    	));
	    	}else{
		    	return response()->json(array(
		    		'status' => 0
		    	));
	    	}
    	}else{
    		return response()->json(array('wala kang kwenta gago.'));
	    }
    }

    public function reborn_process(Request $req){
    	$valid = Validator::make($req->all(),[
    		'UserNum' 	=> 'required',
    		'CharID'	=> 'required'
    	],[
    		'UserNum.required'	=> 'The User Account is a required field.',
    		'CharID.required'	=> 'Please Select a Character to be reborn.'
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid);
    	}
    	if(config('app.reborn_system') != 1){
    		return back()->withErrors(['Reborn System is Currently Turned Off.']);
    	}
    	if(ChaInfo::where(['ChaNum' => $req->input('CharID')])->count() > 0){
    		$char = ChaInfo::where(['ChaNum' => $req->input('CharID')])->first();
    		//Check Stage Status
    		if(config('app.reborn.5.status') == 1){
    			$maxReborn = config('app.reborn.5.to');
    		}else if(config('app.reborn.4.status') == 1){
    			$maxReborn = config('app.reborn.4.to');
    		}else if(config('app.reborn.3.status') == 1){
    			$maxReborn = config('app.reborn.3.to');
    		}else if(config('app.reborn.2.status') == 1){
    			$maxReborn = config('app.reborn.2.to');
    		}else{
    			$maxReborn = config('app.reborn.1.to');
    		}
    		//check max reborn
    		if($maxReborn === $char->ChaReborn){
    			return back()->withErrors(['This Character was already have a max reborn.']);
    		}
    		//check online status
    		if($char->ChaOnline === 1){
    			return back()->withErrors(['Characted must be offline to proceed in reborning.']);
    		}
    		//Check character reborn stage
    		if($char->ChaReborn >= config('app.reborn.5.from') && $char->ChaReborn <= config('app.reborn.5.to')){
    			$stage = 5;
    			$stage_error_reqlevel = 'Reborn Stage 5 Level Requirement is Level '.config('app.reborn.5.level').'. But you only have Level '.$char->ChaLevel.'.';
    			$stage_error_reqgold = 'Reborn Stage 5 Gold requirement is '.number_format(config('app.reborn.5.gold'),2).' Gold. But you only have '.number_format($char->ChaMoney,2).' Gold.';
    		}else if($char->ChaReborn >= config('app.reborn.4.from') && $char->ChaReborn <= config('app.reborn.4.to')){
    			$stage = 4;
    			$stage_error_reqlevel = 'Reborn Stage 4 Level Requirement is Level '.config('app.reborn.4.level').'. But you only have Level '.$char->ChaLevel.'.';
    			$stage_error_reqgold = 'Reborn Stage 4 Gold requirement is '.number_format(config('app.reborn.4.gold'),2).' Gold. But you only have '.number_format($char->ChaMoney,2).' Gold.';
    		}else if($char->ChaReborn >= config('app.reborn.3.from') && $char->ChaReborn <= config('app.reborn.3.to')){
    			$stage = 3;
    			$stage_error_reqlevel = 'Reborn Stage 3 Level Requirement is Level '.config('app.reborn.3.level').'. But you only have Level '.$char->ChaLevel.'.';
    			$stage_error_reqgold = 'Reborn Stage 3 Gold requirement is '.number_format(config('app.reborn.3.gold'),2).' Gold. But you only have '.number_format($char->ChaMoney,2).' Gold.';
    		}else if($char->ChaReborn >= config('app.reborn.2.from') && $char->ChaReborn <= config('app.reborn.2.to')){
    			$stage = 2;
    			$stage_error_reqlevel = 'Reborn Stage 2 Level Requirement is Level '.config('app.reborn.2.level').'. But you only have Level '.$char->ChaLevel.'.';
    			$stage_error_reqgold = 'Reborn Stage 2 Gold requirement is '.number_format(config('app.reborn.2.gold'),2).' Gold. But you only have '.number_format($char->ChaMoney,2).' Gold.';
    		}else if($char->ChaReborn >= config('app.reborn.1.from') && $char->ChaReborn <= config('app.reborn.1.to')){
    			$stage = 1;
    			$stage_error_reqlevel = 'Reborn Stage 1 Level Requirement is Level '.config('app.reborn.1.level').'. But you only have Level '.$char->ChaLevel.'.';
    			$stage_error_reqgold = 'Reborn Stage 1 Gold requirement is '.number_format(config('app.reborn.1.gold'),2).' Gold. But you only have '.number_format($char->ChaMoney,2).' Gold.';
    		}else{
    			$stage = 0;
    		}
    		//process reborn
    		if($stage > 0){
    			//check level if matched.
    			if(config('app.reborn.'.$stage.'.level')-1 >= $char->ChaLevel){
    				return back()->withErrors([$stage_error_reqlevel]);
    			}
    			//check gold if matched.
    			if(config('app.reborn.'.$stage.'.gold') >= $char->ChaMoney){
    				return back()->withErrors([$stage_error_reqgold]);
    			}
    			//proceed reborn
    			$goldReduct = $char->ChaMoney - config('app.reborn.'.$stage.'.gold');//Gold Reduction
    			$char->ChaMoney = $goldReduct;
    			$rebornInc = $char->ChaReborn + 1;//Add Reborn count
    			//Skill Points Adding
    			$remainSkill = $char->ChaSkillPoint + 3;
    			//multiply Stats Remaining to Reborn count
                $char->ChaStRemain = 500;
                $char = $char->save();
                $char = ChaInfo::where(['ChaNum' => $req->input('CharID')])->first();
                //$multiSRR = $char->ChaStRemain * $char->ChaReborn;
                $multiSRR = ($char->ChaStRemain * $rebornInc) + 300;
                //update character info
                $char->ChaLevel = 100;
                $char->ChaPower = 0;
                $char->ChaDex   = 0;
                $char->ChaSpirit    = 0;
                $char->ChaStrength  = 0;
                $char->ChaExp       = 0;
                $char->ChaIntel     = 0;
                $char->ChaStrong    = 0;
                $char->ChaReborn    = $rebornInc;
                $char->ChaSkillPoint    = $remainSkill;
                $char->ChaRebornDate    = \Carbon\Carbon::now();
                $char->ChaStRemain  = $multiSRR;
                $char->ChaOnline = 0;
                $char->save();
                Auth::user()->userinfo4()->update([
                    'UserLoginState' => 0
                ]);
                $char = ChaInfo::where(['ChaNum' => $req->input('CharID')])->first();
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully reborn <b>'.$char->ChaName.'</b>.',
                'remark'        =>  'reborn',
                'ip_address'    => $this->ipaddress()
            ]);
    			return back()->with('success','You have successfully reborn <b>'.$char->ChaName.'</b>.');


    		}else{
    			return back()->withErrors(['Reborn was failed. Please contact our support.']);
    		}
    	}else{
    		return back()->withErrors(['Character ID doesnt exist.']);
    	}
    }

    //CHange School View
    public function changeschool_view(){
        $users = UserInfo4::all();
        return view('pages.admin.tools.changeschool',compact('users'));
    }
    //Change School Settng process
    public function changeschool_process(Request $req){
        $valid = Validator::make($req->all(),[
            'UserNum'   => 'required',
            'CharID'    => 'required',
            'school'    => 'required',
            'password'  =>  ['required','min:6','max:19',new ValidatePassword(auth()->user())]
        ]); 
        if($valid->fails()){
            return back()->withErrors($valid);
        }
        if(ChaInfo::where(['ChaNum' => $req->input('CharID')])->count() > 0){
            $char = ChaInfo::where(['ChaNum' => $req->input('CharID')])->first();
            //check if requested school is equal to current school
            if($char->ChaSchool == $req->input('school')){
                return back()->withErrors('You are not allowed to change school at this moment.');
            }
            //check online status
            if($char->ChaOnline === 1){
                return back()->withErrors(['Characted must be offline before you can reborn.']);
            }
            //Check Current Prerequisites & Deduct points
            if(config('app.change_school.currency') == "VP"){
                //Check if user account exist.
                if(UserInfo4::where(['UserNum' => $req->input('UserNum')])->count() <= 0){
                    return back()->withErrors(['User account doesnt exist.Please Try Again.']);
                }
                //Check if user has enough Vote points
                if(UserInfo4::where(['UserNum' => $req->input('UserNum')])->first()->VPoints < config('app.change_school.required_amount')){
                    return back()->withErrors(['User account doesnt have enough Vote Points to proceed in changing school.']);
                }
                //Else, Process the deducting
                UserInfo4::where(['UserNum' => $req->input('UserNum')])->decrement('VPoints',config('app.change_school.required_amount'));
            }else if(config('app.change_school.currency') == "EP"){
                //Check if user account exist.
                if(UserInfo4::where(['UserNum' => $req->input('UserNum')])->count() <= 0){
                    return back()->withErrors(['User account doesnt exist.Please Try Again.']);
                }
                //Check if user has enough E points
                if(UserInfo4::where(['UserNum' => $req->input('UserNum')])->first()->Points < config('app.change_school.required_amount')){
                    return back()->withErrors(['User account doesnt have enough E-Points to proceed in changing school.']);
                }
                //Else, Process the deducting
                UserInfo4::where(['UserNum' => $req->input('UserNum')])->decrement('VPoints',config('app.change_school.required_amount'));
            }else{
                ChaInfo::where(['ChaNum' => $req->input('CharID')])->decrement('ChaMoney',config('app.change_school.required_amount'));
            }
            //Process Changing School
            ChaInfo::where(['ChaNum' => $req->input('CharID')])->update([
                'ChaSchool'         =>  $req->input('school')
            ]);
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully processed the request of changing school for <b>'.$$char->ChaName.'</b>.',
                'remark'        =>  'change_school',
                'ip_address'    => $this->ipaddress()
            ]);
            return back()->with('success','You have successfully processed the request of changing school for <b>'.$$char->ChaName.'</b>.');
        }

    }
    //Change School Process
    public function changeschool_settings_process(Request $req){
        $valid = Validator::make($req->all(),[
            'cs_currency'   => 'required',
            'cs_required'   => 'required',
        ]); 
        if($valid->fails()){
            return back()->withErrors($valid);
        }
        $data = file_get_contents(base_path('.env'));
        $data = explode("\n", $data);
        $data[235] = 'CHANGE_SCHOOL_CURRENCY="'.$req->input('cs_currency').'"';
        $data[236] = 'CHANGE_SCHOOL_REQUIRED_AMOUNT="'.$req->input('cs_required').'"';
        file_put_contents(base_path('.env'),implode("\n",$data));
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully updated the Change School Settings.',
                'remark'        =>  'change_school',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','You have successfully updated the Change School Settings.');
    }

    //Change Class View
    public function changeclass_view(){
        $users = new UserInfo4();
        return view('pages.admin.tools.changeclass',compact('users'));
    }
    //Change Class Setting Process
    public function changeclass_setting_process(Request $req){
        $valid = Validator::make($req->all(),[
            'CHANGE_CLASS_AMOUNT'   =>  'required',
            'CHANGE_CLASS_CURRENCY'   =>  'required'
        ],[
            'CHANGE_CLASS_AMOUNT.required'  =>  'The REQUIRED AMOUNT field is required.',
            'CHANGE_CLASS_CURRENCY.required'  =>  'The CURRENCY field is required.'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid);
        }
        $data = file_get_contents(base_path('.env'));
        $data = explode("\n", $data);
        $data[240] = 'CHANGE_CLASS_AMOUNT="'.$req->input('CHANGE_CLASS_AMOUNT').'"';
        $data[239] = 'CHANGE_CLASS_CURRENCY="'.$req->input('CHANGE_CLASS_CURRENCY').'"';
        file_put_contents(base_path('.env'),implode("\n",$data));
        return back()->with('success','You have successfully updated the Change Class Settings.');
    }
    //Change Class Process
    public function changeclass_process(Request $req){
        $valid = Validator::make($req->all(),[
            'UserNum'   =>  'required',
            'CharID'    =>  'required',
            'class'     =>  'required',
        ]);
        if($valid->fails()){
            return back()->withErrors($valid);
        }
        $userinfo = UserInfo4::with('user_2')->where(['UserNum' => $req->input('UserNum')])->first();
        $charInfo = ChaInfo::where(['ChaNum' => $req->input('CharID')])->first();
        $points = ($userinfo->user_2->count() > 0 ? Points::where(['user_id' => $userinfo->user_2->first()->id])->first() : array() );
        //check if character is online
        if($charInfo->ChaOnline === 1){
            return back()->withErrors(['Please logout the character first.']);
        }
        //check if user is online
        if($userinfo->UserLoginState === 1){
            return back()->withErrors(['Please logout the user account first.']);
        }
        //check what currency to deduct
        if(config('app.change_class.currency') == "VP"){
            if($userinfo->user_2->count() <= 0){
                return back()->withErrors(['This user account doesnt have Vote Points.']);
            }
            if(count($points) != 0 && $points->Vpoints <= config('app.change_class.required_amount')){
                return back()->withErrors(['This user account doesnt have enough Vote Points.']);
            }
            //Deduct Vote Points
            Points::where(['user_id' => $userinfo->user_2->first()->id])->decrement('Vpoints',config('app.change_class.required_amount'));
        }else if(config('app.change_class.currency') == "EP"){
            if($userinfo->user_2->count() <= 0){
                return back()->withErrors(['This user account doesnt have E-Points.']);
            }
            if(count($points) != 0 && $points->points <= config('app.change_class.required_amount')){
                return back()->withErrors(['This user account doesnt have enough Vote Points.']);
            }
            //Deduct E Points
            Points::where(['user_id' => $userinfo->user_2->first()->id])->decrement('points',config('app.change_class.required_amount'));
        }else if(config('app.change_class.currency') == "PP"){
            if($charInfo->ChaPremiumPoint <= config('app.change_class.required_amount')){
                return back()->withErrors(['This user account doesnt have enough Premium Points.']);
            }
            //Deduct Premium Points
            ChaInfo::where(['ChaNum' => $req->input('CharID')])->decrement('ChaPremiumPoint',config('app.change_class.required_amount'));
        }else{
            if($charInfo->ChaMoney <= config('app.change_class.required_amount')){
                return back()->withErrors(['This user account doesnt have enough In-Game Gold.']);
            }
            //Deduct Gold Points
            ChaInfo::where(['ChaNum' => $req->input('CharID')])->decrement('ChaMoney',config('app.change_class.required_amount'));
        }
        //check if current class is same as class he/she wanted to change
        if($charInfo->ChaClass === $req->input('class')){
            return back()->withErrors(['You cant transfer this character in the same class.']);
        }
        //define if what class he wanted to be
        if($req->input('class') == 256 || $req->input('class') == 4){
            //ARCHER
            $skills = config('app.change_class.change_class_archer');
            $slot   =   "0x01010000040000001E000000FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF0000";
        }else if($req->input('class') == 1 || $req->input('class') == 64){
            //BRAWLER
            $skills = config('app.change_class.change_class_brawler');
            $slot = "0x01010000040000001E000000FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF0000";
        }else if($req->input('class') == 2 || $req->input('class') == 128){
            //SWORDSMAN
            $skills = config('app.change_class.change_class_swordsman');
            $slot = "0x01010000040000001E000000FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF0000";
        }else if($req->input('class') == 512 || $req->input('class') == 8){
            //SHAMAN
            $skills = config('app.change_class.change_class_shaman');
            $slot = "0x01010000040000001E000000FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF0000";
        }else{
            //GUNNER
            $skills = config('app.change_class.change_class_gunner');
            $slot = "0x01010000040000001E000000FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF0000";
        }
        //Process CHanging Class        
        $char = ChaInfo::find($req->input('CharID'));
        $char->update([
            'ChaClass'      =>  $req->input('class'),
            'ChaSkills'     =>  \DB::raw("CONVERT(VARBINARY(MAX), $skills) "),
            'ChaSkillslot'  =>  \DB::raw("CONVERT(VARBINARY(MAX), $slot) "),
            'ChaSkillPoint' =>  399
        ]);
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully processed the changing class for <b>'.$char->ChaName.'</b>.',
                'remark'        =>  'change_class',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','You have successfully processed the changing class for <b>'.$char->ChaName.'</b>.');
    }

    //Max reborn reward view
    public function maxrbreward_view(){
        $users = new UserInfo4();
        return view('pages.admin.tools.maxrbreward',compact('users'));
    }
    //Max reborn reward process
    public function maxrbreward_process(Request $req){
        $valid = Validator::make($req->all(),[
            'UserNum'   =>  'required',
            'CharID'    =>  'required'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid);
        }
        $chainfo = ChaInfo::findOrFail($req->input('CharID'));
        //check if character is online
        if($chainfo->ChaOnline == 1){
            return back()->withErrors(['Character must be offline.']);
        }
        //check max reborn requirement
        if(config('app.reborn.5.status') == 1){
            $maxReborn = config('app.reborn.5.to');
        }else if(config('app.reborn.4.status') == 1){
            $maxReborn = config('app.reborn.4.to');
        }else if(config('app.reborn.3.status') == 1){
            $maxReborn = config('app.reborn.3.to');
        }else if(config('app.reborn.2.status') == 1){
            $maxReborn = config('app.reborn.2.to');
        }else{
            $maxReborn = config('app.reborn.1.to');
        }
        //check reborn count of character
        if($chainfo->ChaReborn < $maxReborn-1){
            return back()->withErrors(['This character doesnt have enough reborn to claim a reward.']);
        }
        //categorize level
        if($chainfo->ChaLevel > 499 && $chainfo->ChaLevel < 700){
            $column = "ChaReward1";
            $plus = "2000";
            $reward = 1;
        }else{
            $column = "ChaReward2";
            $plus = "500";
            $reward = 2;
        }
        if($reward == 1 && $chainfo->ChaLevel <= 499){
            return back()->withErrors(['This character doesnt have enough level to claim a reward for RB 100, LvL 500.']);   
        }
        if($reward == 2 && $chainfo->ChaLevel <= 699){
            return back()->withErrors(['This character doesnt have enough level to claim a reward for RB 100, LvL 700.']);   
        }
        if($reward == 1 && $chainfo->ChaReward1 >= 1){
            return back()->withErrors(['This character was already rewarded in Max Reborn with Level Requirement of 500.']);
        }
        if($reward == 2 && $chainfo->ChaReward2 >= 1){
            return back()->withErrors(['This character was already rewarded in Max Reborn with Level Requirement of 700.']);
        }
        //process reward
        ChaInfo::where(['ChaNum' => $req->input('CharID')])->increment('ChaPremiumPoint',$plus);
        ChaInfo::where(['ChaNum' => $req->input('CharID')])->increment($column,1);
        UserInfo4::where(['UserNum' => $req->input('UserNum')])->increment($column,1);
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully claimed the reward '.$reward.' for <b>'.$chainfo->ChaName.'</b>.',
                'remark'        =>  'maxrbreward',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','You have successfully claimed the reward '.$reward.' for <b>'.$chainfo->ChaName.'</b>.');
    }

    //PK Points Reset View
    public function pkreset_view(){
        $users = new UserInfo4();
        return view('pages.admin.tools.pkreset',compact('users'));
    }
    //PK Points Reset Setting Process
    public function pkreset_setting_process(Request $req){
        $valid = Validator::make($req->all(),[
            'PK_POINTS_AMOUNT'      =>  'required',
            'PK_POINTS_CURRENCY'    =>  'required'
        ],[
            'PK_POINTS_AMOUNT.required'  =>  'The REQUIRED AMOUNT field is required.',
            'PK_POINTS_CURRENCY.required'  =>  'The CURRENCY field is required.'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid);
        }
        $data = file_get_contents(base_path('.env'));
        $data = explode("\n", $data);
        $data[248] = 'PK_POINTS_CURRENCY="'.$req->input('PK_POINTS_CURRENCY').'"';
        $data[249] = 'PK_POINTS_AMOUNT="'.$req->input('PK_POINTS_AMOUNT').'"';
        file_put_contents(base_path('.env'),implode("\n",$data));
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully updated the PK Points Reset Settings.',
                'remark'        =>  'pkpointsreset',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','You have successfully updated the PK Points Reset Settings.');
    }
    //PK Points Reset Process
    public function pkreset_process(Request $req){
        $valid = Validator::make($req->all(),[
            'UserNum'   =>  'required',
            'CharID'    =>  'required'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid);
        }
        $userinfo = UserInfo4::with('user_2')->where(['UserNum' => $req->input('UserNum')])->first();
        $charInfo = ChaInfo::where(['ChaNum' => $req->input('CharID')])->first();
        $points = ($userinfo->user_2->count() > 0 ? Points::where(['user_id' => $userinfo->user_2->first()->id])->first() : array() );
        //check if character is online
        if($charInfo->ChaOnline === 1){
            return back()->withErrors(['Please logout the character first.']);
        }
        //check if user is online
        if($userinfo->UserLoginState === 1){
            return back()->withErrors(['Please logout the user account first.']);
        }
        //check what currency to deduct
        if(config('app.pk_points.currency') == "VP"){
            if($userinfo->user_2->count() <= 0){
                return back()->withErrors(['This user account doesnt have Vote Points.']);
            }
            if(count($points) != 0 && $points->Vpoints <= config('app.pk_points.required_amount')){
                return back()->withErrors(['This user account doesnt have enough Vote Points.']);
            }
            //Deduct Vote Points
            Points::where(['user_id' => $userinfo->user_2->first()->id])->decrement('Vpoints',config('app.pk_points.required_amount'));
        }else if(config('app.pk_points.currency') == "EP"){
            if($userinfo->user_2->count() <= 0){
                return back()->withErrors(['This user account doesnt have E-Points.']);
            }
            if(count($points) != 0 && $points->points <= config('app.pk_points.required_amount')){
                return back()->withErrors(['This user account doesnt have enough Vote Points.']);
            }
            //Deduct E Points
            Points::where(['user_id' => $userinfo->user_2->first()->id])->decrement('points',config('app.pk_points.required_amount'));
        }else if(config('app.pk_points.currency') == "PP"){
            if($charInfo->ChaPremiumPoint <= config('app.pk_points.required_amount')){
                return back()->withErrors(['This user account doesnt have enough Premium Points.']);
            }
            //Deduct Premium Points
            ChaInfo::where(['ChaNum' => $req->input('CharID')])->decrement('ChaPremiumPoint',config('app.pk_points.required_amount'));
        }else{
            if($charInfo->ChaMoney <= config('app.pk_points.required_amount')){
                return back()->withErrors(['This user account doesnt have enough In-Game Gold.']);
            }
            //Deduct Gold Points
            ChaInfo::where(['ChaNum' => $req->input('CharID')])->decrement('ChaMoney',config('app.pk_points.required_amount'));
        }
        //CHeck characters bright
        if($charInfo->ChaBright > 1){
            return back()->withErrors(['<b>'.$charInfo->ChaName.'</b> Need less than 0 PK Points.']);
        }
        //PK Points Reset Process
        ChaInfo::where(['ChaNum' => $req->input('CharID')])->increment('ChaBright',20);
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully reset the pk points of <b>'.$charInfo->ChaName.'</b>.',
                'remark'        =>  'pkpointsreset',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','You have successfully reset the pk points of <b>'.$charInfo->ChaName.'</b>.');
    }

    //STATISTICAL POINTS VIEW
    public function statsreset_view(){
        $users = new UserInfo4();
        return view('pages.admin.tools.statsreset',compact('users'));
    }
    //STATISTICAL POINTS RESET SETTING PROCESS
    public function statsreset_setting_process(Request $req){
        $valid = Validator::make($req->all(),[
            'STATISTICAL_POINTS_AMOUNT'      =>  'required',
            'STATISTICAL_POINTS_CURRENCY'    =>  'required'
        ],[
            'STATISTICAL_POINTS_AMOUNT.required'  =>  'The REQUIRED AMOUNT field is required.',
            'STATISTICAL_POINTS_CURRENCY.required'  =>  'The CURRENCY field is required.'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid);
        }
        $data = file_get_contents(base_path('.env'));
        $data = explode("\n", $data);
        $data[252] = 'STATISTICAL_POINTS_CURRENCY="'.$req->input('STATISTICAL_POINTS_CURRENCY').'"';
        $data[253] = 'STATISTICAL_POINTS_AMOUNT="'.$req->input('STATISTICAL_POINTS_AMOUNT').'"';
        file_put_contents(base_path('.env'),implode("\n",$data));
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully updated the STATISTICAL Points Reset Settings.',
                'remark'        =>  'statsreset',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','You have successfully updated the STATISTICAL Points Reset Settings.');
    }
    //STATISTICAL POINTS RESET PROCESS
    public function statsreset_process(Request $req){
        $valid = Validator::make($req->all(),[
            'UserNum'   =>  'required',
            'CharID'    =>  'required'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid);
        }
        $userinfo = UserInfo4::with('user_2')->where(['UserNum' => $req->input('UserNum')])->first();
        $charInfo = ChaInfo::where(['ChaNum' => $req->input('CharID')])->first();
        $points = ($userinfo->user_2->count() > 0 ? Points::where(['user_id' => $userinfo->user_2->first()->id])->first() : array() );
        //check if character is online
        if($charInfo->ChaOnline === 1){
            return back()->withErrors(['Please logout the character first.']);
        }
        //check if user is online
        if($userinfo->UserLoginState === 1){
            return back()->withErrors(['Please logout the user account first.']);
        }
        //check default max reborn
        if(config('app.reborn.5.status') == 1){
            $maxReborn = config('app.reborn.5.to');
        }else if(config('app.reborn.4.status') == 1){
            $maxReborn = config('app.reborn.4.to');
        }else if(config('app.reborn.3.status') == 1){
            $maxReborn = config('app.reborn.3.to');
        }else if(config('app.reborn.2.status') == 1){
            $maxReborn = config('app.reborn.2.to');
        }else{
            $maxReborn = config('app.reborn.1.to');
        }
        //check if character has max reborn
        if($maxReborn > $charInfo->ChaReborn){
            return back()->withErrors(['<b>'.$charInfo->ChaName.'</b> doesnt have max reborn.']);
        }
        //check if character has max level
        if($charInfo->ChaLevel <= 699){
            return back()->withErrors(['<b>'.$charInfo->ChaName.'</b> doesnt have max level.']);
        }
        //check what currency to deduct
        if(config('app.stats_points.currency') == "VP"){
            if($userinfo->user_2->count() <= 0){
                return back()->withErrors(['This user account doesnt have Vote Points.']);
            }
            if(count($points) != 0 && $points->Vpoints <= config('app.stats_points.required_amount')){
                return back()->withErrors(['This user account doesnt have enough Vote Points.']);
            }
            //Deduct Vote Points
            Points::where(['user_id' => $userinfo->user_2->first()->id])->decrement('Vpoints',config('app.stats_points.required_amount'));
        }else if(config('app.stats_points.currency') == "EP"){
            if($userinfo->user_2->count() <= 0){
                return back()->withErrors(['This user account doesnt have E-Points.']);
            }
            if(count($points) != 0 && $points->points <= config('app.stats_points.required_amount')){
                return back()->withErrors(['This user account doesnt have enough Vote Points.']);
            }
            //Deduct E Points
            Points::where(['user_id' => $userinfo->user_2->first()->id])->decrement('points',config('app.stats_points.required_amount'));
        }else if(config('app.stats_points.currency') == "PP"){
            if($charInfo->ChaPremiumPoint <= config('app.stats_points.required_amount')){
                return back()->withErrors(['This user account doesnt have enough Premium Points.']);
            }
            //Deduct Premium Points
            ChaInfo::where(['ChaNum' => $req->input('CharID')])->decrement('ChaPremiumPoint',config('app.stats_points.required_amount'));
        }else{
            if($charInfo->ChaMoney <= config('app.stats_points.required_amount')){
                return back()->withErrors(['This user account doesnt have enough In-Game Gold.']);
            }
            //Deduct Gold Points
            ChaInfo::where(['ChaNum' => $req->input('CharID')])->decrement('ChaMoney',config('app.stats_points.required_amount'));
        }
        //process stats reset
        $char->ChaStRemain = (3*$char->ChaLevel);
        $char = $char->save();
        $char = ChaInfo::find($req->input('CharID'));
        $multiSRR = $charInfo->ChaStRemain * $charInfo->ChaReborn;
        ChaInfo::where(['ChaNum' => $req->input('CharID')])->update([
            'ChaPower'      =>  0,
            'ChaDex'        =>  0,
            'ChaSpirit'     =>  0,
            'ChaStrength'   =>  0,
            'ChaIntel'      =>  0,
            'ChaStrong'     =>  0,
            'ChaStRemain'   =>  '51800'
        ]);
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully processed the Statistical Points Reset for Character <b>'.$charInfo->ChaName.'</b>.',
                'remark'        =>  'statsreset',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','You have successfully processed the Statistical Points Reset for Character <b>'.$charInfo->ChaName.'</b>.');

    }
}
