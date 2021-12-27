<?php
$title = "Đăng nhập";
include "./header_login.php";
?>
<div class="row mt-2 mx-2">
    <div class="col-md-4 offset-md-4 form login-form">
        <form action="login-user.php" method="POST" autocomplete="">
            <h2 class="text-center mb-4">Đăng nhập tài khoản</h2>
            <?php
            if (count($errors) > 0) {
            ?>
                <div class="alert alert-danger text-center">
                    <?php
                    foreach ($errors as $showerror) {
                        echo $showerror;
                    }
                    ?>
                </div>
            <?php
            }
            ?>
            <div class="mt-2 mb-2">
                <input class="form-control" type="email" name="email" placeholder="Email" required value="<?php echo $email ?>">
            </div>
            <div class="mb-3">
                <input class="form-control" type="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <div class="link forget-pass text-left ml-1"><a href="forgot-password.php" class="text-decoration-none">Quên mật khẩu?</a></div>
            <div class="mb-2">
                <button type="submit" name="login" class="form-control button btn-spinner">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Đăng nhập
                </button>
            </div>
            <div class="link login-link text-center">Bạn chưa có tài khoản? <a href="signup-user.php" class="text-decoration-none">Đăng ký ngay</a></div>
        </form>
        <div class="mt-3 link login-link text-center">
            <a href="../index.php" class="text-decoration-none"><i class='fas fa-home'></i> Quay về trang chủ</a>
        </div>
    </div>
</div>
<?php
include "./footer_login.php";
?>
