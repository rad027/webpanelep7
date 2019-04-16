@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Restored Users</h1>
@stop

@php
use App\Models\User;
use jeremykenedy\LaravelRoles\Models\Role;
@endphp

@section('content')
<div class="box">
	<div class="box-body">
		<table class="table clearfix">
			<thead>
				<tr>
					<th>ID</th>
					<th>USERNAME</th>
					<th>EMAIL</th>
					<th>STATUS</th>
					<th>PANEL/IN-GAME ROLE</th>
					<th>ACTION</th>
					<th>REGISTERED DATE</th>
				</tr>
			</thead>
			<tbody>
				@if($userinfo->count() > 0)
				@php
					foreach($userinfo->orderBy('UserNum','desc')->with('user_2')->cursor() as $user):
				$newlist = array();
				$klist = explode(',',env('USERTYPES_LIST'));
				$vlist = explode(',',env('USERTYPES_LIST_VALUE'));
				$newlist[''] = "SELECT IN-GAME ROLE";
				for($i=0; $i < count($klist); $i++){
					$newlist[$klist[$i]] = $vlist[$i];
				}
				if($user->UserType >= $klist[count($klist)-1]){
					$usertype = $klist[count($klist)-1];
				}else{
					$usertype = $user->UserType;
				}
				$ingame_role = '<span class="label label-primary">'.$newlist[$usertype].'</span>';
				if(count($user->user_2) > 0):
					$registered = date ('F d, Y h:i a',strtotime($user->user_2->first()->created_at));
					$role = User::find($user->user_2->first()->id)->roles()->first();
					$restore = 0;
					if($role->slug === "unverified"){
						$status = '<span class="label label-danger">unverified</span>';
						$panel_role = '<span class="label label-danger">unverified</span>';
					}else if($role->slug === "admin"){
						$panel_role = '<span class="label label-primary">admin</span>';
						$status = '<span class="label label-success">verified</span>';
					}else{
						$status='<span class="label label-success">verified</span>';
						$panel_role = '<span class="label label-success">User</span>';
					}
				else:	
						$registered = date('F d, Y h:i a',strtotime($user->CreateDate));
						$status='<span class="label label-warning">unrestore</span>';
						$panel_role = '<span class="label label-warning">none</span>';
						$restore = 1;
				endif;
				@endphp
				<tr style="z-index: 99999px!important;position: relative!important;">
					<td>{{ $user->UserNum }}</td>
					<td>{{ $user->UserName }}</td>
					<td>{{ $user->UserEmail }}</td>
					<td>{!! $status !!}</td>
					<td>{!! $panel_role !!}/{!! $ingame_role !!}</td>
					<td>
						@if($restore===1)
						<a href="{{ url('game/users/'.$user->UserNum.'/restore') }}" class="btn btn-xs btn-warning">RESTORE</a>
						@else
						<div class="btn-group">
						  <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    EDIT <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" style="z-index: 999999!important;position: relative!important;">
						    <li><a href="{{ url('game/users/'.$user->user_2->first()->id.'/informations') }}">INFORMATIONS</a></li>
						    <li><a href="{{ url('game/users/'.$user->user_2->first()->id.'/password') }}">PASSWORD</a></li>
						    <li><a href="{{ url('game/users/'.$user->user_2->first()->id.'/creds') }}">ACCOUNT TYPE</a></li>
						  </ul>
						</div>
						@endif
					</td>
					<td>{{ $registered }}</td>
				</tr>
				@php
					endforeach;
				@endphp
				@endif
			</tbody>
		</table>
	</div>
</div>
@stop

@section('css')
<style type="text/css">
table.dataTable.display tbody tr table tr:hover {
    background: none!important;
}
</style>
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$('table').DataTable({
		'order' : [[0,'desc']]
	});
});
</script>
@stop