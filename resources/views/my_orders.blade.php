@extends('layouts.main_layout')

@section('head')
<script src="{{asset('/js/my_orders.js')}}"></script>
<script src="{{asset('/js/my_orders.js')}}"></script>
<script src="{{asset('/js/my_orders.js')}}"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
@endsection

@section('content')
<h3>My orders</h3>
<div class="container">
	<table id="my-orders-table">
		<thead>
			<tr>
				<th>Order id</th>
				<th>Item</th>
				<th>Pieces</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($data as $d)
			<tr>
				<td>{{$d->id}}</td>
				<td>{{$d->name}}</td>
				<td>{{$d->count}}</td>
				<td>{{$d->created_at}}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endsection