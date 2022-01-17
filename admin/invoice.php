<?php
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
<!DOCTYPE html>
<html lang="en">

<head>
    <title>In hóa đơn</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="p-5">
    <?php
    $get_order = $odr->get_order_by_id($orderID);
    if ($get_order)
        $result_order = $get_order->fetch_assoc();
    ?>
    <div class="container mt-3">
        <h2 class="text-center">Unicorn Store</h2>
        <?php
        $get_cus = $usr->get_users_by_id($result_order['customerID']);
        if ($get_cus)
            $result_cus = $get_cus->fetch_assoc();
        ?>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td><span class="fw-bold">Mã đơn hàng: <?php echo $result_order['orderID'] ?></span></td>
                    <td><span class="fw-bold">Ngày đặt hàng: <?php echo date('g:i A\, d-m-Y', strtotime($result_order['orderDate'])); ?></span></td>
                </tr>
                <tr>
                    <td>Từ:<br> <b>Unicorn Store</b> <br>40 Đoàn Trần Nghiệp, Nha Trang, Khánh Hòa</td>
                    <td>
                        Đến:<br> 
                        <?php 
                        echo '<b>'. $result_cus['customerName'] .'</b><br>';
                        echo $result_order['deliveryAddress']. '<br>';
                        echo 'SĐT: <b>'. $result_order['customerPhone']. '</b><br>';
                        ?>
                      
                
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div>
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
                        <div class="row py-md-0 py-3 m-3">
                            <div class="col-md-3 d-flex align-items-center">
                                <?php echo $fmt->textShorten($result_prod["productName"], 100) ?>
                            </div>
                            <div class="col-md-3 d-flex align-items-center">
                                <span class="text-secondary">Đơn giá: &nbsp;</span>
                                <span class="fw-bold">
                                    <?php echo $fmt->format_currency($result_prod["current_price"]) ?>
                                </span>
                                <span class="fw-bold" style="text-decoration: underline;">đ</span>
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <span class="text-secondary">Số lượng: &nbsp;</span>
                                <span class="fw-bold"><?php echo $result_order_details["quantity"] ?></span>
                            </div>

                            <div class="col-md-4 d-flex align-items-center">
                                <span class="text-secondary">Thành tiền: &nbsp;</span>
                                <span class="fw-bold">
                                    <?php echo $fmt->format_currency($result_order_details["totalPrice"]) ?>
                                </span>
                                <span class=" fw-bold" style="text-decoration: underline;">đ</span>
                            </div>

                        </div>
            <?php
                }
            }
            ?>
        </div>
                    </td>
                    
                </tr>
                <tr>
                    <td>
                        <h6>Tiền thu người nhận:</h6>
                        <h3 class="fw-bold">
                            <?php
                            echo $fmt->format_currency($result_order['orderPrice']);
                            ?>
                            <span style="text-decoration: underline;">VNĐ</span>
                        </h3>
                    </td>
                    <td class="text-center">
                        <h5>Chữ ký người nhận</h5>
                        <p>Xác nhận hàng còn nguyên vẹn, không móp méo/bể/vỡ</p>
                        <div class="p-5"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>


