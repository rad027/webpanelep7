
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@php
use App\Models\RanGame1\ChaInfo;
use App\Models\RanUser\UserInfo4;
$user = UserInfo4::where(['UserID' => Auth::user()->name])->first();
@endphp

@section('content')
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
<div class="box">
	<div class="box-header">
		<h3 class="box-title">CREATED CHARACTERS</h3>
	</div>
	<div class="box-body">
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>CLASS</th>
					<th>IN-GAME NAME</th>
					<th>LEVEL</th>
					<th>REBORN</th>
					<th>STATS</th>
					<th>GUILD</th>
					<th>SCHOOL</th>
					<th>PREMIUM POINTS</th>
					<th>ZG POINTS</th>
				</tr>
			</thead>
			<tbody>
				@if($user->chainfo3()->count())
				@foreach($user->chainfo3()->cursor() as $char)
				@if($char->ChaDeleted == 0)
				<tr>
					<td>{{ $char->ChaNum }}</td>
					<td>
						@if($char->ChaClass == 256 || $char->ChaClass == 4)
						ARCHER
						@elseif($char->ChaClass == 1 || $char->ChaClass == 64)
						BRAWLER
						@elseif($char->ChaClass == 2 || $char->ChaClass == 128)
						SWORDSMAN
						@elseif($char->ChaClass == 512 || $char->ChaClass == 8)
						SHAMAN
						@elseif($char->ChaClass == 16 || $char->ChaClass == 32)
						GUNNER
						@endif
						<div class="icon c{{ $char->ChaClass }}"></div>
					</td>
					<td>{{ $char->ChaName }}</td>
					<td>{{ $char->ChaLevel }}</td>
					<td>{{ $char->ChaReborn }}</td>
					<td><canvas id="canvas{{ $char->ChaNum }}" height="130" width="130"></canvas></td>
					<script>
					var radarChartData{{ $char->ChaNum }} = {
						labels: ["Pow", "Dex", "Int", "Stm", "Vit"],
						datasets: [
							{
								label: "{{ $char->ChaName }}",
								fillColor: "rgba(151,187,205,0.2)",
								strokeColor: "rgba(151,187,205,1)",
								pointColor: "rgba(151,187,205,1)",
								pointStrokeColor: "#fff",
								pointHighlightFill: "#fff",
								pointHighlightStroke: "rgba(151,187,205,1)",
								data: [{{ $char->ChaPower }},{{ $char->ChaDex }},{{ $char->ChaSpirit }},{{ $char->ChaStrength }},{{ $char->ChaStrong }}]
								
							}
						]
					};
					
						//Get the context of the Radar Chart canvas element we want to select
					var ctx{{ $char->ChaNum }} = document.getElementById("canvas{{ $char->ChaNum }}").getContext("2d");

					// Create the Radar Chart
					var myradarChart2 = new Chart(ctx{{ $char->ChaNum }}).Radar(radarChartData{{ $char->ChaNum }}, { responsive: false });
					</script>
					<td>
						@if($char->guildinfo()->count() > 0)
						{{ $char->guildinfo()->first()->GuName }}
						@else
						<span class="text-danger">Not Available</span>
						@endif
					</td>
					<td>
						<img src="{{ url('school/'.$char->ChaSchool.'.png') }}">
					</td>
					<td>{{ number_format($char->ChaPremiumPoint,2) }}</td>
					<td>{{ number_format($char->ChaVotePoint,2) }}</td>
				</tr>
				@endif
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">RECENT ACTIVITIES</h3>
	</div>
	<div class="box-body">
		@if(Auth::user()->timeline()->count())
			<ul class="timeline">
				@php
				$lastdate = date('Ymd',(time() * (60*60*24)));
				$i=0;
				@endphp
				@foreach(Auth::user()->timeline()->orderBy('id','desc')->take(5)->get() as $timeline)
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
		YOU DONT HAVE ANY RECENT ACTIVITIES
		@endif
	</div>
	<div class="box-footer">
		<a href="{{ url('profile/'.Auth::user()->name) }}" class="btn btn-xs btn-primary">SEE MORE</a>
	</div>
</div>
@stop

@section('css')
<style type="text/css">
.c1 {background:url(/images/classes/ran_lqhmej.gif) 0 0}
.c64 {background:url(/images/classes/ran_lqhmej.gif) 0 -53px}
.c2 {background:url(/images/classes/ran_lqhmej.gif) -57px 0}
.c128 {background:url(/images/classes/ran_lqhmej.gif) -57px -53px}
.c256 {background:url(/images/classes/ran_lqhmej.gif) -114px 0}
.c4 {background:url(/images/classes/ran_lqhmej.gif) -114px -53px}
.c512 {background:url(/images/classes/ran_lqhmej.gif) -171px 0}
.c8 {background:url(/images/classes/ran_lqhmej.gif) -171px -53px}
.c16 {background:url(/images/classes/ran_lqhmej.gif) -228px 1px}
.c32 {background:url(/images/classes/ran_lqhmej.gif) -228px -53px}
.c16 {background:url(/images/classes/ran_lqhmej.gif) -285px 1px}
.c32 {background:url(/images/classes/ran_lqhmej.gif) -285px -53px}
.c4096 {background:url(/images/classes/ran_lqhmej.gif) -342px 1px}
.c8192 {background:url(/images/classes/ran_lqhmej.gif) -342px -53px}
.c16384 {background:url(/images/classes/ran_lqhmej.gif) -228px -107px}
.c32768 {background:url(/images/classes/ran_lqhmej.gif) -287px -107px}
.icon {height:53px;width:53px;margin-top:4px;margin-right:4px;cursor: pointer;border: 1px solid #333;border-radius:4px;}
</style>
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
@stop