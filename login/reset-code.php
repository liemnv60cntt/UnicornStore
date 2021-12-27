<?php
$title = "Reset Code";
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
        <form action="reset-code.php" method="POST" autocomplete="off">
            <h2 class="text-center">Mã xác thực</h2>
            <?php
            if (isset($_SESSION['info'])) {
            ?>
                <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
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
            <div class="mb-3">
                <input class="form-control" type="number" name="otp" placeholder="Nhập mã xác thực" required>
            </div>
            <div class="mb-2">
                <button type="submit" name="check-reset-otp" class="form-control button btn-spinner">
                    <span class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Xác nhận
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