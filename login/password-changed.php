<?php
$title = "Đổi mật khẩu";
include "./header_login.php";
?>
<?php
if ($_SESSION['info'] == false) {
    header('Location: login-user.php');
}
?>

<div class="row mt-2 mx-2">
    <div class="col-md-4 offset-md-4 form login-form">
        <?php
        if (isset($_SESSION['info'])) {
        ?>
            <div class="alert alert-success text-center">
                <?php echo $_SESSION['info']; ?>
            </div>
        <?php
        }
        ?>
        <form action="login-user.php" method="POST">
            <div class="form-group">
                <button type="submit" name="login-now" class="form-control button btn-spinner">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Đăng nhập ngay
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