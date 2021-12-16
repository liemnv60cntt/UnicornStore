<?php
include "./includes/sidebar_topbar.php";
include '../classes/product.php';
include '../classes/category.php';
include_once '../helpers/format.php'
?>
<?php
    $fmt = new Format();
    $prod = new Product();
    $deleteID = (isset($_GET['deleteID']) && $_GET['deleteID']!=null) ? $_GET['deleteID'] : '';
    if($deleteID != '')
        $deleteProd = $prod->delete_product($deleteID);
    
?>
<h1 class="h3 mb-4 text-gray-800">Sản phẩm</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách các sản phẩm</h6>
    </div>
    <div class="card-body">
        <?php
            if (isset($deleteProd)) {
                echo $deleteProd;
            }
        ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th>STT</th>
                        <th>Tên SP</th>
                        <th>Loại SP</th>
                        <th>Thương hiệu</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Ảnh</th>
                        <th style="width: 8em;">Chức năng</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Tên SP</th>
                        <th>Loại SP</th>
                        <th>Thương hiệu</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Ảnh</th>
                        <th>Chức năng</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        $show_prod = $prod->show_product();
                        if($show_prod){
                            $i = 0;
                            while($result = $show_prod->fetch_assoc()){
                                $i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $fmt->textShorten($result['productName'],50) ?></td>
                        <td><?php echo $result['typeName'] ?></td>
                        <td><?php echo $result['brandName'] ?></td>
                        <td><?php 
                            $cate = new Category();
                            $get_cate = $cate->get_cate_byID($result['cateID']);
                            $result_cate = $get_cate->fetch_assoc();
                            echo $result_cate['cateName'] ;
                        ?></td>
                        <td><?php 
                        switch($result['productStatus']){
                            case 0: echo "Sản phẩm mới";
                            break;
                            case 1: echo "Nổi bật";
                            break;
                            case 2: echo "Bán chạy";
                            break;
                            case 3: echo "Đang khuyến mãi";
                            break;
                            case 4: echo "Giảm giá sốc";
                            break;
                            case 5: echo "Hàng sắp về";
                            break;
                        }
                        ?></td>
                        <td><?php 
                            echo "<b>Tổng: </b>".$result['productQuantity']."<br><b>Còn: </b>".$result['productRemain'];
                        ?></td>
                        <td>
                            <?php
                                echo "<b>Giá cũ: </b>".$fmt->format_currency($result['old_price'])."<br>";
                                echo "<b>Giá mới: </b>".$fmt->format_currency($result['current_price']);
                            ?>
                        </td>
                        <td>
                            <img src="../images/product_img/<?php echo $result['image_1'] ?>" alt="..." style="max-width: 100px;max-height: 100px;">
                        </td>
                        <td>
                            <div class="d-flex justify-content-center mt-4">
                                <a href="product_detail.php?productID=<?php echo $result['productID'] ?>">
                                    <button class="btn btn-success p-1 mr-2 shadow" style="color: black;" title="Xem chi tiết">
                                        <i class='far fa-eye'></i>
                                    </button>
                                </a>
                                <a href="product_edit.php?productID=<?php echo $result['productID'] ?>">
                                    <button class="btn btn-warning p-1 mr-2 shadow" style="color: black;" title="Sửa">
                                        <i class='far fa-edit'></i>
                                    </button>
                                </a>
                                <a href="?deleteID=<?php echo $result['productID'] ?>" onclick = "return confirm('Bạn có chắc chắn muốn xóa?')">
                                    <button class="btn btn-danger p-1 shadow" title="Xóa">
                                        <i class='far fa-trash-alt'></i>
                                    </button>
                                </a>
                            </div>
                        </td>
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