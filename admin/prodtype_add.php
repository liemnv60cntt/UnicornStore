<?php
include "./includes/sidebar_topbar.php";
include '../classes/producttype.php';
include '../classes/category.php';
?>
<?php
$type = new ProductType();
$cateID = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $typeName = $_POST['typeName'];
    $cateID = $_POST['category'];

    $insertType = $type->insert_type($typeName, $cateID);
}
?>
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Thêm loại sản phẩm</h1>

<div class="card mb-4 py-3 border-bottom-primary shadow">
    <div class="card-body">
        <div class="mb-3">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <label for="inputType" class="form-label">Tên loại sản phẩm:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input class="form-control w-100 mb-3" name="typeName" type="text" id="inputType" placeholder="Vui lòng nhập tên loại sản phẩm..." value="<?php if (isset($_POST['typeName'])) echo $_POST['typeName']; ?>">
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
                                if (isset($insertType)) {
                                    echo $insertType;
                                }
                            ?>
                            </div>
                        </div>

                        <input type="submit" name="add" value="Thêm" class="btn btn-primary mt-1 float-right shadow">


                    </form>

                </div>
                <div class="col-lg-6 col-12">

                </div>
            </div>

        </div>
    </div>
</div>


<?php
include "./includes/footer.php";
?>