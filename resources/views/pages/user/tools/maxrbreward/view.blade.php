@extends('adminlte::page')

@section('title', 'Max Reborn Reward')

@section('content_header')
    <h1>Max Reborn Reward</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<div class="callout callout-warning">
			<h4>Prerequisites:</h4>
			<p>
				<ul>
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
					<li>RB {{ $maxReborn }}, Lv. 500+/700</li>
				</ul>
			</p>
			<h4>Reward:</h4>
			<p>
				<ul>
					<li>+2,000 Premium Points(For RB {{ $maxReborn }}, Lv. 500)</li>
					<li>+500 Premium Points(For RB {{ $maxReborn }}, Lv. 700)</li>
				</ul>
			</p>
		</div>
		<form action="{{ url('user/maxrbreward') }}" method="POST">
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
			<button class="btn btn-success" type="submit">PROCESS REWARD</button>
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