@extends('adminlte::page')

@section('title', 'Knowledge Base')

@section('content_header')
    <h1>
    	Knowledge Base
		<span class="pull-right">
			<a href="{{ url('webtool/knowledgebase/create') }}" class="btn btn-xs btn-flat btn-warning">CREATE NEW</a>
		</span>
	</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>TITLE</th>
					<th>CATEGORY</th>
					<th>CREATED DATE</th>
					<th>ACTIONS</th>
				</tr>
			</thead>
			<tbody>
				@if($kbs->count())
				@foreach($kbs->cursor() as $kb)
				<tr>
					<td>{{ $kb->id }}</td>
					<td>{{ $kb->title }}</td>
					<td>{{ $kb->category()->first()->title }}</td>
					<td>{{ date('M d, Y h:i a', strtotime($kb->created_at)) }}</td>
					<td>
						<a href="{{ url('webtool/knowledgebase/'.$kb->id.'/view') }}" class="btn btn-xs btn-flat btn-success">VIEW</a>
						<a href="{{ url('webtool/knowledgebase/'.$kb->id.'/edit') }}" class="btn btn-xs btn-flat btn-primary">EDIT</a>
						<a href="{{ url('webtool/knowledgebase/'.$kb->id.'/delete') }}" class="btn btn-xs btn-flat btn-danger" onclick="return confirm('Are you sure you want to delete this?')">DELETE</a>
					</td>
				</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$('table').DataTable({
		'order' : [[ 0,'desc' ]]
	});
});
</script>
@stop