@extends('adminlte::page')

@section('title', 'Reborn System Setting')

@section('content_header')
    <h1>Reborn System Setting</h1>
@stop

@section('content')
<form action="{{ url('tools/reborn/system') }}" method="POST" id="reborm_form">
	@csrf
	{{-- REBORN SYSTEM SETTING --}}
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">REBORN SYSTEM SETTING</h3>
		</div>
		<div class="box-body">
				<div class="form-group">
					<label>REBORN SYSTEM SWITCH :</label>
					{!!Form::select('status', ['' => 'SELECT REBORN SYSTEM STATUS', '1' => 'ON','0' => 'OFF'], env('REBORN_SYSTEM'), ['class' => 'form-control'])!!}
				</div>
		</div>
	</div>
	{{-- REBORN STAGE 1 SETTING --}}
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">REBORN STAGE 1 SETTING</h3>
		</div>
		<div class="box-body">
				<div class="form-group {{ $errors->has('REBORN1_LEVEL') ? 'has-error' : '' }}">
					<label>STAGE 1 REQUIRED LEVEL :</label>
					{!! Form::text('REBORN1_LEVEL', env('REBORN1_LEVEL'), array('id' => 'REBORN1_LEVEL', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN1_GOLD') ? 'has-error' : '' }}">
					<label>STAGE 1 REQUIRED GOLD :</label>
					{!! Form::text('REBORN1_GOLD', env('REBORN1_GOLD'), array('id' => 'REBORN1_GOLD', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN1_REWARD') ? 'has-error' : '' }}">
					<label>STAGE 1 REBORN REWARD :</label>
					{!! Form::text('REBORN1_REWARD', env('REBORN1_REWARD'), array('id' => 'REBORN1_REWARD', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN1_COUNT_FROM') ? 'has-error' : '' }}">
					<label>STAGE 1 RANGE FROM :</label>
					{!! Form::text('REBORN1_COUNT_FROM', env('REBORN1_COUNT_FROM'), array('id' => 'REBORN1_COUNT_FROM', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN1_COUNT_TO') ? 'has-error' : '' }}">
					<label>STAGE 1 RANGE TO :</label>
					{!! Form::text('REBORN1_COUNT_TO', env('REBORN1_COUNT_TO'), array('id' => 'REBORN1_COUNT_TO', 'class' => 'form-control')) !!}
				</div>
		</div>
	</div>
	{{-- REBORN STAGE 2 SETTING --}}
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">REBORN STAGE 2 SETTING</h3>
		</div>
		<div class="box-body">
				<div class="form-group {{ $errors->has('REBORN2_STATUS') ? 'has-error' : '' }}">
					<label>STAGE 2 STATUS :</label>
					{!!Form::select('REBORN2_STATUS', ['' => 'SELECT STAGE 2 STATUS', '1' => 'ON','0' => 'OFF'], env('REBORN2_STATUS'), ['class' => 'form-control'])!!}
				</div>
				<div class="form-group {{ $errors->has('REBORN2_LEVEL') ? 'has-error' : '' }}">
					<label>STAGE 2 REQUIRED LEVEL :</label>
					{!! Form::text('REBORN2_LEVEL', env('REBORN2_LEVEL'), array('id' => 'REBORN2_LEVEL', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN2_GOLD') ? 'has-error' : '' }}">
					<label>STAGE 2 REQUIRED GOLD :</label>
					{!! Form::text('REBORN2_GOLD', env('REBORN2_GOLD'), array('id' => 'REBORN2_GOLD', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN2_REWARD') ? 'has-error' : '' }}">
					<label>STAGE 2 REBORN REWARD :</label>
					{!! Form::text('REBORN2_REWARD', env('REBORN2_REWARD'), array('id' => 'REBORN2_REWARD', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN2_COUNT_FROM') ? 'has-error' : '' }}">
					<label>STAGE 2 RANGE FROM :</label>
					{!! Form::text('REBORN2_COUNT_FROM', env('REBORN2_COUNT_FROM'), array('id' => 'REBORN2_COUNT_FROM', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN2_COUNT_TO') ? 'has-error' : '' }}">
					<label>STAGE 2 RANGE TO :</label>
					{!! Form::text('REBORN2_COUNT_TO', env('REBORN2_COUNT_TO'), array('id' => 'REBORN2_COUNT_TO', 'class' => 'form-control')) !!}
				</div>
		</div>
	</div>
	{{-- REBORN STAGE 3 SETTING --}}
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">REBORN STAGE 3 SETTING</h3>
		</div>
		<div class="box-body">
				<div class="form-group {{ $errors->has('REBORN3_STATUS') ? 'has-error' : '' }}">
					<label>STAGE 3 STATUS :</label>
					{!!Form::select('REBORN3_STATUS', ['' => 'SELECT STAGE 3 STATUS', '1' => 'ON','0' => 'OFF'], env('REBORN3_STATUS'), ['class' => 'form-control'])!!}
				</div>
				<div class="form-group {{ $errors->has('REBORN3_LEVEL') ? 'has-error' : '' }}">
					<label>STAGE 3 REQUIRED LEVEL :</label>
					{!! Form::text('REBORN3_LEVEL', env('REBORN3_LEVEL'), array('id' => 'REBORN3_LEVEL', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN3_GOLD') ? 'has-error' : '' }}">
					<label>STAGE 3 REQUIRED GOLD :</label>
					{!! Form::text('REBORN3_GOLD', env('REBORN3_GOLD'), array('id' => 'REBORN3_GOLD', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN3_REWARD') ? 'has-error' : '' }}">
					<label>STAGE 3 REBORN REWARD :</label>
					{!! Form::text('REBORN3_REWARD', env('REBORN3_REWARD'), array('id' => 'REBORN3_REWARD', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN3_COUNT_FROM') ? 'has-error' : '' }}">
					<label>STAGE 3 RANGE FROM :</label>
					{!! Form::text('REBORN3_COUNT_FROM', env('REBORN3_COUNT_FROM'), array('id' => 'REBORN3_COUNT_FROM', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN3_COUNT_TO') ? 'has-error' : '' }}">
					<label>STAGE 3 RANGE TO :</label>
					{!! Form::text('REBORN3_COUNT_TO', env('REBORN3_COUNT_TO'), array('id' => 'REBORN3_COUNT_TO', 'class' => 'form-control')) !!}
				</div>
		</div>
	</div>
	{{-- REBORN STAGE 4 SETTING --}}
	<div class="box">
		<div class="box-header">
			<h4 class="box-title">REBORN STAGE 4 SETTING</h4>
		</div>
		<div class="box-body">
				<div class="form-group {{ $errors->has('REBORN4_STATUS') ? 'has-error' : '' }}">
					<label>STAGE 4 STATUS :</label>
					{!!Form::select('REBORN4_STATUS', ['' => 'SELECT STAGE 4 STATUS', '1' => 'ON','0' => 'OFF'], env('REBORN4_STATUS'), ['class' => 'form-control'])!!}
				</div>
				<div class="form-group {{ $errors->has('REBORN4_LEVEL') ? 'has-error' : '' }}">
					<label>STAGE 4 REQUIRED LEVEL :</label>
					{!! Form::text('REBORN4_LEVEL', env('REBORN4_LEVEL'), array('id' => 'REBORN4_LEVEL', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN4_GOLD') ? 'has-error' : '' }}">
					<label>STAGE 4 REQUIRED GOLD :</label>
					{!! Form::text('REBORN4_GOLD', env('REBORN4_GOLD'), array('id' => 'REBORN4_GOLD', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN4_REWARD') ? 'has-error' : '' }}">
					<label>STAGE 4 REBORN REWARD :</label>
					{!! Form::text('REBORN4_REWARD', env('REBORN4_REWARD'), array('id' => 'REBORN4_REWARD', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN4_COUNT_FROM') ? 'has-error' : '' }}">
					<label>STAGE 4 RANGE FROM :</label>
					{!! Form::text('REBORN4_COUNT_FROM', env('REBORN4_COUNT_FROM'), array('id' => 'REBORN4_COUNT_FROM', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN4_COUNT_TO') ? 'has-error' : '' }}">
					<label>STAGE 4 RANGE TO :</label>
					{!! Form::text('REBORN4_COUNT_TO', env('REBORN4_COUNT_TO'), array('id' => 'REBORN4_COUNT_TO', 'class' => 'form-control')) !!}
				</div>
		</div>
	</div>
	{{-- REBORN STAGE 5 SETTING --}}
	<div class="box">
		<div class="box-header">
			<h5 class="box-title">REBORN STAGE 5 SETTING</h5>
		</div>
		<div class="box-body">
				<div class="form-group {{ $errors->has('REBORN5_STATUS') ? 'has-error' : '' }}">
					<label>STAGE 5 STATUS :</label>
					{!!Form::select('REBORN5_STATUS', ['' => 'SELECT STAGE 5 STATUS', '1' => 'ON','0' => 'OFF'], env('REBORN5_STATUS'), ['class' => 'form-control'])!!}
				</div>
				<div class="form-group {{ $errors->has('REBORN5_LEVEL') ? 'has-error' : '' }}">
					<label>STAGE 5 REQUIRED LEVEL :</label>
					{!! Form::text('REBORN5_LEVEL', env('REBORN5_LEVEL'), array('id' => 'REBORN5_LEVEL', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN5_GOLD') ? 'has-error' : '' }}">
					<label>STAGE 5 REQUIRED GOLD :</label>
					{!! Form::text('REBORN5_GOLD', env('REBORN5_GOLD'), array('id' => 'REBORN5_GOLD', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN5_REWARD') ? 'has-error' : '' }}">
					<label>STAGE 5 REBORN REWARD :</label>
					{!! Form::text('REBORN5_REWARD', env('REBORN5_REWARD'), array('id' => 'REBORN5_REWARD', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN5_COUNT_FROM') ? 'has-error' : '' }}">
					<label>STAGE 5 RANGE FROM :</label>
					{!! Form::text('REBORN5_COUNT_FROM', env('REBORN5_COUNT_FROM'), array('id' => 'REBORN5_COUNT_FROM', 'class' => 'form-control')) !!}
				</div>
				<div class="form-group {{ $errors->has('REBORN5_COUNT_TO') ? 'has-error' : '' }}">
					<label>STAGE 5 RANGE TO :</label>
					{!! Form::text('REBORN5_COUNT_TO', env('REBORN5_COUNT_TO'), array('id' => 'REBORN5_COUNT_TO', 'class' => 'form-control')) !!}
				</div>
		</div>
	</div>

	<button class="btn btn-success" type="submit">
		UPDATE
	</button>


</form>
@stop

@section('css')

@stop

@section('js')

@stop