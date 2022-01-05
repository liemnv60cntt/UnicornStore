<?php
include "./includes/sidebar_topbar.php";
include '../classes/product.php';
include '../classes/user.php';
include '../classes/order.php';
include_once '../helpers/format.php'
?>
<?php
$fmt = new Format();
$prod = new Product();
$usr = new User();
$odr = new Order();
$orderID = (isset($_GET['orderID']) && $_GET['orderID'] != null) ? $_GET['orderID'] : '';
if ($orderID == '')
    echo "<script>window.location ='404.php'</script>";
?>
<h1 class="h3 mb-4 text-gray-800">Cập nhật đơn hàng</h1>

<!-- Order Details-->
<?php
$get_order = $odr->get_order_by_id($orderID);
if ($get_order)
    $result_order = $get_order->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateBtn'])) {
    $orderStatus = $_POST['orderStatus'];
    $adminNote = $_POST['adminNote'];
    $updateOrder = $odr->updateOrder($orderID, $orderStatus, $adminNote);
}
?>
<div class="card shadow mb-4">
    <div class="card-header py-3 row no-gutters">
        <div class="col-md-8">
            <span class="font-weight-bold text-primary">Đơn hàng: <?php echo $result_order['orderID'] ?></span>
            <span class="font-weight-bold text-info"> | </span>
            <span class="font-weight-bold text-secondary float-md-none float-left">Ngày đặt hàng:
                <?php
                $time = strtotime($result_order['orderDate']);
                echo date('g:i A\, d-m-Y', $time);
                ?></span>
        </div>
        <div class="col-md-4">
            <span class="float-md-right badge text-white p-2 
                <?php
                if (isset($_POST['orderStatus']))
                    echo $odr->status_bg($_POST['orderStatus']);
                else
                    echo $odr->status_bg($result_order['orderStatus']);
                ?>">
                <?php
                if (isset($_POST['orderStatus']))
                    echo $odr->status_convert($_POST['orderStatus']);
                else
                    echo $odr->status_convert($result_order['orderStatus']);
                ?></span>
        </div>
    </div>
    <div class="card-body pt-2">
        <a href="./order_list.php" class="btn btn-outline-secondary mb-2">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
        <h5>Cập nhật đơn hàng:</h5>
        <?php
        if (isset($updateOrder))
            echo $updateOrder;
        ?>
        <div class="card border-bottom-warning p-2 mb-2">
            <form action="" method="POST">
                <h6>Trạng thái đơn hàng:</h6>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="orderStatus" id="inlineRadio1" value="0" style="cursor: pointer;" <?php
                                                                                                                                                if (isset($_POST['orderStatus']) && $_POST['orderStatus'] == 0)
                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                else {
                                                                                                                                                    if ($result_order['orderStatus'] == 0)
                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                }
                                                                                                                                                ?>>
                        <label class="form-check-label" for="inlineRadio1">Chờ xác nhận</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="orderStatus" id="inlineRadio2" value="1" style="cursor: pointer;" <?php
                                                                                                                                                if (isset($_POST['orderStatus']) && $_POST['orderStatus'] == 1)
                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                else {
                                                                                                                                                    if ($result_order['orderStatus'] == 1)
                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                }
                                                                                                                                                ?>>
                        <label class="form-check-label" for="inlineRadio2">Đang chuẩn bị hàng</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="orderStatus" id="inlineRadio3" value="2" style="cursor: pointer;" <?php
                                                                                                                                                if (isset($_POST['orderStatus']) && $_POST['orderStatus'] == 2)
                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                else {
                                                                                                                                                    if ($result_order['orderStatus'] == 2)
                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                }
                                                                                                                                                ?>>
                        <label class="form-check-label" for="inlineRadio3">Đang giao hàng</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="orderStatus" id="inlineRadio4" value="3" style="cursor: pointer;" <?php
                                                                                                                                                if (isset($_POST['orderStatus']) && $_POST['orderStatus'] == 3)
                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                else {
                                                                                                                                                    if ($result_order['orderStatus'] == 3)
                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                }
                                                                                                                                                ?>>
                        <label class="form-check-label" for="inlineRadio4">Đã giao hàng và thanh toán</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="orderStatus" id="inlineRadio5" value="4" style="cursor: pointer;" <?php
                                                                                                                                                if (isset($_POST['orderStatus']) && $_POST['orderStatus'] == 4)
                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                else {
                                                                                                                                                    if ($result_order['orderStatus'] == 4)
                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                }
                                                                                                                                                ?>>
                        <label class="form-check-label" for="inlineRadio5">Đã hủy</label>
                    </div>
                </div>
                <h6>Ghi chú:</h6>
                <div class="row no-gutters">
                    <div class="col-lg-8">
                        <input type="text" name="adminNote" class="form-control" placeholder="Nhập ghi chú gửi đến khách hàng" value=" <?php
                                                                                                                                        if (isset($_POST['adminNote']))
                                                                                                                                            echo $_POST['adminNote'];
                                                                                                                                        else {
                                                                                                                                            echo $result_order['adminNote'];
                                                                                                                                        }
                                                                                                                                        ?>">
                    </div>
                    <div class="col-lg-4">

                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-icon-split mx-2" type="submit" name="updateBtn">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Cập nhật</span>
                    </button>
                </div>
            </form>

        </div>
        <h6 class="text-center">Lần cập nhật gần nhất:
            <?php
            $up_time = strtotime($result_order['updateTime']);
            echo date('g:i A\, d-m-Y', $up_time);
            ?>
        </h6>
        <h5>Thông tin khách hàng:</h5>
        <div class="card border-left-primary p-3">
            <?php
            $get_cus = $usr->get_users_by_id($result_order['customerID']);
            if ($get_cus)
                $result_cus = $get_cus->fetch_assoc();
            ?>
            <span>Khách hàng: <b><?php echo $result_cus['customerName'] ?></b>
            </span>
            <span>Email:
                <b> <?php
                    echo $result_cus['email']
                    ?>
                </b>
            </span>
            <div>
                <span>Số điện thoại:</span>
                <b><?php echo $result_cus['phone'] ?></b>
            </div>
            <div>
                <span>Địa chỉ nhận hàng:</span>
                <b><?php echo $result_cus['address'] . ', ' . $result_cus['city_province'] ?></b>
            </div>
        </div>
        <div class="mt-3">
            <h5>Sản phẩm đã đặt:</h5>
            <?php
            $subPrice = 0;
            $get_order_detail = $odr->get_order_detail_by_id($result_order['orderID']);
            if ($get_order_detail) {
                while ($result_order_details = $get_order_detail->fetch_assoc()) {
                    $subPrice += $result_order_details['totalPrice'];
                    $product_info = $prod->get_details($result_order_details['productID']);
                    if ($product_info)
                        $result_prod = $product_info->fetch_assoc();
            ?>
                    <div class="row no-gutters shadow-sm rounded my-2 mx-2 px-2">
                        <div class="col-md-2 col-5 d-flex justify-content-center">
                            <img src="../images/product_img/<?php echo $result_prod["image_1"] ?>" alt="..." style="width: 8em;height: 7em;" />
                        </div>
                        <div class="col-md-10 col-7 row py-md-0 py-3">
                            <div class="col-md-3 d-flex align-items-center">
                                <a class="text-dark" href="product_detail.php?productID=<?php echo $result_prod["productID"] ?>"><?php echo $fmt->textShorten($result_prod["productName"], 40) ?></a>
                            </div>
                            <div class="col-md-3 d-flex align-items-center">
                                <span class="text-secondary">Đơn giá: &nbsp;</span>
                                <span class="font-weight-bold">
                                    <?php echo $fmt->format_currency($result_prod["current_price"]) ?>
                                </span>
                                <span class="font-weight-bold" style="text-decoration: underline;">đ</span>
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <span class="text-secondary">Số lượng: &nbsp;</span>
                                <span class="font-weight-bold"><?php echo $result_order_details["quantity"] ?></span>
                            </div>

                            <div class="col-md-4 d-flex align-items-center">
                                <span class="text-secondary">Thành tiền: &nbsp;</span>
                                <span class=" text-danger font-weight-bold">
                                    <?php echo $fmt->format_currency($result_order_details["totalPrice"]) ?>
                                </span>
                                <span class="text-danger font-weight-bold" style="text-decoration: underline;">đ</span>
                            </div>

                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>

        <div class="row no-gutters">
            <div class="col-md-8">
                <span class="mb-3"><b>Ghi chú từ khách hàng:</b> <?php echo $result_order['customerNote'] ?></span>
            </div>
            <div class="col-md-4">
                <table class="float-right mr-3" style="font-size: large;">
                    <tr>
                        <td>Thành tiền:</td>
                        <td class="font-weight-bold">
                            <?php
                            echo $fmt->format_currency($subPrice);
                            ?>
                            <span style="text-decoration: underline;">đ</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Phí giao hàng:&nbsp;</td>
                        <td class="font-weight-bold">
                            <?php
                            echo $fmt->format_currency($odr->get_shipping_fee($subPrice));
                            ?>
                            <span style="text-decoration: underline;">đ</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Tổng tiền:</td>
                        <td class="font-weight-bold text-danger">
                            <?php
                            echo $fmt->format_currency($result_order['orderPrice']);
                            ?>
                            <span style="text-decoration: underline;">đ</span>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>







<?php
include "./includes/footer.php";
?>