<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\ValidatePassword;
use App\Traits\CaptureIpTrait;
use App\Models\RanGame1\ChaInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use Validator;

class ConvertionController extends Controller
{
	public function ipaddress(){
		$ip = new CaptureIpTrait();
		return $ip->getClientIp();
	}

	//CONVERTION POINTS PROCESS
    public function convertion_view(){
    	$char = Auth::user()->userinfo4()->first()->chainfo3();
    	return view('pages.user.convertion.index',compact('char'));
    }
    //CONVERTION POINTS PROCESS
    public function convertion_process(Request $req){
    	if($req->input('to_points') == "gold" || $req->input('to_points') == "ppoints" || $req->input('to_points') == "zgpoints"){
    		$valid = Validator::make($req->all(),[
    			'from_points'		=>	'required',
    			'to_points'			=>	'required',
    			'ChaID'				=>	'required',
    			'amount'			=>	'required',
    			'password'			=>	['required','max:20','min:6',new ValidatePassword(auth()->user())]
    		]);
    	}else{
    		$valid = Validator::make($req->all(),[
    			'from_points'		=>	'required',
    			'to_points'			=>	'required',
    			'amount'			=>	'required',
    			'password'			=>	['required','max:20','min:6',new ValidatePassword(auth()->user())]
    		]);
    	}
    	if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
    	}
    	//set variable of value
    	$vpoints = 'vpoints';
    	$epoints = 'epoints';
    	$gold = 'gold';
    	//check if amount value is 0
    	if($req->input() <= 0){
    		return back()->withErrors(['The amount value must be atleast 1 or more.'])->withInput();
    	}
    	//check if vp converting to ep
    	if($req->input('from_points') == $vpoints && $req->input('to_points') == $epoints){
    		return back()->with('error','This is not allowed. Please try again.');
    	}
    	//check if ep converting to vp
    	if($req->input('from_points') == $epoints && $req->input('to_points') == $vpoints){
            return back()->with('error','This is not allowed. Please try again.');
    	}
    	//check if vp converting to gold
    	if($req->input('from_points') == $vpoints && $req->input('to_points') == $gold){
    		//check if current vote points is enough in request amount
    		if(Auth::user()->points()->first()->Vpoints < $req->input('amount')){
    			return back()->withErrors(['Your Current Vote Points is not enough to convert in to IN-GAME Gold. You need <b>'.config('app.convert_points.FROM_VP_TO_GOLD_REQUIRED_AMOUNT').' Vote Points</b>.'])->withInput();
    		}
    		//check if requested amount is enough from required vote points to epoints
    		if(config('app.convert_points.FROM_VP_TO_GOLD_REQUIRED_AMOUNT') > $req->input('amount')){
    			return back()->withErrors(['Your requested amount to convert is not enough to process. You need <b>'.config('app.convert_points.FROM_VP_TO_GOLD_REQUIRED_AMOUNT').' Vote Points</b>.'])->withInput();
    		}

    		$value = (($req->input('amount') / config('app.convert_points.FROM_VP_TO_GOLD_REQUIRED_AMOUNT')) * config('app.convert_points.FROM_VP_TO_GOLD_AMOUNT'));
    		Auth::user()->points()->decrement('Vpoints',$req->input('amount'));
    		try{
    			$char = ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->firstOrFail();
    			//$char->increment('ChaMoney',$value);
                $char->ChaMoney = $char->ChaMoney + $value;
                $char->save();
    		}catch(ModelNotFoundException $e){
    			return back()->withErrors(['Character could not be found.'])->withInput();
    		}
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully converted <b>'.number_format($req->input('amount'),2).' Vote Points</b> to <b>'.number_format($value,2).' IN-GAME Gold</b> for <b>['.$char->ChaName.']</b>.',
                'remark'        =>  'convert_points',
                'ip_address'    => $this->ipaddress()
            ]);
    		return back()->with('success','You have successfully converted <b>'.number_format($req->input('amount'),2).' Vote Points</b> to <b>'.number_format($value,2).' IN-GAME Gold</b> for <b>['.$char->ChaName.']</b>.');
    	}
    	//check if ep converting to gold
    	if($req->input('from_points') == $epoints && $req->input('to_points') == $gold){
    		//check if current vote points is enough in request amount
    		if(Auth::user()->points()->first()->points < $req->input('amount')){
    			return back()->withErrors(['Your Current E-Points is not enough to convert in to IN-GAME Gold. You need <b>'.config('app.convert_points.FROM_EP_TO_GOLD_REQUIRED_AMOUNT').' E-Points</b>.'])->withInput();
    		}
    		//check if requested amount is enough from required vote points to epoints
    		if(config('app.convert_points.FROM_EP_TO_GOLD_REQUIRED_AMOUNT') > $req->input('amount')){
    			return back()->withErrors(['Your requested amount to convert is not enough to process. You need <b>'.config('app.convert_points.FROM_EP_TO_GOLD_REQUIRED_AMOUNT').' E-Points</b>.'])->withInput();
    		}

    		$value = (($req->input('amount') / config('app.convert_points.FROM_EP_TO_GOLD_REQUIRED_AMOUNT')) * config('app.convert_points.FROM_EP_TO_GOLD_AMOUNT'));
    		Auth::user()->points()->decrement('points',$req->input('amount'));
    		try{
    			$char = ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->firstOrFail();
    			//$char->increment('ChaMoney',$value);
                $char->ChaMoney = $char->ChaMoney + $value;
                $char->save();
    		}catch(ModelNotFoundException $e){
    			return back()->withErrors(['Character could not be found.'])->withInput();
    		}
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully converted <b>'.number_format($req->input('amount'),2).' E-Points</b> to <b>'.number_format($value,2).' IN-GAME Gold</b> for <b>['.$char->ChaName.']</b>.',
                'remark'        =>  'convert_points',
                'ip_address'    => $this->ipaddress()
            ]);
    		return back()->with('success','You have successfully converted <b>'.number_format($req->input('amount'),2).' E-Points</b> to <b>'.number_format($value,2).' IN-GAME Gold</b> for <b>['.$char->ChaName.']</b>.');
    	}
        //check if vp to pp
        if($req->input('from_points') == "vpoints" && $req->input('to_points') == 'ppoints'){
            //check if current vote points is enough in request amount
            if(Auth::user()->points()->first()->Vpoints < $req->input('amount')){
                return back()->withErrors(['Your Current Vote Points is not enough to convert in to Premium Points. You need <b>'.config('app.convert_points.FROM_VP_TO_PP_REQUIRED_AMOUNT').' Vote Points</b>. You only have <b>'.Auth::user()->points()->first()->Vpoint.'</b>.'])->withInput();
            }
            //check if requested amount is enough from required vote points to epoints
            if(config('app.convert_points.FROM_VP_TO_PP_REQUIRED_AMOUNT') > $req->input('amount')){
                return back()->withErrors(['Your requested amount to convert is not enough to process. You need <b>'.config('app.convert_points.FROM_VP_TO_PP_REQUIRED_AMOUNT').' Vote Points</b>.'])->withInput();
            }

            $value = (($req->input('amount') / config('app.convert_points.FROM_VP_TO_PP_REQUIRED_AMOUNT')) * config('app.convert_points.FROM_VP_TO_PP_AMOUNT'));
            Auth::user()->points()->decrement('Vpoints',$req->input('amount'));
            try{
                $char = ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->firstOrFail();
                //$char->increment('ChaMoney',$value);
                $char->ChaPremiumPoint = $char->ChaPremiumPoint + $value;
                $char->save();
            }catch(ModelNotFoundException $e){
                return back()->withErrors(['Character could not be found.'])->withInput();
            }
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully converted <b>'.number_format($req->input('amount'),2).' Vote Points</b> to <b>'.number_format($value,2).' Premium Points</b> for <b>['.$char->ChaName.']</b>.',
                'remark'        =>  'convert_points',
                'ip_address'    => $this->ipaddress()
            ]);
            return back()->with('success','You have successfully converted <b>'.number_format($req->input('amount'),2).' Vote Points</b> to <b>'.number_format($value,2).' Premium Points</b> for <b>['.$char->ChaName.']</b>.');
        }
        //check if ep to pp
        if($req->input('from_points') == "epoints" && $req->input('to_points') == 'ppoints'){
            return back()->with('error','This is not allowed. Please try again.');
        }
        //check if vp to zg
        if($req->input('from_points') == "vpoints" && $req->input('to_points') == 'zgpoints'){
            return back()->with('error','This is not allowed. Please try again.');
        }
        //check if ep to zg
        if($req->input('from_points') == "epoints" && $req->input('to_points') == 'zgpoints'){
            //check if current vote points is enough in request amount
            if(Auth::user()->points()->first()->points < $req->input('amount')){
                return back()->withErrors(['Your Current E-Points is not enough to convert in to ZG Points. You need <b>'.config('app.convert_points.FROM_EP_TO_ZG_REQUIRED_AMOUNT').' Vote Points</b>.'])->withInput();
            }
            //check if requested amount is enough from required vote points to epoints
            if(config('app.convert_points.FROM_EP_TO_ZG_REQUIRED_AMOUNT') > $req->input('amount')){
                return back()->withErrors(['Your requested amount to convert is not enough to process. You need <b>'.config('app.convert_points.FROM_EP_TO_ZG_REQUIRED_AMOUNT').' Vote Points</b>.'])->withInput();
            }

            $value = (($req->input('amount') / config('app.convert_points.FROM_EP_TO_ZG_REQUIRED_AMOUNT')) * config('app.convert_points.FROM_EP_TO_ZG_AMOUNT'));
            Auth::user()->points()->decrement('points',$req->input('amount'));
            try{
                $char = ChaInfo::where(['ChaNum' => $req->input('ChaID')])->where(['UserNum' => Auth::user()->userinfo4()->first()->UserNum])->firstOrFail();
                //$char->increment('ChaMoney',$value);
                $char->ChaVotePoint = $char->ChaVotePoint + $value;
                $char->save();
            }catch(ModelNotFoundException $e){
                return back()->withErrors(['Character could not be found.'])->withInput();
            }
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully converted <b>'.number_format($req->input('amount'),2).' E-Points</b> to <b>'.number_format($value,2).' ZG Points</b> for <b>['.$char->ChaName.']</b>.',
                'remark'        =>  'convert_points',
                'ip_address'    => $this->ipaddress()
            ]);
            return back()->with('success','You have successfully converted <b>'.number_format($req->input('amount'),2).' E-Points</b> to <b>'.number_format($value,2).' ZG Points</b> for <b>['.$char->ChaName.']</b>.');
        }
    	//check if user is trying to convert same currenry
    	if($req->input('from_points') == $req->input('to_points')){
    		return back()->withErrors(['You are not allowed to convert in same currenry.'])->withInput();
    	}
    	return back()->with('error','Do not request an unnecessary things. Thank you!.');
    }
}
