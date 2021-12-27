<?php
$title = "Đăng xuất";
include "./header_login.php";
?>
<?php
session_start();
session_unset();
session_destroy();
header('location: ../index.php');
?>
<?php
include "./footer_login.php";
?>