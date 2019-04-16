@extends('adminlte::page')

@section('title', 'Convert Points')

@section('content_header')
    <h1>Convert Points</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<div class="callout callout-warning">
			<h4>CONVERTION GUIDE:</h4>
			<p>
				<ul>
					<li> {{ config('app.convert_points.FROM_VP_TO_GOLD_REQUIRED_AMOUNT') }} VOTE POINTS = {{ number_format(config('app.convert_points.FROM_VP_TO_GOLD_AMOUNT'),2) }} IN-GAME GOLD </li>
					<li> {{ config('app.convert_points.FROM_EP_TO_GOLD_REQUIRED_AMOUNT') }} E-POINTS = {{ number_format(config('app.convert_points.FROM_EP_TO_GOLD_AMOUNT'),2) }} IN-GAME GOLD </li>
					<li> {{ config('app.convert_points.FROM_VP_TO_PP_REQUIRED_AMOUNT') }} VOTE POINTS = {{ number_format(config('app.convert_points.FROM_VP_TO_PP_AMOUNT'),2) }} PREMIUM POINTS </li>
					<li> {{ config('app.convert_points.FROM_EP_TO_ZG_REQUIRED_AMOUNT') }} E-POINTS = {{ number_format(config('app.convert_points.FROM_EP_TO_ZG_AMOUNT'),2) }} ZG POINTS </li>
				</ul>
			</p>
		</div>
		<form method="POST">
			@csrf
			<div class="form-group {{ $errors->has('from_points') ? 'has-error' : '' }}">
				<label>CONVERT POINTS FROM :</label>
				@php
					$newlist = array();
					$newlist[''] = "SELECT POINTS TO CONVERT";
					$newlist['vpoints'] = "Vote Points";
					$newlist['epoints'] = "E-Points";
				@endphp
				{!! Form::select('from_points', $newlist, old('from_points'), [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('to_points') ? 'has-error' : '' }}">
				<label>CONVERT POINTS TO :</label>
				@php
					$newlist = array();
					$newlist[''] = "SELECT POINTS FROM CONVERT";
					$newlist['ppoints'] = "Premium Points";
					$newlist['zgpoints'] = "ZG Points";
					$newlist['gold'] = "IN-GAME GOLD";
				@endphp
				{!! Form::select('to_points', $newlist, old('to_points'), [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group characters {{ $errors->has('ChaID') ? 'has-error' : '' }}" @if(old('to_points') == "vpoints" || old('to_points') == "epoints" || old('to_points') == null ) style="display: none" @else @endif>
				<label>SELECT CHARACTER :</label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT A CHARACTER";
				if($char->count() > 0):
				foreach($char->cursor() as $chars):
					if($chars->ChaDeleted == 0):
					$newlist[$chars->ChaNum] = $chars->ChaName." [Gold : ".number_format($chars->ChaMoney,2).", ZG : ".number_format($chars->ChaVotePoint,2).", Premium : ".number_format($chars->ChaPremiumPoint,2)."]";
					endif;
				endforeach;
				endif;
				@endphp
				{!!Form::select('ChaID', $newlist, old('ChaID'), ['class' => 'form-control'])!!}
			</div>
			<div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
				<label>AMOUNT :</label>
				{!! Form::text('amount', old('amount'), [ 'class' => 'form-control', 'placeholder' => 'Enter amount to convert.' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
				<label>PASSWORD :</label>
				<input type="password" name="password" class="form-control" placeholder="Enter your password.">
			</div>
			<button class="btn btn-flat btn-success" type="submit">CONVERT</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$('select[name="to_points"]').change(function(){
		if($(this).val() == "gold" || $(this).val() == "ppoints" || $(this).val() == "zgpoints"){
			$('div.characters').slideDown();
			$('select').select2();
		}else{
			$('div.characters').slideUp();
		}
	});
	$('select').select2();
});
</script>
@stop