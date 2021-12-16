<?php
include "./includes/sidebar_topbar.php";
include '../classes/brand.php';
include '../classes/category.php';
?>
<?php
$brand = new Brand();
$cateID = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $brandName = $_POST['brandName'];
    $cateID = $_POST['category'];
    $insertBrand = $brand->insert_brand($brandName, $cateID);
}
?>
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Thêm thương hiệu sản phẩm</h1>

<div class="card mb-4 py-3 border-bottom-primary shadow">
    <div class="card-body">
        <div class="mb-3">
            <div class="row">
                <div class="col-lg-6">
                    <form action="" method="POST">

                        <div class="row">
                            <div class="col-md-4 col-12">
                                <label for="inputBrand" class="form-label">Tên thương hiệu sản phẩm:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input class="form-control w-100 mb-3" name="brandName" type="text" id="inputBrand" placeholder="Vui lòng nhập tên thương hiệu sản phẩm..." value="<?php if (isset($_POST['brandName'])) echo $_POST['brandName']; ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-12">
                                <label for="selectCate" class="form-label">Danh mục sản phẩm:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <select id="selectCate" name="category" class="form-control">
                                    <option value="N">-----Chọn danh mục sản phẩm-----</option>
                                    <?php
                                    $cate = new Category();
                                    $cate_list = $cate->show_category();

                                    if ($cate_list) {
                                        while ($result = $cate_list->fetch_assoc()) {
                                    ?>
                                            <option <?php
                                                if($result['cateID']==$cateID)
                                                    echo "selected";
                                            ?>
                                             value="<?php echo $result['cateID'] ?>"><?php echo $result['cateName'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-12">
                            </div>
                            <div class="col-md-8 col-12 mt-3">
                            <?php
                                if (isset($insertBrand)) {
                                    echo $insertBrand;
                                }
                            ?>
                            </div>
                        </div>

                        <input type="submit" name="add" value="Thêm" class="btn btn-primary float-right shadow">
                    </form>
                    
                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div>
    </div>
</div>


<?php
include "./includes/footer.php";
?>