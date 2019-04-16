@extends('adminlte::page')

@section('title', 'Item Shop')

@section('content_header')
    <h1>Item Shop</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>IMAGE</th>
					<th>NAME</th>
					<th>DESCRIPTION</th>
					<th>PRICE</th>
					<th>STOCK</th>
					<th>SECTION</th>
					<th>CATEGORY</th>
					<th>HIDDEN</th>
					<th>CREATED DATE</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody>
				@if($items->count())
				@foreach($items->orderBy('ProductNum','desc')->cursor() as $item)
				<tr>
					<td>{{ $item->ProductNum }}</td>
					<td><img src="@If($item->ItemSS != NULL){{ url('images/items/'.$item->ItemSS) }}@else https://itefix.net/sites/default/files/not_available.png @endif" width="40px"></td>
					<td>{{ $item->ItemName }}</td>
					<td>{{ $item->ItemComment }}</td>
					<td>{{ number_format($item->ItemPrice,2) }}</td>
					<td>{{ $item->Itemstock }}</td>
					<td>
						@if($item->ItemSec == 1)
						Premium Shop
						@else
						Vote Shop
						@endif
					</td>
					<td>
						@php
						$list = array('','Weapon','Accessories','Costumes','Pet System','EXP','Cards','Enhancements');
						@endphp
						{{ $list[$item->ItemCtg] }}
					</td>
					<td>
						@if($item->IsHidden != NULL)
						<span class="text-danger">HIDDEN</span>
						@else
						<span class="text-success">NOT HIDDEN</span>
						@endif
					</td>
					<td>{{ date('M d, Y h:i A',strtotime($item->date)) }}</td>
					<td>
						<a href="{{ url('webtool/itemshop/'.$item->ProductNum.'/edit') }}" class="btn btn-xs btn-warning">EDIT</a>
						<a href="{{ url('webtool/itemshop/'.$item->ProductNum.'/delete') }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delet this?')">DELETE</a>
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
		'order' : [[0,'desc']]
	});
});
</script>
@stop