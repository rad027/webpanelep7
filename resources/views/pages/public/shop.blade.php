@extends('adminlte::page')

@section('title', 'Item Mall')

@section('content_header')
    <h1>Item Mall</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3" style="padding: 0px 5px 0px 5px">
        @include('partials.sidepanel')
    </div>
    <div class="col-md-9" style="padding: 0px 5px 0px 5px">
    	<div class="box">
    		<div class="box-body">
    			@php
    				$items = ($id == 0 ? $items->where(['IsHidden' => NULL]) : $items->where(['IsHidden' => NULL])->where(['ItemCtg' => $id]));
    			@endphp
    			@if($items->count() > 0)
	    			<div class="row">
	    			@foreach($items->cursor() as $item)
	    				<div class="col-md-6">
	    					<div class="box">
	    						<div class="box-body">
								<div class="media">
								  <div class="media-left">
								    <a href="#">
								      <img class="media-object" src="@If($item->ItemSS != NULL){{ url('images/items/'.$item->ItemSS) }}@else https://itefix.net/sites/default/files/not_available.png @endif" alt="{{ $item->ItemName }}" width="70px">
								    </a>
								  </div>
								  <div class="media-body">
								    <h4 class="media-heading">{{ $item->ItemName }}</h4>
									@if($item->ItemSec == 1)
										{{ number_format($item->ItemPrice,2) }} E-Points
									@else
										{{ number_format($item->ItemPrice,2) }} Vote Points
									@endif
									[STOCKS : {{ $item->Itemstock }}]
									<div class="">
										<a href="#" onclick="return inewWorks.mods('{{ $item->ItemName }}','@If($item->ItemSS != NULL){{ url('images/items/'.$item->ItemSS) }}@else https://itefix.net/sites/default/files/not_available.png @endif','@if($item->ItemSec == 1) {{ number_format($item->ItemPrice,2) }} E-Points @else {{ number_format($item->ItemPrice,2) }} Vote Points @endif','{{ $item->ItemComment }}','{{ $item->ProductNum }}','{{ $item->Itemstock }}');" class="btn btn-xs bg-navy btn-flat">VIEW</a>
									</div>
								  </div>
								</div>
	    						</div>
	    					</div>
	    				</div>
	    			@endforeach
	    			</div>
    			@else
    				NO ITEMS HERE.
    			@endif
    		</div>
    	</div>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript" src="https://github.com/makeusabrew/bootbox/releases/download/v4.4.0/bootbox.min.js"></script>
<script type="text/javascript">
$.ajaxSetup({
  headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
});
var inewWorks = {
	mods : function(title,img,price,desc,id,stock){
		var x = '<center><img src="'+img+'"></center>';
			x += '<div style="padding:10px;margin:5px" class="bg-light-blue disabled color-palette">';
			x += '<b> PRICE : </b>'+price+'<br>';
			x += '<b> STOCK : </b>'+stock+'<br>';
			x += '<b> DESCRIPTION : </b><i>'+desc+'</i><br>';
			x += '</div>';
			@if(Auth::guest())
			x += '<div style="padding:10px;margin:5px" class="bg-red disabled color-palette">';
			x += 'Please login to start purchasing items.';
			x += '</div>';
			@endif
		var dialog = bootbox.dialog({
		title: title,
		message: x,
		@if(!Auth::guest())
		buttons: {
		    cancel: {
		        label: "<i class='fa fa-cart-plus'></i> ADD TO CART!",
		        className: 'btn-success',
		        callback: function(){
					bootbox.dialog({ message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Loading...</div>' });		        	
		            $.ajax({
		            	url : '{{ url("shop/addtocart") }}',
		            	data : { product_id : id },
		            	type : 'post',
		            	success : function(res){
		            		if(res.status == 1){
		            			bootbox.hideAll();
		            			$('span.cart-badge').html((parseInt($('span.cart-badge').html())+1));
		            			bootbox.alert('Product <b>'+title+'</b> was successfully added to the cart.');
		            		}else{
		            			bootbox.hideAll();
		            			bootbox.alert(res.text);
		            		}
		            	},
		            	error : function(res){
		            		console.log(res);
		            	}
		            });
		        }
		    },
		}
		@endif
		});
		return false;
	}
}
</script>
@stop