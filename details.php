<?php
$page_title = "Chi tiết sản phẩm";
include "./includes/header.php";
?>
<?php
$productID = (isset($_GET['productID']) && $_GET['productID'] != null) ? $_GET['productID'] : '';
$_SESSION['prodID'] = (isset($_GET['productID']) && $_GET['productID'] != null) ? $_GET['productID'] : '';
if ($productID == '')
    echo "<script>window.location ='404.php'</script>";
$details_prod = $prod->get_details($productID);
if ($details_prod) {
    $result_details = $details_prod->fetch_assoc();

?>
    <div class="mb-1">
        <i class='fas fa-home text-primary'></i>
        <a href="index.php" class="text-decoration-none text-primary">Trang chủ</a>
        <i class='fas fa-chevron-right text-secondary' style="font-size: 12px;"></i>
        <span class="text-dark">Chi tiết sản phẩm</span>
    </div>
    <div class="row px-sm-3 shadow mb-3 pt-3" style="background-color: #FFF;border-radius: 0.5em;">
        <div class="col-md-4">
            <div class="container-detail mx-sm-0 mx-auto">
                <div class="mySlides">
                    <!-- <div class="numbertext">1 / 3</div> -->
                    <img src="./images/product_img/<?php echo $result_details['image_1'] ?>" class="img-detail">
                </div>

                <div class="mySlides">
                    <!-- <div class="numbertext">2 / 3</div> -->
                    <img src="./images/product_img/<?php echo $result_details['image_2'] ?>" class="img-detail">
                </div>

                <div class="mySlides">
                    <!-- <div class="numbertext">3 / 3</div> -->
                    <img src="./images/product_img/<?php echo $result_details['image_3'] ?>" class="img-detail">
                </div>

                <!-- <a class="prev" onclick="plusSlides(-1)">❮</a>
                <a class="next" onclick="plusSlides(1)">❯</a> -->

                <div class="row-detail justify-content-center d-flex mt-1">
                    <div class="column-detail">
                        <img class="demo cursor" src="./images/product_img/<?php echo $result_details['image_1'] ?>" onclick="currentSlide(1)" alt="...">
                    </div>
                    <div class="column-detail">
                        <img class="demo cursor" src="./images/product_img/<?php echo $result_details['image_2'] ?>" onclick="currentSlide(2)" alt="...">
                    </div>
                    <div class="column-detail">
                        <img class="demo cursor" src="./images/product_img/<?php echo $result_details['image_3'] ?>" onclick="currentSlide(3)" alt="...">
                    </div>
                </div>
                <div class="justify-content-center d-flex <?php if ($ss->get('userlogin') == false) echo "d-none" ?>">

                    <input type="hidden" name="customer_ID_WL" id="customer_ID_WL" value="<?php echo $ss->get('userid') ?>">
                    <input type="hidden" name="product_ID_WL" id="product_ID_WL" value="<?php echo $productID ?>">
                    <?php
                    $check_wlist = $prod->check_wishlist($productID, $ss->get('userid'));
                    if ($check_wlist) {
                        echo '<button type="button" name="actionWishList" class="btn-heart-2 text-danger" id="actionWList"><i class="heart ff fas fa-heart mt-2"></i> Yêu thích</button>';
                    } else {
                        echo '<button type="button" name="actionWishList" class="btn-heart text-dark" id="actionWList"><i class="heart ff far fa-heart mt-2"></i> Yêu thích</button>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <h4><?php echo $result_details['productName'] ?></h4>
            <table>
                <tr>
                    <td>
                        <b><span class="average_rating text-warning border-bottom border-warning border-2">0.0</span></b>&nbsp;
                    </td>
                    <td>
                        <div class="show_star"></div>
                    </td>
                    <td class="text-primary">
                        &nbsp;&nbsp;|&nbsp;&nbsp;
                    </td>
                    <td>
                        <b><span class="total_review text-dark border-bottom border-dark border-2">0</span></b>
                    </td>
                    <td>&nbsp;đánh giá</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <span style="font-weight: 600;">Thương hiệu</span>
                    </td>
                    <td>:</td>
                    <td>
                        <b>&nbsp;&nbsp;<?php echo $result_details['brandName'] ?></b>
                    </td>
                    <td class="text-primary"> &nbsp;&nbsp;|&nbsp;&nbsp; </td>
                    <td>
                        <span style="font-weight: 600;">Đã bán</span>
                    </td>
                    <td>:</td>
                    <td>
                        <b>&nbsp;&nbsp;<?php echo $odr->check_sold($result_details['productID']); ?> sản phẩm</b>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span style="font-weight: 600;">Bảo hành</span>
                    </td>
                    <td>:</td>
                    <td colspan="5">
                        <b>&nbsp;&nbsp;<?php echo $result_details['warrantyPeriod'] ?></b>
                    </td>
                </tr>
            </table>
            <h4 class="text-primary mt-3"><?php echo $fm->format_currency($result_details['current_price']) ?> <span style="text-decoration: underline;">đ</span></h4>
            <h6 class="text-secondary" style="text-decoration: line-through;"><?php echo $fm->format_currency($result_details['old_price']) ?> <span style="text-decoration: underline;">đ</span></h6>
            <table class="w-75">
                <tr>
                    <td class="w-25">
                        Số lượng:
                    </td>
                    <td>
                        <div class="input-group mt-3 w-50">
                            <button class="input-group-text" onclick="upOrDown(false);"><i class='fas fa-minus' style='font-size:14px'></i></button>
                            <input type="number" name="quantity" id="quantity_detail" class="form-control bg-light text-center w-25" value="1" onblur="limitNum();">
                            <input type="hidden" id="remain_detail" value="<?php echo $result_details['productRemain']; ?>">
                            <button class="input-group-text" onclick="upOrDown(true);"><i class='fas fa-plus' style='font-size:14px'></i></button>
                        </div>
                        <!-- Thêm vào giỏ hàng -->
                        <input type="hidden" name="hidden_name" id="name_detail" value="<?php echo $result_details['productName'] ?>" />
                        <input type="hidden" name="hidden_price" id="price_detail" value="<?php echo $result_details['current_price'] ?>" />
                        <input type="hidden" name="hidden_image" id="image_detail" value="<?php echo $result_details['image_1'] ?>" />
                        <input type="hidden" name="hidden_remain" id="remain_detail" value="<?php echo $result_details['productRemain'] ?>" />
                        <input type="hidden" name="hidden_price_old" id="price_old_detail" value="<?php echo $result_details['old_price'] ?>" />
                        <!-- Kết thúc thêm giỏ hàng -->
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?php
                        if($result_details['productRemain']>0)
                            echo "<span class='text-secondary'>". $result_details['productRemain'] . " sản phẩm có sẵn</span>";
                        else
                            echo "<span class='text-danger'>Sản phẩm hết hàng</span>"
                        ?>
                    </td>
                </tr>
            </table>
            <div class="mt-2 mb-4">
                <button class="btn btn-outline-primary mx-1 add_to_cart_from_detail <?php if($result_details['productRemain']==0) echo 'disabled' ?>" name="add_to_cart_from_detail" id="<?php echo $result_details['productID'] ?>"><i class='fas fa-cart-plus'></i> Thêm vào giỏ hàng</button>
                <a href="cart_page.php" class="btn btn-primary mx-1 px-5 buy_now <?php if($result_details['productRemain']==0) echo 'disabled' ?>" name="buy_now" id="<?php echo $result_details['productID'] ?>">Mua ngay</a>
                <!-- <button class="btn btn-primary mx-1 px-5">Mua ngay</button> -->
            </div>
            <span class="text-danger <?php if ($result_details['current_price'] <= 500000) echo 'd-none' ?>">
                <b>Ưu đãi:</b> Miễn phí giao hàng cho đơn hàng hơn 500K
            </span>


        </div>
        <div class="col-md-3 d-flex justify-content-end sidebar-detail">
            <?php include "./includes/sidebar.php" ?>
        </div>
    </div>
    <div class="row shadow mb-3 py-3 px-4" style="background-color: #FFF;border-radius: 0.5em;">
        <h3 class="text-primary">Mô tả sản phẩm</h3>
        <div class="desc-detail"><?php echo $result_details['description'] ?></div>
    </div>
    <!-- Start form rating -->
    <div class="row px-5 shadow mb-3" style="background-color: #FFF;border-radius: 0.5em;">
        <h3 class="mt-4 mb-3 text-primary">Đánh giá sản phẩm</h3>
        <div class="card p-0">
            <!-- <div class="card-header">Điểm đánh giá</div> -->
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <h1 class="text-warning mt-4 mb-4">
                            <b><span class="average_rating">0.0</span> / 5</b>
                        </h1>
                        <div class="mb-3">
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                        </div>
                        <h4><span class="total_review">0</span> đánh giá</h4>
                    </div>
                    <div class="col-sm-4">
                        <p>
                        <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>

                        <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                        </div>
                        </p>
                        <p>
                        <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>

                        <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                        </div>
                        </p>
                        <p>
                        <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>

                        <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                        </div>
                        </p>
                        <p>
                        <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>

                        <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                        </div>
                        </p>
                        <p>
                        <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>

                        <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                        </div>
                        </p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h3 class="mt-4 mb-3">Viết đánh giá</h3>

                        <button type="button" name="add_review" id="add_review" class="btn btn-primary <?php if ($prod->check_user_rating($ss->get('userid'), $productID) != true) {
                                                                                                            echo 'd-none';
                                                                                                        } ?>">Đánh giá</button>
                        <button type="button" id="disabled_review" class="btn btn-secondary <?php if ($prod->check_user_rating($ss->get('userid'), $productID) == true) {
                                                                                                echo 'd-none';
                                                                                            } ?>">Đánh giá</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5" id="review_content">
            <h5 class="text-center text-secondary">Chưa có đánh giá</h5>
        </div>
    </div>
    <!-- End form rating -->
    <div class="d-flex justify-content-center">
        <a href="#" class="btn btn-secondary shadow">&nbsp;&nbsp;<i class='fas fa-chevron-up' style='font-size:30px'></i>&nbsp;&nbsp;</a>
    </div>
    <!-- Start Suggest Product -->
    <div class="row mb-5 py-3 px-md-5 px-1">
        <h3 class="text-center">Sản phẩm gợi ý</h4>
        <?php
        $get_suggest = $cate->get_product_by_cate($result_details['cateID']);
        $i = 0;
        if ($get_suggest && mysqli_num_rows($get_suggest)>1) {
            while ($result_suggest = $get_suggest->fetch_assoc()) {
                if ($i <= 3) {
                    if ($result_suggest['productID'] != $result_details['productID']) {
        ?>

                        <div class="col-md-3 col-6 p-2 filterDiv <?php echo $result_suggest['brandName'] ?>" id="<?php echo $result_suggest['current_price'] ?>">
                            <a href="details.php?productID=<?php echo $result_suggest['productID'] ?>" class="a-card">
                                <div class="card shadow w-100 card-product" style="border-radius: 1rem;">
                                    <div class="card-body p-2">
                                        <img src="./images/product_img/<?php echo $result_suggest['image_1'] ?>" class="card-img-top mt-3 mb-4" alt="..." />
                                        <div class="label-top shadow-sm"><?php echo $result_suggest['brandName'] ?></div>
                                        <div class="clearfix mb-1">
                                            <div class="float-start p-0">
                                                <span class="price-old"><?php echo $fm->format_currency($result_suggest['old_price']) ?>đ</span><br>
                                                <span class="text-warning price-new"><?php echo $fm->format_currency($result_suggest['current_price']) ?>đ</span>
                                            </div>
                                            <span class="float-end <?php if ($result_suggest['current_price'] <= 500000) echo 'd-none' ?>">
                                                <img src="./images/more/freeship-2.png" alt="..." style="width: 2.5em;margin:0px;" />
                                            </span>
                                        </div>
                                        <h5 class="card-title mb-sm-4">
                                            <?php echo $fm->textShorten($result_suggest['productName'], 50) ?>
                                        </h5>
                            </a>
                            <div class="clearfix mt-1">
                                <span class="float-start" style="font-size: small;">
                                    <?php $prodID = $result_suggest['productID'];
                                    include "includes/load_rating.php" ?><br>
                                    Đã bán <?php echo $odr->check_sold($result_suggest['productID']); ?> sản phẩm
                                </span>
                                <!-- Thêm vào giỏ hàng -->
                                <input type="hidden" name="quantity" id="quantity<?php echo $result_suggest['productID'] ?>" class="form-control" value="1" />
                                <input type="hidden" name="hidden_name" id="name<?php echo $result_suggest['productID'] ?>" value="<?php echo $result_suggest['productName'] ?>" />
                                <input type="hidden" name="hidden_price" id="price<?php echo $result_suggest['productID'] ?>" value="<?php echo $result_suggest['current_price'] ?>" />
                                <input type="hidden" name="hidden_image" id="image<?php echo $result_suggest['productID'] ?>" value="<?php echo $result_suggest['image_1'] ?>" />
                                <input type="hidden" name="hidden_remain" id="remain<?php echo $result_suggest['productID'] ?>" value="<?php echo $result_suggest['productRemain'] ?>" />
                                <input type="hidden" name="hidden_price_old" id="price_old<?php echo $result_suggest['productID'] ?>" value="<?php echo $result_suggest['old_price'] ?>" />
                                <button name="add_to_cart" id="<?php echo $result_suggest['productID'] ?>" style="border-radius:0.5rem;" class="add_to_cart btn btn-warning float-end mt-1"><i class='fas fa-cart-plus'></i></button>
                                <!-- Kết thúc thêm giỏ hàng -->
                            </div>
                        </div>
    </div>

    </div>

<?php
                        $i++;
                    }
                }
            }
        } else {
            echo "<h5 class='text-center'>Chưa có sản phẩm gợi ý!</h5>";
        }
?>
</div>
<!-- End Suggest Product -->

<!-- Modal review -->
<div id="review_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gửi đánh giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h4 class="text-center mt-2 mb-4">
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                </h4>
                <div class="form-group">
                    <!-- <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Nhập tên..." /> -->
                    <input type="hidden" name="customer_ID" id="customer_ID" value="<?php echo $ss->get('userid') ?>">
                    <input type="hidden" name="product_ID" id="product_ID" value="<?php echo $productID ?>">
                </div>
                <div class="form-group mt-2">
                    <textarea name="review" id="review" class="form-control" placeholder="Nhập đánh giá..."></textarea>
                </div>
                <div class="form-group text-center mt-4">
                    <button type="button" class="btn btn-primary" id="save_review">Gửi</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Review -->
<?php
}
?>
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
<!-- End Modal Add Cart -->
<!-- The Modal Save Review -->
<div class="modal fade" id="savedReview">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thông báo</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="font-size: larger;">
                Đánh giá sản phẩm thành công!
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
            </div>

        </div>
    </div>
</div>
<!-- End Modal Save Review -->
<!-- The Modal Error Review Blank -->
<div class="modal fade" id="reviewBlank">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thông báo</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="font-size: larger;">
                Gửi đánh giá không thành công! Vui lòng nhập đầy đủ thông tin!
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
            </div>

        </div>
    </div>
</div>
<!-- End Modal Error Review Blank -->
<!-- The Modal Error Review Not Logged in -->
<div class="modal fade" id="notLoggedIn">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thông báo</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="font-size: larger;">
                Bạn chưa đăng nhập tài khoản!
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
            </div>

        </div>
    </div>
</div>
<!-- End Modal Error Review Not Logged in -->

<?php
include "./includes/footer.php";
?>