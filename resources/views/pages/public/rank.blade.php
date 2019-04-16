@extends('adminlte::page')

@section('title', 'Ranking')

@section('content_header')
    <h1>Ranking</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3" style="padding: 0px 5px 0px 5px">
        @include('partials.sidepanel')
    </div>
    <div class="col-md-9" style="padding: 0px 5px 0px 5px">
    	<div class="box">
    		<div class="box-body">
    			<div class="row" style="margin-bottom: 5px">
    				<div class="col-md-4">
    					<form method="get" id="sortclass">
    						<div class="form-group">
								@php
								$old = (isset($_GET['class']) ? $_GET['class'] : old('class'));
								$newlist = array();
								$newlist[''] 		= "SORT BY CLASS";
								$newlist['ARCHER']	= [
														'256'	=>	'Archer[M]',
														'4'		=>	'Archer[F]'
													];
								$newlist['BRAWLER']	= [
														'1'		=>	'Brawler[M]',
														'64'	=>	'Brawler[F]'
													];
								$newlist['SWORDSMAN']	= [
														'2'		=>	'Swordsman[M]',
														'128'	=>	'Swordsman[F]'
													];
								$newlist['SHAMAN']	= [
														'512'	=>	'Shaman[M]',
														'8'		=>	'Shaman[F]'
													];
								$newlist['GUNNER']	= [
														'16'	=>	'Gunner[M]',
														'32'	=>	'Gunner[F]'
													];
								@endphp
    							{!! Form::select('class', $newlist, $old, [ 'class' => 'form-control' ]) !!}
    						</div>
    					</form>
    				</div>
    				<div class="col-md-4">
    					<form method="get" id="sortschool">
    						<div class="form-group">
								@php
								$old = (isset($_GET['school']) ? $_GET['school'] : old('school'));
								$newlist = array();
								$newlist[''] 		= "SORT BY SCHOOL";
								$newlist['0'] 		= "Sacred Gate";
								$newlist['1'] 		= "Mystic Peak";
								$newlist['2'] 		= "Phoenix";
								@endphp
    							{!! Form::select('school', $newlist, $old, [ 'class' => 'form-control' ]) !!}
    						</div>
    					</form>
    				</div>
    				<div class="col-md-4">
    					<a href="{{ url('ranking').'?type=richest' }}" class="btn btn-block btn-default">SORT BY WEALTH</a>
    				</div>
    				<div class="col-md-4 col-md-offset-4">
    					<a href="{{ url('ranking') }}" class="btn btn-block btn-primary">RESET SORTING</a>
    				</div>
    			</div>
				@if($char->count())
				@php
					$i=1;
					if(isset($_GET['class'])):
						$get = (int)$_GET['class'];
						$query = $char->with('guildinfo','info')->where(['ChaClass' => \DB::raw("CONVERT(VARBINARY(MAX), $get) ")])->orderBy('ChaReborn','desc')->orderBy('ChaLevel','desc')->orderBy('ChaPkWin','desc')->orderBy('ChaPkLoss','asc')->take(50)->get();
					elseif(isset($_GET['school'])):
						$get = (int)$_GET['school'];
						$query = $char->with('guildinfo','info')->where(['ChaSchool' => \DB::raw("CONVERT(VARBINARY(MAX), $get) ")])->orderBy('ChaReborn','desc')->orderBy('ChaLevel','desc')->orderBy('ChaPkWin','desc')->orderBy('ChaPkLoss','asc')->take(50)->get();
					elseif(isset($_GET['type'])):
						$query = $char->with('guildinfo','info')->orderBy('ChaMoney','desc')->take(50)->get();
					else:
						$query = $char->with('guildinfo','info')->orderBy('ChaReborn','desc')->orderBy('ChaLevel','desc')->orderBy('ChaPkWin','desc')->orderBy('ChaPkLoss','asc')->take(50)->get();
					endif;
				@endphp
				@if(count($query))
				<table class="table" cellpadding="0" style="padding: 0px">
					@foreach($query as $top)
					@php
	                    if($top->ChaClass == 256 || $top->ChaClass == 4){
	                        if($top->ChaClass == 256){
	                            $gender =   "M";
	                        }else{
	                            $gender =   "F";
	                        }
	                        $name = "ARCHER";

	                    }else if($top->ChaClass == 1 || $top->ChaClass == 64){
	                        if($top->ChaClass == 1){
	                            $gender =   "M";
	                        }else{
	                            $gender =   "F";
	                        }
	                        $name = "BRAWLER";
	                    }else if($top->ChaClass == 2 || $top->ChaClass == 128){
	                        if($top->ChaClass == 2){
	                            $gender =   "M";
	                        }else{
	                            $gender =   "F";
	                        }
	                        $name = "SWORDSMAN";
	                    }else if($top->ChaClass == 512 || $top->ChaClass == 8){
	                        if($top->ChaClass == 512){
	                            $gender =   "M";
	                        }else{
	                            $gender =   "F";
	                        }
	                        $name = "SHAMAN";
	                    }else{
	                        if($top->ChaClass == 16){
	                            $gender =   "M";
	                        }else{
	                            $gender =   "F";
	                        }
	                        $name = "GUNNER";
	                    }
					@endphp
					@if($top->info->count() && $top->info->first()->UserType == 1)
					<tr class="@if($i==1) bg-danger text-black @else bg-gray @endif">
						<td style="vertical-align:middle;text-align: left;">
							<div class="icon c{{ $top->ChaClass }}"></div>
						</td>
						<td style="vertical-align:middle;text-align: left;"><b>{{ $top->ChaName }}</b></td>
						<td style="vertical-align:middle;text-align: left;">
							<span class="label label-primary">TOP : {{ $i }}</span>&nbsp;
							<span class="label label-warning">{{ $top->guildinfo->count() ? $top->guildinfo->first()->GuName : 'No Guild' }}</span>&nbsp;
							<span class="label label-danger">
								@if($top->ChaSchool == 0)
								Sacred Gate
								@elseif($top->ChaSchool == 1)
								Mystic Peak
								@else
								Phoenix
								@endif
							</span>&nbsp;
							<span>{{ $name.'['.$gender.']' }}</span>
						</td>
						<td style="vertical-align:middle;text-align: right;">
							<div>LEVEL : {{ $top->ChaLevel }}</div>
							<div>REBORN : {{ $top->ChaReborn }}</div>
							<div>KILLS : {{ $top->ChaPkWin }}</div>
							{{--<div>DEATH : {{ $top->ChaPKLoss }}</div>--}}
							@if(isset($_GET['type']))
							<div>MONEY : {{ number_format($top->ChaMoney,2) }}</div>
							@endif

						</td>
					</tr>
					@php
					$i++;
					@endphp
					@endif
					@endforeach
				</table>
				@endif
				@endif
    		</div>
    	</div>
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
tr:hover {
	opacity: 0.8;
}
</style>
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$('select').select2();
	$('select[name="class"]').change(function(){
		$('form#sortclass').submit();
	});
	$('select[name="school"]').change(function(){
		$('form#sortschool').submit();
	});
});
</script>
@stop