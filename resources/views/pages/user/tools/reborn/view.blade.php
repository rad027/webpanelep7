@extends('adminlte::page')

@section('title', 'Reborn System')

@section('content_header')
    <h1>Reborn System</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<div class="callout callout-warning">
			<h4>Reborn Stage 1 ({{ config('app.reborn.1.from') }}-{{ config('app.reborn.1.to') }})</h4>
			<p>
				<ul>
					<li><b>REQUIRED LEVEL :</b> {{ config('app.reborn.1.level') }}</li>
					<li><b>REQUIRED GOLD :</b> {{ number_format(config('app.reborn.1.gold'),2) }}</li>
					<li><b>REBORN REWARD :</b> Character Stat Points + {{ config('app.reborn.1.reward') }}</li>
				</ul>
			</p>
			@if(config('app.reborn.2.status') == 1)
			<h4>Reborn Stage 2 ({{ config('app.reborn.2.from') }}-{{ config('app.reborn.2.to') }})</h4>
			<p>
				<ul>
					<li><b>REQUIRED LEVEL :</b> {{ config('app.reborn.2.level') }}</li>
					<li><b>REQUIRED GOLD :</b> {{ number_format(config('app.reborn.2.gold'),2) }}</li>
					<li><b>REBORN REWARD :</b> Character Stat Points + {{ config('app.reborn.2.reward') }}</li>
				</ul>
			</p>
			@endif
			@if(config('app.reborn.3.status') == 1)
			<h4>Reborn Stage 3 ({{ config('app.reborn.3.from') }}-{{ config('app.reborn.3.to') }})</h4>
			<p>
				<ul>
					<li><b>REQUIRED LEVEL :</b> {{ config('app.reborn.3.level') }}</li>
					<li><b>REQUIRED GOLD :</b> {{ number_format(config('app.reborn.3.gold'),2) }}</li>
					<li><b>REBORN REWARD :</b> Character Stat Points + {{ config('app.reborn.3.reward') }}</li>
				</ul>
			</p>
			@endif
			@if(config('app.reborn.4.status') == 1)
			<h4>Reborn Stage 4 ({{ config('app.reborn.4.from') }}-{{ config('app.reborn.4.to') }})</h4>
			<p>
				<ul>
					<li><b>REQUIRED LEVEL :</b> {{ config('app.reborn.4.level') }}</li>
					<li><b>REQUIRED GOLD :</b> {{ number_format(config('app.reborn.4.gold'),2) }}</li>
					<li><b>REBORN REWARD :</b> Character Stat Points + {{ config('app.reborn.4.reward') }}</li>
				</ul>
			</p>
			@endif
			@if(config('app.reborn.5.status') == 1)
			<h4>Reborn Stage 5 ({{ config('app.reborn.5.from') }}-{{ config('app.reborn.5.to') }})</h4>
			<p>
				<ul>
					<li><b>REQUIRED LEVEL :</b> {{ config('app.reborn.5.level') }}</li>
					<li><b>REQUIRED GOLD :</b> {{ number_format(config('app.reborn.5.gold'),2) }}</li>
					<li><b>REBORN REWARD :</b> Character Stat Points + {{ config('app.reborn.5.reward') }}</li>
				</ul>
			</p>
			@endif
		</div>
		<form action="{{ url('user/reborn') }}" method="post">
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
			<div class="form-group">
				<label>CURRENT PASSWORD :</label>
				{!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter your current password.')) !!}
			</div>
			<button class="btn btn-success" type="submit">REBORN!</button>
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