@extends('adminlte::page')

@section('title', 'Download Page')

@section('content_header')
    <h1>Download Page</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3" style="padding: 0px 5px 0px 5px">
        @include('partials.sidepanel')
    </div>
    <div class="col-md-9" style="padding: 0px 5px 0px 5px">
    	<div class="box">
    		<div class="box-body">
				@if($downloads->where(['status' => 1])->count())
				@foreach($downloads->where(['status' => 1])->orderBy('id','desc')->cursor() as $dl)
				<div class="box box-solid">
					<div class="box-header with-border">
						<i class="fa fa-cloud-download"></i>

						<h3 class="box-title">{{ $dl->title }}</h3>
					</div>
					<div class="box-body">
						<blockquote>
							{!! $dl->content !!}
							<small><i class="fa fa-user"></i> Posted by <b>{{ $dl->user()->first()->name }}</b> <cite title="Source Title"><i class="fa fa-calendar"></i> {{ date('M d, Y h:i a',strtotime($dl->created_at)) }}</cite></small>
						</blockquote>
					</div>
				</div>
				@endforeach
				@else
				<div class="alert alert-warnng">
					NO DOWNLOAD CONTENT YET!.
				</div>
				@endif
    		</div>
    	</div>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop