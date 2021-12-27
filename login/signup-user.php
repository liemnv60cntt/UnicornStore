<?php
$title = "Đăng ký";
include "./header_login.php";
?>
<div class="row mb-3 mt-2 mx-2">
    <div class="col-md-8 offset-md-2 form">
        <form action="signup-user.php" method="POST" autocomplete="">
            <h2 class="text-center mb-4">Đăng ký tài khoản</h2>
            <?php
            if (count($errors) == 1) {
            ?>
                <div class="alert alert-danger text-center w-75 mx-auto">
                    <?php
                    foreach ($errors as $showerror) {
                        echo $showerror;
                    }
                    ?>
                </div>
            <?php
            } elseif (count($errors) > 1) {
            ?>
                <div class="alert alert-danger">
                    <?php
                    foreach ($errors as $showerror) {
                    ?>
                        <li><?php echo $showerror; ?></li>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-2">
                        <label class="form-label">Họ và tên:</label>
                        <input class="form-control" type="text" name="name" placeholder="Họ tên" required value="<?php echo $name ?>">
                    </div>
                    <div class="mb-2">
                    <label class="form-label">Địa chỉ:</label>
                        <input class="form-control" type="text" name="address" placeholder="Địa chỉ" required value="<?php echo $address ?>">
                    </div>
                    <div class="mb-2">
                    <label class="form-label">Tỉnh / thành phố:</label>
                        <input class="form-control" type="text" name="city" placeholder="Tỉnh / Thành phố" required value="<?php echo $city ?>">
                    </div>
                    <div class="mb-2">
                    <label class="form-label">Số điện thoại:</label>
                        <input class="form-control" type="text" name="phone" placeholder="Số điện thoại" required value="<?php echo $phone ?>">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-2">
                    <label class="form-label">Email đăng nhập:</label>
                        <input class="form-control" type="email" name="email" placeholder="Email" required value="<?php echo $email ?>">
                    </div>
                    <div class="mb-2">
                    <label class="form-label">Mật khẩu:</label>
                        <input class="form-control" type="password" name="password" placeholder="Mật khẩu" required>
                    </div>
                    <div class="mb-2">
                    <label class="form-label">Nhập lại mật khẩu:</label>
                        <input class="form-control" type="password" name="cpassword" placeholder="Xác nhận mật khẩu" required>
                    </div>
                </div>
            </div>


            <div class="mb-2 mt-4 w-75 mx-auto">
                <button type="submit" name="signup" class="form-control button btn-spinner">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Đăng ký
                </button>
            </div>
            <div class="link login-link text-center">Bạn đã có tài khoản? <a href="login-user.php" class="text-decoration-none">Đăng nhập tại đây</a></div>
        </form>
        <div class="mt-3 link login-link text-center">
            <a href="../index.php" class="text-decoration-none"><i class='fas fa-home'></i> Quay về trang chủ</a>
        </div>
    </div>
</div>
<?php
include "./footer_login.php";
?>