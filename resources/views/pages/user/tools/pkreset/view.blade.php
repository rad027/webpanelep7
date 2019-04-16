@extends('adminlte::page')

@section('title', 'PK Points Reset')

@section('content_header')
    <h1>PK Points Reset</h1>
@stop

@section('content')
<div class="box">
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
		<form action="{{ url('user/pkreset') }}" method="POST">
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