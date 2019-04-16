@extends('adminlte::page')

@section('title', 'Refresh Database')

@section('content_header')
    <h1>Refresh Database</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<div class="callout callout-warning">
			<h3>NOTE :</h3>
			<p>
				<ul>
					<li>USE THIS FUNCTION ONLY WHEN YOU HAVE RESTART YOUR DATABASE SERVER.</li>
				</ul>
			</p>
		</div>
		<form method="post">
			@csrf
			<button class="btn btn-flat btn-block btn-success">REFRESH!</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop