<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\RanUser\UserInfo4;
use App\Models\Downloads;
use App\Models\Announcement;
use App\Models\User;
use App\Models\AboutUs;
use App\Models\RanGame1\ChaInfo;
use App\Models\RanShop\ShopItemMap;
use App\Models\KBCategory;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\KnowledgeBase;
use jeremykenedy\LaravelRoles\Models\Role;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        $count = UserInfo4::count() - User::count();
        $char = new ChaInfo();
        config()->set('adminlte.layout','top-nav');
        config()->set('adminlte.collapse_sidebar',false);
        $announcement = new Announcement();
        if($count > 0 && Auth::guest()){
            return view('welcome',compact('count','announcement','char'))->with('warning','Welcome to our new Panel.<br> As of now, we have an unrestored account that is currently count <b>'.$count.'</b>. If you are one of them please click the link below to restore your current account. If you are a new user please <a href="'.URL("register").'">register</a> a new account. If your account is already restored, just login.<br><a href="'.URL("restore/account").'">'.URL("restore/account").'</a>');
        }else{
            return view('welcome',compact('count','announcement','char'));
        }
    }

    public function updatemo(){
        $users = User::whereHas('roles',function($q){
            return $q->where(['slug' => 'donor']);
        })->cursor();
        foreach($users as $user){
            $user->detachAllRoles();
            $user->attachRole(2);
            $user->save();
        }
        return "done";
    }

    //ANNOUNCEMENT VIEW BY TITLE
    public function show_news($id){
        try{
            config()->set('adminlte.layout','top-nav');
            config()->set('adminlte.collapse_sidebar',false);
            $annc = Announcement::findOrFail($id);
            $char = new ChaInfo();
            return view('pages.public.show_news',compact('annc','char'));
        }catch(ModelNotFoundException $e){

        }
    }

    //ABOUT US VIEW
    public function about_us_view(){
        config()->set('adminlte.layout','top-nav');
        config()->set('adminlte.collapse_sidebar',false);
        $about = AboutUs::find(1);
        $char = new ChaInfo();
        return view('pages.public.about',compact('about','char'));
    }

    //DOWNLOAD PAGE VIEW
    public function download_view(){
        config()->set('adminlte.layout','top-nav');
        config()->set('adminlte.collapse_sidebar',false);
        $downloads = new Downloads();
        $char = new ChaInfo();
        return view('pages.public.download',compact('downloads','char'));
    }

    //RANKING VIEW
    public function ranking_view(){
        config()->set('adminlte.layout','top-nav');
        config()->set('adminlte.collapse_sidebar',false);
        $char = new ChaInfo();
        return view('pages.public.rank',compact('char'));
    }

    //ITEM MALL VIEW
    public function shop_view($id=0){
        config()->set('adminlte.layout','top-nav');
        config()->set('adminlte.collapse_sidebar',false);
        $items = new ShopItemMap();
        $char = new ChaInfo();
        return view('pages.public.shop',compact('items','id','char'));
    }

    //KNOWLEDGE BASE VIEW
    public function knowledgebase_view(){
        config()->set('adminlte.layout','top-nav');
        config()->set('adminlte.collapse_sidebar',false);
        $char = new ChaInfo();
        $kbs = new KnowledgeBase();
        $search = NULL;
        $cats = new KBCategory();
        return view('pages.public.knowledgebase',compact('char','kbs','search','cats'));
    }
    //KNOWLEDGE BASE ID VIEW
    public function knowledgebase_id_view($id){
        config()->set('adminlte.layout','top-nav');
        config()->set('adminlte.collapse_sidebar',false);
        $char = new ChaInfo();
        try{
            $kbn = KnowledgeBase::findOrFail($id);
            return view('pages.public.knowledgebase.view',compact('kbn','char'));
        }catch(ModelNotFoundException $e){
            return back()->with('error','Article doesnt exists.');
        }
    }
    //KNOWLEDGE BASE SEARCH
    public function knowledgebase_search(Request $req){
        config()->set('adminlte.layout','top-nav');
        config()->set('adminlte.collapse_sidebar',false);
        $char = new ChaInfo();
        $kbs = new KnowledgeBase();
        $search = ($req->input('search') ? $req->input('search') : NULL);
        $result = KnowledgeBase::where('title','LIKE','%'.$req->input('search').'%');
        $cats = new KBCategory();
        return view('pages.public.knowledgebase',compact('char','kbs','search','cats','result'));
    }
}
