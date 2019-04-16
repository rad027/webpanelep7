@extends('adminlte::page')

@section('title', 'Ran User Database')

@section('content_header')
    <h1>Ran User Database</h1>
@stop

@section('content')
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">Update</h3>
	</div>
	<div class="box-body">
		<form action="{{ URL('db/ranuser') }}" method="POST">
			@csrf
                <div class="form-group {{ $errors->has('DB_HOST') ? 'has-error' : '' }}">
                    <label>DB HOST :</label>
                    {!! Form::text('DB_HOST', env('DB_HOST_4'), array('id' => 'DB_HOST', 'class' => 'form-control', 'placeholder' => 'example : 127.0.0.1')) !!}
                    @if ($errors->has('DB_HOST'))
                        <span class="help-block">
                            <strong>{{ $errors->first('DB_HOST') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('DB_PORT') ? 'has-error' : '' }}">
                    <label>DB PORT :</label>
                    {!! Form::text('DB_PORT', env('DB_PORT_4'), array('id' => 'DB_PORT', 'class' => 'form-control', 'placeholder' => 'example : 1433')) !!}
                    @if ($errors->has('DB_PORT'))
                        <span class="help-block">
                            <strong>{{ $errors->first('DB_PORT') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('DB_DATABASE') ? 'has-error' : '' }}">
                    <label>DB Name :</label>
                    {!! Form::text('DB_DATABASE', env('DB_DATABASE_4'), array('id' => 'DB_DATABASE', 'class' => 'form-control', 'placeholder' => 'example : webpanel_db')) !!}
                    @if ($errors->has('DB_DATABASE'))
                        <span class="help-block">
                            <strong>{{ $errors->first('DB_DATABASE') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('DB_USERNAME') ? 'has-error' : '' }}">
                    <label>DB Username :</label>
                    {!! Form::text('DB_USERNAME', env('DB_USERNAME_4'), array('id' => 'DB_USERNAME', 'class' => 'form-control', 'placeholder' => 'example : root')) !!}
                    @if ($errors->has('DB_USERNAME'))
                        <span class="help-block">
                            <strong>{{ $errors->first('DB_USERNAME') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('DB_PASSWORD') ? 'has-error' : '' }}">
                    <label>DB Password :</label>
                    {!! Form::text('DB_PASSWORD', env('DB_PASSWORD_4'), array('id' => 'DB_PASSWORD', 'class' => 'form-control', 'placeholder' => 'example : 1234')) !!}
                    @if ($errors->has('DB_PASSWORD'))
                        <span class="help-block">
                            <strong>{{ $errors->first('DB_PASSWORD') }}</strong>
                        </span>
                    @endif
                </div>
                <button class="btn btn-sm btn-success" type="submit" style="border-radius: 0px">UPDATE</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop