<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use Artisan;
use Validator;
use App\Models\User;
use App\Models\TopUp;
use App\Models\AboutUs;
use App\Models\Timeline;
use App\Models\Downloads;
use App\Models\KBCategory;
use App\Models\VoteTopSite;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\KnowledgeBase;
use App\Traits\CaptureIpTrait;
use Illuminate\Validation\Rule;
use App\Models\RanGame1\ChaInfo;
use App\Models\RanUser\UserInfo4;
use App\Models\RanShop\ShopItemMap;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WebToolController extends Controller
{
	public function ipaddress(){
		$ip = new CaptureIpTrait();
		return $ip->getClientIp();
	}

	//TOP UP CODES VIEW
    public function topupcode_view(){
    	$topup = new TopUp();
    	return view('pages.admin.webtool.topupcode',compact('topup'));
    }
    //TOP UP CODES PROCESS
    public function topupcode_process(Request $req){
    	$valid = Validator::make($req->all(),[
    		'function'	=>	'required',
    		'amount'	=>	'required|numeric'
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid);
    	}
    	$code = strtoupper(str_random(16));
    	$pin = strtoupper(str_random(12));
    	$user = Auth::user();
    	while(true){
    		if(TopUp::where(['code' => $code])->count() <= 0){
    			$user->topup()->create([
			    	'code'			=>	$code,
			    	'pin_code'		=>	$pin,
			    	'status'		=>	1,
			    	'amount'		=>	$req->input('amount'),
			        'function'		=>	$req->input('function')
    			]);
    			break;
    		}
    	}
    	if($req->input('function') === "votepoints"){
    		$msg = "VOTE POINTS";
    	}else{
    		$msg = "E-POINTS";
    	}
   		Auth::user()->timeline()->create([
   			'content'		=> 	'You have successfully generated a new <b>'.$msg.'</b> code with <b>CODE: '.$code.'</b> / <b>PIN CODE : '.$pin.'</b> WORTH <b>'.number_format($req->input('amount'),2).'</b>.',
   			'remark'		=>	'topupcode',
 			'ip_address'	=> $this->ipaddress()
   		]);
    	return back()->with('success','You have successfully generated a new ,b>'.$msg.'</b> code with <b>CODE: '.$code.'</b> / <b>PIN CODE : '.$pin.'</b> WORTH <b>'.number_format($req->input('amount'),2).'</b>.');
    }
    //TOP UP CODE REVOKE PROCESS
    public function topupcode_revoke_process($id, Request $req){
    	$code = TopUp::findOrFail($id);
    	$code->status=2;
    	$code->save();
   		Auth::user()->timeline()->create([
   			'content'		=> 	'You have successfully revoked the top up code with ID <b>'.$id.'</b>.',
   			'remark'		=>	'topupcode',
 			'ip_address'	=> $this->ipaddress()
   		]);
    	return back()->with('success','You have successfully revoked the top up code with ID <b>'.$id.'</b>.');
    }


    //ITEM SHOP CREATE NEW VIEW
    public function itemshop_create_view(){
    	return view('pages.admin.webtool.itemshop.create');
    }
    //ITEM SHOP CREATE NEW PROCESS
    public function itemshop_create_process(Request $req){
    	$valid = Validator::make($req->all(),[
    		'ItemName'				=>		'required',
    		'item_main'				=>		'required|numeric',
    		'item_sub'				=>		'required|numeric',
    		'item_section'			=>		'required',
    		'item_category'			=>		'required',
    		'item_stock'			=>		'required|numeric',
    		'item_price'			=>		'required|numeric',
    		'item_hidden'			=>		'required',
    		'item_description'		=>		'required|min:10',
    		'item_image'			=>		'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    	]);
    	//check if item name exists
    	if(ShopItemMap::where(['ItemName' => htmlspecialchars($req->input('ItemName'))])->count()){
    		return back()->withErrors(['The selected item name is already exists.'])->withInput();
    	}
    	if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
    	}
    	$hidden = ($req->input('item_hidden') == 1 ? 1 : NULL);
    	$image = $req->file('item_image');
    	$filename = time().$image->getClientOriginalExtension();
    	$loc = base_path()."/public/images/items/";
    	$image->move($loc,$filename);
    	$image = $filename;
    	ShopItemMap::create([
	        'ItemName'			=>	$req->input('ItemName'),
	        'ItemMain'			=>	$req->input('item_main'),
	        'ItemSub'			=>	$req->input('item_sub'),
	        'ItemSec'			=>	$req->input('item_section'),
	        'Itemstock'			=>	$req->input('item_stock'),
	        'ItemPrice'			=>	$req->input('item_price'),
	        'ItemCtg'			=>	$req->input('item_category'),
	        'ItemSS'			=>	$image,
	        'ItemComment'		=>	$req->input('item_description'),
	        'IsHidden'			=>	$hidden
    	]);
   		Auth::user()->timeline()->create([
   			'content'		=> 	'You have successfully release a new item <b>'.$req->input('ItemName').'</b>.',
   			'remark'		=>	'itemshop',
 			'ip_address'	=> $this->ipaddress()
   		]);
    	return back()->with('success','You have successfully release a new item <b>'.$req->input('ItemName').'</b>.');
    }
    //ITEM SHOP LIST VIEW
    public function itemshop_list_view(){
    	$items = new ShopItemMap();
    	return view('pages.admin.webtool.itemshop.index',compact('items'));
    }
    //ITEM SHOP EDIT VIEW
    public function itemshop_edit_view($id){
    	try {
	    	$item = ShopItemMap::findOrFail($id);
	    	return view('pages.admin.webtool.itemshop.edit',compact('item'));
    	}catch(ModelNotFoundException $e){
    		return redirect('webtool/itemshop')->with('error','This Item Doesnt Exist.');
    	}
    }
    //ITEM SHOP EDIT PROCESS
    public function itemshop_edit_process($id,Request $req){
    	try{
	    	$item = ShopItemMap::findOrFail($id);
	    	$valid = Validator::make($req->all(),[
	    		'ItemName'				=>		'required',
	    		'item_main'				=>		'required|numeric',
	    		'item_sub'				=>		'required|numeric',
	    		'item_section'			=>		'required',
	    		'item_category'			=>		'required',
	    		'item_stock'			=>		'required|numeric',
	    		'item_price'			=>		'required|numeric',
	    		'item_description'		=>		'required|min:10',
	    		'item_image'			=>		'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
	    	]);
	    	//check if item name exists
	    	if(ShopItemMap::where(['ItemName' => htmlspecialchars($req->input('ItemName'))])->where('ProductNum','!=',$id)->count()){
	    		return back()->withErrors(['The selected item name is already exists.'])->withInput();
	    	}
	    	if($valid->fails()){
	    		return back()->withErrors($valid)->withInput();
	    	}
	    	$hidden = ($req->input('item_hidden') == 1 ? 1 : NULL);
	    	if($req->hasFile('item_image')){
		    	$image = $req->file('item_image');
		    	$filename = time().$image->getClientOriginalExtension();
		    	$loc = base_path()."/public/images/items/";
		    	$image->move($loc,$filename);
		    	$image = $filename;
	    	}else{
	    		$image = $item->ItemSS;
	    	}
	    	ShopItemMap::where(['ProductNum' => $id])->update([
		        'ItemName'			=>	$req->input('ItemName'),
		        'ItemMain'			=>	$req->input('item_main'),
		        'ItemSub'			=>	$req->input('item_sub'),
		        'ItemSec'			=>	$req->input('item_section'),
		        'Itemstock'			=>	$req->input('item_stock'),
		        'ItemPrice'			=>	$req->input('item_price'),
		        'ItemCtg'			=>	$req->input('item_category'),
		        'ItemSS'			=>	$image,
		        'ItemComment'		=>	$req->input('item_description'),
		        'IsHidden'			=>	$hidden
	    	]);
	   		Auth::user()->timeline()->create([
	   			'content'		=> 	'You have successfully updated the item <b>'.$item->ItemName.'</b>',
	   			'remark'		=>	'itemshop',
	 			'ip_address'	=> $this->ipaddress()
	   		]);
	    	return redirect('webtool/itemshop')->with('success','You have successfully updated the item <b>'.$item->ItemName.'</b>');
    	}catch(ModelNotFoundException $e){
    		return redirect('webtool/itemshop')->with('error','This Item Doesnt Exist.');
    	}
    }
    //ITEM SHOP DELETE PROCESS
    public function itemshop_delete_process($id){
    	try{
	    	$item = ShopItemMap::findOrFail($id);
	    	$item->delete();
	   		Auth::user()->timeline()->create([
	   			'content'		=> 	'You have successfully deleted the item <b>'.$item->ItemName.'</b>.',
	   			'remark'		=>	'itemshop',
	 			'ip_address'	=> $this->ipaddress()
	   		]);
	    	return back()->with('success','You have successfully deleted the item <b>'.$item->ItemName.'</b>.');
    	}catch(ModelNotFoundException $e){
    		return redirect('webtool/itemshop')->with('error','This Item Doesnt Exist.');
    	}
    }


    //INSERT POINTS VIEW
    public function insertpoints_view(){
    	$users = UserInfo4::all();
    	return view('pages.admin.webtool.points.index',compact('users'));
    }
    //INSERT POINTS PROCESS
    public function insertpoints_process(Request $req){
    	if($req->input('points_type') == "premiumpoints" || $req->input('points_type') == "in-gamepoints"){
    		$valid = Validator::make($req->all(),[
    			'points_type'		=>		'required',
    			'UserNum'			=>		'required',
    			'CharID'			=>		'required',
    			'amount'			=>		'required'
    		]);
    	}else{
    		$valid = Validator::make($req->all(),[
    			'points_type'		=>		'required',
    			'UserNum'			=>		'required',
    			'amount'			=>		'required'
    		]);
    	}
    	if($valid->fails()){
    		return back()->withErrors($valid);
    	}
    	try{
    		$user = UserInfo4::findOrFail($req->input('UserNum'))->user_2()->firstOrFail();
    		if($req->input('points_type') == "premiumpoints"){
                $char = ChaInfo::findOrFail($req->input('CharID'));
    			$msg = "Premium Points";
    			$char->ChaPremiumPoint = ($char->ChaPremiumPoint + $req->input('amount'));
    			$char->save();
    		}else if($req->input('points_type') == "in-gamepoints"){
                $char = ChaInfo::findOrFail($req->input('CharID'));
                $msg = "In-Game Points";
                $char->ChaMoney = ($char->ChaMoney + $req->input('amount'));
                $char->save();
            }else if($req->input('points_type') == "zgpoints"){
                $char = ChaInfo::findOrFail($req->input('CharID'));
                $msg = "ZG Points";
                $char->ChaVotePoint = ($char->ChaVotePoint + $req->input('amount'));
                $char->save();
            }else if($req->input('points_type') == "vpoints"){
    			$msg = "Vote Points";
    			$user->points()->increment('Vpoints',$req->input('amount'));
    		}else{
    			$msg = "E-Points";
    			$user->points()->increment('points',$req->input('amount'));
    		}
	   		Auth::user()->timeline()->create([
	   			'content'		=> 	'You have successfully added <b>'.$req->input('amount').' '.$msg.'</b> to User <b>'.$user->name.'</b>.',
	   			'remark'		=>	'insertpoints',
	 			'ip_address'	=> $this->ipaddress()
	   		]);
    		return back()->with('success','You have successfully added <b>'.$req->input('amount').' '.$msg.'</b> to User <b>'.$user->name.'</b>.');
    	}catch(ModelNotFoundException $e){
    		return redirect('webtool/insertpoints')->with('error','You tried to process an account that doesnt have record in points or character info table.');
    	}
    }


    //ANNOUNCEMENTS CREATE VIEW
    public function news_create_view(){
    	return view('pages.admin.webtool.announcement.create');
    }
    //ANNOUNCEMENTS CREATE PROCESS
    public function news_create_process(Request $req){
    	$valid = Validator::make($req->all(),[
    		'title'		=>		'required|min:4|unique:sqlsrv.announcements',
    		'content'	=>		'required|min:20'
    	]);
    	if($valid->fails()){
    		return back()->withErrors($valid)->withInput();
    	}
    	Auth::user()->announcement()->create([
    		'title' => $req->input('title'),
    		'content' => $req->input('content')
    	]);
	   	Auth::user()->timeline()->create([
	   		'content'		=> 	'You have successfully created new announcement titled <b>'.$req->input('title').'</b>.',
	  		'remark'		=>	'announcement',
	 		'ip_address'	=> $this->ipaddress()
	   	]);
    	return back()->with('success','You have successfully created new announcement titled <b>'.$req->input('title').'</b>.');
    }
    //ANNOUNCEMENTS LIST VIEW
    public function news_view(){
    	$announcement = new Announcement();
    	return view('pages.admin.webtool.announcement.index',compact('announcement'));
    }
    //ANNOUNCEMENTS PER ITEM VIEW
    public function news_view_byid($id){
    	try{
    		$annc = Announcement::findOrFail($id);
    		return view('pages.admin.webtool.announcement.show',compact('annc'));
    	}catch(ModelNotFoundException $e){
    		return redirect('webtool/news')->with('error','Announcement ID doesnt exists.');
    	}
    }
    //ANNOUNCEMENTS EDIT VIEW
    public function news_edit_view($id){
    	try{
    		$annc = Announcement::findOrFail($id);
    		return view('pages.admin.webtool.announcement.edit',compact('annc'));
    	}catch(ModelNotFoundException $e){
    		return redirect('webtool/news')->with('error','Announcement ID doesnt exists.');
    	}
    }
    //ANNOUNCEMENTS EDIT PROCESS
    public function news_edit_process($id,Request $req){
    	try{
    		$annc = Announcement::findOrFail($id);
    		$valid = Validator::make($req->all(),[
	    		'title'		=>		'required|min:4|unique:sqlsrv.announcements,title,'.$id,
	    		'content'	=>		'required|min:20'
    		]);
	    	if($valid->fails()){
	    		return back()->withErrors($valid)->withInput();
	    	}
            $annc->title = $req->input('title');
            $annc->content = $req->input('content');
            $annc->save();
		   	Auth::user()->timeline()->create([
		   		'content'		=> 	'You have successfully updated an announcement titled <b>'.$req->input('title').'</b>.',
		  		'remark'		=>	'announcement',
		 		'ip_address'	=> $this->ipaddress()
		   	]);
    		return redirect('webtool/news')->with('success','You have successfully updated an announcement titled <b>'.$req->input('title').'</b>.');
    	}catch(ModelNotFoundException $e){
    		return redirect('webtool/news')->with('error','Announcement ID doesnt exists.');
    	}
    }
    //ANNOUNCEMENTS DELETE PROCESS
    public function news_delete_process($id){
    	try{
    		$annc = Announcement::findOrFail($id);
    		$annc->delete();
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully deleted the announcement <b>'.$annc->title.'</b>.',
                'remark'        =>  'announcement',
                'ip_address'    => $this->ipaddress()
            ]);
    		return back()->with('success','You have successfully deleted the announcement <b>'.$annc->title.'</b>.');

    	}catch(ModelNotFoundException $e){
    		return redirect('webtool/news')->with('error','Announcement ID doesnt exists.');
    	}
    }

    //DOWNLOAD PAGE VIEW
    public function download_create_view(){
        return view('pages.admin.webtool.download.create');
    }
    //DOWNLOAD PAGE PROCESS
    public function download_create_process(Request $req){
        $valid = Validator::make($req->all(),[
            'title'     =>      'required|min:4|unique:sqlsrv.downloads',
            'content'   =>      'required|min:20',
            'status'    =>      'required|numeric'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
        Auth::user()->downloads()->create([
            'title'     =>      $req->input('title'),
            'content'   =>      $req->input('content'),
            'status'    =>      $req->input('status')
        ]);
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully created new Download Content Titled <b>'.$req->input('title').'</b>.',
                'remark'        =>  'downloads',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','You have successfully created new Download Content Titled <b>'.$req->input('title').'</b>.');
    }
    //DOWNLOAD PAGE LIST VIEW
    public function download_list_view(){
        $downloads = new Downloads();
        return view('pages.admin.webtool.download.index',compact('downloads'));
    }
    //DOWNLOAD PAGE VIEW BY ID
    public function download_view_id($title){
        try{
            $dl = Downloads::whereTitle(['title' => $title])->firstOrFail();
            return view('pages.admin.webtool.download.show',compact('dl'));
        }catch(ModelNotFoundException $e){
            return redirect('webtool/download')->with('error','Download Content Title Doesnt exists.');
        }
    }
    //DOWNLOAD PAGE EDIT VIEW
    public function download_edit_view($id){
        try{
            $dl = Downloads::findOrFail($id);
            return view('pages.admin.webtool.download.edit',compact('dl'));
        }catch(ModelNotFoundException $e){
            return redirect('webtool/download')->with('error','Download Content ID Doesnt exists.');
        }
    }
    //DOWNLOAD PAGE EDIT PROCESS
    public function download_edit_process($id,Request $req){
        try{
            $dl = Downloads::findOrFail($id);
            $valid = Validator::make($req->all(),[
                'title'     =>      'required|min:4|unique:sqlsrv.downloads,title,'.$id,
                'content'   =>      'required|min:20',
                'status'    =>      'required|numeric'
            ]);
            if($valid->fails()){
                return back()->withErrors($valid)->withInput();
            }
            Auth::user()->downloads()->update([
                'title'     =>      $req->input('title'),
                'content'   =>      $req->input('content'),
                'status'    =>      $req->input('status')
            ]);
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully updated Download Content Titled <b>'.$req->input('title').'</b>.',
                'remark'        =>  'downloads',
                'ip_address'    => $this->ipaddress()
            ]);
            return back()->with('success','You have successfully update Download Content Titled <b>'.$req->input('title').'</b>.');
        }catch(ModelNotFoundException $e){
            return redirect('webtool/download')->with('error','Download Content ID Doesnt exists.');
        }
    }
    //DOWNLOAD PAGE CONTEN DELETE PROCESS
    public function download_delete_process($id){
        try{
            $dl = Downloads::findOrFail($id);
            $dl->delete();
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully destroyed the Download Content Titled <b>'.$dl->title.'</b>.',
                'remark'        =>  'downloads',
                'ip_address'    => $this->ipaddress()
            ]);
            return back()->with('success','You have successfully destroyed the Download Content Titled <b>'.$dl->title.'</b>.');
        }catch(ModelNotFoundException $e){
            return redirect('webtool/download')->with('error','Download Content ID Doesnt exists.');
        }
    }


    //ABOUT US PAGE VIEW
    public function about_us_view(){
        $about = new AboutUs();
        $about = $about->first();
        $last = User::find($about->updated_by);
        return view('pages.admin.webtool.about.index',compact('about','last'));
    }
    //ABOUT US PAGE PROCESS
    public function about_us_prorcess(Request $req){
        $valid = Validator::make($req->all(),[
            'content'   => 'required|min:20'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
        AboutUs::where(['id' => 1])->update([
            'content' => $req->input('content'),
            'updated_by' => Auth::user()->id
        ]);
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully updated the About Us Page.',
                'remark'        =>  'aboutus',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','You have successfully updated the About Us Page.');
    }

    //VOTING SYSTEM VIEW
    public function vote_view(){
        $topsites = new VoteTopSite();
        return view('pages.admin.webtool.vote.index',compact('topsites'));
    }
    //VOTING SYSTEM CREATE PROCESS
    public function vote_create_process(Request $req){
        $valid = Validator::make($req->all(),[
            'title'         => 'required|min:4|unique:sqlsrv.vote_top_sites',
            'image_link'    => 'required|url|min:10',
            'link'          => 'required|url|min:10',
            'status'        => 'required'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
        Auth::user()->votetopsite()->create([
            'title'         => $req->input('title'),
            'image_link'    => $req->input('image_link'),
            'link'          => $req->input('link'),
            'status'        => $req->input('status')
        ]);
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully added new Top Site link [<b>'.$req->input('title').'</b>].',
                'remark'        =>  'votepage',
                'ip_address'    => $this->ipaddress()
            ]);
        return back()->with('success','You have successfully added new Top Site link [<b>'.$req->input('title').'</b>].');
    }
    //VOTING SYSTEM EDIT VIEW
    public function vote_edit_view($id){
        try{
            $ts = VoteTopSite::findOrFail($id);
        return view('pages.admin.webtool.vote.edit',compact('ts'));
        }catch(ModelNotFoundException $e){
            return back()->with('error','Top Site ID doesnt exist.');
        }
    }
    //VOTING SYSTEM EDIT PROCESS
    public function vote_edit_process($id,Request $req){
        try{
            $ts = VoteTopSite::findOrFail($id);
            $valid = Validator::make($req->all(),[
                'title'         => 'required|min:4|unique:sqlsrv.vote_top_sites,title,'.$id,
                'image_link'    => 'required|url|min:10',
                'link'          => 'required|url|min:10',
                'status'        => 'required'
            ]);
            if($valid->fails()){
                return back()->withErrors($valid)->withInput();
            }
            $ts->title = $req->input('title');
            $ts->image_link = $req->input('image_link');
            $ts->link = $req->input('link');
            $ts->status = $req->input('status');
            $ts->save();
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully updated <b>'.$req->input('title').'</b>.',
                'remark'        =>  'votepage',
                'ip_address'    => $this->ipaddress()
            ]);
            return redirect('webtool/vote')->with('success','You have successfully updated <b>'.$req->input('title').'</b>.');
        }catch(ModelNotFoundException $e){
            return back()->with('error','Top Site ID doesnt exist.');
        }
    }
    //VOTING SYSTEM DELETE PROCESS
    public function vote_delete_process($id){
        try{
            $ts = VoteTopSite::findOrFail($id);
            $title = $ts->title;
            $ts->delete();
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully deleted the <b>'.$title.'</b>.',
                'remark'        =>  'votepage',
                'ip_address'    => $this->ipaddress()
            ]);
            return back()->with('success','You have successfully deleted the <b>'.$title.'</b>.');
        }catch(ModelNotFoundException $e){
            return back()->with('error','Top Site ID doesnt exist.');
        }
    }

    //KNOWLEDGE BASE CREATE VIEW
    public function knowledgebase_create_view(){
        $cat = new KBCategory();
        return view('pages.admin.webtool.knowledgebase.create',compact('cat'));
    }
    //KNOWLEDGE BASE CREATE PROCESS
    public function knowledgebase_create_process(Request $req){
        $valid = Validator::make($req->all(),[
            'title'     =>  'required|min:4|unique:sqlsrv.knowledge_bases',
            'content'   =>  'required|min:20',
            'category'  =>  'required',
            'status'    =>  'required'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
        try{
            $cat = KBCategory::findOrFail($req->input('category'));
            $cat->knowledgebase()->create([
                'title'         =>  $req->input('title'),
                'content'       =>  $req->input('content'),
                'status'        =>  $req->input('status')
            ]);
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully created new Knowledge Base <b>'.$req->input('title').'</b>.',
                'remark'        =>  'knowledgebase',
                'ip_address'    => $this->ipaddress()
            ]);
            return back()->with('success','You have successfully created new Knowledge Base <b>'.$req->input('title').'</b>.');
        }catch(ModelNotFoundException $e){
            return back()->withErrors(['Category doesnt exists.'])->withInput();
        }
    }
    //KNOWLEDGE BASE CREATE CATEGORY VIEW
    public function knowledgebase_create_category_view(){
        $cat = new KBCategory();
        return view('pages.admin.webtool.knowledgebase.create_category',compact('cat'));
    }
    //KNOWLEDGE BASE CREATE CATEGORY VIEW
    public function knowledgebase_create_category_process(Request $req){
        $valid = Validator::make($req->all(),[
            'title' =>  'required|min:4|unique:sqlsrv.k_b_categories'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
        KBCategory::create([
            'title'     =>  $req->input('title')
        ]);
        Auth::user()->timeline()->create([
            'content'       =>  'You have successfully create new category titled <b>'.$req->input('title').'</b>.',
            'remark'        =>  'knowledgebase',
            'ip_address'    => $this->ipaddress()
        ]);
        return back()->with('success','You have successfully create new category titled <b>'.$req->input('title').'</b>.');
    }
    //KNOWLEDGE BASE EDIT CATEGORY VIEW
    public function knowledgebase_edit_category_view($id){
        try{
            $cat = KBCategory::findOrFail($id);
            return view('pages.admin.webtool.knowledgebase.edit_category',compact('cat'));
        }catch(ModelNotFoundException $e){
            return back()->with('error','Category ID doesnt exists.');
        }
    }
    //KNOWLEDGE BASE EDIT CATEGORY PROCESS
    public function knowledgebase_edit_category_process($id, Request $req){
        try{
            $cat = KBCategory::findOrFail($id);
            $valid = Validator::make($req->all(),[
                'title'     =>  'required|min:4|unique:sqlsrv.k_b_categories,title,'.$id
            ]);
            if($valid->fails()){
                return back()->withErrors($valid)->withInput();
            }
            $cat->title = $req->input('title');
            $cat->save();
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully updated the category <b>'.$req->input('title').'</b>.',
                'remark'        =>  'knowledgebase',
                'ip_address'    => $this->ipaddress()
            ]);
            return redirect('webtool/knowledgebase/create/category')->with('success','You have successfully updated the category <b>'.$req->input('title').'</b>.');
        }catch(ModelNotFoundException $e){
            return back()->with('error','Category ID doesnt exists.');
        }
    }
    //KNOWLEDGE BASE DELETE CATEGORY PROCESS
    public function knowledgebase_delete_category_process($id){
        try{
            $cat = KBCategory::findOrFail($id);
            $title = $cat->title;
            $cat->delete();
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully deleted the category <b>'.$title.'</b>.',
                'remark'        =>  'knowledgebase',
                'ip_address'    => $this->ipaddress()
            ]);
            return back()->with('success','You have successfully deleted the category <b>'.$title.'</b>.');
        }catch(ModelNotFoundException $e){
            return back()->with('error','Category ID doesnt exists.');
        }
    }
    //KNOWLEDGE BASE LIST VIEW
    public function knowledgebase_list_view(){
        $kbs = new KnowledgeBase();
        return view('pages.admin.webtool.knowledgebase.index',compact('kbs'));
    }
    //KNOWLEDGE BASE VIEW ID
    public function knowledgebase_view_id($id){
        try{
            $kb = KnowledgeBase::findOrFail($id);
            return view('pages.admin.webtool.knowledgebase.view',compact('kb'));
        }catch(ModelNotFoundException $e){
            return back()->with('error','Knowledge Base ID doesnt exists.');
        }
    }
    //KNOWLEDGE BASE EDIT ID
    public function knowledgebase_edit_id($id){
        try{
            $kb = KnowledgeBase::findOrFail($id);
            $cat = new KBCategory();
            return view('pages.admin.webtool.knowledgebase.edit',compact('kb','cat'));
        }catch(ModelNotFoundException $e){
            return back()->with('error','Knowledge Base ID doesnt exists.');
        }
    }
    //KNOWLEDGE BASE EDIT ID PROCESS
    public function knowledgebase_edit_id_process($id,Request $req){
        $valid = Validator::make($req->all(),[
            'title'     =>  'required|min:4|unique:sqlsrv.knowledge_bases,title,'.$id,
            'content'   =>  'required|min:20',
            'category'  =>  'required',
            'status'    =>  'required'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
        try{
            $kb = KnowledgeBase::findOrFail($id);
            $kb->category_id = $req->input('category');
            $kb->title = $req->input('title');
            $kb->content = $req->input('content');
            $kb->status = $req->input('status');
            $kb->save();
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully updated knowledge base <b>'.$req->input('title').'</b>.',
                'remark'        =>  'knowledgebase',
                'ip_address'    => $this->ipaddress()
            ]);
            return redirect('webtool/knowledgebase')->with('success','You have successfully updated knowledge base <b>'.$req->input('title').'</b>.');
        }catch(ModelNotFoundException $e){
            return back()->with('error','Knowledge Base ID doesnt exists.');
        }
    }
    //KNOWLEDGE BASE DELETE BY ID
    public function knowledgebase_delete_id($id){
        try{
            $kb = KnowledgeBase::findOrFail($id);
            $title = $kb->title;
            $kb->delete();
            Auth::user()->timeline()->create([
                'content'       =>  'You have successfully deleted knowledge base <b>'.$req->input('title').'</b>.',
                'remark'        =>  'knowledgebase',
                'ip_address'    => $this->ipaddress()
            ]);
            return redirect('webtool/knowledgebase')->with('success','You have successfully deleted knowledge base <b>'.$req->input('title').'</b>.');
        }catch(ModelNotFoundException $e){
            return back()->with('error','Knowledge Base ID doesnt exists.');
        }
    }

    //EDIT ENV VIEW
    public function env_view(){
       if(Auth::user()->name == "admin"){
            return view('pages.admin.env');
       }else{
            return back()->with('error','You dont have access here.');
       }
    }
    public function env_process(Request $req){
        $valid = Validator::make($req->all(),[
            'env'   =>  'required|min:100'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        }
        file_put_contents(base_path('.env'),$req->input('env'));
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        return back()->with('success','You have successfully updated the .env file.');
    }
}
