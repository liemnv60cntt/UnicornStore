<?php
include "./includes/sidebar_topbar.php";
include '../classes/user.php';
?>
<?php
    $usr = new User();
    
?>
<h1 class="h3 mb-4 text-gray-800">Khách hàng</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách các khách hàng</h6>
    </div>
    <div class="card-body">
       
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Tỉnh/Thành phố</th>
                        <th>Quận/Huyện</th>
                        <th>Địa chỉ</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên khách hàng</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Tỉnh/Thành phố</th>
                        <th>Quận/Huyện</th>
                        <th>Địa chỉ</th>
                        <th>Trạng thái</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        $show_cus = $usr->get_all_users();
                        if($show_cus){
                            $i = 0;
                            while($result = $show_cus->fetch_assoc()){
                                $i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['customerName'] ?></td>
                        <td><?php echo $result['email'] ?></td>
                        <td><?php echo $result['phone'] ?></td>
                        <td><?php echo $result['city_province'] ?></td>
                        <td><?php echo $result['district'] ?></td>
                        <td><?php echo $result['address'] ?></td>
                        <td><?php echo $result['status'] ?></td>
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