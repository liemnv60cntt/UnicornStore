<?php
include "./includes/sidebar_topbar.php";
include '../classes/product.php';
include '../classes/category.php';
include '../classes/order.php';
?>
<?php
$productID = (isset($_GET['productID']) && $_GET['productID'] != null) ? $_GET['productID'] : '';
if ($productID == '')
    echo "<script>window.location ='product_list.php'</script>";

$prod = new Product();
$odr = new Order();
$deleteID = (isset($_GET['deleteID']) && $_GET['deleteID'] != null) ? $_GET['deleteID'] : '';
if ($deleteID != '')
    $deleteProd = $prod->delete_product($deleteID);

?>

<!-- DataTales Example -->
<div class="card shadow mb-4 border-bottom-success">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-success">Chi tiết sản phẩm</h5>
    </div>
    <div class="card-body">
        <?php
        if (isset($deleteProd)) {
            echo $deleteProd;
        }
        ?>
        <?php
        $show_prod = $prod->get_details($productID);
        if ($show_prod) {
            while ($result = $show_prod->fetch_assoc()) {
        ?>
                <div class="row">
                    <div class="col-sm-4 col-12">
                        <div id="imageSlide" class="carousel slide" data-ride="carousel">

                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <li data-target="#imageSlide" data-slide-to="0" class="active"></li>
                                <li data-target="#imageSlide" data-slide-to="1"></li>
                                <li data-target="#imageSlide" data-slide-to="2"></li>
                            </ul>

                            <!-- The slideshow -->
                            <div class="carousel-inner shadow">
                                <div class="carousel-item active">
                                    <img src="../images/product_img/<?php echo $result['image_1'] ?>" alt="one" width="100%" height="100%">
                                </div>
                                <div class="carousel-item">
                                    <img src="../images/product_img/<?php echo $result['image_2'] ?>" alt="two" width="100%" height="100%">
                                </div>
                                <div class="carousel-item">
                                    <img src="../images/product_img/<?php echo $result['image_3'] ?>" alt="three" width="100%" height="100%">
                                </div>
                            </div>

                            <!-- Left and right controls -->
                            <a class="carousel-control-prev" href="#imageSlide" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#imageSlide" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-8 col-12">
                        <h2 class="mb-4 text-primary mt-sm-0 mt-4"><?php echo $result['productName'] ?></h2>
                        <table>
                            <tr>
                                <td style="width: 10em;"><b>Loại sản phẩm:</b></td>
                                <td><?php echo $result['typeName'] ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10em;"><b>Thương hiệu:</b></td>
                                <td><?php echo $result['brandName'] ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10em;"><b>Danh mục:</b></td>
                                <td>
                                    <?php
                                    $cate = new Category();
                                    $get_cate = $cate->get_cate_byID($result['cateID']);
                                    $result_cate = $get_cate->fetch_assoc();
                                    echo $result_cate['cateName'];
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 10em;"><b>Trạng thái:</b></td>
                                <td><?php
                                    switch ($result['productStatus']) {
                                        case 0:
                                            echo "Bình thường";
                                            break;
                                        case 1:
                                            echo "Nổi bật";
                                            break;
                                        case 2:
                                            echo "Bán chạy";
                                            break;
                                        case 3:
                                            echo "Đang khuyến mãi";
                                            break;
                                        case 4:
                                            echo "Giảm giá sốc";
                                            break;
                                        case 5:
                                            echo "Đề xuất";
                                            break;
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10em;"><b>Số lượng tổng:</b></td>
                                <td><?php echo $result['productQuantity'] ?> sản phẩm</td>
                            </tr>
                            <tr>
                                <td style="width: 10em;"><b>Số lượng còn lại:</b></td>
                                <td><?php echo $result['productRemain'] ?> sản phẩm</td>
                            </tr>
                            <tr>
                                <td style="width: 10em;"><b>Đã bán:</b></td>
                                <td><?php echo $odr->check_sold($result['productID']) ?> sản phẩm</td>
                            </tr>
                            <tr>
                                <td style="width: 8em;"><b>Thời gian thêm:</b></td>
                                <td><?php
                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                    $time = strtotime($result['productTime']);
                                    echo date('\V\à\o \l\ú\c H\h:i\p \n\g\à\y d-m-Y', $time)
                                    ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10em;"><b>Thời hạn bảo hành:</b></td>
                                <td><?php echo $result['warrantyPeriod'] ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10em;"><b>Giá cũ:</b></td>
                                <td style="text-decoration: line-through;"><?php echo $result['old_price'] ?> đ</td>
                            </tr>
                            <tr>
                                <td style="width: 10em;"><b>Giá hiện tại:</b></td>
                                <td><?php echo $result['current_price'] ?> đ</td>
                            </tr>
                        </table>

                    </div>
                </div>
                <div class="mt-3 p-3">
                    <h4 class="text-secondary">Mô tả sản phẩm: </h4>
                    <?php
                    echo (stripslashes($result['description']));
                    ?>
                </div>
                <div class="mt-4 w-100">
                    <div class="row p-2">
                        <div class="col-sm-6 col-12 d-flex justify-content-start p-0">
                            <a href="product_list.php" class="btn btn-secondary btn-icon-split my-1 shadow">
                                <span class="icon text-white-50">
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                                <span class="text">Quay lại</span>
                            </a>
                        </div>
                        <div class="col-sm-6 col-12 d-flex justify-content-end">
                            <a href="product_edit.php?productID=<?php echo $result['productID'] ?>" class="btn btn-warning btn-icon-split my-1 shadow mr-2">
                                <span class="icon text-white-50">
                                    <i class="fas fa-pen"></i>
                                </span>
                                <span class="text">Sửa</span>
                            </a>
                            <a href="?deleteID=<?php echo $result['productID'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn btn-danger btn-icon-split my-1 shadow">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
                                <span class="text">Xóa</span>
                            </a>
                        </div>

                    </div>



                </div>
        <?php
            }
        }
        ?>
    </div>
</div>







<?php
include "./includes/footer.php";
?>