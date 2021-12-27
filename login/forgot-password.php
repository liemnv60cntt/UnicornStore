<?php
$title = "Quên mật khẩu";
include "./header_login.php";
?>
<div class="row mt-2 mx-2">
    <div class="col-md-4 offset-md-4 form">
        <form action="forgot-password.php" method="POST" autocomplete="">
            <h2 class="text-center">Quên mật khẩu</h2>
            <p class="text-center">Nhập địa chỉ email của bạn</p>
            <?php
            if (count($errors) > 0) {
            ?>
                <div class="alert alert-danger text-center">
                    <?php
                    foreach ($errors as $error) {
                        echo $error;
                    }
                    ?>
                </div>
            <?php
            }
            ?>
            <div class="mb-3">
                <input class="form-control" type="email" name="email" placeholder="Email" required value="<?php echo $email ?>">
            </div>
            <div class="mb-2">
                <button type="submit" name="check-email" class="form-control button btn-spinner">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Tiếp tục
                </button>
            </div>
        </form>
        <div class="mt-3 link login-link text-center">
            <a href="../index.php" class="text-decoration-none"><i class='fas fa-home'></i> Quay về trang chủ</a>
        </div>
    </div>
</div>
<?php
include "./footer_login.php";
?>