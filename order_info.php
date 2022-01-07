<?php
$page_title = "Thông tin đơn hàng";
include "./includes/header.php";
?>
<?php
$login_check = $ss->get("userlogin");
if ($login_check == false) {
    echo "<script>location.href = './login/login-user.php';</script>";
}

?>

<div class="container mb-3">
    <div class="mb-2">
        <i class='fas fa-home text-primary'></i>
        <a href="index.php" class="text-decoration-none text-primary">Trang chủ</a>
        <i class='fas fa-chevron-right text-secondary' style="font-size: 12px;"></i>
        <span class="text-dark">Thông tin đơn hàng</span>
    </div>
    <div class="row">
        <div class="col-md-10 p-0 px-md-3 pb-md-0 pb-3">
            <div class="rounded bg-white shadow p-3 pb-5">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#all">
                        <div class="text-center">
                            <i class='fas fa-list-ol' style="font-size: 1.3em;"></i>
                        </div>
                        Tất cả 
                        (<?php
                            $count_all = $odr->count_all_order($ss->get('userid'));
                            if($count_all)
                                $result_count_all = $count_all->fetch_assoc();
                            echo $result_count_all['c']; 
                        ?>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#pending">
                        <div class="text-center">
                            <i class='fas fa-spinner' style="font-size: 1.3em;"></i>
                        </div> 
                        Chờ xác nhận 
                        (<?php
                            $count_pending = $odr->count_order_by_status($ss->get('userid'), 0);
                            if($count_pending)
                                $result_count_pending = $count_pending->fetch_assoc();
                            echo $result_count_pending['c']; 
                        ?>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#preparing">
                        <div class="text-center">
                            <i class='fas fa-box-open' style="font-size: 1.3em;"></i>
                        </div> 
                        Chuẩn bị hàng 
                        (<?php
                            $count_preparing = $odr->count_order_by_status($ss->get('userid'), 1);
                            if($count_preparing)
                                $result_count_preparing = $count_preparing->fetch_assoc();
                            echo $result_count_preparing['c']; 
                        ?>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#delivering">
                        <div class="text-center">
                            <i class='fas fa-truck' style="font-size: 1.3em;"></i>
                        </div> 
                        Đang giao 
                        (<?php
                            $count_delivering = $odr->count_order_by_status($ss->get('userid'), 2);
                            if($count_delivering)
                                $result_count_delivering = $count_delivering->fetch_assoc();
                            echo $result_count_delivering['c']; 
                        ?>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#delivered">
                        <div class="text-center">
                            <i class='fas fa-calendar-check' style="font-size: 1.3em;"></i>
                        </div>
                        Đã giao 
                        (<?php
                            $count_delivered = $odr->count_order_by_status($ss->get('userid'), 3);
                            if($count_delivered)
                                $result_count_delivered = $count_delivered->fetch_assoc();
                            echo $result_count_delivered['c']; 
                        ?>)</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#cancelled">
                        <div class="text-center">
                            <i class='far fa-trash-alt' style="font-size: 1.3em;"></i>
                        </div>
                        Đã hủy 
                        (<?php
                            $count_cancelled = $odr->count_order_by_status($ss->get('userid'), 4);
                            if($count_cancelled)
                                $result_count_cancelled = $count_cancelled->fetch_assoc();
                            echo $result_count_cancelled['c']; 
                        ?>)</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content order-info-list border-bottom border-2">
                    <!-- Start All Order -->
                    <div id="all" class="container tab-pane active"><br>
                        <h3 class="text-center">Tất cả đơn hàng</h3>
                        <?php
                            $all_order = $odr->get_all_order($ss->get('userid'));
                            if($all_order){
                                while($result_all = $all_order->fetch_assoc()){

                        ?>
                        <div class="row border-start border-primary border-3 bg-white shadow rounded mb-2 px-3 pt-1 pb-2">
                            <div class="border-bottom border-2 p-0 mb-2 row g-0 py-2">
                                <div class="col-md-8">
                                    <span>
                                        Đơn hàng: <?php echo $result_all['orderID'] ?>
                                        <span class="fw-bold text-primary"> | </span>
                                        <?php
                                        $time = strtotime($result_all['orderDate']);
                                        echo date('H:i, d-m-Y', $time);
                                        ?>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end badge rounded-pill <?php echo $odr->status_bg($result_all['orderStatus']) ?>"><?php echo $odr->status_convert($result_all['orderStatus']) ?>
                                    </span>
                                </div>
                            </div>
                            <?php
                                $get_order_detail = $odr->get_order_detail_by_id($result_all['orderID']);
                                if($get_order_detail){
                                    while($result_order_details = $get_order_detail->fetch_assoc()){
                                        $product_info = $prod->get_details($result_order_details['productID']);
                                        if($product_info)
                                            $result_prod = $product_info->fetch_assoc();
                            ?>
                                <div class="row g-0 shadow-sm rounded border-start border-end border-2 border-info my-2">
                                <div class="col-md-2 col-4 d-flex justify-content-center">
                                    <img src="images/product_img/<?php echo $result_prod["image_1"] ?>" alt="..." style="width: 8em;height: 7em;"/>
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
                                        if($result_all['customerNote'] != "")
                                        echo "<span>
                                                Ghi chú: ".$result_all['customerNote']."
                                            </span>"
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end">
                                        Tổng tiền: 
                                        <span class="text-danger fw-bold"><?php echo $fm->format_currency($result_all['orderPrice']) ?><span class="text-decoration-underline">đ</span></span>
                                    </span><br>
                                    <a href="./order_details.php?orderID=<?php echo $result_all['orderID'] ?>" class="btn btn-outline-success float-end mt-2 mx-1">Xem chi tiết</a>
                                    <a href="./cancel_order.php?orderID=<?php echo $result_all['orderID'] ?>" class="btn btn-outline-danger float-end mt-2 mx-1 <?php if($result_all['orderStatus']>=2) echo "d-none" ?>">Hủy đơn hàng</a>

                                </div>
                            </div>
                        </div>
                        <?php
                                }
                            }else{
                                echo "<div class='text-center'>";
                                echo "<span class='text-secondary fw-bold'>Chưa có đơn hàng</span>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                    <!-- End All Order -->
                    <!-- Start Pending Order -->
                    <div id="pending" class="container tab-pane fade"><br>
                        <h3 class="text-center">Đơn hàng chờ xác nhận</h3>
                        <?php
                            $pending_order = $odr->get_order_by_status($ss->get('userid'), 0);
                            if($pending_order){
                                while($result_pending = $pending_order->fetch_assoc()){
                        ?>
                        <div class="row border-start border-primary border-3 bg-white shadow rounded mb-2 px-3 pt-1 pb-2">
                            <div class="border-bottom border-2 p-0 mb-2 row g-0 py-2">
                                <div class="col-md-8">
                                    <span>
                                        Đơn hàng: <?php echo $result_pending['orderID'] ?>
                                        <span class="fw-bold text-primary"> | </span>
                                        <?php
                                        $time = strtotime($result_pending['orderDate']);
                                        echo date('H:i, d-m-Y', $time);
                                        ?>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end badge rounded-pill <?php echo $odr->status_bg($result_pending['orderStatus']) ?>"><?php echo $odr->status_convert($result_pending['orderStatus']) ?>
                                    </span>
                                </div>
                            </div>
                            
                            <?php
                                $get_order_detail = $odr->get_order_detail_by_id($result_pending['orderID']);
                                if($get_order_detail){
                                    while($result_order_details = $get_order_detail->fetch_assoc()){
                                        $product_info = $prod->get_details($result_order_details['productID']);
                                        if($product_info)
                                            $result_prod = $product_info->fetch_assoc();
                            ?>
                                <div class="row g-0 shadow-sm rounded border-start border-end border-2 border-info my-2">
                                    <div class="col-md-2 col-4 d-flex justify-content-center">
                                        <img src="images/product_img/<?php echo $result_prod["image_1"] ?>" alt="..." style="width: 8em;height: 7em;"/>
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
                            <div class="border-top border-2 p-0 mt-2 row g-0 py-2">
                                <div class="col-md-8">
                                    <?php
                                        if($result_pending['customerNote'] != "")
                                        echo "<span>
                                                Ghi chú: ".$result_pending['customerNote']."
                                            </span>"
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end">
                                        Tổng tiền: 
                                        <span class="text-danger fw-bold"><?php echo $fm->format_currency($result_pending['orderPrice']) ?><span class="text-decoration-underline">đ</span></span>
                                        <br>
                                        <a href="./order_details.php?orderID=<?php echo $result_pending['orderID'] ?>" class="btn btn-outline-success float-end mt-2">Xem chi tiết</a>
                                        <a href="./cancel_order.php?orderID=<?php echo $result_pending['orderID'] ?>" class="btn btn-outline-danger float-end mt-2 mx-1 <?php if($result_pending['orderStatus']>=2) echo "d-none" ?>">Hủy đơn hàng</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php
                                }
                            }else{
                                echo "<div class='text-center'>";
                                echo "<span class='text-secondary fw-bold'>Chưa có đơn hàng chờ xác nhận</span>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                    <!-- End Pending Order -->
                    <!-- Start Preparing Order -->
                    <div id="preparing" class="container tab-pane fade"><br>
                        <h3 class="text-center">Đang chuẩn bị hàng</h3>
                        <?php
                            $preparing_order = $odr->get_order_by_status($ss->get('userid'),1);
                            if($preparing_order){
                                while($result_preparing = $preparing_order->fetch_assoc()){
                        ?>
                        <div class="row border-start border-primary border-3 bg-white shadow rounded mb-2 px-3 pt-1 pb-2">
                            <div class="border-bottom border-2 p-0 mb-2 row g-0 py-2">
                                <div class="col-md-8">
                                    <span>
                                        Đơn hàng: <?php echo $result_preparing['orderID'] ?>
                                        <span class="fw-bold text-primary"> | </span>
                                        <?php
                                        $time = strtotime($result_preparing['orderDate']);
                                        echo date('H:i, d-m-Y', $time);
                                        ?>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end badge rounded-pill <?php echo $odr->status_bg($result_preparing['orderStatus']) ?>"><?php echo $odr->status_convert($result_preparing['orderStatus']) ?>
                                    </span>
                                </div>
                            </div>
                            <?php
                                $get_order_detail = $odr->get_order_detail_by_id($result_preparing['orderID']);
                                if($get_order_detail){
                                    while($result_order_details = $get_order_detail->fetch_assoc()){
                                        $product_info = $prod->get_details($result_order_details['productID']);
                                        if($product_info)
                                            $result_prod = $product_info->fetch_assoc();
                            ?>
                                <div class="row g-0 shadow-sm rounded border-start border-end border-2 border-info my-2">
                                <div class="col-md-2 col-4 d-flex justify-content-center">
                                    <img src="images/product_img/<?php echo $result_prod["image_1"] ?>" alt="..." style="width: 8em;height: 7em;"/>
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
                            <div class="border-top border-2 p-0 mt-2 row g-0 py-2">
                                <div class="col-md-8">
                                    <?php
                                        if($result_preparing['customerNote'] != "")
                                        echo "<span>
                                                Ghi chú: ".$result_preparing['customerNote']."
                                            </span>"
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end">
                                        Tổng tiền: 
                                        <span class="text-danger fw-bold"><?php echo $fm->format_currency($result_preparing['orderPrice']) ?><span class="text-decoration-underline">đ</span></span>
                                        <br>
                                        <a href="./order_details.php?orderID=<?php echo $result_preparing['orderID'] ?>" class="btn btn-outline-success float-end mt-2">Xem chi tiết</a>
                                        <a href="./cancel_order.php?orderID=<?php echo $result_preparing['orderID'] ?>" class="btn btn-outline-danger float-end mt-2 mx-1 <?php if($result_preparing['orderStatus']>=2) echo "d-none" ?>">Hủy đơn hàng</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php
                                }
                            }else{
                                echo "<div class='text-center'>";
                                echo "<span class='text-secondary fw-bold'>Chưa có đơn hàng đang chuẩn bị</span>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                    <!-- End Preparing Order -->
                    <!-- Start Delivering Order -->
                    <div id="delivering" class="container tab-pane fade"><br>
                        <h3 class="text-center">Đang giao hàng</h3>
                        <?php
                            $delivering_order = $odr->get_order_by_status($ss->get('userid'), 2);
                            if($delivering_order){
                                while($result_delivering = $delivering_order->fetch_assoc()){
                        ?>
                        <div class="row border-start border-primary border-3 bg-white shadow rounded mb-2 px-3 pt-1 pb-2">
                            <div class="border-bottom border-2 p-0 mb-2 row g-0 py-2">
                                <div class="col-md-8">
                                    <span>
                                        Đơn hàng: <?php echo $result_delivering['orderID'] ?>
                                        <span class="fw-bold text-primary"> | </span>
                                        <?php
                                        $time = strtotime($result_delivering['orderDate']);
                                        echo date('H:i, d-m-Y', $time);
                                        ?>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end badge rounded-pill <?php echo $odr->status_bg($result_delivering['orderStatus']) ?>"><?php echo $odr->status_convert($result_delivering['orderStatus']) ?>
                                    </span>
                                </div>
                            </div>
                            <?php
                                $get_order_detail = $odr->get_order_detail_by_id($result_delivering['orderID']);
                                if($get_order_detail){
                                    while($result_order_details = $get_order_detail->fetch_assoc()){
                                        $product_info = $prod->get_details($result_order_details['productID']);
                                        if($product_info)
                                            $result_prod = $product_info->fetch_assoc();
                            ?>
                                <div class="row g-0 shadow-sm rounded border-start border-end border-2 border-info my-2">
                                <div class="col-md-2 col-4 d-flex justify-content-center">
                                    <img src="images/product_img/<?php echo $result_prod["image_1"] ?>" alt="..." style="width: 8em;height: 7em;"/>
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
                            <div class="border-top border-2 p-0 mt-2 row g-0 py-2">
                                <div class="col-md-8">
                                    <?php
                                        if($result_delivering['customerNote'] != "")
                                        echo "<span>
                                                Ghi chú: ".$result_delivering['customerNote']."
                                            </span>"
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end">
                                        Tổng tiền: 
                                        <span class="text-danger fw-bold"><?php echo $fm->format_currency($result_delivering['orderPrice']) ?><span class="text-decoration-underline">đ</span></span>
                                        <br>
                                        <a href="./order_details.php?orderID=<?php echo $result_delivering['orderID'] ?>" class="btn btn-outline-success float-end mt-2">Xem chi tiết</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php
                                }
                            }else{
                                echo "<div class='text-center'>";
                                echo "<span class='text-secondary fw-bold'>Chưa có đơn hàng đang giao</span>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                    <!-- End Delivering Order -->
                    <!-- Start Delivered Order -->
                    <div id="delivered" class="container tab-pane fade"><br>
                        <h3 class="text-center">Đã nhận hàng và thanh toán</h3>
                        <?php
                            $delivered_order = $odr->get_order_by_status($ss->get('userid'), 3);
                            if($delivered_order){
                                while($result_delivered = $delivered_order->fetch_assoc()){
                        ?>
                        <div class="row border-start border-primary border-3 bg-white shadow rounded mb-2 px-3 pt-1 pb-2">
                            <div class="border-bottom border-2 p-0 mb-2 row g-0 py-2">
                                <div class="col-md-8">
                                    <span>
                                        Đơn hàng: <?php echo $result_delivered['orderID'] ?>
                                        <span class="fw-bold text-primary"> | </span>
                                        <?php
                                        $time = strtotime($result_delivered['orderDate']);
                                        echo date('H:i, d-m-Y', $time);
                                        ?>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end badge rounded-pill <?php echo $odr->status_bg($result_delivered['orderStatus']) ?>"><?php echo $odr->status_convert($result_delivered['orderStatus']) ?>
                                    </span>
                                </div>
                            </div>
                            <?php
                                $get_order_detail = $odr->get_order_detail_by_id($result_delivered['orderID']);
                                if($get_order_detail){
                                    while($result_order_details = $get_order_detail->fetch_assoc()){
                                        $product_info = $prod->get_details($result_order_details['productID']);
                                        if($product_info)
                                            $result_prod = $product_info->fetch_assoc();
                            ?>
                                <div class="row g-0 shadow-sm rounded border-start border-end border-2 border-info my-2">
                                <div class="col-md-2 col-4 d-flex justify-content-center">
                                    <img src="images/product_img/<?php echo $result_prod["image_1"] ?>" alt="..." style="width: 8em;height: 7em;"/>
                                </div>
                                    <div class="col-md-10 col-8 row py-md-0 py-3 g-0">
                                        <div class="col-md-4 d-flex align-items-center">
                                        <a class="a-card" href="details.php?productID=<?php echo $result_prod["productID"] ?>"><?php echo $fm->textShorten($result_prod["productName"], 40) ?></a>
                                        </div>
                                        <div class="col-md-3 d-flex align-items-center">
                                            <span class="text-secondary">Đơn giá: &nbsp;</span>
                                            <span class="fw-bold">
                                                <?php echo $fm->format_currency($result_prod["current_price"]) ?>
                                            </span>
                                            <span class="fw-bold" style="text-decoration: underline;">đ</span>
                                            <span class="fw-bold">&nbsp;&nbsp;x<?php echo $result_order_details["quantity"] ?></span>
                                        </div>
                                        
                                        
                                        <div class="col-md-3 d-flex align-items-center">
                                        <span class="text-secondary">Thành tiền: &nbsp;</span>
                                        <span class=" text-danger fw-bold">
                                            <?php echo $fm->format_currency($result_order_details["totalPrice"]) ?>
                                        </span>
                                        <span class="text-danger fw-bold" style="text-decoration: underline;">đ</span>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-center fw-bold text-uppercase">
                                            <span class="text-danger fw-bold mt-md-0 mt-3 <?php if($prod->check_user_rating($ss->get('userid'), $result_prod['productID']) == true ){ echo 'd-none';} ?>">Đã đánh giá</span>
                                            <a href="details.php?productID=<?php echo $result_prod['productID'] ?>" class="text-warning text-decoration-none mt-md-0 mt-3 <?php if($prod->check_user_rating($ss->get('userid'), $result_prod['productID']) != true ){ echo 'd-none';} ?>"><i class='fas fa-star'></i> Đánh giá</a>
                                        </div>
                                        
                                    </div>
                                </div>
                            <?php
                                    }
                                }
                            ?>
                            <div class="border-top border-2 p-0 mt-2 row g-0 py-2">
                                <div class="col-md-8">
                                    <?php
                                        if($result_delivered['customerNote'] != "")
                                        echo "<span>
                                                Ghi chú: ".$result_delivered['customerNote']."
                                            </span>"
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end">
                                        Tổng tiền: 
                                        <span class="text-danger fw-bold"><?php echo $fm->format_currency($result_delivered['orderPrice']) ?><span class="text-decoration-underline">đ</span></span>
                                        <br>
                                        <a href="./order_details.php?orderID=<?php echo $result_delivered['orderID'] ?>" class="btn btn-outline-success float-end mt-2">Xem chi tiết</a>
                                        <!-- <a href="./re_order.php?orderID=<?php //echo $result_delivered['orderID'] ?>" class="btn btn-outline-primary float-end mt-2 mx-1 <?php //if($result_delivered['orderStatus']<=2) echo "d-none" ?>">Mua lại</a> -->
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php
                                }
                            }else{
                                echo "<div class='text-center'>";
                                echo "<span class='text-secondary fw-bold'>Chưa có đơn hàng đã giao</span>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                    <!-- End Delivered Order -->
                    
                    <!-- Start Cancelled Order -->
                    <div id="cancelled" class="container tab-pane fade"><br>
                        <h3 class="text-center">Đơn hàng đã hủy</h3>
                        <?php
                            $cancelled_order = $odr->get_order_by_status($ss->get('userid'), 4);
                            if($cancelled_order){
                                while($result_cancelled = $cancelled_order->fetch_assoc()){
                        ?>
                        <div class="row border-start border-primary border-3 bg-white shadow rounded mb-2 px-3 pt-1 pb-2">
                            <div class="border-bottom border-2 p-0 mb-2 row g-0 py-2">
                                <div class="col-md-8">
                                    <span>
                                        Đơn hàng: <?php echo $result_cancelled['orderID'] ?>
                                        <span class="fw-bold text-primary"> | </span>
                                        <?php
                                        $time = strtotime($result_cancelled['orderDate']);
                                        echo date('H:i, d-m-Y', $time);
                                        ?>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end badge rounded-pill <?php echo $odr->status_bg($result_cancelled['orderStatus']) ?>"><?php echo $odr->status_convert($result_cancelled['orderStatus']) ?>
                                    </span>
                                </div>
                            </div>
                            <?php
                                $get_order_detail = $odr->get_order_detail_by_id($result_cancelled['orderID']);
                                if($get_order_detail){
                                    while($result_order_details = $get_order_detail->fetch_assoc()){
                                        $product_info = $prod->get_details($result_order_details['productID']);
                                        if($product_info)
                                            $result_prod = $product_info->fetch_assoc();
                            ?>
                                <div class="row g-0 shadow-sm rounded border-start border-end border-2 border-info my-2">
                                <div class="col-md-2 col-4 d-flex justify-content-center">
                                    <img src="images/product_img/<?php echo $result_prod["image_1"] ?>" alt="..." style="width: 8em;height: 7em;"/>
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
                            <div class="border-top border-2 p-0 mt-2 row g-0 py-2">
                                <div class="col-md-8">
                                    <?php
                                        if($result_cancelled['customerNote'] != "")
                                        echo "<span>
                                                Ghi chú: ".$result_cancelled['customerNote']."
                                            </span>"
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-md-end">
                                        Tổng tiền: 
                                        <span class="text-danger fw-bold"><?php echo $fm->format_currency($result_cancelled['orderPrice']) ?><span class="text-decoration-underline">đ</span></span>
                                        <br>
                                        <a href="./order_details.php?orderID=<?php echo $result_cancelled['orderID'] ?>" class="btn btn-outline-success float-end mt-2">Xem chi tiết</a>
                                        <a href="./re_order.php?orderID=<?php echo $result_cancelled['orderID'] ?>" class="btn btn-outline-primary float-end mt-2 mx-1 <?php if($result_cancelled['orderStatus']<=3) echo "d-none" ?>">Mua lại</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php
                                }
                            }else{
                                echo "<div class='text-center'>";
                                echo "<span class='text-secondary fw-bold'>Chưa có đơn hàng đã hủy</span>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                    <!-- End Cancelled Order -->
                </div>
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