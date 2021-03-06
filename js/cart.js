$(document).ready(function(){


	load_cart_data();
	load_wishlist_data();
    // Start Action Wish List
	$(document).on('click', '.delete-wishlist', function(){
		var product_ID_WL = $(this).attr("id");
		var actionWL = 'remove-wishlist';
		
			$.ajax({
				url:"includes/action_wishlist.php",
				method:"POST",
				data:{product_ID_WL:product_ID_WL, actionWL:actionWL},
				success:function()
				{
					load_wishlist_data()
					
				}
			})
		
	});
	function load_wishlist_data()
	{
		$.ajax({
			url:"includes/fetch_wishlist.php",
			method:"POST",
			dataType:"json",
			success:function(data)
			{
				$('#wishlist_content').html(data.wishlist_content);
			}
		});
	}
	$(document).on('click', '#actionWList', function(){
		var customer_ID_WL = $('#customer_ID_WL').val();
		var product_ID_WL = $('#product_ID_WL').val();
		var actionWL = "addWL";
		if(customer_ID_WL=='' || product_ID_WL==''){
			return false;
		}else{
			$.ajax({
			url: "includes/action_wishlist.php",
			method: "POST",
			data: {
				customer_ID_WL: customer_ID_WL,
				product_ID_WL: product_ID_WL,
				actionWL: actionWL
			},
			success: function(data) {
				load_wishlist_data()
			}
			});
		}

	});
	// End Action Wish List

	function load_cart_data()
	{
		$.ajax({
			url:"includes/fetch_cart.php",
			method:"POST",
			dataType:"json",
			success:function(data)
			{
				$('#cart_details').html(data.cart_details);
				$('#cart_for_payment').html(data.cart_for_payment);
				$('.total_price').text(data.total_price);
				$('.badge-cart').text(data.total_item);
			}
		});
	}

	

	$(document).on('click', '.add_to_cart', function(){
		var product_id = $(this).attr("id");
		var product_name = $('#name'+product_id+'').val();
		var product_price = $('#price'+product_id+'').val();
		var product_quantity = $('#quantity'+product_id).val();
		var product_image = $('#image'+product_id).val();
		var product_remain = $('#remain'+product_id).val();
		var product_price_old = $('#price_old'+product_id+'').val();
		var action = "add";
		if(product_quantity > 0)
		{
			$.ajax({
				url:"includes/action_cart.php",
				method:"POST",
				data:{
					product_id:product_id, 
					product_name:product_name, 
					product_price:product_price, 
					product_quantity:product_quantity, 
					product_image:product_image, 
					product_remain:product_remain, 
					product_price_old:product_price_old, 
					action:action
					},
				success:function(data)
				{
					load_cart_data();
					$('#addCartSuccess').modal('show');
					// alert("Item has been Added into Cart");
				}
			});
		}
		else
		{
			alert("Ch??a nh???p s??? l?????ng!");
		}
	});
	$(document).on('click', '.add_to_cart_from_detail', function(){
		var product_id = $(this).attr("id");
		var product_name = $('#name_detail').val();
		var product_price = $('#price_detail').val();
		var product_quantity = $('#quantity_detail').val();
		var product_image = $('#image_detail').val();
		var product_remain = $('#remain_detail').val();
		var product_price_old = $('#price_old_detail').val();
		var action = "add";
		if(product_quantity > 0)
		{
			$.ajax({
				url:"includes/action_cart.php",
				method:"POST",
				data:{
					product_id:product_id, 
					product_name:product_name, 
					product_price:product_price, 
					product_quantity:product_quantity, 
					product_image:product_image, 
					product_remain:product_remain, 
					product_price_old:product_price_old, 
					action:action
					},
				success:function(data)
				{
					load_cart_data();
					$('#addCartSuccess').modal('show');
					// alert("Item has been Added into Cart");
				}
			});
		}
		else
		{
			alert("Ch??a nh???p s??? l?????ng!");
		}
	});
	$(document).on('click', '.buy_now', function(){
		var product_id = $(this).attr("id");
		var product_name = $('#name_detail').val();
		var product_price = $('#price_detail').val();
		var product_quantity = $('#quantity_detail').val();
		var product_image = $('#image_detail').val();
		var product_remain = $('#remain_detail').val();
		var product_price_old = $('#price_old_detail').val();
		var action = "add";
		if(product_quantity > 0)
		{
			$.ajax({
				url:"includes/action_cart.php",
				method:"POST",
				data:{
					product_id:product_id, 
					product_name:product_name, 
					product_price:product_price, 
					product_quantity:product_quantity, 
					product_image:product_image, 
					product_remain:product_remain, 
					product_price_old:product_price_old, 
					action:action
					},
				success:function(data)
				{
					load_cart_data();
				}
			});
		}
		else
		{
			alert("Ch??a nh???p s??? l?????ng!");
		}
	});
    $(document).on('blur', '.update_cart_on_blur', function(){
		var product_quantity_id = $(this).attr("id");
		var product_id = product_quantity_id.replace("quantity_update","");
        var product_quantity = Math.round($('#quantity_update'+product_id).val());
		var product_remain = parseInt($('#remain_update'+product_id).val());
		var action = "update";
		if(product_quantity < 1)
			product_quantity = 1;
		if(product_quantity > 0)
		{
			if(product_quantity > product_remain)
				product_quantity = product_remain
			$.ajax({
				url:"includes/action_cart.php",
				method:"POST",
				data:{product_id:product_id, product_quantity:product_quantity, action:action},
				success:function(data)
				{
					load_cart_data();
					// alert("Item has been Added into Cart");
				}
			});
		}
	});
	$(document).on('click', '.update_cart_minus', function(){
		var product_id = $(this).attr("id");
        var product_quantity = $('#quantity_update'+product_id).val();
		if(product_quantity > 1)
			product_quantity -= 1;
		var action = "update";
		if(product_quantity > 0)
		{
			$.ajax({
				url:"includes/action_cart.php",
				method:"POST",
				data:{product_id:product_id, product_quantity:product_quantity, action:action},
				success:function(data)
				{
					load_cart_data();
					// alert("Item has been Added into Cart");
				}
			});
		}
		
	});
	$(document).on('click', '.update_cart_plus', function(){
		var product_id = $(this).attr("id");
        var product_quantity = parseInt($('#quantity_update'+product_id).val());
		var product_remain = parseInt($('#remain_update'+product_id).val());
		//
		if(product_quantity < product_remain)
			product_quantity = product_quantity + 1;
		var action = "update";
		if(product_quantity > 0)
		{
			$.ajax({
				url:"includes/action_cart.php",
				method:"POST",
				data:{product_id:product_id, product_quantity:product_quantity, action:action},
				success:function(data)
				{
					load_cart_data();
					// alert("Item has been Added into Cart");
				}
			});
		}
		
	});

	$(document).on('click', '.delete', function(){
		var product_id = $(this).attr("id");
		var action = 'remove';
		
			$.ajax({
				url:"includes/action_cart.php",
				method:"POST",
				data:{product_id:product_id, action:action},
				success:function()
				{
					load_cart_data();
					
					// alert("???? x??a s???n ph???m kh???i gi??? h??ng");
				}
			})
		
	});

	$(document).on('click', '#clear_cart', function(){
		var action = 'empty';
        
			$.ajax({
                url:"includes/action_cart.php",
                method:"POST",
                data:{action:action},
                success:function()
                {
                    load_cart_data();
                    
                    // alert("Gi??? h??ng c???a b???n ???? tr???ng!");
                }
            });
		
		
	});
    
});