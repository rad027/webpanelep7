@extends('adminlte::page')

@section('title', 'Helpdesk Ticket List')

@section('content_header')
    <h1>Helpdesk Ticket List</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		@if($helpdesks->count())
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>TITLE</th>
					<th>DEPARTMENT</th>
					<th>STATUS</th>
					<th>DATE CREATED</th>
					<th>ACTIONS</th>
				</tr>
			</thead>
			<tbody>
				@foreach($helpdesks->orderBy('id','desc')->cursor() as $hd)
				<tr>
					<td>{{ $hd->id }}</td>
					<td>{{ $hd->title }}</td>
					<td>{{ $hd->category }}</td>
					<td>
						@if($hd->status == 0)
						<span class="label label-default">WAITING FOR ANSWER</span>
						@elseif($hd->status == 1)
						<span class="label label-warning">ANSWERED</span>
						@else
						<span class="label label-danger">CLOSED</span>
						@endif
					</td>
					<td>{{ date('M d, Y h:i A',strtotime($hd->created_at)) }}</td>
					<td>
						@if(Auth::user()->isUser())
						<a href="{{ url('user/helpdesk/view/'.$hd->id) }}" class="btn btn-xs btn-flat btn-success">VIEW</a>
						@else
						<a href="{{ url('helpdesk/view/'.$hd->id) }}" class="btn btn-xs btn-flat btn-success">VIEW</a>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@endif
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop