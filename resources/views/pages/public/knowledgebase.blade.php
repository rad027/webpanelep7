@extends('adminlte::page')

@section('title', 'Knowledge Base')

@section('content_header')
    <h1>Knowledge Base</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3" style="padding: 0px 5px 0px 5px">
        @include('partials.sidepanel')
    </div>
    <div class="col-md-9" style="padding: 0px 5px 0px 5px">
    	<div class="box">
    		<div class="box-body">
				<form method="post">
                    @csrf
                    <div class="form-group">
                        <label>SEARCH :</label>
                        {!! Form::text('search', ($search != NULL ? $search : ''), [ 'class' => 'form-control', 'placeholder' => 'Enter something here...' ]) !!}
                    </div>
                </form>
    		</div>
    	</div>
        <hr>
        @if($search != NULL)
        <h3>RESULTS : {{ $result->count() }}</h3>
        <div class="col-md-12" style="padding: 0;margin: 0">
            @if($result->count())
                @foreach($result->cursor() as $res)
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"><a href="{{ url('knowledgebase/'.$res->id.'/view') }}">{{ $res->title }}</a></h3>
                            </div>
                            <div class="box-body">
                                {{ substr($res->content,0,40) }}...<a href="{{ url('knowledgebase/'.$res->id.'/view') }}">Read more</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-md-12" style="padding: 0;margin: 0">
        <hr>
        </div>
        @endif
        {{-- FETCH --}}
        @if($cats->count())
        @foreach($cats->cursor() as $cat)
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $cat->title }} ({{ $cat->knowledgebase()->count() }})</h3>
                </div>
                <div class="box-body">
                    @if($cat->knowledgebase()->count())
                    <ul>
                        @foreach($cat->knowledgebase()->cursor() as $kb)
                        <li><a href="{{ url('knowledgebase/'.$kb->id.'/view') }}">{{ $kb->title }}</a></li>
                        @endforeach
                    </ul>
                    @else
                    <ul>
                        <li>NOTHING HERE YET.</li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        @endif
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop