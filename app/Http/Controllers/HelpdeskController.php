<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CaptureIpTrait;
use App\Models\Helpdesk;
use App\Models\HelpdeskConversation as HDC;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use Auth;

class HelpdeskController extends Controller
{

	public function ipaddress(){
		$ip = new CaptureIpTrait();
		return $ip->getClientIp();
	}


	//help desk user view
    public function helpdesk_view(){
    	$helpdesks = (Auth::user()->isAdmin() ? new Helpdesk() : Auth::user()->helpdesk());
    	return view('pages.user.helpdesk.index',compact('helpdesks'));
    }

    //help desk create view
    public function helpdesk_create_view(){
    	return view('pages.user.helpdesk.create');
    }

    //help desk create process
    public function helpdesk_create_process(Request $req){
    	$valid = Validator::make($req->all(),[
    		'title'			=> 	'required|min:4',
    		'category'		=>	'required',
    		'message'		=>	'required|min:10|max:600'
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
    	}
    	$help = Auth::user()->helpdesk()->create([
	    	'title'			=> $req->input('title'),
	    	'category'		=> $req->input('category'),
	    	'status'		=> 0
    	]);
    	$id = $help->id;
    	$help->helpdeskconversation()->create([
	    	'user_id'		    => Auth::user()->id,
            'type'              => 'user',
	    	'message'			=> $req->input('message')
    	]);
    		Auth::user()->timeline()->create([
	   			'content'		=> 	'You have successfully submitted a new ticket #'.$id.' ['.$req->input('title').']',
	   			'remark'		=>	'helpdesk',
	 			'ip_address'	=> $this->ipaddress()
    		]);
    	return back()->with('success','You have successfully submitted a new ticket #'.$id.' ['.$req->input('title').']');
    }

    //help desk view by id
    public function helpdesk_view_id($id){
    	try{
    		$hd = Helpdesk::findOrFail($id);
    		return view('pages.user.helpdesk.view',compact('hd'));
    	}catch(ModelNotFoundException $e){
    		return back()->withErrors('Ticket <b>#'.$id.'</b> doesnt exists in our record.');
    	}
    }

   	//help desk view by id process
   	public function helpdesk_view_id_process($id,$receiver,Request $req){
   		$valid = Validator::make($req->all(),[
   			'message'	=>	'required|min:10|max:600'
   		]);
   		if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
   		}
    	try{
    		$hd = Helpdesk::findOrFail($id);
    		if(Auth::user()->isUser()){
    			$hd->status = 0;
                $type = 'user';
    		}else{
    			$hd->status = 1;
                $type = 'staff';
    		}
    		$hd->helpdeskconversation()->create([
                'user_id'           => Auth::user()->id,
                'type'              => $type,
                'message'           => $req->input('message')
    		]);
    		$hd->save();
    		Auth::user()->timeline()->create([
	   			'content'		=> 	'You have successfully submitted a new reply to ticket #'.$id.' ['.$hd->title.']',
	   			'remark'		=>	'helpdesk',
	 			'ip_address'	=> $this->ipaddress()
    		]);
    		return back()->with('success','You have successfully submitted a new reply to ticket #'.$id.' ['.$hd->title.']');
    	}catch(ModelNotFoundException $e){
    		return back()->withErrors('Ticket <b>#'.$id.'</b> doesnt exists in our record.');
    	}
   	}
}
