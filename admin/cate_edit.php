<?php
include "./includes/sidebar_topbar.php";
include '../classes/category.php';
?>
<?php
$cateID = (isset($_GET['cateID']) && $_GET['cateID']!=null) ? $_GET['cateID'] : '';
if($cateID=='')
    echo "<script>window.location ='cate_list.php'</script>";
if(isset($_POST['back']))
    echo "<script>window.location ='cate_list.php'</script>";
$cate = new Category();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['edit'])){
        $cateName = $_POST['cateName'];
        $updateCate = $cate->update_category($cateName, $cateID);
    }
}
?>
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Sửa danh mục sản phẩm</h1>

<div class="card mb-4 py-3 border-bottom-warning shadow">
    <div class="card-body">
        <div class="mb-3">
            <div class="row">
                <div class="col-sm-6">
                    <?php
                        $result = '';
                        $get_cate_name = $cate->get_cate_byID($cateID);
                        if($get_cate_name){
                            $result = $get_cate_name->fetch_assoc();
                        }
                    ?>
                    <form action="" method="POST">
                        <label for="inputCate" class="form-label">Tên danh mục sản phẩm:</label>
                        <input class="form-control mb-3" name="cateName" type="text" id="inputCate" value="<?php echo $result['cateName'] ?>">
                        <div class="float-right">
                            <input type="submit" name="back" value="Quay lại" class="btn btn-secondary shadow">
                            <input type="submit" name="edit" value="Sửa" class="btn btn-primary shadow">
                        </div>
                        
                    </form>
                    <?php
                    if (isset($updateCate)) {
                        echo $updateCate;
                    }
                    ?>
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