<?php
include "./includes/sidebar_topbar.php";
include '../classes/order.php';
include '../classes/user.php';
include_once '../helpers/format.php';
?>
<?php
$odr = new Order();
$fmt = new Format();
$usr = new User();
$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : "";
$lastDate = isset($_POST['lastDate']) ? $_POST['lastDate'] : "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['statisticBtn'])) {
    $orderStatistic = $odr->order_statistic($startDate, $lastDate, 3);
}
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thống kê doanh thu</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>

<!-- Content Row -->
<div class="row">
    <?php
    $pendingNum = $odr->count_all_order_by_status(0);
    $preparingNum = $odr->count_all_order_by_status(1);
    $deliveringNum = $odr->count_all_order_by_status(2);
    $deliveredNum = $odr->count_all_order_by_status(3);
    $cancelledNum = $odr->count_all_order_by_status(4);

    ?>
    <input type="hidden" id="pendingNum" value="<?php echo $pendingNum ?>">
    <input type="hidden" id="preparingNum" value="<?php echo $preparingNum ?>">
    <input type="hidden" id="deliveringNum" value="<?php echo $deliveringNum ?>">
    <input type="hidden" id="deliveredNum" value="<?php echo $deliveredNum ?>">
    <input type="hidden" id="cancelledNum" value="<?php echo $cancelledNum ?>">


    <!-- Earnings (Monthly) Card Example -->
    <!-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="col-xl-5 mb-2">
        <div class="card shadow border-left-info">
            <!-- Card Header - Dropdown -->
            <div class="card-header p-1">
                <h6 class="m-0 font-weight-bold text-primary text-center">Biểu đồ trạng thái đơn hàng</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body px-3 py-1 row">
                <div class="col-md-4 p-0">
                    <div class="border boder-secondary p-1 rounded">
                        <span class="bg-warning px-2"></span>
                        <span>&nbsp;Chờ xác nhận</span><br>
                        <span class="bg-info px-2"></span>
                        <span>&nbsp;Đang chuẩn bị</span><br>
                        <span class="bg-primary px-2"></span>
                        <span>&nbsp;Đang giao</span><br>
                        <span class="bg-success px-2"></span>
                        <span>&nbsp;Đã giao</span><br>
                        <span class="bg-danger px-2"></span>
                        <span>&nbsp;Đã hủy</span><br>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="chart-pie">
                        <canvas id="myPieChart"></canvas>
                    </div>
                </div>

                <!-- <hr>
                Styling for the donut chart can be found in the -->
            </div>
        </div>
    </div>
    <div class="col-xl-7 mb-2">
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Thu nhập (Tháng)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                                    echo $fmt->format_currency($odr->month_revenue());
                                                                                    ?> <span style="text-decoration: underline;">đ</span></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Year) Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Thu nhập (Năm)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                                    echo $fmt->format_currency($odr->year_revenue());
                                                                                    ?> <span style="text-decoration: underline;">đ</span></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Delivered -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Đơn hàng đã giao và thanh toán</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $odr->count_all_order_by_status(3);  ?> đơn hàng</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cancelled -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Đơn hàng bị hủy</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $odr->count_all_order_by_status(4);  ?> đơn hàng</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-trash-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<div class="card px-md-5 px-3 pt-3 pb-5 shadow border-bottom-info">
    <h4>Thống kê doanh thu:</h4>
    <form action="" method="POST">
        <div class="row no-gutters">
            <div class="col-xl-5 pr-5">
                <label for="startDate">Từ ngày:</label>
                <input type="date" name="startDate" id="startDate" class="form-control mb-2" value="<?php if (isset($_POST['startDate'])) echo $_POST['startDate'] ?>" min="2019-01-01" max="2030-12-31">
            </div>
            <div class="col-xl-5 pr-5">
                <label for="lastDate">Đến ngày:</label>
                <input type="date" name="lastDate" id="lastDate" class="form-control mb-2" value="<?php if (isset($_POST['lastDate'])) echo $_POST['lastDate'] ?>" min="2019-01-01" max="2030-12-31">
            </div>
            <div class="col-xl-2">
                <br>
                <button class="btn btn-primary btn-icon-split mt-xl-2" type="submit" name="statisticBtn">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Lấy dữ liệu</span>
                </button>
            </div>
        </div>
    </form>
    <div>
        <?php
        if (isset($orderStatistic) && $orderStatistic != false) {
            $start_cv = strtotime($startDate);
            $start_date = date("d/m/Y", $start_cv);
            $last_cv = strtotime($lastDate);
            $last_date = date("d/m/Y", $last_cv);
            echo "<h5 class='text-center text-success my-3'>Kết quả thống kê từ ngày $start_date đến ngày $last_date</h5>";
            echo "<h5 class='text-center my-3'>Tổng doanh thu: <b class='text-danger'>" . $fmt->format_currency($odr->sum_revenue($startDate, $lastDate, 3)) . " <span style='text-decoration: underline;'>đ</span></b></h5>";
        }

        ?>

        <div class="table-responsive <?php if (!isset($orderStatistic)) echo "d-none"; ?>">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Ngày đặt hàng</th>
                        <th>Ngày thanh toán</th>
                        <th>Tổng tiền</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (isset($orderStatistic) && $orderStatistic != false) {
                        $i = 0;
                        while ($result = $orderStatistic->fetch_assoc()) {
                            $i++;
                    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $result['orderID'] ?></td>
                                <td>
                                    <?php
                                    $get_cus = $usr->get_users_by_id($result['customerID']);
                                    if ($get_cus)
                                        $result_cus = $get_cus->fetch_assoc();
                                    echo $result_cus['customerName'];
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    $time = strtotime($result['orderDate']);
                                    echo date('g:i A\, d-m-Y', $time);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $time = strtotime($result['updateTime']);
                                    echo date('g:i A\, d-m-Y', $time);
                                    ?>
                                </td>
                                <td class="text-danger"><?php echo $fmt->format_currency($result['orderPrice']) ?>
                                    <span style="text-decoration: underline;">đ</span>
                                </td>

                            </tr>
                    <?php
                        }
                    } else {
                        echo "<h6 class='text-center my-3'>Chưa có kết quả thống kê!</h6>";
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