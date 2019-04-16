@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Admin Dashboard</h1>
@stop

@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="info-box bg-red">
		  <span class="info-box-icon"><i class="fa fa-user-times"></i></span>
		  <div class="info-box-content">
		    <span class="info-box-text">Unrestored Users</span>
		    <span class="info-box-number">
		    	{{ $count }}
		    </span>
		  </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="info-box bg-green">
		  <span class="info-box-icon"><i class="fa fa-user-o"></i></span>
		  <div class="info-box-content">
		    <span class="info-box-text">Restored & Verified Users</span>
		    <span class="info-box-number">
		    	{{ \App\Models\User::whereHas('roles',function($q) { 
		    		$q->where(['name' => 'User']); 
		    	})->count() }}
		    </span>
		  </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="info-box bg-orange">
		  <span class="info-box-icon"><i class="fa fa-user"></i></span>
		  <div class="info-box-content">
		    <span class="info-box-text">Unverified Users</span>
		    <span class="info-box-number">
		    	{{ \App\Models\User::whereHas('roles',function($q) { 
		    		$q->where(['name' => 'Unverified']); 
		    	})->count() }}
		    </span>
		  </div>
		</div>
	</div>
	<div class="col-md-4 col-md-offset-2">
		<div class="info-box bg-gray">
		  <span class="info-box-icon"><i class="fa fa-user-circle"></i></span>
		  <div class="info-box-content">
		    <span class="info-box-text">Users With Admin Access</span>
		    <span class="info-box-number">
		    	{{ \App\Models\User::whereHas('roles',function($q) { 
		    		$q->where(['name' => 'Admin']); 
		    	})->count() }}
		    </span>
		  </div>
		</div>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop