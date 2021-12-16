<?php
include "./includes/sidebar_topbar.php";
include '../classes/producttype.php';
include '../classes/category.php';
?>
<?php
$typeID = (isset($_GET['typeID']) && $_GET['typeID'] != null) ? $_GET['typeID'] : '';
if ($typeID == '')
    echo "<script>window.location ='prodtype_list.php'</script>";
if (isset($_POST['back']))
    echo "<script>window.location ='prodtype_list.php'</script>";
$cate = new Category();
$type = new ProductType();
$typeName = '';
$cateID = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit'])) {
        $typeName = $_POST['typeName'];
        $cateID = $_POST['category'];

        $updateType = $type->update_type($typeName, $cateID, $typeID);
    }
}
?>
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Sửa loại sản phẩm</h1>

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
                            <?php
                            $result_type = '';
                            $get_type_name = $type->get_type_byID($typeID);
                            if ($get_type_name) {
                                while($result_type = $get_type_name->fetch_assoc()){

                            ?>
                            <div class="col-md-8 col-12">
                                <input class="form-control w-100 mb-3" name="typeName" type="text" id="inputType" placeholder="Vui lòng nhập tên loại sản phẩm..." value="<?php echo $result_type['typeName']; ?>">
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
                                    $cate_list = $cate->show_category();

                                    if ($cate_list) {
                                        while ($result = $cate_list->fetch_assoc()) {
                                    ?>
                                            <option <?php
                                                if ($result['cateID'] == $result_type['cateID']) {
                                                    echo 'selected';
                                                }
                                            ?> value="<?php echo $result['cateID'] ?>"><?php echo $result['cateName'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-4 col-12">
                            </div>
                            <div class="col-md-8 col-12 mt-3">
                                <?php
                                if (isset($updateType)) {
                                    echo $updateType;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="float-right">
                            <input type="submit" name="back" value="Quay lại" class="btn btn-secondary shadow">
                            <input type="submit" name="edit" value="Sửa" class="btn btn-primary shadow">
                        </div>


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