<?php
$page_title = "Giỏ hàng";
include "./includes/header.php";
?>
		<div class="container">
			<div>
				<i class='fas fa-home text-primary'></i>
				<a href="index.php" class="text-decoration-none text-primary">Trang chủ</a>
				<i class='fas fa-chevron-right text-secondary' style="font-size: 12px;"></i>
				<span class="text-dark">Giỏ hàng</span>
			</div>
			

			<span id="cart_details"></span>
			<!-- <div>
				<div align="right">
					<a href="#" class="btn btn-danger shadow" id="clear_cart">
					<i class='fas fa-trash-restore'></i> Xóa toàn bộ
					</a>
					<a href="#" class="btn btn-primary shadow" id="check_out_cart">
					<i class='fas fa-credit-card'></i> Thanh toán
					</a>
				</div>
			</div> -->
		</div>
        


<?php
include "./includes/footer.php";
?>