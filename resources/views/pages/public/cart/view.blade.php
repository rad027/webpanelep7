@extends('adminlte::page')

@section('title', 'Cart')

@section('content_header')
    <h1>Cart</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3" style="padding: 0px 5px 0px 5px">
        @include('partials.sidepanel')
    </div>
    <div class="col-md-9" style="padding: 0px 5px 0px 5px">
    	<div class="box">
    		<div class="box-body">
    			@if(Auth::user()->cart()->count())
    			<table class="table">
    				<thead>
    					<tr>
                            <th>&nbsp;</th>
    						<th>IMAGE</th>
    						<th>NAME</th>
    						<th>QUANTITY</th>
    						<th>UNIT PRICE</th>
    						<th>SUB TOTAL</th>
    					</tr>
    				</thead>
    				<tbody>
    					@php
    						$tvpoint = 0;
    						$tepoint = 0;
    					@endphp
    					@foreach(Auth::user()->cart()->with('product')->cursor() as $cart)
    					<tr>
                            <td>
                                <a href="{{ url('cart/'.$cart->id.'/remove') }}" class="btn btn-flat btn-xs btn-danger" onclick="return confirm('Are you sure you want to remove this item?')">REMOVE</a>
                                <a href="{{ url('cart/decrease/'.$cart->id.'/item') }}" class="btn btn-flat btn-xs btn-warning" title="REMOVE 1 QUANTITY"><i class="fa fa-minus"></i></a>
                                <a href="{{ url('cart/increase/'.$cart->id.'/item') }}" class="btn btn-flat btn-xs btn-success" title="ADD 1 QUANTITY"><i class="fa fa-plus"></i></a>
                            </td>
    						<td> <img class="media-object" src="@If($cart->product->first()->ItemSS != NULL){{ url('images/items/'.$cart->product->first()->ItemSS) }}@else https://itefix.net/sites/default/files/not_available.png @endif" alt="{{ $cart->product->first()->ItemName }}" width="70px"></td>
    						<td>{{ $cart->product->first()->ItemName }}</td>
    						<td>{{ $cart->quantity }}</td>
    						<td class="border-right">
								@if($cart->product->first()->ItemSec == 1)
									{{ number_format($cart->product->first()->ItemPrice,2) }} E-Points
								@else
									{{ number_format($cart->product->first()->ItemPrice,2) }} Vote Points
								@endif
							</td>
    						<td>
								@if($cart->product->first()->ItemSec == 1)
									{{ number_format(($cart->quantity * $cart->product->first()->ItemPrice),2) }} E-Points
									@php
										$tepoint += ($cart->quantity * $cart->product->first()->ItemPrice);
									@endphp
								@else
									{{ number_format(($cart->quantity * $cart->product->first()->ItemPrice),2) }} Vote Points
									@php
										$tvpoint += ($cart->quantity * $cart->product->first()->ItemPrice);
									@endphp
								@endif
    						</td>
    					</tr>
    					@endforeach
    					<tr>
    						<td colspan="5" class="border-right"><a href="{{ url('cart/remove/all') }}" class="btn btn-flat btn-xs btn-danger" onclick="return confirm('Are you sure you want to remove all items?')">REMOVE ALL</a></td>
    						<th style="text-align: center">TOTAL</th>
    					</tr>
    					<tr>
    						<td colspan="4" class="border-right"></td>
    						<th style="text-align: right" class="border-right">
    							TOTAL VOTE POINTS
    						</th>
    						<td>
    							{{ number_format($tvpoint,2) }}
    						</td>
    					</tr>
    					<tr>
    						<td colspan="4" class="border-right"></td>
    						<th style="text-align: right" class="border-right">
    							TOTAL EPOINTS
    						</th>
    						<td>
    							{{ number_format($tepoint,2) }}
    						</td>
    					</tr>
    					<tr>
    						<td colspan="5" class="border-right"></td>
    						<th style="text-align: center"><a href="{{ url('cart/checkout') }}" class="btn btn-block btn-success btn-flat">CHECKOUT</a></th>
    					</tr>
    				</tbody>
    			</table>
    			@else
    			<div class="alert alert-warning">
    				You dont have any item that has been added to your cart.
    			</div>
    			@endif
    		</div>
    	</div>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop