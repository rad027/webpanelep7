@extends('adminlte::page')

@section('title', 'Item Shop Edit ['.$item->ItemName.']')

@section('content_header')
    <h1>Item Shop Edit [<b>{{ $item->ItemName }}</b>]</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('webtool/itemshop/'.$item->ProductNum.'/edit') }}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="form-group {{ $errors->has('ItemName') ? 'has-error' : '' }}">
				<label>ITEM NAME <span class="text-danger">*</span>:</label>
				{!! Form::text('ItemName', $item->ItemName, [ 'class' => 'form-control', 'placeholder' => 'Enter item name.' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_main') ? 'has-error' : '' }}">
				<label>ITEM MAIN <span class="text-danger">*</span>:</label>
				{!! Form::text('item_main', $item->ItemMain, [ 'class' => 'form-control', 'placeholder' => 'Enter item main.', 'onkeypress' => 'return isNumberKey(event)' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_sub') ? 'has-error' : '' }}">
				<label>ITEM SUB <span class="text-danger">*</span>:</label>
				{!! Form::text('item_sub', $item->ItemSub, [ 'class' => 'form-control', 'placeholder' => 'Enter item sub.', 'onkeypress' => 'return isNumberKey(event)' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_section') ? 'has-error' : '' }}">
				<label>ITEM SECTION <span class="text-danger">*</span>:</label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT ITEM SECTION";
				$newlist['1'] = "PREMIUM SHOP";
				$newlist['2'] = "VOTE SHOP";
				@endphp
				{!! Form::select('item_section', $newlist, $item->ItemSec, [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_category') ? 'has-error' : '' }}">
				<label>ITEM CATEGORY <span class="text-danger">*</span>:</label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT ITEM CATEGORY";
				$newlist['1'] = "Weapons";
				$newlist['2'] = "Accessories";
				$newlist['3'] = "Costumes";
				$newlist['4'] = "Pet System";
				$newlist['5'] = "EXP";
				$newlist['6'] = "Cards";
				$newlist['7'] = "Enhancements";
				@endphp
				{!! Form::select('item_category', $newlist, $item->ItemCtg, [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_stock') ? 'has-error' : '' }}">
				<label>ITEM STOCK <span class="text-danger">*</span>:</label>
				{!! Form::text('item_stock', $item->Itemstock, [ 'class' => 'form-control', 'placeholder' => 'Enter item stock.', 'onkeypress' => 'return isNumberKey(event)' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_price') ? 'has-error' : '' }}">
				<label>ITEM PRICE <span class="text-danger">*</span>:</label>
				{!! Form::text('item_price', $item->ItemPrice, [ 'class' => 'form-control', 'placeholder' => 'Enter item price.', 'onkeypress' => 'return isNumberKey(event)' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_hidden') ? 'has-error' : '' }}">
				<label>HIDDEN <span class="text-danger">*</span>:</label>
				@php
				$newlist = array();
				$newlist['1'] = "TRUE";
				$newlist[NULL] = "FALSE";
				@endphp
				{!! Form::select('item_hidden', $newlist, $item->IsHidden, [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_description') ? 'has-error' : '' }}">
				<label>ITEM DESCRIPTION <span class="text-danger">*</span>:</label>
				{!! Form::textarea('item_description', $item->ItemComment, [ 'class' => 'form-control', 'placeholder' => 'Enter item description.', 'style' => 'resize:none' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_description') ? 'has-error' : '' }}">
				<label>ITEM IMAGE:</label>
				<div class="input-group">
					<span class="input-group-btn">
						<span class="btn btn-primary btn-file">
							Browse… <input type="file" name="item_image" id="imgInp">
						</span>
					</span>
					<input type="text" class="form-control" readonly placeholder="Upload item image.">
				</div>
			</div>
			<div class="form-group">
				<img src="@If($item->ItemSS != NULL){{ url('images/items/'.$item->ItemSS) }}@else https://itefix.net/sites/default/files/not_available.png @endif" width="50px">
			</div>
			<a href="{{ url('webtool/itemshop') }}" class="btn btn-danger">BACK</a>
			<button class="btn btn-success" type="submit">UPDATE</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop