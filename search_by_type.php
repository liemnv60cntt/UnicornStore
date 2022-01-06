<?php
$page_title = "Kết quả tìm kiếm";
include "./includes/header.php";
?>
<?php
    $typeID = (isset($_GET['typeID']) && $_GET['typeID'] != null) ? $_GET['typeID'] : "";
    if ($typeID == '')
        echo "<script>window.location ='404.php'</script>";
?>
<!-- Sản phẩm theo loại sản phẩm -->
<div class="row mb-5 mx-auto p-2" style="max-width: 1200px;">
    <?php
    $type_cate = $prodtype->get_type_detail_byID($typeID);
    if($type_cate){
        $result_type = $type_cate->fetch_assoc();
        echo "<h5>
        <i class='fas fa-home text-primary'></i>
        <a href='index.php' class='text-decoration-none text-primary'>Trang chủ</a>
        <i class='fas fa-chevron-right text-secondary' style='font-size: 16px;'></i> 
        <a href='search_by_cate.php?cateID=".$result_type['cateID']."' class='text-decoration-none text-dark'>
            ".$result_type['cateName']."</a>
        <i class='fas fa-chevron-right text-secondary' style='font-size: 16px;'></i> 
        ". $result_type['typeName']."
        </h5>";
    }
    ?>
    <!-- Bộ lọc -->
    <div class="bg-white pb-3 pt-1 my-2 rounded-3 shadow-sm">
        <h5 class="border-start border-3 border-dark px-2">Bộ lọc:</h5>
        <div class="container" id="myBtnContainer">
            <h6 class="border-start border-3 border-secondary px-2">Thương hiệu:</h6>
            <button class="btn btn-sm btn-outline-secondary active mt-1" onclick="filterSelection('all')"> Tất cả</button>
            <?php
            $product_by_type = $prodtype->get_distinct_product_brandName_by_type($typeID);
            if ($product_by_type) {
                while ($result_search = $product_by_type->fetch_assoc()) {
                    
            ?>
            <button class="btn btn-sm btn-outline-secondary mt-1" 
                onclick="filterSelection('<?php echo $result_search['brandName'] ?>')"> <?php echo $result_search['brandName'] ?></button>
            <?php
                }
            }
            ?>
        </div>
        <div class="container mt-3" id="myBtnContainer2">
            <h6 class="border-start border-3 border-secondary px-2">Giá tiền:</h6>
            <button class="btn btn-sm btn-outline-secondary active mt-1" 
                onclick="filterSelection2(0)"> Tất cả</button>

            <button class="btn btn-sm btn-outline-secondary mt-1" 
                onclick="filterSelection2(1)">
                 Dưới 1 triệu
            </button>
            <button class="btn btn-sm btn-outline-secondary mt-1" 
                onclick="filterSelection2(2)">
                 1 - 2 triệu
            </button>
            <button class="btn btn-sm btn-outline-secondary mt-1" 
                onclick="filterSelection2(3)">
                 2 - 5 triệu
            </button>
            <button class="btn btn-sm btn-outline-secondary mt-1" 
                onclick="filterSelection2(4)">
                 5 - 10 triệu
            </button>
            <button class="btn btn-sm btn-outline-secondary mt-1" 
                onclick="filterSelection2(5)">
                 Trên 10 triệu
            </button>
        </div>
    </div>
    <!-- Bộ lọc -->
    <?php
    $products_by_type = $prodtype->get_product_by_type($typeID);
    if ($products_by_type) {
        while ($result_search = $products_by_type->fetch_assoc()) {

    ?>
            <div class="col-md-3 col-6 p-2 filterDiv <?php echo $result_search['brandName'] ?>" id="<?php echo $result_search['current_price'] ?>">
                <a href="details.php?productID=<?php echo $result_search['productID'] ?>" class="a-card">
                    <div class="card shadow w-100 card-product" style="border-radius: 1rem;">
                        <div class="card-body p-2">
                            <img src="./images/product_img/<?php echo $result_search['image_1'] ?>" class="card-img-top mt-3 mb-4" alt="..." />
                            <div class="label-top shadow-sm"><?php echo $result_search['brandName'] ?></div>
                            <div class="clearfix mb-1">
                                <div class="float-start p-0">
                                    <span class="price-old"><?php echo $fm->format_currency($result_search['old_price']) ?>đ</span><br>
                                    <span class="text-warning price-new"><?php echo $fm->format_currency($result_search['current_price']) ?>đ</span>
                                </div>
                                <span class="float-end <?php if($result_search['current_price']<=500000) echo 'd-none' ?>">
                                    <img src="./images/more/freeship-2.png" alt="..." style="width: 2.5em;margin:0px;" />
                                </span>
                            </div>
                            <h5 class="card-title mb-sm-4">
                                <?php echo $fm->textShorten($result_search['productName'], 50) ?>
                            </h5>
                            </a>
                            <div class="clearfix mt-1">
                                <span class="float-start" style="font-size: small;">
                                    <?php $prodID = $result_search['productID'];
                                    include "includes/load_rating.php" ?><br>
                                    Đã bán <?php echo $odr->check_sold($result_search['productID']); ?> sản phẩm
                                </span>
                                <!-- Thêm vào giỏ hàng -->
                                <input type="hidden" name="quantity" id="quantity<?php echo $result_search['productID'] ?>" class="form-control" value="1" />
            	                <input type="hidden" name="hidden_name" id="name<?php echo $result_search['productID'] ?>" value="<?php echo $result_search['productName'] ?>" />
            	                <input type="hidden" name="hidden_price" id="price<?php echo $result_search['productID'] ?>" value="<?php echo $result_search['current_price'] ?>" />
                                <input type="hidden" name="hidden_image" id="image<?php echo $result_search['productID'] ?>" value="<?php echo $result_search['image_1'] ?>" />
                                <input type="hidden" name="hidden_remain" id="remain<?php echo $result_search['productID'] ?>" value="<?php echo $result_search['productRemain'] ?>" />
                                <input type="hidden" name="hidden_price_old" id="price_old<?php echo $result_search['productID'] ?>" value="<?php echo $result_search['old_price'] ?>" />
                                <button name="add_to_cart" id="<?php echo $result_search['productID'] ?>" style="border-radius:0.5rem;" class="add_to_cart btn btn-warning float-end mt-1"><i class='fas fa-cart-plus'></i></button>
                                <!-- Kết thúc thêm giỏ hàng -->
                            </div>
                        </div>
                    </div>
               
            </div>
    <?php
        }
    }else{
        echo "<h3 class='text-center mt-5 text-secondary'>Không có sản phẩm cần tìm!</h3>";
    }
    ?>
   

</div>
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