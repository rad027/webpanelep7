@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    
@stop

@section('content')
<div class="row">
    <div class="col-md-3" style="padding: 0px 5px 0px 5px">
        @include('partials.sidepanel')
    </div>
    <div class="col-md-9" style="padding: 0px 5px 0px 5px">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">NEWS & ANNOUNCEMENTS</h3>
            </div>
            <div class="box-body">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-newspaper-o"></i>

                        <h3 class="box-title">{{ $annc->title }}</h3>
                    </div>
                    <div class="box-body">
                        <blockquote>
                            {!! $annc->content !!}
                            <small><i class="fa fa-user"></i> Posted by <b>{{ $annc->user()->first()->name }}</b> <cite title="Posted Date"><i class="fa fa-calendar"></i> {{ date('M d, Y h:i a',strtotime($annc->created_at)) }}</cite></small>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')
@stop