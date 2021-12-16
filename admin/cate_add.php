<?php
include "./includes/sidebar_topbar.php";
include '../classes/category.php';
?>
<?php
$cate = new Category();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $cateName = $_POST['cateName'];

    $insertCate = $cate->insert_category($cateName);
}
?>
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Thêm danh mục sản phẩm</h1>

<div class="card mb-4 py-3 border-bottom-primary shadow">
    <div class="card-body">
        <div class="mb-3">
            <div class="row">
                <div class="col-lg-6">
                    <form action="" method="POST">
                        <label for="inputCate" class="form-label">Tên danh mục sản phẩm:</label>
                        <input class="form-control mb-3" name="cateName" type="text" id="inputCate" placeholder="Vui lòng nhập tên danh mục sản phẩm...">
                        <input type="submit" name="add" value="Thêm" class="btn btn-primary float-right shadow">
                    </form>
                    <?php
                    if (isset($insertCate)) {
                        echo $insertCate;
                    }
                    ?>
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