function communicateWithServer(url, item_id, count) {
	$.ajax({
			url: url,
			type: 'POST',
			headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
			data: {item_id: item_id, count: count},
			success: function(data) {
						if (data.products.length == 0) {
							$("#empty-cart-mesg").css("visibility", "visible");
							$("#summary-div").css("visibility", "hidden");
						} else {
							$("#empty-cart-mesg").css("visibility", "hidden");
							$("#summary-div").css("visibility", "visible");
							updateSumTable(data);
						}
					},
			error: function() {
				alert("Error communicating with the server!");
				}
		});
}

function updateSumTable(data) {
		$("#ordered-items-tbody").empty();
					data.products.forEach(function(item, index){
						$("#ordered-items-tbody").append(`
						<tr>
                            <td>${item.unit_price}$/pcs</td>
                            <td colspan="2"><input class="item-sum-list-input" type="number" min="0" max="10" value="${item.count}" data-item_id="${item.id}"> x ${item.name}</td>
                       </tr>
						`);
					});
					
					$("#discounts-tbody").empty();
					data.reductions.forEach(function(item, index){
						$("#discounts-tbody").append(`
						<tr>
                            <td>-${item.value}$</td>
                            <td colspan="2">${item.message}</td>
                       </tr>
						`);
					});
					$("#original-price-span").text(`${data.full_price}$`);
					$("#final-price-span").text(`${data.reduced_price}$`);
}

$(document).ready(function(){
	
	communicateWithServer(checkCartContentUrl, "", "");

	$(document).on("click", ".add-to-cart-btn", function(){
		let item_id = $(this).attr("data-item_id");
		let count = $(this).siblings(".item-count-input").val();
		communicateWithServer(addItemToCartUrl, item_id, count);
	});
	
	$(document).on("change", ".item-sum-list-input", function() {
		let item_id = $(this).attr("data-item_id");
		let count = $(this).val();
		communicateWithServer(changeItemCountUrl, item_id, count);
	});
	
	$(document).on("click", "#promo-code-ok-btn", function(){
		let promoCode = $("#promo-code-input").val();
		$.ajax({
			url: uploadPromoCodeUrl,
			type: 'POST',
			headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
			data: {promoCode: promoCode},
			success: function(data) {
						if (data == 1) {
							alert("Active promo code added!");
						} else {
							alert("Wrong promo code!");
						}
						communicateWithServer(checkCartContentUrl, "", "");
					},
			error: function() {
				alert("Error communicating with the server!");
				}
		});
		$("#promo-code-input").val("");
	});
	
	$(document).on("click", "#store-order-btn", function(){
	$.ajax({
			url: storeOrderUrl,
			type: 'POST',
			headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
			success: function(data) {
			console.log(data)
						if (data == 1) {
							$("#empty-cart-mesg").css("visibility", "visible");
							$("#summary-div").css("visibility", "hidden");
							alert("Order stored successfully!");
						} else {
							alert("Error in storing order!");
						}
					},
			error: function() {
				alert("Error communicating with the server!");
				}
		});
	});
});