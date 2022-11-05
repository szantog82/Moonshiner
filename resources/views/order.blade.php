@extends('layouts.main_layout')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{asset("/css/order.css")}}">
<div class="container">
	<h3>Available hoodies</h3>
	<div style="display: flex; justify-content: center; align-items: center;">
	@foreach ($items as $item)
		<div class="item-container">
			<img src="{{asset("/img/hoodie{$item->id}.jpg")}}">
			<p style="position: absolute; bottom: 20px;">{{$item->name}} {{$item->price}}$</p>
			<input type="number">
			<button class="btn btn-primary add-to-cart-btn" title="Add to cart..." data-item_id="{{$item->id}}"><i class="bi bi-cart4"></i></button>
		</div>
	@endforeach
	</div>
	Enter promo code: <input type="text" id="promo-code-input"><button class="btn btn-success" id="promo-code-ok-btn">OK</button>
</div>
@endsection