<?php
$page_title = "Sản phẩm yêu thích";
include "./includes/header.php";
?>
<?php
$login_check = $ss->get("userlogin");
if ($login_check == false) {
    echo "<script>location.href = './login/login-user.php';</script>";
}

?>
    
<!-- Start WL -->
    <span id="wishlist_content"></span>
<!-- End WL -->




<!-- Modal -->
<!-- The Modal Add Cart Success -->
<div class="modal fade" id="addCartSuccess">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Thông báo</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
    <!-- Modal body -->
      <div class="modal-body" style="font-size: larger;">
            Thêm sản phẩm vào giỏ hàng thành công!
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
      </div>

    </div>
  </div>
</div>


<?php
include "./includes/footer.php";
?>