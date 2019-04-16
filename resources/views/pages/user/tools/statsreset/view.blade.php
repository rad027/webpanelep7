@extends('adminlte::page')

@section('title', 'Statistical Points Reset')

@section('content_header')
    <h1>Statistical Points Reset</h1>
@stop

@section('content')
<div class="box">
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
		<form action="{{ url('user/statsreset') }}" method="POST">
			@csrf
			<div class="form-group">
				<label>SELECT CHARACTER :</label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT A CHARACTER";
				if($char->count() > 0):
				foreach($char->cursor() as $chars):
					if($chars->ChaDeleted == 0):
					$newlist[$chars->ChaNum] = $chars->ChaName." [RB. ".$chars->ChaReborn."/LvL. ".$chars->ChaLevel."]";
					endif;
				endforeach;
				endif;
				@endphp
				{!!Form::select('ChaID', $newlist, old('ChaID'), ['class' => 'form-control'])!!}
			</div>
			<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
				<label>PASSWORD :</label>
				<input type="password" name="password" class="form-control" placeholder="Enter your password.">
			</div>
			<button class="btn btn-success" type="submit">PROCESS RESET</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$('select').select2();
});
</script>
@stop