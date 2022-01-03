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
    
    
?>
<h1 class="h3 mb-4 text-gray-800">Đơn đặt hàng</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn đặt hàng</h6>
    </div>
    <div class="card-body">
        
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="text-center">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Tên khách hàng</th>
                        <th>SĐT</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Cập nhật</th>
                    </tr>
                </thead>
                <tfoot class="text-center">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Tên khách hàng</th>
                        <th>SĐT</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Cập nhật</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        $show_order = $odr->show_all_order();
                        if($show_order){
                            $i = 0;
                            while($result = $show_order->fetch_assoc()){
                                $i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['orderID'] ?></td>
                        <td><?php
                            $get_cus = $usr->get_users_by_id($result['customerID']);
                            if($get_cus)
                                $result_cus = $get_cus->fetch_assoc();
                            echo $result_cus['customerName'];
                         ?></td>
                         <td>
                            <?php
                            echo $result_cus['phone'];
                            ?>
                         </td>
                        <td><?php
                            $time = strtotime($result['orderDate']);
                            echo date('g:i A\, d-m-Y', $time);
                         ?></td>
                        <td class="text-danger"><?php echo $fmt->format_currency($result['orderPrice']) ?>
                                <span style="text-decoration: underline;">đ</span>
                        </td>
                        <td>
                            <span class="badge text-white p-2 <?php echo $odr->status_bg($result['orderStatus']) ?>">
                                <?php echo $odr->status_convert($result['orderStatus']) ?>
                            </span>
                        </td>
                          
                        <td>
                            <div class="d-flex justify-content-center">
                               
                                <a href="order_update.php?orderID=<?php echo $result['orderID'] ?>">
                                    <button class="btn btn-warning p-1 mr-2 shadow" style="color: black;" title="Cập nhật">
                                        <i class='far fa-edit'></i> Cập nhật
                                    </button>
                                </a>
                                
                            </div>
                        </td>
                    </tr>
                    <?php
					        }
					    }
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>







<?php
include "./includes/footer.php";
?>