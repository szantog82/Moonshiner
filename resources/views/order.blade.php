@extends('layouts.main_layout')

@section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{asset("/css/order.css")}}">
<script>
const addItemToCartUrl = '{{route('item.add.cart')}}';
const changeItemCountUrl = '{{route('item.changecount.cart')}}';
const checkCartContentUrl = '{{route('item.check.cart')}}';
const uploadPromoCodeUrl = '{{route('order.upload.promocode')}}';
const storeOrderUrl = '{{route('store.order')}}';
</script>
<script src="{{asset('/js/order.js')}}"></script>
@endsection

@section('content')
<div class="container">
	<h3>Available hoodies</h3>
	@if(!auth()->check())
		<h4 style="color: red">You must log in to order hoodies!</h4>
	@endif
	<div style="display: flex; justify-content: center; align-items: center;">
	@foreach ($items as $item)
		<div class="item-container">
			<img src="{{asset("/img/hoodie{$item->id}.jpg")}}">
			<p style="position: absolute; bottom: 20px;">{{$item->name}} {{$item->price}}$</p>
			<input class="item-count-input" type="number" min="1" max="10" value="1">
			<button class="btn btn-primary add-to-cart-btn" title="Add to cart..." data-item_id="{{$item->id}}" data-url="{{route('item.add.cart')}}"><i class="bi bi-cart4"></i></button>
		</div>
	@endforeach
	</div>
	<div>
    	Enter promo code (Welcome1337): <input type="text" id="promo-code-input"><button class="btn btn-success" id="promo-code-ok-btn">OK</button>
    	<h3 id="empty-cart-mesg" style="">Cart is empty!</h3>
    	<div id="summary-div">
          <table>
            <tbody id="ordered-items-tbody">
            </tbody>
            <tbody>
             	<tr>
                  <td colspan="3">
                    <hr>
                  </td>
                </tr>
                 <tr>
                  <td>Original sum:</td>
                  <td><b><span id="original-price-span"></span></b></td>
                </tr>
                <tr>
                  <td colspan="3">
                    <hr>
                  </td>
                </tr>
            </tbody>
            <tbody id="discounts-tbody">
            </tbody>
            <tbody>
                <tr>
                  <td colspan="3">
                    <hr>
                  </td>
                </tr>
                <tr>
                  <td>Reduced sum:</td>
                  <td><b><span id="final-price-span"></span></b></td>
                </tr>
            </tbody>
          </table>
          @if(auth()->check())
          	<button class="btn btn-success" id="store-order-btn">Send order</button>
          @endif
        </div>
    </div>
</div>
@endsection