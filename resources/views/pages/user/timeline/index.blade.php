@extends('adminlte::page')

@section('title', ( Auth::user()->name == $name ? 'Your Timeline' : 'User ['.$name.'] Timeline'))

@section('content_header')
    <h1>User [{{ $name }}] Timeline</h1>
@stop

@php
use App\Models\Timeline;
use App\Models\User;
@endphp

@section('content')
@if(Auth::user()->isAdmin())
<div class="box">
	<div class="box-body">
		<div class="form-group">
			<label>SELECT ACCOUNT TO VIEW : [{{ User::whereHas('roles',function($q) { $q->where('name','!=','Unverified'); })->where(['id' => Auth::user()->id])->count() }}]</label>
			@php
				$newlist = array();
				$old = url('profile/'.$name);
				$newlist[''] = "SELECT AN ACCOUNT";
				if(User::whereHas('roles',function($q) { $q->where('name','!=','Unverified'); })->where('id','!=',Auth::user()->id)->count()){
					foreach(User::whereHas('roles',function($q) { $q->where('name','!=','Unverified'); })->where('id','!=',Auth::user()->id)->cursor() as $userr):
						$newlist[url('profile/'.$userr->name)] = '['.$userr->roles->first()->name.']'.$userr->name.' ['.$userr->first_name.' '.$userr->last_name.']';
					endforeach;
				}
			@endphp
			{!! Form::select('accounts', $newlist, $old, [ 'class' => 'form-control' ]) !!}
		</div>
	</div>
</div>
@endif
@if(Auth::user()->isUser())
<div class="box box-widget widget-user">
	<div class="widget-user-header bg-aqua-active">
		<h3 class="widget-user-username">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
		<h5 class="widget-user-desc">{{ Auth::user()->roles()->first()->name }}</h5>
	</div>
	<div class="widget-user-image">
		<img class="img-circle" src="@if (Auth::user()->profile()->count() && Auth::user()->profile()->first()->avatar_status == True) {{ Auth::user()->profile()->first()->avatar }} @else {{ Gravatar::get(Auth::user()->email) }} @endif" alt="User Avatar">
	</div>
	<div class="box-footer">
		<div class="row">
			<div class="col-sm-4 border-right">
				<div class="description-block">
					<h5 class="description-header">{{ Auth::user()->email }}</h5>
					<span class="description-text">EMAIL</span>
				</div>
			</div>
			<div class="col-sm-4 border-right">
				<div class="description-block">
					<h5 class="description-header">{{ Auth::user()->name }}</h5>
					<span class="description-text">USERNAME</span>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="description-block">
					<h5 class="description-header">{{ date('F d, Y h:i A',strtotime(Auth::user()->created_at)) }}</h5>
					<span class="description-text">DATE REGISTERED</span>
				</div>
			</div>
		</div>
	</div>
	<div class="box-footer">
		<div class="row">
			<div class="col-sm-6 border-right">
				<div class="description-block">
					<h5 class="description-header">{{ number_format(Auth::user()->points()->first()->Vpoints,2) }}</h5>
					<span class="description-text">VOTE POINTS</span>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="description-block">
					<h5 class="description-header">{{ number_format(Auth::user()->points()->first()->points,2) }}</h5>
					<span class="description-text">E-POINTS</span>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
@if(count($timelines))
	<ul class="timeline">
		@php
		$lastdate = date('Ymd',(time() * (60*60*24)));
		$i=0;
		@endphp
		@foreach($timelines as $timeline)
		@php
			$title = config('app.timeline.'.$timeline->remark);
		@endphp
		@if(date('Ymd',strtotime($lastdate)) != date('Ymd',strtotime($timeline->created_at)))
	    <li class="time-label">
	        <span class="bg-red">
	        	@if(date('Ymd',strtotime($timeline->created_at)) == date('Ymd'))
	        		Today
	        	@else
	            	{{ date('M d, Y h:i A',strtotime($timeline->created_at)) }}
	        	@endif
	        </span>
	    </li>
	    @endif
	    <li>
	        <i class="fa fa-square bg-blue"></i>
	        <div class="timeline-item">
	            <span class="time"><i class="fa fa-clock-o"></i> <span class="tfm-time" data-unix-time="{{ $timeline->created_at }}" title="{{ date('F d,Y h:i A',strtotime($timeline->created_at)) }}">...</span></span>

	            <h3 class="timeline-header"><a>{{ $timeline->user()->first()->name }} [{{ $timeline->user()->first()->first_name }} {{ $timeline->user()->first()->last_name }}]</a></h3>

	            <div class="timeline-body">
	                {!! $timeline->content !!}
	            </div>

	            <div class="timeline-footer">
	                <a class="btn btn-primary btn-xs">PROCEDURE : [{{ $title }}]</a>
	                <a class="btn btn-danger btn-xs">IP : [{{ $timeline->ip_address }}]</a>
	            </div>
	        </div>
	    </li>
	    @php
	    $lastdate = $timeline->created_at;
	    @endphp
		@endforeach
	    <li>
	    	<i class="fa fa-clock-o bg-gray"></i>
	    </li>
	</ul>
@else
	<div class="alert alert-warning">
		YOU DONT HAVE AN ACTIVITY YET.
	</div>
@endif
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
    (function TimeoutFunction(){
        liveTime(TimeoutFunction);
    })();
    function liveTime(selfTimeout) {

            $('.tfm-time').each(function() {

                var msgTime = $(this).attr('data-unix-time');
                msgTime = Date.parse(msgTime)/1000;
                var time = Math.round(new Date().getTime() / 1000) - msgTime;

                var day = Math.round(time / (60 * 60 * 24));
                var week = Math.round(day / 7);
                var remainderHour = time % (60 * 60 * 24);
                var hour = Math.round(remainderHour / (60 * 60));
                var remainderMinute = remainderHour % (60 * 60);
                var minute = Math.round(remainderMinute / 60);
                var second = remainderMinute % 60;

                var currentTime = new Date(msgTime*1000);
                var currentHours = ( currentTime.getHours() > 12 ) ? currentTime.getHours() - 12 : currentTime.getHours();
                var currentHours = ( currentHours == 0 ) ? 12 : currentHours;
                var realTime = currentHours+':'+currentTime.getMinutes();
                var timeOfDay = ( currentTime.getHours() < 12 ) ? "AM" : "PM";

                if(day > 7) {
                    var timeAgo = currentTime.toLocaleDateString();
                } else if(day>=2 && day<=7) {
                    var timeAgo =  day+' days ago';
                } else if(day==1) {
                    var timeAgo =  'Yesterday '+realTime+' '+timeOfDay;
                } else if(hour>1) {
                    var timeAgo =  hour+' hours ago';
                } else if(hour==1) {
                    var timeAgo =  'about an hour ago';
                } else if(minute==1) {
                    var timeAgo =  'about a minute ago';
                } else if(minute>1) {
                    var timeAgo =  minute+' minutes ago';
                } else if(second>1) {
                    var timeAgo =  second+' seconds ago';
                } else {
                    var timeAgo =  'few seconds ago';
                }
                $(this).html(timeAgo);
            });
            setTimeout(selfTimeout,1000);
        }
</script>
<script type="text/javascript">
$(document).ready(function(){
	$('select[name="accounts"]').change(function(){
		if($(this).val() == ""){
			location.href = "{{ url('profile/'.Auth::user()->name) }}";
		}else{
			location.href = $(this).val();
		}
	}).select2();
});
</script>
@stop