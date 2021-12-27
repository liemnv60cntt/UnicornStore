<?php
$title = "Mật khẩu mới";
include "./header_login.php";
?>
<?php
$email = $_SESSION['email'];
if ($email == false) {
    header('Location: login-user.php');
}
?>
<div class="row mt-2 mx-2">
    <div class="col-md-4 offset-md-4 form">
        <form action="new-password.php" method="POST" autocomplete="off">
            <h2 class="text-center">Mật khẩu mới</h2>
            <?php
            if (isset($_SESSION['info'])) {
            ?>
                <div class="alert alert-success text-center">
                    <?php echo $_SESSION['info']; ?>
                </div>
            <?php
            }
            ?>
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
            <div class="mb-2">
                <input class="form-control" type="password" name="password" placeholder="Tạo mật khẩu mới" required>
            </div>
            <div class="mb-3">
                <input class="form-control" type="password" name="cpassword" placeholder="Nhập lại mật khẩu mới" required>
            </div>
            <div class="mb-2">
                <button type="submit" name="change-password" class="form-control button btn-spinner">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Thay đổi
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