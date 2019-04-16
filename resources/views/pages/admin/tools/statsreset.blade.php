@extends('adminlte::page')

@section('title', 'Statistical Points Reset')

@section('content_header')
    <h1>Statistical Points Reset</h1>
@stop

@section('content')
{{-- STATISTICAL RESET SETTINGS --}}
<div class="box">
	<div class="box-header">
		<h3 class="box-title">STATISTICAL POINTS RESET SETTING</h3>
	</div>
	<div class="box-body">
		<form action="{{ url('tools/statsreset/setting') }}" method="post">
			@csrf
			<div class="form-group">
				<label>STATISTICAL POINTS CURRENCY :</label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT A CURRENCY";
				$newlist['VP'] = "VOTE POINTS";
				$newlist['EP'] = "E-POINTS";
				$newlist['PP'] = "PREMIUM POINTS";
				$newlist['GOLD'] = "GOLD";
				@endphp
				{!!Form::select('STATISTICAL_POINTS_CURRENCY', $newlist, config('app.stats_points.currency'), ['class' => 'form-control'])!!}
			</div>
			<div class="form-group">
				<label>REQUIRED AMOUNT :</label>
				{!! Form::text('STATISTICAL_POINTS_AMOUNT', config('app.stats_points.required_amount'), array('class' => 'form-control')) !!}
			</div>
			<button class="btn btn-success" type="submit">UPDATE</button>
		</form>
	</div>
</div>
{{-- CHARACTER STATISTICAL POINTS RESET --}}
<div class="box">
	<div class="box-header">
		<h3 class="box-title">CHARACTER STATISTICAL POINTS RESET</h3>
	</div>
	<div class="box-body">
		<div class="callout callout-warning">
			<h4>Prerequisites:</h4>
			<p>
				<ul>
					@if(config('app.stats_points.currency') == "VP")
					<li>{{ config('app.stats_points.required_amount') }} Vote Points</li>
					@elseif(config('app.stats_points.currency') == "EP")
					<li>{{ config('app.stats_points.required_amount') }} E-Points</li>
					@elseif(config('app.stats_points.currency') == "PP")
					<li>{{ config('app.stats_points.required_amount') }} Premium Points</li>
					@else
					<li>{{ config('app.stats_points.required_amount') }} Gold</li>
					@endif
					@php
			        if(config('app.reborn.5.status') == 1){
			            $maxReborn = config('app.reborn.5.to');
			        }else if(config('app.reborn.4.status') == 1){
			            $maxReborn = config('app.reborn.4.to');
			        }else if(config('app.reborn.3.status') == 1){
			            $maxReborn = config('app.reborn.3.to');
			        }else if(config('app.reborn.2.status') == 1){
			            $maxReborn = config('app.reborn.2.to');
			        }else{
			            $maxReborn = config('app.reborn.1.to');
			        }
					@endphp
					<li>RB {{ $maxReborn }}, Lvl 700</li>
				</ul>
			</p>
			<h4>Note:</h4>
			<p>
				<ul>
					<li>Add Stats thru command : <span class="text-danger">E.g... /pow 50000</span></li>
				</ul>
			</p>
			<h4>Notice:</h4>
			<p>
				<ul>
					<li>Follow the requirements to avoid item loss.</li>
					<li><img src="{{ url('tools/inventory.png') }}"></li>
				</ul>
			</p>
			<h4>Reward:</h4>
			<p>
				<ul>
					<li>Stats Remaining : {{number_format(51800,2)}}</li>
				</ul>
			</p>
			
		</div>
		<form action="{{ url('tools/statsreset') }}" method="POST">
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