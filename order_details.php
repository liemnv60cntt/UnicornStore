<?php
$page_title = "Chi tiết đơn hàng";
include "./includes/header.php";
?>
<?php
$login_check = $ss->get("userlogin");
if ($login_check == false) {
    echo "<script>location.href = './login/login-user.php';</script>";
}
$orderID = (isset($_GET['orderID']) && $_GET['orderID'] != null) ? $_GET['orderID'] : '';
if ($orderID == '')
    echo "<script>window.location ='404.php'</script>";

?>

<div class="container mb-3">
    <div class="mb-2">
        <i class='fas fa-home text-primary'></i>
        <a href="index.php" class="text-decoration-none text-primary">Trang chủ</a>
        <i class='fas fa-chevron-right text-secondary' style="font-size: 12px;"></i>
        <a href="./order_info.php" class="text-decoration-none"><span class="text-dark">Thông tin đơn hàng</span></a>
        <i class='fas fa-chevron-right text-secondary' style="font-size: 12px;"></i>
        <span class="text-dark">Chi tiết đơn hàng</span>
    </div>
    <div class="row">
        <div class="col-md-10 p-0 px-md-3 pb-md-0 pb-3">
            <div>
                <?php
                $get_order = $odr->get_order_by_id($orderID);
                if ($get_order) {
                    while ($result = $get_order->fetch_assoc()) {

                ?>
                        <div class="row border-start border-primary border-3 bg-white shadow rounded mx-0 px-3 pt-1 pb-2">
                            <div class="border-bottom border-2 p-0 mb-2 row g-0 py-2">
                                <div class="col-md-4">
                                    <button onClick='window.history.back()' class="btn btn-outline-secondary"><i class='fas fa-arrow-left'></i> Quay lại</button>
                                </div>
                                <div class="col-md-8">
                                    <span class="float-md-end">
                                        Đơn hàng: <?php echo $result['orderID'] ?>
                                        <span class="fw-bold text-primary"> | </span>
                                        <?php
                                        $time = strtotime($result['orderDate']);
                                        echo date('g:i A\, d-m-Y', $time);
                                        ?>
                                    </span>
                                </div>
                                <div class="card card-timeline px-2 border-none my-2">
                                    
                                    <ul class="bs5-order-tracking <?php if($result['orderStatus']==4) echo "d-none"; ?>">
                                        <li class="step active">
                                            <div><i class="fas fa-check-circle"></i></div> Đơn hàng đã đặt
                                        </li>
                                        <!-- <li class="step active">
                                            <div><i class="fas fa-undo-alt"></i></div> Đơn hàng đã hủy
                                        </li> -->
                                        <li class="step <?php echo $odr->check_active(1,$orderID) ?>">
                                            <div><i class="fas fa-spinner"></i></div> Chờ xác nhận đơn hàng
                                        </li>
                                        <li class="step <?php echo $odr->check_active(2,$orderID) ?>">
                                            <div><i class="fas fa-box-open"></i></div> Đang chuẩn bị hàng
                                        </li>
                                        <li class="step <?php echo $odr->check_active(3,$orderID) ?>">
                                            <div><i class="fas fa-truck"></i></div> Đang giao hàng
                                        </li>
                                        <li class="step <?php echo $odr->check_active(4,$orderID) ?>">
                                            <div><i class="fas fa-calendar-check"></i></div> Đã nhận hàng và thanh toán
                                        </li>
                                        <li class="step <?php if($odr->check_order_rating($orderID)==true) echo "active" ?>">
                                            <div><i class="fas fa-star-half-alt"></i></div> Đã đánh giá đơn hàng
                                        </li>
                                    </ul>
                                    <ul class="bs5-order-tracking-2 <?php if($result['orderStatus']!=4) echo "d-none"; ?>">
                                        <li class="step active">
                                            <div><i class="fas fa-check-circle"></i></div> Đơn hàng đã đặt
                                        </li>
                                        <li class="step <?php echo $odr->check_active(5,$orderID) ?>">
                                            <div><i class="far fa-trash-alt"></i></div> Đơn hàng đã hủy
                                        </li>
                                    </ul>
                                    <h6 class="text-center"><?php
                                        $up_time = strtotime($result['updateTime']);
                                        echo "Lần cập nhật gần nhất: ".date('g:i A\, d-m-Y', $up_time);
                                    ?></h6>
                                    <div class="alert alert-success mx-5 text-center alert-dismissible fade show <?php if($result['adminNote']=="") echo "d-none"; ?>" role="alert">
                                        <?php
                                        echo $result['adminNote']
                                        ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    
                                </div>
                            </div>
                            <?php
                            $subPrice = 0;
                            $get_order_detail = $odr->get_order_detail_by_id($result['orderID']);
                            if ($get_order_detail) {
                                while ($result_order_details = $get_order_detail->fetch_assoc()) {
                                    $subPrice += $result_order_details['totalPrice'];
                                    $product_info = $prod->get_details($result_order_details['productID']);
                                    if ($product_info)
                                        $result_prod = $product_info->fetch_assoc();
                            ?>
                                    <div class="row g-0 shadow-sm rounded border-start border-end border-2 border-info my-2">
                                        <div class="col-md-2 col-4 d-flex justify-content-center">
                                            <img src="images/product_img/<?php echo $result_prod["image_1"] ?>" alt="..." style="width: 8em;height: 7em;" />
                                        </div>
                                        <div class="col-md-10 col-8 row py-md-0 py-3">
                                            <div class="col-md-3 d-flex align-items-center">
                                                <a class="a-card" href="details.php?productID=<?php echo $result_prod["productID"] ?>"><?php echo $fm->textShorten($result_prod["productName"], 40) ?></a>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-center">
                                                <span class="text-secondary">Đơn giá: &nbsp;</span>
                                                <span class="fw-bold">
                                                    <?php echo $fm->format_currency($result_prod["current_price"]) ?>
                                                </span>
                                                <span class="fw-bold" style="text-decoration: underline;">đ</span>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-center">
                                                <span class="text-secondary">Số lượng: &nbsp;</span>
                                                <span class="fw-bold"><?php echo $result_order_details["quantity"] ?></span>
                                            </div>

                                            <div class="col-md-4 d-flex align-items-center">
                                                <span class="text-secondary">Thành tiền: &nbsp;</span>
                                                <span class=" text-danger fw-bold">
                                                    <?php echo $fm->format_currency($result_order_details["totalPrice"]) ?>
                                                </span>
                                                <span class="text-danger fw-bold" style="text-decoration: underline;">đ</span>
                                            </div>

                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                            <div class="border-top border-2 p-0 mt-2 row g-0 py-1">
                                <div class="col-md-8">
                                    <?php
                                    if ($result['customerNote'] != "")
                                        echo "<span>
                                                Ghi chú: " . $result['customerNote'] . "
                                            </span>"
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end">
                                        Thành tiền:
                                        <span class="fw-bold"><?php echo $fm->format_currency($subPrice) ?><span class="text-decoration-underline">đ</span></span>
                                    </span><br>
                                    <span class="float-md-end">
                                        Phí vận chuyển:
                                        <span class="fw-bold"><?php echo $fm->format_currency($odr->get_shipping_fee($subPrice)) ?><span class="text-decoration-underline">đ</span></span>
                                    </span><br>
                                    <span class="float-md-end">
                                        Tổng tiền:
                                        <span class="text-danger fw-bold"><?php echo $fm->format_currency($result['orderPrice']) ?><span class="text-decoration-underline">đ</span></span>
                                    </span><br>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<div class='text-center'>";
                    echo "<span class='text-secondary fw-bold'>Chưa có đơn hàng</span>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <div class="col-md-2 d-flex justify-content-center rounded bg-white shadow">
        <div class="p-3 py-5">
            <div class="d-flex justify-content-between align-items-center"><span></span><a href="./user_profile.php" class="text-decoration-none text-dark border px-3 p-1 btn-profile rounded shadow-sm"><i class="fas fa-user-cog"></i>&nbsp;Tài khoản</a></div><br>
            <div class="d-flex justify-content-between align-items-center"><span></span><a href="./wishlist_page.php" class="text-decoration-none text-dark border px-3 p-1 btn-profile rounded shadow-sm"><i class="fas fa-heart"></i>&nbsp;Yêu thích</a></div><br>
            <div class="d-flex justify-content-between align-items-center"><span></span><span class="border px-3 p-1 btn-profile rounded shadow-sm"><i class="fas fa-compress-alt"></i>&nbsp;So sánh</span></div><br>
            <div class="d-flex justify-content-between align-items-center"><span></span>
                <a href="./login/update-password.php?email=<?php echo $ss->get('email') ?>" class="text-dark text-decoration-none border px-3 p-1 btn-profile rounded shadow-sm"><i class="fas fa-user-lock"></i>&nbsp;Mật khẩu</a>
            </div><br>
            <div class="d-flex justify-content-between align-items-center"><span></span>
                <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" class="btn btn-outline-danger text-decoration-none px-3 p-1 btn-logout rounded shadow-sm"><i class="fas fa-sign-out-alt"></i>&nbsp;Đăng xuất</a>
            </div>
        </div>
        </div>
    </div>
</div>









<?php
include "./includes/footer.php";
?>