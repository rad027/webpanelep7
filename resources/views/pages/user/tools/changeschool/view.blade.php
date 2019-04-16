@extends('adminlte::page')

@section('title', 'Change School System')

@section('content_header')
    <h1>Change School System</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<div class="callout callout-warning">
			<h4>Prerequisites:</h4>
			<p>
				<ul>
					@php
					if(config('app.change_school.currency') == "VP"){
					$msg = number_format(config('app.change_school.required_amount'),2)." VOTE POINTS";
					}else if(config('app.change_school.currency') == "EP"){
					$msg = number_format(config('app.change_school.required_amount'),2)." E-POINTS";
					}else{
					$msg = number_format(config('app.change_school.required_amount'),2)." GOLD POINTS";
					}
					@endphp
					<li>{{ $msg }}</li>
					<li>Remove all your equiped items</li>
				</ul>
			</p>
			<h4>Notice:</h4>
			<p>
				<ul>
					<li>Follow the requirements to avoid item loss.</li>
					<li><img src="{{ url('tools/inventory.png') }}"></li>
				</ul>
			</p>
		</div>
		<form action="{{ url('user/changeschool') }}" method="POST">
			@csrf
			<div class="form-group">
				<label>SELECT CHARACTER :</label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT A CHARACTER";
				if($char->count() > 0):
				foreach($char->cursor() as $chars):
					if($chars->ChaDeleted == 0):
						if($chars->ChaSchool == 0):
							$school = "Sacred Gate";
						elseif($chars->ChaSchool == 1):
							$school = "Mystic Peak";
						else:
							$school = "Phoenix";
						endif;
					$newlist[$chars->ChaNum] = $chars->ChaName." [RB. ".$chars->ChaReborn."/LvL. ".$chars->ChaLevel."/School : ".$school."<img src='".url('school/'.$chars->ChaSchool.'.png')."'>]";
					endif;
				endforeach;
				endif;
				@endphp
				{!!Form::select('ChaID', $newlist, old('ChaID'), ['class' => 'form-control'])!!}
			</div>
			<div class="form-group {{ $errors->has('school') ? 'has-error' : '' }}">
				<label>SELECT SCHOOL :</label>
				<select class="form-control" name="school">
					<option value="">SELECT A SCHOOL</option>
					<option value="0">Sacred Gate</option>
					<option value="1">Mystic Peak</option>
					<option value="2">Phoenix</option>
				</select>
			</div>
			<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
				<label>PASSWORD :</label>
				<input type="password" name="password" class="form-control" placeholder="Enter your password.">
			</div>
			<button class="btn btn-success" type="submit">CHANGE SCHOOL</button>
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