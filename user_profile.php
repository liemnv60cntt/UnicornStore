<?php
$page_title = "Thông tin tài khoản";
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

<div class="container mb-3">
    <div class="mb-2">
        <i class='fas fa-home text-primary'></i>
        <a href="index.php" class="text-decoration-none text-primary">Trang chủ</a>
        <i class='fas fa-chevron-right text-secondary' style="font-size: 12px;"></i>
        <span class="text-dark">Thông tin tài khoản</span>
    </div>
    <div class="row">
        <div class="col-md-3 rounded bg-white shadow">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="mt-5 shadow-sm" style="border-radius: 50%;" width="150px" height="150px" src="./images//more/img_avatar.png">
                <?php
                $get_user = $us->get_users_by_id($ss->get("userid"));
                if ($get_user) {
                    $result_user = $get_user->fetch_assoc();

                ?>
                    <span class="font-weight-bold"><?php echo $result_user['customerName'] ?></span><span class="text-black-50"><?php echo $ss->get('email') ?></span><span> </span>
            </div>
        </div>
        <div class="col-md-5 px-md-2 px-0 py-md-0 py-2">
            <div class="p-3 py-5 rounded bg-white shadow">
                <form action="" method="POST">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Thông tin tài khoản</h4>
                    </div>
                    <?php
                    if (isset($updateUser) && $updateUser['success']!="") {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                        echo $updateUser['success'];
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                    }
                    if (isset($updateUser) && $updateUser['error']!="") {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo $updateUser['error'];
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                    }
                    ?>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Họ tên:</label>
                            <input name="customerName" type="text" class="form-control" placeholder="Nhập họ tên" value="<?php echo $result_user['customerName'] ?>">
                            <?php
                            if (isset($updateUser)) {
                                echo "<span class='text-danger fw-light fst-italic'>";
                                echo $updateUser['customerName'];
                                echo "<span>";
                            }
                            ?>
                        </div>
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
                            <label class="labels">Email:</label>
                            <input readonly type="text" class="form-control" placeholder="Email" value="<?php echo $result_user['email'] ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Địa chỉ:</label>
                            <input name="address" type="text" class="form-control" placeholder="Nhập địa chỉ" value="<?php echo $result_user['address'] ?>">
                            <?php
                            if (isset($updateUser)) {
                                echo "<span class='text-danger fw-light fst-italic'>";
                                echo $updateUser['address'];
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

                    </div>
                    <div class="mt-5 text-center">
                        <button name="save_profile" class="btn btn-primary text-white fw-bold shadow" type="submit">Cập nhật</button><br>
                    </div>
                </form>

            </div>
        </div>
    <?php
                }
    ?>
    <div class="col-md-4 rounded bg-white shadow">
        <div class="p-3 py-5">
            <div class="d-flex justify-content-between align-items-center"><span>Quản lý đơn hàng:</span><span class="border px-3 p-1 btn-profile rounded shadow-sm"><i class="fas fa-truck"></i>&nbsp;Đơn hàng</span></div><br>
            <div class="d-flex justify-content-between align-items-center"><span>Sản phẩm yêu thích:</span><span class="border px-3 p-1 btn-profile rounded shadow-sm"><i class="fas fa-heart"></i>&nbsp;Yêu thích</span></div><br>
            <div class="d-flex justify-content-between align-items-center"><span>So sánh sản phẩm:</span><span class="border px-3 p-1 btn-profile rounded shadow-sm"><i class="fas fa-compress-alt"></i>&nbsp;So sánh</span></div><br>
            <div class="d-flex justify-content-between align-items-center"><span>Đổi mật khẩu:</span>
            <a href="./login/update-password.php?email=<?php echo $ss->get('email') ?>" class="text-dark text-decoration-none border px-3 p-1 btn-profile rounded shadow-sm"><i class="fas fa-user-lock"></i>&nbsp;Mật khẩu</a></div><br>
            <div class="d-flex justify-content-between align-items-center"><span></span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" class="btn btn-outline-danger text-decoration-none px-3 p-1 btn-logout rounded shadow-sm"><i class="fas fa-sign-out-alt"></i>&nbsp;Đăng xuất</a></div>
        </div>
    </div>
    </div>
</div>









<?php
include "./includes/footer.php";
?>