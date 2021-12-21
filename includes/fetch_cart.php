<?php

//fetch_cart.php

session_start();

$total_price = 0;
$total_item = 0;

$output = '
<div>
	
';
if (!empty($_SESSION["shopping_cart"])) {
	foreach ($_SESSION["shopping_cart"] as $keys => $values) {
		$output .= '
		<div class="row bg-white shadow my-3 py-3 rounded-3 g-0">
			<div class="col-md-2 col-4 d-flex justify-content-center">
				<img src="images/product_img/' . $values["product_image"] . '" alt="..." style="width: 8em;height: 7em;"/>
			</div>
			<div class="col-md-10 col-8 row">
				<div class="col-md-3 d-flex align-items-center">
				<a class="a-card" href="details.php?productID=' . $values["product_id"] . '">' . $values["product_name"] . '</a>
				</div>
				<div class="col-md-3 d-flex align-items-center">
					<div class="input-group w-75 mt-2">
                        <button name="update_cart_minus" class="input-group-text update_cart_minus" id="' . $values["product_id"] . '"><i class="fas fa-minus" style="font-size:14px"></i></button>
                        <input type="number" name="quantity_update" id="quantity_update' . $values["product_id"] . '" class="form-control bg-light text-center w-25 update_cart_on_blur" value="' . $values["product_quantity"] . '" >
						<input type="hidden" name="remain_update" id="remain_update' . $values["product_id"] . '" value="' . $values["product_remain"] . '">
                        <button name="update_cart_plus" class="input-group-text update_cart_plus" id="' . $values["product_id"] . '"><i class="fas fa-plus" style="font-size:14px"></i></button>

						<span class="text-secondary"> ' . $values["product_remain"] . ' sản phẩm có sẵn</span>
                    </div>
					
				</div>
				<div class="col-md-2 pt-2 text-secondary d-flex align-items-center">
					<div>
						<div class="d-block">
							<span class="text-decoration-line-through">' . number_format($values["product_price_old"], 0) . ' <span style="text-decoration: underline;">đ</span></span>
						</div>
						<div class="fw-bold d-block">
							' . number_format($values["product_price"], 0) . ' <span style="text-decoration: underline;">đ</span>
						</div>
					</div>
				</div>
				<div class="col-md-2 pt-2 text-danger fw-bold d-flex align-items-center">
				' . number_format($values["product_quantity"] * $values["product_price"], 0) . '
				<span style="text-decoration: underline;">đ</span>
				</div>
				<div class="col-md-2 d-flex align-items-center">
				<button class="btn btn-danger shadow-sm mt-2" data-bs-toggle="modal" data-bs-target="#myRemoveModal">
					<i class="fas fa-minus-circle"></i> Xóa
				</button>
				
				<!-- The Remove Modal -->
				<div class="modal fade" id="myRemoveModal">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">

					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Thông báo</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>

					<!-- Modal body -->
					<div class="modal-body" style="font-size: larger;">
						Bạn có chắc chắn muốn xóa sản phẩm khỏi giỏ hàng?
					</div>

					<!-- Modal footer -->
					<div class="modal-footer">
						<button name="delete" class="btn btn-danger delete" data-bs-dismiss="modal" id="' . $values["product_id"] . '">Xóa</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
					</div>

					</div>
				</div>
				</div>
				<!-- End Remove Modal -->
				</div>
			</div>
		</div>
		';
		$total_price = $total_price + ($values["product_quantity"] * $values["product_price"]);
		$total_item = $total_item + 1;
	}
	$output .= '
	<div class="d-flex align-items-center justify-content-end shadow rounded-3 px-5 py-4 my-4 bg-light">  
        <div class="fw-bold mx-3">
			Phí giao hàng: <span class="text-danger">' . 0 . ' <span style="text-decoration: underline;">đ</span></span> <br>
			Tổng thanh toán: <span class="text-danger">' . number_format($total_price, 0) . ' <span style="text-decoration: underline;">đ</span></span></div>  
		<div>
			<button class="btn btn-danger shadow mt-1" data-bs-toggle="modal" data-bs-target="#myClearModal">
				<i class="fas fa-trash-restore"></i> Xóa toàn bộ
			</button>
			
			<a href="#" class="btn btn-primary shadow mt-1" id="check_out_cart">
					<i class="fas fa-credit-card"></i> Mua hàng
			</a>
			<!-- The Clear Modal -->
				<div class="modal fade" id="myClearModal">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">

					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Thông báo</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>

					<!-- Modal body -->
					<div class="modal-body" style="font-size: larger;">
						Bạn có chắc chắn muốn xóa toàn bộ sản phẩm khỏi giỏ hàng?
					</div>

					<!-- Modal footer -->
					<div class="modal-footer">
						<button class="btn btn-danger shadow mt-1" id="clear_cart" data-bs-dismiss="modal">
							Xóa toàn bộ
						</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
					</div>

					</div>
				</div>
				</div>
			<!-- End Clear Modal -->
		</div>
    </div>
	';
} else {
	$output .= '
    <div class="text-center bg-white shadow mx-5 py-5 mt-2 mb-3 rounded-pill">
    	<h4 class="text-secondary">
    		Giỏ hàng của bạn trống!
    	</h4>
    </div>
    ';
}
$output .= '</div>';
$data = array(
	'cart_details'		=>	$output,
	'total_price'		=>	'$' . number_format($total_price, 0),
	'total_item'		=>	$total_item
);

echo json_encode($data);
?>
