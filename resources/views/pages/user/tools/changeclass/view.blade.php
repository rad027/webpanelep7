@extends('adminlte::page')

@section('title', 'Change Class System')

@section('content_header')
    <h1>Change Class System</h1>
@stop

@section('content')
<div class="box">
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
		<form action="{{ url('user/changeclass') }}" method="POST">
			@csrf
			<div class="form-group">
				<label>SELECT CHARACTER :</label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT A CHARACTER";
				if($char->count() > 0):
				foreach($char->cursor() as $chars):
					if($chars->ChaDeleted == 0):
	                    if($chars->ChaClass == 256 || $chars->ChaClass == 4){
	                        if($chars->ChaClass == 256){
	                            $gender =   "M";
	                        }else{
	                            $gender =   "F";
	                        }
	                        $name = "ARCHER";

	                    }else if($chars->ChaClass == 1 || $chars->ChaClass == 64){
	                        if($chars->ChaClass == 1){
	                            $gender =   "M";
	                        }else{
	                            $gender =   "F";
	                        }
	                        $name = "BRAWLER";
	                    }else if($chars->ChaClass == 2 || $chars->ChaClass == 128){
	                        if($chars->ChaClass == 2){
	                            $gender =   "M";
	                        }else{
	                            $gender =   "F";
	                        }
	                        $name = "SWORDSMAN";
	                    }else if($chars->ChaClass == 512 || $chars->ChaClass == 8){
	                        if($chars->ChaClass == 512){
	                            $gender =   "M";
	                        }else{
	                            $gender =   "F";
	                        }
	                        $name = "SHAMAN";
	                    }else{
	                        if($chars->ChaClass == 16){
	                            $gender =   "M";
	                        }else{
	                            $gender =   "F";
	                        }
	                        $name = "GUNNER";
	                    }
					$newlist[$chars->ChaNum] = $chars->ChaName." [RB. ".$chars->ChaReborn."/LvL. ".$chars->ChaLevel."](".$name."[".$gender."])";
					endif;
				endforeach;
				endif;
				@endphp
				{!!Form::select('ChaID', $newlist, old('ChaID'), ['class' => 'form-control'])!!}
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
			<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
				<label>PASSWORD :</label>
				<input type="password" name="password" class="form-control" placeholder="Enter your password.">
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
	$('select').select2({
	  escapeMarkup: function(markup) {
	    return markup;
	  }
	});
});
</script>
@stop