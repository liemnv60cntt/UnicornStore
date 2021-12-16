<?php
include "./includes/sidebar_topbar.php";
include '../classes/brand.php';
include '../classes/category.php';
?>
<?php
    $brand = new Brand();
    $deleteID = (isset($_GET['deleteID']) && $_GET['deleteID']!=null) ? $_GET['deleteID'] : '';
    if($deleteID != '')
        $deleteBrand = $brand->delete_brand($deleteID);
    
?>
<h1 class="h3 mb-4 text-gray-800">Thương hiệu sản phẩm</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách các thương hiệu sản phẩm</h6>
    </div>
    <div class="card-body">
        <?php
            if (isset($deleteBrand)) {
                echo $deleteBrand;
            }
        ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID &nbsp;&nbsp;</th>
                        <th>Tên thương hiệu</th>
                        <th>Tên danh mục</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>ID &nbsp;&nbsp;</th>
                        <th>Tên thương hiệu</th>
                        <th>Tên danh mục</th>
                        <th>Chức năng</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        $show_brand = $brand->show_brand();
                        if($show_brand){
                            $i = 0;
                            while($result = $show_brand->fetch_assoc()){
                                $i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['brandID'] ?></td>
                        <td><?php echo $result['brandName'] ?></td>
                        <td><?php 
                            $cate = new Category();
                            $get_cate = $cate->get_cate_byID($result['cateID']);
                            $result_cate = $get_cate->fetch_assoc();
                            echo $result_cate['cateName'] ;
                        ?></td>
                        <td>
                            <a href="brand_edit.php?brandID=<?php echo $result['brandID'] ?>">
                                <button class="btn btn-warning p-1 shadow" style="color: black;">
                                    <i class='far fa-edit'> Sửa</i>
                                </button>
                            </a>  || 
                            <a href="?deleteID=<?php echo $result['brandID'] ?>" onclick = "return confirm('Bạn có chắc chắn muốn xóa?')">
                                <button class="btn btn-danger p-1 shadow">
                                    <i class='far fa-trash-alt'> Xóa</i>
                                </button>
                            </a> 
                        </td>
                    </tr>
                    <?php
					        }
					    }
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>







<?php
include "./includes/footer.php";
?>