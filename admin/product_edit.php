<?php
include "./includes/sidebar_topbar.php";
include '../classes/producttype.php';
include '../classes/brand.php';
include '../classes/product.php';
include '../classes/category.php';
?>
<?php
$productID = (isset($_GET['productID']) && $_GET['productID'] != null) ? $_GET['productID'] : '';
if ($productID == '')
    echo "<script>window.location ='product_list.php'</script>";
if (isset($_POST['back']))
    echo "<script>window.location ='product_list.php'</script>";
$prod = new Product();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $updateProduct = $prod->update_product($_POST,$_FILES,$productID);
}
?>
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Sửa sản phẩm</h1>

<div class="card mb-4 py-3 border-bottom-primary shadow">
    <div class="card-body">
        <div class="mb-3">
            <!-- <div class="row"> -->
                <!-- <div class="col-lg-8 col-12"> -->
                    <form action="" method="POST" enctype="multipart/form-data">
                        <?php
                            $result_prod = '';
                            $get_product = $prod->get_details($productID);
                            if ($get_product) {
                                while($result_prod = $get_product->fetch_assoc()){

                        ?>
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="inputPName" class="form-label ml-md-5">Tên sản phẩm:</label>
                            </div>
                            <div class="col-md-6 col-12">
                                <input class="form-control w-100 mb-3" name="productName" type="text" id="inputPName" placeholder="Vui lòng nhập tên loại sản phẩm..." value="<?php echo $result_prod['productName']; ?>">
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['productName'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="selectType" class="form-label ml-md-5">Loại sản phẩm:</label>
                            </div>
                            <div class="col-md-6 col-12">
                                <select id="selectType" name="product_type" class="form-control mb-3">
                                    <option value="N">-----Chọn loại sản phẩm-----</option>
                                    <?php
                                    $prodtype = new ProductType();
                                    $cate = new Category();
                                    $cate_list = $cate->show_category();
                                    if($cate_list){
                                        while($result_cate_type = $cate_list->fetch_assoc()){
                                            $prodtype_list = $prodtype->show_type_by_cate($result_cate_type['cateID']);
                                            if($prodtype_list > 0)
                                                echo "<option disabled>- ".$result_cate_type['cateName'].":</option>";
                                    ?>
                                    
                                    <?php
                                            if ($prodtype_list) {
                                                while ($result_type = $prodtype_list->fetch_assoc()) {
                                            ?>
                                                    <option <?php
                                                        if($result_prod['typeID']==$result_type['typeID'])
                                                            echo "selected";
                                                    ?>
                                                    value="<?php echo $result_type['typeID'] ?>">&nbsp;&nbsp;+ <?php echo $result_type['typeName'] ?></option>
                                            <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['product_type'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="selectBrand" class="form-label ml-md-5">Thương hiệu sản phẩm:</label>
                            </div>
                            <div class="col-md-6 col-12">
                                <select id="selectBrand" name="brand" class="form-control mb-3">
                                    <option value="N">-----Chọn thương hiệu sản phẩm-----</option>
                                    <?php
                                    $brand = new Brand();
                                    $cate = new Category();
                                    $cate_list = $cate->show_category();
                                    if($cate_list){
                                        while($result_cate_brand = $cate_list->fetch_assoc()){
                                            $brand_list = $brand->show_brand_by_cate($result_cate_brand['cateID']);
                                            if($brand_list > 0)
                                                echo "<option disabled>- ".$result_cate_brand['cateName'].":</option>";
                                    ?>
                                    
                                    <?php
                                            if ($brand_list) {
                                                while ($result_brand = $brand_list->fetch_assoc()) {
                                            ?>
                                                    <option <?php
                                                        if($result_brand['brandID']==$result_prod['brandID'])
                                                            echo "selected";
                                                    ?>
                                                    value="<?php echo $result_brand['brandID'] ?>">&nbsp;&nbsp;+ <?php echo $result_brand['brandName'] ?></option>
                                            <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['brand'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="area" class="form-label ml-md-5">Mô tả sản phẩm:</label>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                    <textarea name="description" class="tinymce" id="area">
                                        <?php
                                            if(isset($result_prod['description']))
                                                echo(stripslashes($result_prod['description']))
                                        ?>
                                    </textarea>
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['description'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="selectStatus" class="form-label ml-md-5">Trạng thái:</label>
                            </div>
                            <div class="col-md-6 col-12">
                                <select id="selectStatus" name="productStatus" class="form-control w-100 mb-3">
                                    <option value="N">-----Chọn trạng thái sản phẩm-----</option>
                                    <option value="0" <?php if($result_prod['productStatus']==0) echo "selected" ?>>Sản phẩm mới</option>
                                    <option value="1" <?php if($result_prod['productStatus']==1) echo "selected" ?>>Nổi bật</option>
                                    <option value="2" <?php if($result_prod['productStatus']==2) echo "selected" ?>>Bán chạy</option>
                                    <option value="3" <?php if($result_prod['productStatus']==3) echo "selected" ?>>Đang khuyến mãi</option>
                                    <option value="4" <?php if($result_prod['productStatus']==4) echo "selected" ?>>Giảm giá sốc</option>
                                    <option value="5" <?php if($result_prod['productStatus']==5) echo "selected" ?>>Hàng sắp về</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['productStatus'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="inputQuantity" class="form-label ml-md-5">Tổng số lượng sản phẩm:</label>
                            </div>
                            <div class="col-md-6 col-12">
                                <input class="form-control w-100 mb-3" name="productQuantity" type="number" id="inputQuantity" placeholder="Vui lòng nhập số lượng sản phẩm..." value="<?php echo $result_prod['productQuantity']; ?>">
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['productQuantity'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="inputRemain" class="form-label ml-md-5">Số lượng sản phẩm còn lại:</label>
                            </div>
                            <div class="col-md-6 col-12">
                                <input class="form-control w-100 mb-3" name="productRemain" type="number" id="inputRemain" placeholder="Vui lòng nhập số lượng sản phẩm..." value="<?php echo $result_prod['productRemain']; ?>">
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['productRemain'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="inputPeriod" class="form-label ml-md-5">Thời hạn bảo hành:</label>
                            </div>
                            <div class="col-md-6 col-12">
                                <input class="form-control w-100 mb-3" name="warrantyPeriod" type="text" id="inputPeriod" placeholder="Vui lòng nhập thời hạn bảo hành..." value="<?php echo $result_prod['warrantyPeriod']; ?>">
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['warrantyPeriod'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="inputOldPrice" class="form-label ml-md-5">Đơn giá ban đầu (đ):</label>
                            </div>
                            <div class="col-md-6 col-12">
                                <input class="form-control w-100 mb-3" name="old_price" type="number" id="inputOldPrice" placeholder="Vui lòng nhập giá ban đầu..." value="<?php echo $result_prod['old_price']; ?>">
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['old_price'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="inputNewPrice" class="form-label ml-md-5">Đơn giá hiện tại (đ):</label>
                            </div>
                            <div class="col-md-6 col-12">
                                <input class="form-control w-100 mb-3" name="current_price" type="number" id="inputNewPrice" placeholder="Vui lòng nhập giá hiện tại..." value="<?php echo $result_prod['current_price']; ?>">
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['current_price'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="inputImage1" class="form-label ml-md-5">Ảnh sản phẩm 1:</label>
                            </div>
                            <div class="col-md-6 col-12">
                                <input class="form-control-file w-100 mb-3" name="image_1" type="file" id="inputImage1" placeholder="Vui lòng nhập giá hiện tại..." >
                                <input type="hidden" name="image_1_old" value="<?php echo $result_prod['image_1'] ?>">
                                <?php
                                if(isset($_FILES['image_1']) && $_FILES['image_1']['name']!="")
                                    echo '<input class="border-0 mb-3 w-100" readonly type="text" name="image_01" value="'.$_FILES['image_1']['name'].'">';
                                ?>
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['image_1'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="inputImage2" class="form-label ml-md-5">Ảnh sản phẩm 2:</label>
                            </div>
                            <div class="col-md-6 col-12">
                                <input class="form-control-file w-100 mb-3" name="image_2" type="file" id="inputImage2" placeholder="Vui lòng nhập giá hiện tại..." >
                                <input type="hidden" name="image_2_old" value="<?php echo $result_prod['image_2'] ?>">
                                <?php
                                if(isset($_FILES['image_2']) && $_FILES['image_2']['name']!="")
                                    echo '<input class="border-0 mb-3 w-100" readonly type="text" name="image_02" value="'.$_FILES['image_2']['name'].'">';
                                ?>
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['image_2'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label for="inputImage3" class="form-label ml-md-5">Ảnh sản phẩm 3:</label>
                            </div>
                            <div class="col-md-6 col-12">
                                <input class="form-control-file w-100 mb-3" name="image_3" type="file" id="inputImage3" placeholder="Vui lòng nhập giá hiện tại...">
                                <input type="hidden" name="image_3_old" value="<?php echo $result_prod['image_3'] ?>">
                                <?php
                                if(isset($_FILES['image_3']) && $_FILES['image_3']['name']!="")
                                    echo '<input class="border-0 mb-3 w-100" readonly type="text" name="image_03" value="'.$_FILES['image_3']['name'].'">';
                                ?>
                            </div>
                            <div class="col-md-3 col-12">
                            <?php
                                if (isset($updateProduct)) {
                                    echo "<span class='text-danger'>";
                                    echo $updateProduct['image_3'];
                                    echo "<span>";
                                }
                            ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-12">
                            </div>
                            <div class="col-md-6 col-12">
                                <div class=" row p-3 rounded border border-secondary">
                                    <div class="col-md-4 col-12 p-0">
                                        <img src="../images/product_img/<?php echo $result_prod['image_1'] ?>" alt="..." style="max-width: 10em;max-height: 10em;" class="shadow mb-3 mr-2">
                                        <h6><b>Ảnh cũ 1: </b><?php echo $result_prod['image_1'] ?></h6>
                                    </div>
                                    <div class="col-md-4 col-12 p-0">
                                        <img src="../images/product_img/<?php echo $result_prod['image_2'] ?>" alt="..." style="max-width: 10em;max-height: 10em;" class="shadow mb-3 mr-2">
                                        <h6><b>Ảnh cũ 2: </b><?php echo $result_prod['image_2'] ?></h6>
                                    </div>
                                    <div class="col-md-4 col-12 p-0">
                                        <img src="../images/product_img/<?php echo $result_prod['image_3'] ?>" alt="..." style="max-width: 10em;max-height: 10em;" class="shadow mb-3 mr-2">
                                        <h6><b>Ảnh cũ 3: </b><?php echo $result_prod['image_3'] ?></h6>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-3 col-12">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <input type="submit" name="back" value="Quay lại" class="btn btn-secondary shadow mx-1">
                            <input type="submit" name="edit" value="Sửa" class="btn btn-primary shadow mx-1">                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <?php
                                if (isset($updateProduct)) {
                                    echo $updateProduct['mess'];
                                }
                            ?>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </form>

                <!-- </div> -->
                <!-- <div class="col-lg-4 col-12">
                    
                </div>
            </div> -->

        </div>
    </div>
</div>


<?php
include "./includes/footer.php";
?>