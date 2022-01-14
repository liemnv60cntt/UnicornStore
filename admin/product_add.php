<?php
include "./includes/sidebar_topbar.php";
include '../classes/producttype.php';
include '../classes/brand.php';
include '../classes/product.php';
include '../classes/category.php';
?>
<?php
$prod = new Product();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $insertProduct = $prod->insert_product($_POST, $_FILES);
}
?>
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Thêm sản phẩm</h1>

<div class="card mb-4 py-3 border-bottom-primary shadow">
    <div class="card-body">
        <div class="mb-3">
            <!-- <div class="row"> -->
            <!-- <div class="col-lg-8 col-12"> -->
            <form action="" method="POST" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-md-3 col-12">
                    </div>
                    <div class="col-md-6 col-12">
                        
                            <?php
                            if (isset($insertProduct)) {
                                echo $insertProduct['mess'];
                            }
                            ?>
                        
                    </div>
                    <div class="col-md-3 col-12">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-12">
                        <label for="inputPName" class="form-label ml-md-5">Tên sản phẩm:</label>
                    </div>
                    <div class="col-md-6 col-12">
                        <input class="form-control w-100 mb-3" name="productName" type="text" id="inputPName" placeholder="Vui lòng nhập tên loại sản phẩm..." value="<?php if (isset($_POST['productName'])) echo $_POST['productName']; ?>">
                    </div>
                    <div class="col-md-3 col-12">
                        <?php
                        if (isset($insertProduct)) {
                            echo "<span class='text-danger'>";
                            echo $insertProduct['productName'];
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
                            if ($cate_list) {
                                while ($result_cate_type = $cate_list->fetch_assoc()) {
                                    $prodtype_list = $prodtype->show_type_by_cate($result_cate_type['cateID']);
                                    if ($prodtype_list > 0)
                                        echo "<option disabled style='font-weight: bold'>- " . $result_cate_type['cateName'] . ":</option>";
                            ?>

                                    <?php
                                    if ($prodtype_list) {
                                        while ($result_type = $prodtype_list->fetch_assoc()) {
                                    ?>
                                            <option <?php
                                                    if (isset($_POST['product_type']) && $result_type['typeID'] == $_POST['product_type'])
                                                        echo "selected";
                                                    ?> value="<?php echo $result_type['typeID'] ?>">&nbsp;&nbsp;+ <?php echo $result_type['typeName'] ?></option>
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
                        if (isset($insertProduct)) {
                            echo "<span class='text-danger'>";
                            echo $insertProduct['product_type'];
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
                            if ($cate_list) {
                                while ($result_cate_brand = $cate_list->fetch_assoc()) {
                                    $brand_list = $brand->show_brand_by_cate($result_cate_brand['cateID']);
                                    if ($brand_list > 0)
                                        echo "<option disabled style='font-weight: bold'>- " . $result_cate_brand['cateName'] . ":</option>";
                            ?>

                                    <?php
                                    if ($brand_list) {
                                        while ($result_brand = $brand_list->fetch_assoc()) {
                                    ?>
                                            <option <?php
                                                    if (isset($_POST['brand']) && $result_brand['brandID'] == $_POST['brand'])
                                                        echo "selected";
                                                    ?> value="<?php echo $result_brand['brandID'] ?>">&nbsp;&nbsp;+ <?php echo $result_brand['brandName'] ?></option>
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
                        if (isset($insertProduct)) {
                            echo "<span class='text-danger'>";
                            echo $insertProduct['brand'];
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
                                        if (isset($_POST['description']))
                                            echo (stripslashes($_POST['description']))
                                        ?>
                                    </textarea>
                    </div>
                    <div class="col-md-3 col-12">
                        <?php
                        if (isset($insertProduct)) {
                            echo "<span class='text-danger'>";
                            echo $insertProduct['description'];
                            echo "<span>";
                        }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-12">
                        <label for="inputQuantity" class="form-label ml-md-5">Số lượng sản phẩm:</label>
                    </div>
                    <div class="col-md-6 col-12">
                        <input class="form-control w-100 mb-3" name="productQuantity" type="number" id="inputQuantity" placeholder="Vui lòng nhập số lượng sản phẩm..." value="<?php if (isset($_POST['productQuantity'])) echo $_POST['productQuantity']; ?>">
                    </div>
                    <div class="col-md-3 col-12">
                        <?php
                        if (isset($insertProduct)) {
                            echo "<span class='text-danger'>";
                            echo $insertProduct['productQuantity'];
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
                        <input class="form-control w-100 mb-3" name="warrantyPeriod" type="text" id="inputPeriod" placeholder="Vui lòng nhập thời hạn bảo hành..." value="<?php if (isset($_POST['warrantyPeriod'])) echo $_POST['warrantyPeriod']; ?>">
                    </div>
                    <div class="col-md-3 col-12">
                        <?php
                        if (isset($insertProduct)) {
                            echo "<span class='text-danger'>";
                            echo $insertProduct['warrantyPeriod'];
                            echo "<span>";
                        }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-12">
                        <label for="inputOldPrice" class="form-label ml-md-5">Đơn giá ban đầu:</label>
                    </div>
                    <div class="col-md-6 col-12">
                        <input class="form-control w-100 mb-3" name="old_price" type="number" id="inputOldPrice" placeholder="Vui lòng nhập giá ban đầu..." value="<?php if (isset($_POST['old_price'])) echo $_POST['old_price']; ?>">
                    </div>
                    <div class="col-md-3 col-12">
                        <?php
                        if (isset($insertProduct)) {
                            echo "<span class='text-danger'>";
                            echo $insertProduct['old_price'];
                            echo "<span>";
                        }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-12">
                        <label for="inputNewPrice" class="form-label ml-md-5">Đơn giá hiện tại:</label>
                    </div>
                    <div class="col-md-6 col-12">
                        <input class="form-control w-100 mb-3" name="current_price" type="number" id="inputNewPrice" placeholder="Vui lòng nhập giá hiện tại..." value="<?php if (isset($_POST['current_price'])) echo $_POST['current_price']; ?>">
                    </div>
                    <div class="col-md-3 col-12">
                        <?php
                        if (isset($insertProduct)) {
                            echo "<span class='text-danger'>";
                            echo $insertProduct['current_price'];
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
                        <input class="form-control-file w-100 mb-3" name="image_1" type="file" id="inputImage1" placeholder="Vui lòng nhập giá hiện tại...">
                        <?php
                        if (isset($_FILES['image_1']) && $_FILES['image_1']['name'] != "")
                            echo '<input class="border-0 mb-3 w-100" readonly type="text" name="image_1_old" value="' . $_FILES['image_1']['name'] . '">';
                        ?>

                    </div>
                    <div class="col-md-3 col-12">
                        <?php
                        if (isset($insertProduct)) {
                            echo "<span class='text-danger'>";
                            echo $insertProduct['image_1'];
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
                        <input class="form-control-file w-100 mb-3" name="image_2" type="file" id="inputImage2" placeholder="Vui lòng nhập giá hiện tại...">
                        <?php
                        if (isset($_FILES['image_2']) && $_FILES['image_2']['name'] != "")
                            echo '<input class="border-0 mb-3 w-100" readonly type="text" name="image_2_old" value="' . $_FILES['image_2']['name'] . '">';
                        ?>
                    </div>
                    <div class="col-md-3 col-12">
                        <?php
                        if (isset($insertProduct)) {
                            echo "<span class='text-danger'>";
                            echo $insertProduct['image_2'];
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
                        <?php
                        if (isset($_FILES['image_3']) && $_FILES['image_3']['name'] != "")
                            echo '<input class="border-0 mb-3 w-100" readonly type="text" name="image_3_old" value="' . $_FILES['image_3']['name'] . '">';
                        ?>
                    </div>
                    <div class="col-md-3 col-12">
                        <?php
                        if (isset($insertProduct)) {
                            echo "<span class='text-danger'>";
                            echo $insertProduct['image_3'];
                            echo "<span>";
                        }
                        ?>
                    </div>
                </div>
                <?php
                $image_01 = "";
                $image_02 = "";
                $image_03 = "";
                if (isset($_FILES['image_1']) && isset($insertProduct)) {
                    if ($insertProduct['success'] == 1) {
                        $image_01 = $_FILES['image_1']['name'];
                        $image_02 = $_FILES['image_2']['name'];
                        $image_03 = $_FILES['image_3']['name'];
                        echo '<div class="row">
                                    <div class="col-md-3 col-12">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class=" row p-3 rounded border border-secondary">
                                            <div class="col-md-4 col-12 p-0">
                                                <img src="../images/product_img/' . $image_01 . '" alt="..." style="max-width: 10em;max-height: 10em;" class="shadow mb-3 mr-2">
                                                <h6><b>Ảnh 1: </b>' . $image_01 . '</h6>
                                            </div>
                                            <div class="col-md-4 col-12 p-0">
                                                <img src="../images/product_img/' . $image_02 . '" alt="..." style="max-width: 10em;max-height: 10em;" class="shadow mb-3 mr-2">
                                                <h6><b>Ảnh 2: </b>' . $image_02 . '</h6>
                                            </div>
                                            <div class="col-md-4 col-12 p-0">
                                                <img src="../images/product_img/' . $image_03 . '" alt="..." style="max-width: 10em;max-height: 10em;" class="shadow mb-3 mr-2">
                                                <h6><b>Ảnh 3: </b>' . $image_03 . '</h6>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-3 col-12">
                                    </div>
                                </div>';
                    }
                }
                ?>

                <div class="d-flex justify-content-center mt-3">
                    <a href="product_add.php" class="btn btn-secondary shadow mr-2">Làm mới</a>
                    <input type="submit" name="add" value="Thêm sản phẩm" class="btn btn-primary shadow">
                </div>


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