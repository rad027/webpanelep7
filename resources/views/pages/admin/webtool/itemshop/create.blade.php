@extends('adminlte::page')

@section('title', 'Item Shop - Create New Item')

@section('content_header')
    <h1>Item Shop - Create New Item</h1>
@stop
{{-- onkeypress="return isNumberKey(event)" --}}
@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('webtool/itemshop/create') }}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="form-group {{ $errors->has('ItemName') ? 'has-error' : '' }}">
				<label>ITEM NAME <span class="text-danger">*</span>:</label>
				{!! Form::text('ItemName', old('ItemName'), [ 'class' => 'form-control', 'placeholder' => 'Enter item name.' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_main') ? 'has-error' : '' }}">
				<label>ITEM MAIN <span class="text-danger">*</span>:</label>
				{!! Form::text('item_main', old('item_main'), [ 'class' => 'form-control', 'placeholder' => 'Enter item main.', 'onkeypress' => 'return isNumberKey(event)' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_sub') ? 'has-error' : '' }}">
				<label>ITEM SUB <span class="text-danger">*</span>:</label>
				{!! Form::text('item_sub', old('item_sub'), [ 'class' => 'form-control', 'placeholder' => 'Enter item sub.', 'onkeypress' => 'return isNumberKey(event)' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_section') ? 'has-error' : '' }}">
				<label>ITEM SECTION <span class="text-danger">*</span>:</label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT ITEM SECTION";
				$newlist['1'] = "PREMIUM SHOP";
				$newlist['2'] = "VOTE SHOP";
				@endphp
				{!! Form::select('item_section', $newlist, old('item_section'), [ 'class' => 'form-control' ]) !!}
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
				{!! Form::select('item_category', $newlist, old('item_category'), [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_stock') ? 'has-error' : '' }}">
				<label>ITEM STOCK <span class="text-danger">*</span>:</label>
				{!! Form::text('item_stock', old('item_stock'), [ 'class' => 'form-control', 'placeholder' => 'Enter item stock.', 'onkeypress' => 'return isNumberKey(event)' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_price') ? 'has-error' : '' }}">
				<label>ITEM PRICE <span class="text-danger">*</span>:</label>
				{!! Form::text('item_price', old('item_price'), [ 'class' => 'form-control', 'placeholder' => 'Enter item price.', 'onkeypress' => 'return isNumberKey(event)' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_hidden') ? 'has-error' : '' }}">
				<label>HIDDEN <span class="text-danger">*</span>:</label>
				@php
				$newlist = array();
				$newlist['1'] = "TRUE";
				$newlist[NULL] = "FALSE";
				@endphp
				{!! Form::select('item_hidden', $newlist, old('item_hidden'), [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_description') ? 'has-error' : '' }}">
				<label>ITEM DESCRIPTION <span class="text-danger">*</span>:</label>
				{!! Form::textarea('item_description', old('item_description'), [ 'class' => 'form-control', 'placeholder' => 'Enter item description.', 'style' => 'resize:none' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('item_description') ? 'has-error' : '' }}">
				<label>ITEM IMAGE <span class="text-danger">*</span>:</label>
				<div class="input-group">
					<span class="input-group-btn">
						<span class="btn btn-primary btn-file">
							Browse… <input type="file" name="item_image" id="imgInp">
						</span>
					</span>
					<input type="text" class="form-control" readonly placeholder="Upload item image.">
				</div>
			</div>
			<button class="btn btn-success" type="submit">CREATE</button>
		</form>
	</div>
</div>
@stop

@section('css')
<style type="text/css">
  .btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

#img-upload{
    width: 100%;
}
</style>
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$('select').select2();
})
</script>
<script type="text/javascript">
$(document).ready(function(){function d(b){if(b.files&&b.files[0]){var a=new FileReader;a.onload=function(a){$("#img-upload").attr("src",a.target.result)};a.readAsDataURL(b.files[0])}}$(document).on("change",".btn-file :file",function(){var b=$(this),a=b.val().replace(/\\/g,"/").replace(/.*\//,"");b.trigger("fileselect",[a])});$(".btn-file :file").on("fileselect",function(b,a){var c=$(this).parents(".input-group").find(":text");c.length?c.val(a):a&&alert(a)});$("input#imgInp").change(function(){d(this)})});
</script>
@stop