@extends('adminlte::page')

@section('title', 'Reborn System')

@section('content_header')
    <h1>Reborn System</h1>
@stop

@section('content')
{{-- REBORN CHARACTER --}}
@if(config('app.reborn_system') == 1)
<div class="box">
	<div class="box-header">
		<h3 class="box-title">REBORN A CHARACTER</h3>
	</div>
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
		<form action="{{ url('tools/reborn') }}" method="POST">
			@csrf
			<div class="form-group">
				<label>SELECT USER ACCOUNT : <span class="text-danger errormoto"></span></label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT USER ACCOUNT";
				foreach($users as $user):
					$newlist[$user->UserNum] = $user->UserID;
				endforeach;
				@endphp
				{!!Form::select('UserNum', $newlist, old('UserNum'), ['class' => 'form-control'])!!}
			</div>
			<div class="form-group">
				<label>SELECT A CHARACTER :</label>
				<select class="form-control" name="CharID" disabled>
					<option value="">SELECT A CHARACTER</option>
				</select>
			</div>
			<button class="btn btn-sm btn-success" type="submit">REBORN</button>
		</form>
	</div>
</div>
@endif
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