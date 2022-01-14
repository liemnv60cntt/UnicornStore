<?php
include "./includes/sidebar_topbar.php";
include '../classes/productreview.php';
include_once '../helpers/format.php';
?>
<?php
    $rv = new ProductReview();
    $fm = new Format();
    
?>
<h1 class="h3 mb-4 text-gray-800">Đánh giá sản phẩm</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách các đánh giá từ khách hàng</h6>
    </div>
    <div class="card-body">
       
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Ảnh SP</th>
                        <th>Tên sản phẩm</th>
                        <th>Tên khách hàng</th>
                        <th>Thời gian</th>
                        <th>Số sao</th>
                        <th>Lời đánh giá</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Ảnh SP</th>
                        <th>Tên sản phẩm</th>
                        <th>Tên khách hàng</th>
                        <th>Thời gian</th>
                        <th>Số sao</th>
                        <th>Lời đánh giá</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        $show_rv = $rv->get_all_review();
                        if($show_rv){
                            $i = 0;
                            while($result = $show_rv->fetch_assoc()){
                                $i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td>
                            <img src="../images/product_img/<?php echo $result['image_1'] ?>" alt="..." style="max-width: 80px;max-height: 80px;">
                        </td>
                        <td><?php echo $fm->textShorten($result['productName'], 30)  ?></td>
                        <td><?php echo $result['customerName'] ?></td>
                        <td><?php echo $fm->formatDateReview($result['ratingTime']) ?></td>
                        <td>
                            <i class='fas fa-star <?php if($result['rating']>=1) echo 'text-warning'; ?>'></i>
                            <i class='fas fa-star <?php if($result['rating']>=2) echo 'text-warning'; ?>'></i>
                            <i class='fas fa-star <?php if($result['rating']>=3) echo 'text-warning'; ?>'></i>
                            <i class='fas fa-star <?php if($result['rating']>=4) echo 'text-warning'; ?>'></i>
                            <i class='fas fa-star <?php if($result['rating']==5) echo 'text-warning'; ?>'></i>
                        </td>
                        <td><?php echo $result['review'] ?></td>
                    </tr>
                    <?php
					        }
					    }
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>







<?php
include "./includes/footer.php";
?>