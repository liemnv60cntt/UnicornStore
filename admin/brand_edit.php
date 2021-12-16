<?php
include "./includes/sidebar_topbar.php";
include '../classes/brand.php';
include '../classes/category.php';
?>
<?php
$brandID = (isset($_GET['brandID']) && $_GET['brandID']!=null) ? $_GET['brandID'] : '';
if($brandID=='')
    echo "<script>window.location ='brand_list.php'</script>";
if(isset($_POST['back']))
    echo "<script>window.location ='brand_list.php'</script>";
$cate = new Category();
$brand = new Brand();
$typeName = '';
$cateID = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['edit'])){
        $brandName = $_POST['brandName'];
        $cateID = $_POST['category'];
        $updatebrand = $brand->update_brand($brandName, $cateID, $brandID);
    }
}
?>
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Sửa thương hiệu sản phẩm</h1>

<div class="card mb-4 py-3 border-bottom-warning shadow">
    <div class="card-body">
        <div class="mb-3">
            <div class="row">
                <div class="col-sm-6">
                    <?php
                        $result_brand = '';
                        $get_brand_name = $brand->get_brand_byID($brandID);
                        if($get_brand_name){
                            while($result_brand = $get_brand_name->fetch_assoc()){
                        
                    ?>
                    <form action="" method="POST">

                        <div class="row">
                            <div class="col-md-4 col-12">
                                <label for="inputBrand" class="form-label">Tên thương hiệu sản phẩm:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input class="form-control w-100 mb-3" name="brandName" type="text" id="inputBrand" placeholder="Vui lòng nhập tên thương hiệu sản phẩm..." value="<?php echo $result_brand['brandName']; ?>">
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
                                                if ($result['cateID'] == $result_brand['cateID']) {
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
                                if (isset($updatebrand)) {
                                    echo $updatebrand;
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
                <div class="col-sm-6">

                </div>
            </div>

        </div>
    </div>
</div>


<?php
include "./includes/footer.php";
?>