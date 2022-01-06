<?php
include "../helpers/format.php";
include "../classes/product.php";
include "../classes/order.php";
include "../lib/session.php";
// Action from cart.js
Session::init();
$fm = new Format();
$prod = new Product();
$ss = new Session();
$odr = new Order();

$output = '
<div class="row mx-auto p-2" style="max-width: 1200px;">
    <div class="mb-1">
        <i class="fas fa-home text-primary"></i>
        <a href="index.php" class="text-decoration-none text-primary">Trang chủ</a>
        <i class="fas fa-chevron-right text-secondary" style="font-size: 12px;"></i>
        <span class="text-dark">Yêu thích</span>
    </div>
    <h3 class="text-center">Sản phẩm yêu thích</h3>
';
$check_freeship = '';
$wishlist_products = $prod->get_wishlist($ss->get('userid'));
if ($wishlist_products) {
    while ($result_wishlist = $wishlist_products->fetch_assoc()) {
        $get_product_detail = $prod->get_product_by_ID($result_wishlist['productID']);
        if($get_product_detail)
            $result_prod = $get_product_detail->fetch_assoc();
        if($result_prod['current_price']<=500000) 
            $check_freeship = 'd-none';
        else
            $check_freeship = '';
        
        // Start fetch
        $output .= '
        <div class="col-md-3 col-6 p-2">
        
        <div class="card shadow w-100 card-product" style="border-radius: 1rem;">
            <div class="card-body p-2">
                <button  data-bs-toggle="modal" data-bs-target="#removeWLModal'.$result_wishlist['productID'].'" class="label-top-wishlist shadow-sm"><i class="fas fa-minus-circle"></i> Xóa</button>
                <a href="details.php?productID='.$result_wishlist['productID'] .'" class="a-card">
                <img src="./images/product_img/'. $result_prod['image_1'] .'" class="card-img-top mt-3 mb-4" alt="..." />

                <div class="clearfix mb-1">
                    <div class="float-start p-0">
                        <span class="price-old">'. $fm->format_currency($result_prod['old_price']) .'đ</span><br>
                        <span class="text-warning price-new">'. $fm->format_currency($result_prod['current_price']) .'đ</span>
                    </div>
                    <span class="float-end '. $check_freeship .'">
                        <img src="./images/more/freeship-2.png" alt="..." style="width: 2.5em;margin:0px;" />
                    </span>
                </div>
                <h5 class="card-title mb-sm-4">
                    '. $fm->textShorten($result_prod['productName'], 50) .'
                </h5>
                </a>
                <div class="clearfix mt-1">
                    <span class="float-start" style="font-size: small;">
                        Đã bán '. $odr->check_sold($result_wishlist['productID']) .' sản phẩm
                    </span>
                    <!-- Thêm vào giỏ hàng -->
                    <input type="hidden" name="quantity" id="quantity'. $result_wishlist['productID'] .'" class="form-control" value="1" />
                    <input type="hidden" name="hidden_name" id="name'. $result_wishlist['productID'] .'" value="'. $result_prod['productName'] .'" />
                    <input type="hidden" name="hidden_price" id="price'. $result_wishlist['productID'] .'" value="'. $result_prod['current_price'] .'" />
                    <input type="hidden" name="hidden_image" id="image'. $result_wishlist['productID'] .'" value="'. $result_prod['image_1'] .'" />
                    <input type="hidden" name="hidden_remain" id="remain'. $result_wishlist['productID'] .'" value="'. $result_prod['productRemain'] .'" />
                    <input type="hidden" name="hidden_price_old" id="price_old'. $result_wishlist['productID'] .'" value="'. $result_prod['old_price'] .'" />
                    <button name="add_to_cart" id="'. $result_wishlist['productID'] .'" style="border-radius:0.5rem;" class="add_to_cart btn btn-warning float-end mt-1"><i class="fas fa-cart-plus"></i></button>
                    <!-- Kết thúc thêm giỏ hàng -->
                </div>
                </div>
            </div>
        
        
        </div>
        <!-- The Remove Modal -->
        <div class="modal fade" id="removeWLModal'.$result_wishlist['productID'].'">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thông báo</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="font-size: larger;">
                Bạn có chắc chắn muốn xóa sản phẩm khỏi danh sách yêu thích?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button name="delete-wishlist" class="btn btn-danger delete-wishlist" data-bs-dismiss="modal" id="' . $result_wishlist['productID'] . '">Xóa</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>

            </div>
        </div>
        </div>
        <!-- End Remove Modal --> 
        ';

        // End fetch

    }
	
} else {
	$output .= '
    <div class="text-center bg-white shadow mx-5 py-5 mt-2 mb-3 rounded-pill">
    	<h4 class="text-secondary">
    		Chưa có sản phẩm yêu thích!
    	</h4>
    </div>
    ';
}
$output .= '</div>';


$data = array(
	'wishlist_content'		=>	$output
);
// Action from cart.js
echo json_encode($data);
?>