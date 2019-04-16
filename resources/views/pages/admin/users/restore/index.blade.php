@extends('adminlte::page')

@section('title', 'Restore User')

@section('content_header')
    <h1>Restore User</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<div class="form-group">
			<label>SELECT USER :</label>
			@php
				$users->with('user_2')->chunk($users->count(),function($q){
					$newlist = array();
					$newlist[''] = "SELECT A USER";
					foreach($q as $user):
						if(!$user->user_2->count()):
							$newlist[url('game/users/'.$user->UserNum.'/restore')] = $user->UserName;
						endif;
					endforeach;
					echo Form::select('user', $newlist, old('user'), [ 'class' => 'form-control' ]);
				});

			@endphp
		</div>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$('select').select2().change(function(){
		if($(this).val() != ""){
			location.href = $(this).val();
		}
	});
});
</script>
@stop