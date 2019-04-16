<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Timeline;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;

class UserTimelineController extends Controller
{
    public function profile_view($name){
    	try{
    		if(Auth::user()->isUser()){
                if(Auth::user()->name != $name){
                    return redirect('home')->with('error','You are not allowed to view the timeline of other user.');
                }
    		}
    		$user = User::where(['name' => $name])->firstOrFail();
    		$timelines = ($user->timeline()->count() ? $user->timeline()->orderBy('created_at','desc')->get() : array());
    		return view('pages.user.timeline.index',compact('timelines','name'));
    	}catch(ModelNotFoundException $e){
    		return redirect('home')->with('error','Invalid username. Please try again');
    	}
    }
}
