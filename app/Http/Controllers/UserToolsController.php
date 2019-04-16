<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CaptureIpTrait;
use App\Models\RanGame1\ChaInfo;
use App\Models\RanUser\UserInfo4;
use App\Rules\ValidatePassword;
use App\Models\Points;
use App\Models\User;
use App\Models\Timeline;
use App\Models\VoteTopSite;
use App\Models\VoteLog;
use App\Models\TopUp;
use App\Traits\CaptchaTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use Auth;
use Input;

class UserToolsController extends Controller
{
    use CaptchaTrait;

	public function ipaddress(){
		$ip = new CaptureIpTrait();
		return $ip->getClientIp();
	}

	//REBORN SYSTEM VIEW
    public function reborn_view(){
    	if(config('app.reborn_system') != 1){
    		return redirect('home')->with('error','Reborn system is currently disabled by default.');
    	}
    	$char = Auth::user()->userinfo4()->first()->chainfo3();
    	return view('pages.user.tools.reborn.view',compact('char'));
    }
    //REBORN SYSTEM PROCESS
    public function reborn_process(Request $req){
    	$valid = Validator::make($req->all(),[
    		'ChaID'		=> 	'required',
    		'password'	=> ['required','max:20','min:6',new ValidatePassword(auth()->user())]
    	],[
    		'ChaID.required'	=>	'The Character ID must be set to proceed.'
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
    	}
    	//check if character id exist
    	if(ChaInfo::where(['ChaNum' => $req->input('ChaID')])->count() <= 0){
    		return back()->withErrors(['Character ID Doesnt exist.'])->withInput();
    	}
    	//check if character is belong to current user
    	if(ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->count() <= 0){
    		return back()->withErrors(['You are not allowed to update a character that doesnt belong to you!.'])->withInput();
    	}
    	//Declare chainfo
    	$char = ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->first();
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
    	if($maxReborn == $char->ChaReborn){
   			return back()->withErrors(['This Character was already have a max reborn.']);
   		}
        //Check if account is online 
        if(Auth::user()->userinfo4()->first()->UserLoginState == 1){
            return back()->withErrors(['Your account must be offline.'])->withInput();
        }
   		//check online status
   		if($char->ChaOnline == 1){
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
            $char = ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->first();
            //$multiSRR = $char->ChaStRemain * $char->ChaReborn;
   			$multiSRR = ($char->ChaStRemain * $rebornInc) + 300;
   			//update character info
   			$char->ChaLevel = 100;
   			$char->ChaPower = 0;
   			$char->ChaDex	= 0;
   			$char->ChaSpirit	= 0;
   			$char->ChaStrength	= 0;
   			$char->ChaExp		= 0;
   			$char->ChaIntel		= 0;
   			$char->ChaStrong	= 0;
   			$char->ChaReborn 	= $rebornInc;
   			$char->ChaSkillPoint	= $remainSkill;
   			$char->ChaRebornDate 	= \Carbon\Carbon::now();
   			$char->ChaStRemain 	= $multiSRR;
            $char->ChaOnline = 0;
   			$char->save();
            Auth::user()->userinfo4()->update([
                'UserLoginState' => 0
            ]);
            $char = ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->first();
   			Auth::user()->timeline()->create([
   				'content'		=> 	'You have successfully reborn <b>'.$char->ChaName.'</b>.',
   				'remark'		=>	'reborn',
   				'ip_address'	=> $this->ipaddress()
   			]);
    		return back()->with('success','You have successfully reborn <b>'.$char->ChaName.'</b>.');
    	}else{
    		return back()->withErrors(['Reborn was failed. Please contact our support.']);
    	}
    }

    //CHANGE SCHOOL VIEW
    public function changeschool_view(){
    	$char = Auth::user()->userinfo4()->first()->chainfo3();
    	return view('pages.user.tools.changeschool.view',compact('char'));
    }
    //CHANGE SCHOOL PROCESS
    public function changeschool_process(Request $req){
        $valid = Validator::make($req->all(),[
            'ChaID'    => 'required',
            'school'    => 'required',
            'password'  =>  ['required','min:6','max:19',new ValidatePassword(auth()->user())]
        ]); 
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
    	//check if character id exist
    	if(ChaInfo::where(['ChaNum' => $req->input('ChaID')])->count() <= 0){
    		return back()->withErrors(['Character ID Doesnt exist.'])->withInput();
    	}
    	//check if character is belong to current user
    	if(ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->count() <= 0){
    		return back()->withErrors(['You are not allowed to update a character that doesnt belong to you!.'])->withInput();
    	}
    	//Declare chainfo
    	$char = ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->first();
    	//check if requested school is equal to current school
    	if($char->ChaSchool == $req->input('school')){
    		return back()->withErrors(['You are not allowed to transfer in school where you are already in.']);
    	}
    	//check if character is online
    	if($char->ChaOnline == 1){
    		return back()->withErrors(['Your character must be offline.'])->withInput();
    	}
    	//Check if account is online 
    	if(Auth::user()->userinfo4()->first()->UserLoginState == 1){
    		return back()->withErrors(['Your account must be offline.'])->withInput();
    	}
        //Check Current Prerequisites & Deduct points
        if(config('app.change_school.currency') == "VP"){
            if(Auth::user()->points()->first()->Vpoints < config('app.change_school.required_amount')){
            	return back()->withErrors(['You dont have enought vote points on your account.'])->withInput();
            }
            Auth::user()->points()->decrement('Vpoints',config('app.change_school.required_amount'));
        }else if(config('app.change_school.currency') == "EP"){
            if(Auth::user()->points()->first()->points < config('app.change_school.required_amount')){
            	return back()->withErrors(['You dont have enought E-points on your account.'])->withInput();
            }
            Auth::user()->points()->decrement('points',config('app.change_school.required_amount'));
        }else{
        	if($char->ChaMoney < config('app.pk_points.required_amount')){
            	return back()->withErrors(['You dont have enought In-Game Gold on your Character.'])->withInput();
        	}
            ChaInfo::where(['ChaNum' => $req->input('ChaID')])->decrement('ChaMoney',config('app.change_school.required_amount'));
        }
        //change school proceed
        ChaInfo::where(['ChaNum' => $req->input('ChaID')])->update([
            'ChaSchool'         =>  $req->input('school')
        ]);
   		Auth::user()->timeline()->create([
   			'content'		=> 	'You have successfully processed the request of changing school of <b>'.$char->ChaName.'</b>.',
   			'remark'		=>	'change_school',
 			'ip_address'	=> $this->ipaddress()
   		]);
        return back()->with('success','You have successfully processed the request of changing school of <b>'.$char->ChaName.'</b>.');
    }

    //CHANGE CLASS VIEW
    public function changeclass_view(){
    	$char = Auth::user()->userinfo4()->first()->chainfo3();
    	return view('pages.user.tools.changeclass.view',compact('char'));
    }
    //CHANGE CLASS PROCESS
    public function changeclass_process(Request $req){
        $valid = Validator::make($req->all(),[
            'ChaID'    => 'required',
            'class'    => 'required',
            'password'  =>  ['required','min:6','max:19',new ValidatePassword(auth()->user())]
        ]); 
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
    	//check if character id exist
    	if(ChaInfo::where(['ChaNum' => $req->input('ChaID')])->count() <= 0){
    		return back()->withErrors(['Character ID Doesnt exist.'])->withInput();
    	}
    	//check if character is belong to current user
    	if(ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->count() <= 0){
    		return back()->withErrors(['You are not allowed to update a character that doesnt belong to you!.'])->withInput();
    	}
    	//Declare chainfo
    	$char = ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->first();
    	//check if requested class is equal to current class
    	if($char->ChaClass == $req->input('class')){
    		return back()->withErrors(['You are not allowed to transfer in class where you are already in.']);
    	}
    	//check if character is online
    	if($char->ChaOnline == 1){
    		return back()->withErrors(['Your character must be offline.'])->withInput();
    	}
    	//Check if account is online 
    	if(Auth::user()->userinfo4()->first()->UserLoginState == 1){
    		return back()->withErrors(['Your account must be offline.'])->withInput();
    	}
        //Check Current Prerequisites & Deduct points
        if(config('app.change_class.currency') == "VP"){
            if(Auth::user()->points()->first()->Vpoints < config('app.change_class.required_amount')){
            	return back()->withErrors(['You dont have enought vote points on your account.'])->withInput();
            }
            Auth::user()->points()->decrement('Vpoints',config('app.change_class.required_amount'));
        }else if(config('app.change_class.currency') == "EP"){
            if(Auth::user()->points()->first()->points < config('app.change_class.required_amount')){
            	return back()->withErrors(['You dont have enought E-points on your account.'])->withInput();
            }
            Auth::user()->points()->decrement('points',config('app.change_class.required_amount'));
        }else{
        	if($char->ChaMoney < config('app.pk_points.required_amount')){
            	return back()->withErrors(['You dont have enought In-Game Gold on your Character.'])->withInput();
        	}
            ChaInfo::where(['ChaNum' => $req->input('ChaID')])->decrement('ChaMoney',config('app.change_class.required_amount'));
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
        $char = ChaInfo::find($req->input('ChaID'));
        $char->update([
            'ChaClass'      =>  $req->input('class'),
            'ChaSkills'     =>  \DB::raw("CONVERT(VARBINARY(MAX), $skills) "),
            'ChaSkillslot'  =>  \DB::raw("CONVERT(VARBINARY(MAX), $slot) "),
            'ChaSkillPoint' =>  399
        ]);
   		Auth::user()->timeline()->create([
   			'content'		=> 	'You have successfully processed the changing class of <b>'.$char->ChaName.'</b>.',
   			'remark'		=>	'change_class',
 			'ip_address'	=> $this->ipaddress()
   		]);
        return back()->with('success','You have successfully processed the changing class of <b>'.$char->ChaName.'</b>.');
    }


    //MAX REBORN REWARD VIEW
    public function maxrbreward_view(){
    	$char = Auth::user()->userinfo4()->first()->chainfo3();
    	return view('pages.user.tools.maxrbreward.view',compact('char'));
    }
    //MAX REBORN REWARD PROCESS
    public function maxrbreward_process(Request $req){
        $valid = Validator::make($req->all(),[
            'ChaID'    => 'required',
            'password'  =>  ['required','min:6','max:19',new ValidatePassword(auth()->user())]
        ]); 
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
    	//check if character id exist
    	if(ChaInfo::where(['ChaNum' => $req->input('ChaID')])->count() <= 0){
    		return back()->withErrors(['Character ID Doesnt exist.'])->withInput();
    	}
    	//check if character is belong to current user
    	if(ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->count() <= 0){
    		return back()->withErrors(['You are not allowed to update a character that doesnt belong to you!.'])->withInput();
    	}
    	//Check if account is online 
    	if(Auth::user()->userinfo4()->first()->UserLoginState == 1){
    		return back()->withErrors(['Your account must be offline.'])->withInput();
    	}
    	//Declare chainfo
    	$char = ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->first();
    	//check if character is online
    	if($char->ChaOnline == 1){
    		return back()->withErrors(['Your character must be offline.'])->withInput();
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
        if($char->ChaReborn < $maxReborn-1){
            return back()->withErrors(['This character doesnt have enough reborn to claim a reward.']);
        }
        //categorize level
        if($char->ChaLevel > 499 && $char->ChaLevel < 700){
            $column = "ChaReward1";
            $plus = "2000";
            $reward = 1;
        }else{
            $column = "ChaReward2";
            $plus = "500";
            $reward = 2;
        }
        if($reward == 1 && $char->ChaLevel <= 499){
            return back()->withErrors(['This character doesnt have enough level to claim a reward for RB 100, LvL 500.']);   
        }
        if($reward == 2 && $char->ChaLevel <= 699){
            return back()->withErrors(['This character doesnt have enough level to claim a reward for RB 100, LvL 700.']);   
        }
        if($reward == 1 && $char->ChaReward1 >= 1){
            return back()->withErrors(['This character was already rewarded in Max Reborn with Level Requirement of 500.']);
        }
        if($reward == 2 && $char->ChaReward2 >= 1){
            return back()->withErrors(['This character was already rewarded in Max Reborn with Level Requirement of 700.']);
        }
        //process reward
        ChaInfo::where(['ChaNum' => $req->input('ChaID')])->increment('ChaPremiumPoint',$plus);
        ChaInfo::where(['ChaNum' => $req->input('ChaID')])->increment($column,1);
        UserInfo4::where(['UserNum' => $req->input('UserNum')])->increment($column,1);
   		Auth::user()->timeline()->create([
   			'content'		=> 	'You have successfully claimed the reward '.$reward.' for <b>'.$char->ChaName.'</b>.',
   			'remark'		=>	'maxrbreward',
 			'ip_address'	=> $this->ipaddress()
   		]);
        return back()->with('success','You have successfully claimed the reward '.$reward.' for <b>'.$char->ChaName.'</b>.');
    }

    //PK POINTS RESET VIEW
    public function pkreset_view(){
    	$char = Auth::user()->userinfo4()->first()->chainfo3();
    	return view('pages.user.tools.pkreset.view',compact('char'));
    }
    //PK POINTS RESET PROCESS
    public function pkreset_process(Request $req){
        $valid = Validator::make($req->all(),[
            'ChaID'    => 'required',
            'password'  =>  ['required','min:6','max:19',new ValidatePassword(auth()->user())]
        ]); 
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
    	//check if character id exist
    	if(ChaInfo::where(['ChaNum' => $req->input('ChaID')])->count() <= 0){
    		return back()->withErrors(['Character ID Doesnt exist.'])->withInput();
    	}
    	//check if character is belong to current user
    	if(ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->count() <= 0){
    		return back()->withErrors(['You are not allowed to update a character that doesnt belong to you!.'])->withInput();
    	}
    	//Check if account is online 
    	if(Auth::user()->userinfo4()->first()->UserLoginState == 1){
    		return back()->withErrors(['Your account must be offline.'])->withInput();
    	}
    	//Declare chainfo
    	$char = ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->first();
    	//check if character is online
    	if($char->ChaOnline == 1){
    		return back()->withErrors(['Your character must be offline.'])->withInput();
    	}
        //CHeck characters bright
        if($char->ChaBright > 1){
            return back()->withErrors(['<b>'.$char->ChaName.'</b> Need less than 0 PK Points. Which is currently it has <b>'.$char->ChaBright.' PK Points.</b>']);
        }
        //Check Current Prerequisites & Deduct points
        if(config('app.pk_points.currency') == "VP"){
            if(Auth::user()->points()->first()->Vpoints < config('app.pk_points.required_amount')){
            	return back()->withErrors(['You dont have enought vote points on your account.'])->withInput();
            }
            Auth::user()->points()->decrement('Vpoints',config('app.pk_points.required_amount'));
        }else if(config('app.pk_points.currency') == "EP"){
            if(Auth::user()->points()->first()->points < config('app.pk_points.required_amount')){
            	return back()->withErrors(['You dont have enought E-points on your account.'])->withInput();
            }
            Auth::user()->points()->decrement('points',config('app.pk_points.required_amount'));
        }else if(config('app.pk_points.currency') == "PP"){
        	if($char->ChaMoney < config('app.pk_points.required_amount')){
            	return back()->withErrors(['You dont have enought Premium Points on your Character.'])->withInput();
        	}
            ChaInfo::where(['ChaNum' => $req->input('ChaID')])->decrement('ChaPremiumPoint',config('app.pk_points.required_amount'));
        }else{
        	if($char->ChaMoney < config('app.pk_points.required_amount')){
            	return back()->withErrors(['You dont have enought In-Game Gold on your Character.'])->withInput();
        	}
            ChaInfo::where(['ChaNum' => $req->input('ChaID')])->decrement('ChaMoney',config('app.pk_points.required_amount'));
        }
        //PK Points Reset Process
        ChaInfo::where(['ChaNum' => $req->input('ChaID')])->increment('ChaBright',20);
   		Auth::user()->timeline()->create([
   			'content'		=> 	'You have successfully reset the pk points of <b>'.$char->ChaName.'</b>.',
   			'remark'		=>	'pkpointsreset',
 			'ip_address'	=> $this->ipaddress()
   		]);
        return back()->with('success','You have successfully reset the pk points of <b>'.$char->ChaName.'</b>.');
    }


    //STATS POINTS RESET VIEW
    public function statsreset_view(){
    	$char = Auth::user()->userinfo4()->first()->chainfo3();
    	return view('pages.user.tools.statsreset.view',compact('char'));
    }
    //STATS POINTS RESET PROCESS
    public function statsreset_process(Request $req){
        $valid = Validator::make($req->all(),[
            'ChaID'    => 'required',
            'password'  =>  ['required','min:6','max:19',new ValidatePassword(auth()->user())]
        ]); 
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
    	//check if character id exist
    	if(ChaInfo::where(['ChaNum' => $req->input('ChaID')])->count() <= 0){
    		return back()->withErrors(['Character ID Doesnt exist.'])->withInput();
    	}
    	//check if character is belong to current user
    	if(ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->count() <= 0){
    		return back()->withErrors(['You are not allowed to update a character that doesnt belong to you!.'])->withInput();
    	}
    	//Check if account is online 
    	if(Auth::user()->userinfo4()->first()->UserLoginState == 1){
    		return back()->withErrors(['Your account must be offline.'])->withInput();
    	}
    	//Declare chainfo
    	$char = ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->first();
    	//check if character is online
    	if($char->ChaOnline == 1){
    		return back()->withErrors(['Your character must be offline.'])->withInput();
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
        if($maxReborn > $char->ChaReborn){
            return back()->withErrors(['<b>'.$char->ChaName.'</b> doesnt have max reborn.']);
        }
        //check if character has max level
        if($char->ChaLevel <= 699){
            return back()->withErrors(['<b>'.$char->ChaName.'</b> doesnt have max level.']);
        }
        //Check Current Prerequisites & Deduct points
        if(config('app.stats_points.currency') == "VP"){
            if(Auth::user()->points()->first()->Vpoints < config('app.stats_points.required_amount')){
            	return back()->withErrors(['You dont have enought vote points on your account.'])->withInput();
            }
            Auth::user()->points()->decrement('Vpoints',config('app.stats_points.required_amount'));
        }else if(config('app.stats_points.currency') == "EP"){
            if(Auth::user()->points()->first()->points < config('app.stats_points.required_amount')){
            	return back()->withErrors(['You dont have enought E-points on your account.'])->withInput();
            }
            Auth::user()->points()->decrement('points',config('app.stats_points.required_amount'));
        }else if(config('app.stats_points.currency') == "PP"){
        	if($char->ChaPremiumPoint < config('app.stats_points.required_amount')){
            	return back()->withErrors(['You dont have enought Premium Points on your Character.'])->withInput();
        	}
            ChaInfo::where(['ChaNum' => $req->input('ChaID')])->decrement('ChaPremiumPoint',config('app.stats_points.required_amount'));
        }else{
        	if($char->ChaMoney < config('app.stats_points.required_amount')){
            	return back()->withErrors(['You dont have enought In-Game Gold on your Character.'])->withInput();
        	}
            ChaInfo::where(['ChaNum' => $req->input('ChaID')])->decrement('ChaMoney',config('app.stats_points.required_amount'));
        }
        //process stats reset
        $char->ChaStRemain = (3*$char->ChaLevel);
        $char = $char->save();
        $char = ChaInfo::find($req->input('ChaID'));
        $multiSRR = $char->ChaStRemain * $char->ChaReborn;
        ChaInfo::where(['ChaNum' => $req->input('ChaID')])->update([
            'ChaPower'      =>  0,
            'ChaDex'        =>  0,
            'ChaSpirit'     =>  0,
            'ChaStrength'   =>  0,
            'ChaIntel'      =>  0,
            'ChaStrong'     =>  0,
            'ChaStRemain'   =>  '51800'
        ]);
   		Auth::user()->timeline()->create([
   			'content'		=> 	'You have successfully processed the Statistical Points Reset for Character <b>'.$char->ChaName.'</b>.',
   			'remark'		=>	'statsreset',
 			'ip_address'	=> $this->ipaddress()
   		]);
        return back()->with('success','You have successfully processed the Statistical Points Reset for Character <b>'.$char->ChaName.'</b>.');
    }

    //VOTING SYSTEM VIEW
    public function vote_view(){
        $topsites = new VoteTopSite();
        return view('pages.user.vote.index',compact('topsites'));
    }
    //VOTING SYSTEM VOTE NOW PROCESS
    public function vote_now_process($id,Request $req){
        try{
            $ts = VoteTopSite::findOrFail($id);
            try{
                $userlog = VoteLog::where(['user_id' => Auth::user()->id])->where(['vote_site_id' => $id])->orderBy('id','desc')->firstOrFail();
                //return $userlog;
                $exp = (strtotime($userlog->created_at) + (60 * 60 * 12));
                if(time() < $exp){
                    return back()->with('error','Sorry but you are not allowed yet to vote <b>'.$ts->title.'</b> at this time. Please try again on <b>'.date('M d,Y h:i A',$exp).'</b>. Thank you!.');
                }
                //add vote log
                Auth::user()->votelog()->create([
                    'vote_site_id'      => $id,
                    'ip_address'        => $this->ipaddress()
                ]);
                //add 5 vote points to user
                Auth::user()->points()->increment('Vpoints',50);
                //add timeline content
                Auth::user()->timeline()->create([
                    'content'       =>  'You have successfully voted our site in <b>'.$ts->title.'</b>. Thank you!.',
                    'remark'        =>  'votepage',
                    'ip_address'    => $this->ipaddress()
                ]);
                $msg = 'You have successfully voted our site in <b>'.$ts->title.'</b> and earned <b>50 vote points</b>. Thank you!. You are now being redirected to '.$ts->title.' site in 5 seconds.<script> setTimeout(function() { location.href="'.$ts->link.'"; },5000); </script>';
                return view('pages.user.vote.redirect',compact('msg'));
            }catch(ModelNotFoundException $e){
                //add vote log
                Auth::user()->votelog()->create([
                    'vote_site_id'      => $id,
                    'ip_address'        => $this->ipaddress()
                ]);
                //add 5 vote points to user
                Auth::user()->points()->increment('Vpoints',5);
                //add timeline content
                Auth::user()->timeline()->create([
                    'content'       =>  'You have successfully voted our site in <b>'.$ts->title.'</b>. Thank you!.',
                    'remark'        =>  'votepage',
                    'ip_address'    => $this->ipaddress()
                ]);
                $msg = 'You have successfully voted our site in <b>'.$ts->title.'</b> and earned <b>5 vote points</b>. Thank you!. You are now being redirected to '.$ts->title.' site in 5 seconds.<script> setTimeout(function() { location.href="'.$ts->link.'"; },5000); </script>';
                return view('pages.user.vote.redirect',compact('msg'));
            }
        }catch(ModelNotFoundException $e){
            return back()->with('error','You clicked on something that doesnt exists in our record.');
        }
    }

    //ACCOUNT FIX VIEW
    public function accountfix_view(){
        return view('pages.user.tools.accountfix');
    }
    //ACCOUNT FIX PROCESS
    public function accountfix_process(Request $req){
        if(Auth::guest()){
            return back();
        }else{
            $req->merge(['captcha' => $this->captchaCheck()]);
            if (!config('settings.reCaptchStatus')) {
                $req->merge(['captcha' => true]);
            }
            $valid = Validator::make($req->input(),[
                'captcha' => 'required|min:1'
            ]);
            if($valid->fails()){
                return back()->withErrors($valid)->withInput();
            }
            $user = Auth::user();
            $user->userinfo4()->update([
                'UserLoginState'    =>  0
            ]);
            return back()->with('success','You have successfully fixed your account.');
        }
    }

    //TOP UP VIEW
    public function topup_view(){
        return view('pages.user.tools.topup');
    }
    //TOP UP PROCESS
    public function topup_process(Request $req){
        $valid = Validator::make($req->all(),[
            'code'      =>  'required|min:16|max:16',
            'pin_code'  =>  'required|min:12|max:12'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid);
        }
        try {
            $topup = TopUp::where(['code' => $req->input('code')])->where(['pin_code' => $req->input('pin_code')])->firstOrFail();
            if($topup->status == 0){
                return back()->with('error','Top Up Card was revoked by admin.');
            }
            if($topup->status == 2){
                return back()->with('error','Top Up Card was already used.');
            }
            $user = Auth::user();
            if($topup->function == "votepoints"){
                $user->points()->increment('Vpoints',$topup->amount);
                $msg =  back()->with('success','You have successfully top up <b>'.number_format($topup->amount,2).' Vote Points</b>. You have now <b>'.number_format(Auth::user()->points()->first()->Vpoints).' Vote Points</b>.');
                Auth::user()->timeline()->create([
                    'content'       =>  'You have successfully top up <b>'.number_format($topup->amount,2).' Vote Points</b>. You have now <b>'.number_format(Auth::user()->points()->first()->Vpoints).' Vote Points</b>.',
                    'remark'        =>  'topupcode',
                    'ip_address'    => $this->ipaddress()
                ]);
            }else{
                $user->points()->increment('points',$topup->amount);
                $msg = back()->with('success','You have successfully top up <b>'.number_format($topup->amount,2).' E-Points</b>. You have now <b>'.number_format(Auth::user()->points()->first()->points).' E-Points</b>.');
                Auth::user()->timeline()->create([
                    'content'       =>  'You have successfully top up <b>'.number_format($topup->amount,2).' E-Points</b>. You have now <b>'.number_format(Auth::user()->points()->first()->points).' E-Points</b>.',
                    'remark'        =>  'topupcode',
                    'ip_address'    => $this->ipaddress()
                ]);
            }
            $topup->status = 2;
            $topup->save();
            return $msg;
        }catch(ModelNotFoundException $e){
            return back()->withErrors(['Invalid Top up card code and pin code. please try again.']);
        }
    }
}
