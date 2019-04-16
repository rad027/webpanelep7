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
		<form action="{{ url('tools/maxrbreward') }}" method="POST">
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
			<button class="btn btn-success" type="submit">CLAIM REWARD</button>
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