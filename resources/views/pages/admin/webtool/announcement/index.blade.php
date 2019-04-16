@extends('adminlte::page')

@section('title', 'Announcements List')

@section('content_header')
    <h1>
	    Announcements List
	    <span class="pull-right">
	    	<a href="{{ url('webtool/news/create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> CREATE</a>
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
					<th>AUTHOR</th>
					<th>CREATED DATE</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody>
				@if($announcement->count())
				@foreach($announcement->orderBy('id','desc')->cursor() as $annc)
				<tr>
					<td>{{ $annc->id }}</td>
					<td>{{ $annc->title }}</td>
					<td>{{ $annc->user()->first()->name }}</td>
					<td>{{ date('M d, Y h:i A',strtotime($annc->created_at)) }}</td>
					<td>
						<a href="{{ url('webtool/news/'.$annc->id.'/show') }}" class="btn btn-xs btn-success">VIEW</a>
						<a href="{{ url('webtool/news/'.$annc->id.'/edit') }}" class="btn btn-xs btn-primary">EDIT</a>
						<a href="{{ url('webtool/news/'.$annc->id.'/delete') }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this announcement?')">DELETE</a>
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