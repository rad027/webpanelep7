@extends('adminlte::page')

@section('title', 'Edit User ['.$user->name.']`s Account Type')

@section('content_header')
    <h1>Edit User [{{ $user->name }}]`s Account Type</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('game/users/'.$user->id.'/creds') }}" method="POST">
			@csrf
			<div class="form-group {{ $errors->has('ingame_role') ? 'has-error' : '' }}">
				<label>In-Game Role :</label>
				@php
				$newlist = array();
				$klist = explode(',',env('USERTYPES_LIST'));
				$vlist = explode(',',env('USERTYPES_LIST_VALUE'));
				$newlist[''] = "SELECT IN-GAME ROLE";
				for($i=0; $i < count($klist); $i++){
					$newlist[$klist[$i]] = $vlist[$i];
				}
				@endphp
				{!!Form::select('ingame_role', $newlist, $user->UserInfo4()->first()->UserType, ['class' => 'form-control'])!!}
                @if ($errors->has('ingame_role'))
                    <span class="help-block">
                        <strong>{{ $errors->first('ingame_role') }}</strong>
                    </span>
                @endif
			</div>
			<div class="form-group">
				<label>IN-GAME STATUS :</label>
				@php
				$newlist = array();
				$newlist[''] = 'SELECT USER STATUS';
				$newlist['0'] = 'NOT BLOCKED';
				$newlist['1'] = 'BLOCKED';
				@endphp
				{!! Form::select('user_status', $newlist, $user->UserInfo4()->first()->UserBlock, [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('panel_role') ? 'has-error' : '' }}">
				<label>Panel Role :</label>
				@php
				$newlist = array();
				foreach($roles as $role){
					$newlist[$role->id] = $role->name;
				}
				@endphp
				{!!Form::select('panel_role', $newlist, $user->roles->first()->id, ['class' => 'form-control'])!!}
                @if ($errors->has('panel_role'))
                    <span class="help-block">
                        <strong>{{ $errors->first('panel_role') }}</strong>
                    </span>
                @endif
			</div>
			<a href="{{ url('game/users') }}" class="btn btn-sm btn-danger">BACK</a>
			<button class="btn btn-sm btn-success" type="submit">UPDATE</button>
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