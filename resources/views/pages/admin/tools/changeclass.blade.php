@extends('adminlte::page')

@section('title', 'Change Class')

@section('content_header')
    <h1>Change Class</h1>
@stop

@section('content')
{{-- CHANGE CLASS SETTING --}}
<div class="box">
	<div class="box-header">
		<h3 class="box-title">CHANGE CLASS SETTING</h3>
	</div>
	<div class="box-body">
		<form action="{{ url('tools/changeclass/setting') }}" method="post">
			@csrf
			<div class="form-group">
				<label>POINTS CURRENCY :</label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT A CURRENCY";
				$newlist['VP'] = "VOTE POINTS";
				$newlist['EP'] = "E-POINTS";
				$newlist['PP'] = "PREMIUM POINTS";
				$newlist['GOLD'] = "GOLD";
				@endphp
				{!!Form::select('CHANGE_CLASS_CURRENCY', $newlist, config('app.change_class.currency'), ['class' => 'form-control'])!!}
			</div>
			<div class="form-group">
				<label>REQUIRED AMOUNT :</label>
				{!! Form::text('CHANGE_CLASS_AMOUNT', config('app.change_class.required_amount'), array('class' => 'form-control')) !!}
			</div>
			<button class="btn btn-success" type="submit">UPDATE</button>
		</form>
	</div>
</div>
{{-- CHANGE CHARACTER`S CLASS --}}
<div class="box">
	<div class="box-header">
		<h3 class="box-title">CHANGE CHARACTER`S CLASS</h3>
	</div>
	<div class="box-body">
		<div class="callout callout-warning">
			<h4>Prerequisites:</h4>
			<p>
				<ul>
					@if(config('app.change_class.currency') == "VP")
					<li>{{ config('app.change_class.required_amount') }} Vote Points</li>
					@elseif(config('app.change_class.currency') == "EP")
					<li>{{ config('app.change_class.required_amount') }} E-Points</li>
					@elseif(config('app.change_class.currency') == "PP")
					<li>{{ config('app.change_class.required_amount') }} Premium Points</li>
					@else
					<li>{{ config('app.change_class.required_amount') }} Gold</li>
					@endif
					<li>Remove all your equiped items</li>
				</ul>
			</p>
			<h4>Notice:</h4>
			<p>
				<ul>
					<li>Follow the requirements to avoid item loss.</li>
					<li>207 - 237 are not included in this function.</li>
					<li><img src="{{ url('tools/inventory.png') }}"></li>
				</ul>
			</p>
			
		</div>
		<form action="{{ url('tools/changeclass') }}" method="post">
			@csrf
			<div class="form-group">
				<label>SELECT USER ACCOUNT : <span class="text-danger errormoto"></span></label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT USER ACCOUNT";
				if($users->count() > 0):
					foreach($users->orderBy('UserNum','ASC')->get()->chunk($users->count()) as $user):
						foreach($user as $userr):
							$newlist[$userr->UserNum] = $userr->UserID;
						endforeach;
					endforeach;
				endif;
				@endphp
				{!!Form::select('UserNum', $newlist, old('UserNum'), ['class' => 'form-control'])!!}
			</div>
			<div class="form-group">
				<label>SELECT A CHARACTER :</label>
				<select class="form-control" name="CharID" disabled>
					<option value="">SELECT A CHARACTER</option>
				</select>
			</div>
			<div class="form-group">
				<label>SELECT NEW CLASS :</label>
				@php
				$newlist = array();
				$newlist[''] 		= "SELECT NEW CLASS";
				$newlist['ARCHER']	= [
										'256'	=>	'Archer[M]',
										'4'		=>	'Archer[F]'
									];
				$newlist['BRAWLER']	= [
										'1'		=>	'Brawler[M]',
										'64'	=>	'Brawler[F]'
									];
				$newlist['SWORDSMAN']	= [
										'2'		=>	'Swordsman[M]',
										'128'	=>	'Swordsman[F]'
									];
				$newlist['SHAMAN']	= [
										'512'	=>	'Shaman[M]',
										'8'		=>	'Shaman[F]'
									];
				$newlist['GUNNER']	= [
										'16'	=>	'Gunner[M]',
										'32'	=>	'Gunner[F]'
									];
				@endphp
				{!!Form::select('class', $newlist, old('class'), ['class' => 'form-control'])!!}
			</div>
			<button class="btn btn-sm btn-success" type="submit">CHANGE CLASS</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$.ajaxSetup({
		headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
	});
	$('select').select2();
	$('select[name="UserNum"]').change(function(){
		$('span.errormoto').html('Loading...');
		$('select[name="CharID"]').prop('disabled',true).html('<option value="">SELECT A CHARACTER</option>');
        $.ajax({
        	url : '{{ url('tools/reborn/charinfo') }}',
        	type : 'POST',
        	data : { 'UserNum' : $(this).val() },
        	success : function(res){
        		if(res.status !== 0){
					$('select[name="CharID"]').prop('disabled',false).html(res.msg);
					$('span.errormoto').html('');
        		}else{
					$('span.errormoto').html('There is no character that have been made by this user.');
        		}
        	}
        });
	});
});
</script>
@stop