@extends('adminlte::page')

@section('title', 'Edit .ENV File')

@section('content_header')
    <h1>Edit .ENV File</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<div class="callout callout-warning">
			<h3>IMPORTANT NOTICE :</h3>
			<p>
				<b>Updating this file must be in an accurate way.</b> <b>Misconfiguration</b> or <b>misspell</b> in each word here might ruined your whole website and it could be a proper reason to cancel our relationship for us to maintain the security and updating file of this system.
			</p>
		</div>
		<form method="post" onsubmit="return confirm('Are you sure you want to update this ?');">
			@csrf
			<div class="form-group">
				<label>UPDATE .ENV FILE :</label>
				{!! Form::textarea('env', file_get_contents(base_path('.env')), [ 'class' => 'form-control', 'style' => 'resize:none', 'rows' => 20 ]) !!}
			</div>
			<button class="btn btn-flat btn-success" type="submit">UPDATE!</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop