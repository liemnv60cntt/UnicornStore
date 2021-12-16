<?php
$page_title = "Trang chủ";
include "./includes/header.php";
?>
<div class="row">
    <div class="col-md-3 col-12 px-4 mb-3">
        <div class="sidebar-index p-0">
            <?php
            include "./includes/sidebar.php";
            ?>
        </div>
    </div>
    <div class="col-md-9 col-12 p-0">
        <?php
        include "./includes/slider.php";
        ?>
    </div>
</div>

<!-- Sản phẩm nổi bật -->
<div class="row mt-5 mx-auto p-2" style="max-width: 1200px;">
    <h3>Sản phẩm nổi bật</h3>
    <?php
    $featured_products = $prod->get_featured_product();
    if ($featured_products) {
        while ($result_featured = $featured_products->fetch_assoc()) {

    ?>
            <div class="col-md-3 col-6 p-2">
                <a href="details.php?productID=<?php echo $result_featured['productID'] ?>" class="a-card">
                    <div class="card shadow w-100 card-product" style="border-radius: 1rem;">
                        <div class="card-body p-2">
                            <img src="./images/product_img/<?php echo $result_featured['image_1'] ?>" class="card-img-top mt-3 mb-4" alt="..." />
                            <div class="label-top shadow-sm"><?php echo $result_featured['brandName'] ?></div>
                            <div class="clearfix mb-1">
                                <div class="float-start p-0">
                                    <span class="price-old"><?php echo $fm->format_currency($result_featured['old_price']) ?>đ</span><br>
                                    <span class="text-warning price-new"><?php echo $fm->format_currency($result_featured['current_price']) ?>đ</span>
                                </div>
                                <span class="float-end">
                                    <img src="./images/more/freeship-2.png" alt="..." style="width: 2.5em;margin:0px;" />
                                </span>
                            </div>
                            <h5 class="card-title mb-sm-4">
                                <?php echo $fm->textShorten($result_featured['productName'], 50) ?>
                            </h5>
                            <div class="clearfix mt-1">
                                <span class="float-start" style="font-size: small;">
                                    <?php $prodID = $result_featured['productID'];
                                    include "load_rating.php" ?><br>
                                    Đã bán <?php echo $result_featured['productQuantity'] - $result_featured['productRemain'] ?> sản phẩm
                                </span>
                                <a href="#" class="btn btn-warning float-end mt-1" style="border-radius:0.5rem;"><i class='fas fa-cart-plus'></i></a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
    <?php
        }
    }
    ?>
    <!-- <div class="col-md-3 col-6 p-2">
        <a href="details.php" class="a-card">
            <div class="card shadow w-100 " style="border-radius: 1rem;">
                <div class="card-body p-2">
                    <img src="./images/product_img/p-1-1.jpg" class="card-img-top mt-3 mb-4" alt="..." />
                    <div class="label-top shadow-sm">Asus Rog</div>
                    <div class="clearfix mb-1">
                        <div class="float-start p-0">
                            <span class="price-old">590.000đ</span><br>
                            <span class="text-warning price-new">489.000đ</span>
                        </div>
                        <span class="float-end">
                            <img src="./images/more/freeship-2.png" alt="..." style="width: 2.5em;margin:0px;" />
                        </span>
                    </div>
                    <h5 class="card-title mb-4">
                        Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1
                    </h5>
                    <div class="clearfix mt-1">

                        <span class="float-start mt-1" style="font-size: small;">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span><br>
                            Đã bán 10
                        </span>
                        <a href="#" class="btn btn-warning float-end mt-1" style="border-radius:0.5rem;"><i class='fas fa-cart-plus'></i></a>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6 p-2">
        <a href="#" class="a-card">
            <div class="card h-100 shadow w-100 " style="border-radius: 1rem">
                <div class="card-body p-2">
                    <img src="./images/product_img/k1.png" class="card-img-top" alt="..." />
                    <div class="label-top shadow-sm">Asus Rog</div>
                    <div class="clearfix mb-1">
                        <div class="float-start p-0">
                            <span class="price-old">12354.00€</span><br>
                            <span class="text-warning price-new">12354.00€</span>
                        </div>
                        <span class="float-end">
                            <img src="./images/more/freeship-2.png" alt="..." style="width: 2.5em;margin:0px;" />
                        </span>
                    </div>
                    <h5 class="card-title">
                        Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1
                    </h5>
                    <div class="clearfix mt-1">
                        <span class="float-start mt-3" style="font-size: small;">Đã bán 10</span>
                        <a href="#" class="btn btn-warning float-end mt-1" style="border-radius:0.5rem;"><i class='fas fa-cart-plus'></i></a>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6 p-2">
        <a href="#" class="a-card">
            <div class="card h-100 shadow w-100 " style="border-radius: 1rem">
                <div class="card-body p-2">
                    <img src="./images/product_img/k1.png" class="card-img-top" alt="..." />
                    <div class="label-top shadow-sm">Asus Rog</div>
                    <div class="clearfix mb-1">
                        <div class="float-start p-0">
                            <span class="price-old">12354.00€</span><br>
                            <span class="text-warning price-new">12354.00€</span>
                        </div>
                        <span class="float-end">
                            <img src="./images/more/freeship-2.png" alt="..." style="width: 2.5em;margin:0px;" />
                        </span>
                    </div>
                    <h5 class="card-title">
                        Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1
                    </h5>
                    <div class="clearfix mt-1">
                        <span class="float-start mt-3" style="font-size: small;">Đã bán 10</span>
                        <a href="#" class="btn btn-warning float-end mt-1" style="border-radius:0.5rem;"><i class='fas fa-cart-plus'></i></a>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6 p-2">
        <a href="#" class="a-card">
            <div class="card h-100 shadow w-100 " style="border-radius: 1rem">
                <div class="card-body p-2">
                    <img src="./images/product_img/k1.png" class="card-img-top" alt="..." />
                    <div class="label-top shadow-sm">Asus Rog</div>
                    <div class="clearfix mb-1">
                        <div class="float-start p-0">
                            <span class="price-old">12354.00€</span><br>
                            <span class="text-warning price-new">12354.00€</span>
                        </div>
                        <span class="float-end">
                            <img src="./images/more/freeship-2.png" alt="..." style="width: 2.5em;margin:0px;" />
                        </span>
                    </div>
                    <h5 class="card-title">
                        Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1 Bàn phím Gaming 1
                    </h5>
                    <div class="clearfix mt-1">
                        <span class="float-start mt-3" style="font-size: small;">Đã bán 10</span>
                        <a href="#" class="btn btn-warning float-end mt-1" style="border-radius:0.5rem;"><i class='fas fa-cart-plus'></i></a>
                    </div>
                </div>
            </div>
        </a>
    </div> -->

</div>
<!-- Sản phẩm khuyến mãi -->
<div class="row mt-3 mx-auto p-2" style="max-width: 1200px;">
    <h3>Giảm giá sốc</h3>
    <?php
    $discount_products = $prod->get_discount_product();
    if ($discount_products) {
        while ($result_discount = $discount_products->fetch_assoc()) {

    ?>
            <div class="col-md-3 col-6 p-2">
                <a href="details.php?productID=<?php echo $result_discount['productID'] ?>" class="a-card">
                    <div class="card shadow w-100 card-product" style="border-radius: 1rem;">
                        <div class="card-body p-2">
                            <img src="./images/product_img/<?php echo $result_discount['image_1'] ?>" class="card-img-top mt-3 mb-4" alt="..." />
                            <div class="label-top shadow-sm"><?php echo "Giảm " . 100 - ceil(100 / ($result_discount['old_price'] / $result_discount['current_price'])) . "%" ?></div>
                            <div class="clearfix mb-1">
                                <div class="float-start p-0">
                                    <span class="price-old"><?php echo $fm->format_currency($result_discount['old_price']) ?>đ</span><br>
                                    <span class="text-warning price-new"><?php echo $fm->format_currency($result_discount['current_price']) ?>đ</span>
                                </div>
                                <span class="float-end">
                                    <img src="./images/more/freeship-2.png" alt="..." style="width: 2.5em;margin:0px;" />
                                </span>
                            </div>
                            <h5 class="card-title mb-sm-4">
                                <?php echo $fm->textShorten($result_discount['productName'], 50) ?>
                            </h5>
                            <div class="clearfix mt-1">
                                <span class="float-start" style="font-size: small;">
                                    <?php $prodID = $result_discount['productID'];
                                    include "load_rating.php" ?><br>
                                    Đã bán <?php echo $result_discount['productQuantity'] - $result_discount['productRemain'] ?> sản phẩm
                                </span>
                                <a href="#" class="btn btn-warning float-end mt-1" style="border-radius:0.5rem;"><i class='fas fa-cart-plus'></i></a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
    <?php
        }
    }
    ?>

</div>

<!-- Sản phẩm mới -->
<div class="row mt-3 mx-auto p-2" style="max-width: 1200px;">
    <h3>Sản phẩm mới</h3>
    <?php
    $new_products = $prod->get_new_product();
    if ($new_products) {
        while ($result_new = $new_products->fetch_assoc()) {

    ?>
            <div class="col-md-3 col-6 p-2">
                <a href="details.php?productID=<?php echo $result_new['productID'] ?>" class="a-card">
                    <div class="card shadow w-100 card-product" style="border-radius: 1rem;">
                        <div class="card-body p-2">
                            <img src="./images/product_img/<?php echo $result_new['image_1'] ?>" class="card-img-top mt-3 mb-4" alt="..." />
                            <div class="label-top shadow-sm"><?php echo $result_new['brandName'] ?></div>
                            <div class="clearfix mb-1">
                                <div class="float-start p-0">
                                    <span class="price-old"><?php echo $fm->format_currency($result_new['old_price']) ?>đ</span><br>
                                    <span class="text-warning price-new"><?php echo $fm->format_currency($result_new['current_price']) ?>đ</span>
                                </div>
                                <span class="float-end">
                                    <img src="./images/more/freeship-2.png" alt="..." style="width: 2.5em;margin:0px;" />
                                </span>
                            </div>
                            <h5 class="card-title mb-sm-4">
                                <?php echo $fm->textShorten($result_new['productName'], 50) ?>
                            </h5>
                            <div class="clearfix mt-1">
                                <span class="float-start" style="font-size: small;">
                                    <?php $prodID = $result_new['productID'];
                                    include "load_rating.php" ?><br>
                                    Đã bán <?php echo $result_new['productQuantity'] - $result_new['productRemain'] ?> sản phẩm
                                </span>
                                <a href="#" class="btn btn-warning float-end mt-1" style="border-radius:0.5rem;"><i class='fas fa-cart-plus'></i></a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
    <?php
        }
    }
    ?>


</div>
<div class="d-flex justify-content-center">
    <a href="#" class="btn btn-secondary m-3 shadow">&nbsp;&nbsp;<i class='fas fa-chevron-up' style='font-size:30px'></i>&nbsp;&nbsp;</a>
</div>









<?php
include "./includes/footer.php";
?>