<?php
$page_title = "Đặt hàng";
include "./includes/header.php";
?>
<?php
$login_check = $ss->get("userlogin");
if ($login_check == false) {
    echo "<script>location.href = './login/login-user.php';</script>";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_profile'])) {
    $updateUser = $us->update_user_profile($_POST, $ss->get('userid'));
}
?>


<!-- <div class="container"> -->
<div class="mb-2">
    <i class='fas fa-home text-primary'></i>
    <a href="index.php" class="text-decoration-none text-primary">Trang chủ</a>
    <i class='fas fa-chevron-right text-secondary' style="font-size: 12px;"></i>
    <a href="./cart_page.php" class="text-decoration-none"><span class="text-dark">Giỏ hàng</span></a>
    <i class='fas fa-chevron-right text-secondary' style="font-size: 12px;"></i>
    <span class="text-dark">Đặt hàng</span>
</div>
<div class="row px-sm-0 px-3">
    <div class="col-md-8 mb-3 px-md-2 px-0 py-sm-0">
        <div class="px-3 py-4 pb-5 rounded bg-white shadow">
            <div class="text-end px-1">
                <a href="./cart_page.php" style="font-weight: 500;" class="text-decoration-none text-primary">Chỉnh sửa</a>
            </div>
            <span id="cart_for_payment"></span>
        </div>
    </div>

    <div class="col-md-4 mb-3 p-1 rounded bg-white shadow">
        <div class="p-3">
            <div class="text-center d-flex flex-column align-items-center">
                <img class="shadow-sm" style="border-radius: 50%;" width="100px" height="100px" src="./images//more/img_avatar.png">
                <?php
                $get_user = $us->get_users_by_id($ss->get("userid"));
                if ($get_user) {
                    $result_user = $get_user->fetch_assoc();

                ?>
                    <span class="font-weight-bold"><?php echo $result_user['customerName'] ?></span><span class="text-black-50"><?php echo $ss->get('email') ?></span><span> </span>
                <?php
                }
                ?>
            </div>
            <h4 class="text-center mt-2">Xác nhận thông tin:</h4>
            <form action="" method="POST">

                <?php
                if (isset($updateUser) && $updateUser['success'] != "") {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo $updateUser['success'];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }
                if (isset($updateUser) && $updateUser['error'] != "") {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo $updateUser['error'];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }
                ?>
                <div class="row mt-1">
                    <input name="customerName" type="hidden" class="form-control" placeholder="Nhập họ tên" value="<?php echo $result_user['customerName'] ?>">
                    <div class="col-md-12">
                        <label class="labels">Số điện thoại:</label>
                        <input name="phone" type="text" class="form-control" placeholder="Nhập SĐT" value="<?php echo $result_user['phone'] ?>">
                        <?php
                        if (isset($updateUser)) {
                            echo "<span class='text-danger fw-light fst-italic'>";
                            echo $updateUser['phone'];
                            echo "<span>";
                        }
                        ?>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Tỉnh / Thành phố:</label>
                        <input name="city_province" type="text" class="form-control" placeholder="Nhập tỉnh/thành phố" value="<?php echo $result_user['city_province'] ?>">
                        <?php
                        if (isset($updateUser)) {
                            echo "<span class='text-danger fw-light fst-italic'>";
                            echo $updateUser['city_province'];
                            echo "<span>";
                        }
                        ?>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Địa chỉ nhận hàng:</label>
                        <input name="address" type="text" class="form-control" placeholder="Nhập địa chỉ nhận hàng" value="<?php echo $result_user['address'] ?>">
                        <?php
                        if (isset($updateUser)) {
                            echo "<span class='text-danger fw-light fst-italic'>";
                            echo $updateUser['address'];
                            echo "<span>";
                        }
                        ?>
                    </div>


                </div>
                <div class="mt-4 text-center">
                    <button name="save_profile" class="btn btn-primary text-white fw-bold shadow" type="submit">Cập nhật</button><br>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- </div> -->









<?php
include "./includes/footer.php";
?>