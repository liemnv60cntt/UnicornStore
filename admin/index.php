<?php
include "./includes/sidebar_topbar.php";
include '../classes/order.php';
?>
<?php
$odr = new Order();
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-center mb-4">
    <h1 class="h3 mb-0 text-gray-900">TRANG CHỦ QUẢN LÝ CỬA HÀNG UNICORN</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>
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
<!-- Content Row -->
<div class="card shadow p-5 border-bottom-secondary">
    <div class="row">

        <div class="col-xl-7 mb-4">
            <div class="row">
                <!-- Pending Requests-->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Đơn hàng chờ xác nhận</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $odr->count_all_order_by_status(0);  ?> đơn hàng</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-spinner fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Preparing -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Đơn hàng đang chuẩn bị</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $odr->count_all_order_by_status(1);  ?> đơn hàng</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-box-open fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Delivering -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Đơn hàng đang giao</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $odr->count_all_order_by_status(2);  ?> đơn hàng</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-truck fa-2x text-gray-300"></i>
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
                                        Đơn hàng đã giao</div>
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
                                        Đơn hàng đã hủy</div>
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
        <div class="col-xl-5 mb-4">
            <div class="card shadow border-left-info">
                <!-- Card Header - Dropdown -->
                <div class="card-header p-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Biểu đồ trạng thái đơn hàng</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body px-3 py-2 row">
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


    </div>
</div>




<!-- Content Row -->
<div class="row d-none">

    <!-- Content Column -->
    <div class="col-lg-6 mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
            </div>
            <div class="card-body">
                <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <!-- Color System -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        Primary
                        <div class="text-white-50 small">#4e73df</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        Success
                        <div class="text-white-50 small">#1cc88a</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        Info
                        <div class="text-white-50 small">#36b9cc</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        Warning
                        <div class="text-white-50 small">#f6c23e</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        Danger
                        <div class="text-white-50 small">#e74a3b</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-secondary text-white shadow">
                    <div class="card-body">
                        Secondary
                        <div class="text-white-50 small">#858796</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-light text-black shadow">
                    <div class="card-body">
                        Light
                        <div class="text-black-50 small">#f8f9fc</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        Dark
                        <div class="text-white-50 small">#5a5c69</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-6 mb-4">

        <!-- Illustrations
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_posting_photo.svg" alt="...">
                </div>
                <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                    constantly updated collection of beautiful svg images that you can use
                    completely free and without attribution!</p>
                <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                    unDraw &rarr;</a>
            </div>
        </div> -->

        <!-- Approach
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
            </div>
            <div class="card-body">
                <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                    CSS bloat and poor page performance. Custom CSS classes are used to create
                    custom components and custom utility classes.</p>
                <p class="mb-0">Before working with this theme, you should become familiar with the
                    Bootstrap framework, especially the utility classes.</p>
            </div>
        </div> -->

    </div>
</div>



<?php
include "./includes/footer.php";
?>