@extends('adminlte::page')

@section('title', 'Download Page Contents')

@section('content_header')
    <h1>Download Page Contents</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>TITLE</th>
					<th>AUTHOR</th>
					<th>CREATED DATE</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody>
				@if($downloads->count())
				@foreach($downloads->orderBy('id','desc')->cursor() as $dl)
				<tr>
					<td>{{ $dl->id }}</td>
					<td>{{ $dl->title }}</td>
					<td>{{ $dl->user()->first()->name }}</td>
					<td>{{ date('M d, Y h:i a',strtotime($dl->created_at)) }}</td>
					<td>
						<a href="{{ url('webtool/download/'.$dl->title.'/show') }}" class="btn btn-xs btn-success">VIEW</a>
						<a href="{{ url('webtool/download/'.$dl->id.'/edit') }}" class="btn btn-xs btn-primary">EDIT</a>
						<a href="{{ url('webtool/download/'.$dl->id.'/delete') }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this?')">DELETE</a>
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