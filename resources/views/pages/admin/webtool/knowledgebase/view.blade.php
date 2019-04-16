@extends('adminlte::page')

@section('title', 'Viewing ['.$kb->title.'] Knowledge Base')

@section('content_header')
    <h1>
    	Viewing [{{ $kb->title }}] Knowledge Base
    	<span class="pull-right">
    		<a href="{{ url('webtool/knowledgebase') }}" class="btn btn-flat btn-xs btn-danger">BACK</a>
    	</span>
    </h1>
@stop

@section('content')
<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-newspaper-o"></i>

        <h3 class="box-title">{{ $kb->title }}</h3>
    </div>
    <div class="box-body">
        <blockquote>
            {!! $kb->content !!}
            <small><i class="fa fa-user"></i> Category <b>{{ $kb->category()->first()->title }}</b> <cite title="Posted Date"><i class="fa fa-calendar"></i> {{ date('M d, Y h:i a',strtotime($kb->created_at)) }}</cite></small>
        </blockquote>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop