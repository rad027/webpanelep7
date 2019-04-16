@extends('adminlte::page')

@section('title', 'Top Up')

@section('content_header')
    <h1>Top Up</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form method="post">
			@csrf
			<div class="form-group">
				<label>CARD CODE :</label>
				{!! Form::text('code', old('code'), [ 'class' => 'form-control', 'placeholder' => 'Enter your card code here. E.g : JKNM9JA291JANEM4' ]) !!}
			</div>
			<div class="form-group">
				<label>CARD PIN :</label>
				{!! Form::text('pin_code', old('pin_code'), [ 'class' => 'form-control', 'placeholder' => 'Enter your card pin code here. E.g : JKNM9JA291JA' ]) !!}
			</div>
			<button class="btn btn-flat btn-success" type="submit">TOP UP</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop