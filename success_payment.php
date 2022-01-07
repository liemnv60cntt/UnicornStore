<?php
$page_title = "Đặt hàng thành công";
include "./includes/header.php";
?>
<?php
$login_check = $ss->get("userlogin");
if ($login_check == false) {
    echo "<script>location.href = './login/login-user.php';</script>";
}
if (!isset($_POST['orderID'])) {
    echo "<script>location.href = '404.php';</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_now'])) {
    $orderID = $_POST['orderID'];
    $customerID = $ss->get('userid');
    $insertOrder = $odr->insertOrder($_POST, $customerID);
    foreach ($ss->get("shopping_cart") as $keys => $values) {
        $productID = $values['product_id'];
        $quantity = $values['product_quantity'];
        $totalPrice = $values['product_quantity'] * $values['product_price'];
        $insertOrderDetail = $odr->insertOrderDetail($orderID, $productID, $quantity, $totalPrice);
        $updateRemain = $prod->update_remain($productID, $quantity, 0);
    }
    if ($insertOrder['error'] == 0 && $insertOrderDetail['error'] == 0 && $updateRemain == true) {
        unset($_SESSION['shopping_cart']);
        // $get_order = $odr->get_order_by_id($orderID);
        // if ($get_order) {
        //     $result = $get_order->fetch_assoc();
        //     $time = strtotime($result['orderDate']);
        //     echo date('\V\à\o \l\ú\c H\h:i\p \n\g\à\y d-m-Y', $time);
        // }
    }
}


?>


<div class="card text-center card-success mb-4 mx-md-5">
    <div class="checkmark-area">
        <i class="checkmark">✓</i>
    </div>
    <h3 class="success-title">Đặt hàng thành công!</h3>
    <p class="success-note">Chúng tôi sẽ sớm xác nhận đơn hàng.<br /> Cảm ơn bạn đã mua sắm tại cửa hàng!</p>
    <a href="order_info.php" class="shadow text-decoration-none btn btn-success rounded-pill mt-3 fw-bold">Xem đơn hàng <i class='fas fa-arrow-right' style="font-size: 14px;"></i></a>
</div>









<?php
include "./includes/footer.php";
?>