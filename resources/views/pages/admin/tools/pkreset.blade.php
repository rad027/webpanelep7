@extends('adminlte::page')

@section('title', 'PK Points Reset')

@section('content_header')
    <h1>PK Points Reset</h1>
@stop

@section('content')
{{-- PK RESET SETTINGS --}}
<div class="box">
	<div class="box-header">
		<h3>PK POINTS RESET SETTING</h3>
	</div>
	<div class="box-body">
		<form action="{{ url('tools/pkreset/setting') }}" method="post">
			@csrf
			<div class="form-group">
				<label>PK POINTS CURRENCY :</label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT A CURRENCY";
				$newlist['VP'] = "VOTE POINTS";
				$newlist['EP'] = "E-POINTS";
				$newlist['PP'] = "PREMIUM POINTS";
				$newlist['GOLD'] = "GOLD";
				@endphp
				{!!Form::select('PK_POINTS_CURRENCY', $newlist, config('app.pk_points.currency'), ['class' => 'form-control'])!!}
			</div>
			<div class="form-group">
				<label>REQUIRED AMOUNT :</label>
				{!! Form::text('PK_POINTS_AMOUNT', config('app.pk_points.required_amount'), array('class' => 'form-control')) !!}
			</div>
			<button class="btn btn-success" type="submit">UPDATE</button>
		</form>
	</div>
</div>
{{-- CHARACTER PK RESET --}}
<div class="box">
	<div class="box-header">
		<h3>CHARACTER PK POINTS RESET</h3>
	</div>
	<div class="box-body">
		<div class="callout callout-warning">
			<h4>Prerequisites:</h4>
			<p>
				<ul>
					@if(config('app.pk_points.currency') == "VP")
					<li>{{ config('app.pk_points.required_amount') }} Vote Points</li>
					@elseif(config('app.pk_points.currency') == "EP")
					<li>{{ config('app.pk_points.required_amount') }} E-Points</li>
					@elseif(config('app.pk_points.currency') == "PP")
					<li>{{ config('app.pk_points.required_amount') }} Premium Points</li>
					@else
					<li>{{ config('app.pk_points.required_amount') }} Gold</li>
					@endif
				</ul>
			</p>
			<h4>Reward:</h4>
			<p>
				<ul>
					<li>+20 Bright Points</li>
				</ul>
			</p>
			
		</div>
		<form action="{{ url('tools/pkreset') }}" method="POST">
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
			<button class="btn btn-success" type="submit">RESET</button>
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