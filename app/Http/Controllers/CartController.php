<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\RanShop\ShopPurchase;
use App\Traits\CaptureIpTrait;
use App\Models\RanGame1\ChaInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function ipaddress(){
		$ip = new CaptureIpTrait();
		return $ip->getClientIp();
	}


    //ADD CART PROCESS
    public function add_to_cart(Request $req){
    	if(!$req->ajax()){
    		return response()->json([
    			'status'	=>	0,
    			'text'		=>	'Request here must be ajax only.'
    		]);
    	}
    	$valid = Validator::make($req->all(),[
    		'product_id'	=>		'required|numeric'
    	]);
    	if($valid->fails()){
    		return response()->json([
    			'status'	=>	0,
    			'text'		=>	'You have something wrong with your input.'
    		]);
    	}
    	if(Cart::where(['product_id' => $req->input('product_id')])->where(['user_id' => Auth::user()->id])->count()){
    		Cart::where(['product_id' => $req->input('product_id')])->where(['user_id' => Auth::user()->id])->increment('quantity',1);
    	}else{
	    	Auth::user()->cart()->create([
	    		'product_id' => $req->input('product_id'),
	    		'quantity'	 => 1
	    	]);
    	}
    	return response()->json([
    			'status'	=>	1,
    			'text'		=>	'Product added to the cart!'
    	]);
    }
    //CART VIEW
    public function cart_view(){
    	$carts = new Cart();
        config()->set('adminlte.layout','top-nav');
        config()->set('adminlte.collapse_sidebar',false);
        $char = new ChaInfo();
    	return view('pages.public.cart.view',compact('carts','char'));
    }
    //CART CHECKOUT
    public function cart_checkout(){
    	if(Auth::user()->cart()->count() <= 0){
    		return back()->with('error','Sorry, But you dont have any items in your cart.');
    	}
    	$user = Auth::user();
    	foreach($user->cart()->with('product')->cursor() as $cart){
    		$total = $cart->product->first()->ItemPrice * $cart->quantity;
    		if($cart->product->first()->ItemSec == 1){
    			$process = "E-Points";
    			if($user->points()->first()->points < $total){
    				return back()->with('error','You dont have enough E-Points to purchase an item you selected.');
    			}
    			$user->points()->first()->decrement('points',$total);
    		}else{
    			$process = "Vote Points";
    			if($user->points()->first()->Vpoints < $total){
    				return back()->with('error','You dont have enough Vote Points to purchase an item you selected.');
    			}
    			$user->points()->first()->decrement('Vpoints',$total);
    		}
    		$i = 0;
    		for($i = 0;$i < $cart->quantity; $i++){
    			ShopPurchase::create([
			        'UserUID'		=> Auth::user()->name,
			        'ProductNum'	=> $cart->product_id
    			]);
    		}
    		$msg = 'You have successfully purchased from item mall.';
    		$msg .= '<table class="table">';
	    		$msg .= '<thead>';
		    		$msg .= '<tr>';
			    		$msg .= '<th>IMAGE</th>';
			    		$msg .= '<th>NAME</th>';
			    		$msg .= '<th>QUANTITY</th>';
			    		$msg .= '<th>UNIT PRICE</th>';
			    		$msg .= '<th>TOTAL</th>';
		    		$msg .= '</tr>';
	    		$msg .= '</thead>';
	    		$msg .= '<tbody>';
		    		$msg .= '<tr>';
		    			if($cart->product->first()->ItemSS != NULL){
		    				$msg .= '<td><img class="media-object" src="'.url('images/items/'.$cart->product->first()->ItemSS).'" width="70px"></td>';
		    			}else{
		    				$msg .= '<td><img class="media-object" src="https://itefix.net/sites/default/files/not_available.png" width="70px"></td>';
		    			}
		    			$msg .= '<td>'.$cart->product->first()->ItemName.'</td>';
		    			$msg .= '<td>'.$cart->quantity.'</td>';
		    			$msg .= '<td>'.number_format($cart->product->first()->ItemPrice,2).' '.$process.'</td>';
		    			$msg .= '<td>'.number_format(($cart->quantity * $cart->product->first()->ItemPrice),2).'</td>';
		    		$msg .= '</tr>';
	    		$msg .= '</tbody>';
    		$msg .= '</table>';
	    		$msg .= '';
    		Auth::user()->timeline()->create([
	   			'content'		=> 	$msg,
	   			'remark'		=>	'itemshop',
	 			'ip_address'	=> $this->ipaddress()
    		]);
    	}
    	$user->cart()->delete();
    	return redirect('/')->with('success','You have successfully purchased an item from item mall.');
    }

    //CART REMOVE BY ITEM
    public function remove_by_item($id){
        try{
            $cart = Cart::findOrFail($id);
            $title = $cart->product()->first()->ItemName;
            $cart->delete();
            return back()->with('success','You have successfully remove an item <b>'.$title.'</b>.');
        }catch(ModelNotFoundException $e){
            return back()->with('error','Item ID doesnt exists.');
        }
    }
    //CART REMOVE ALL ITEMS
    public function remove_items(){
        Auth::user()->cart()->delete();
        return back()->with('success','You have successfully remove all the items in your cart.');
    }
    //CART QUANTITY CONTROLL
    public function item_quantity($com,$id){
        try{
            $item = Cart::findOrFail($id);
            $title = $item->product()->first()->ItemName;
            if($com == "increase"){
                $item->quantity = $item->quantity + 1;
                $item->save();
                return back()->with('success','You have successfully added quantity to item <b>'.$title.'</b>.');
            }else{
                if($item->quantity == 1){
                    return back()->with('error','Item <b>'.$title.'</b> is already in minimum quantity. You might just remove it.');
                }
                $item->quantity = $item->quantity - 1;
                $item->save();
                return back()->with('success','You have successfully decrease quantity to item <b>'.$title.'</b>.');
            }
        }catch(ModelNotFoundException $e){
            return back()->with('error','Item ID doesnt exists.');
        }
    }
}
