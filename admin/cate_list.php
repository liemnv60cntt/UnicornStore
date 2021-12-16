<?php
include "./includes/sidebar_topbar.php";
include '../classes/category.php';
?>
<?php
    $cate = new Category();
    $deleteID = (isset($_GET['deleteID']) && $_GET['deleteID']!=null) ? $_GET['deleteID'] : '';
    if($deleteID != '')
        $deleteCate = $cate->delete_category($deleteID);
    
?>
<h1 class="h3 mb-4 text-gray-800">Danh mục sản phẩm</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách các danh mục sản phẩm</h6>
    </div>
    <div class="card-body">
        <?php
            if (isset($deleteCate)) {
                echo $deleteCate;
            }
        ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID &nbsp;&nbsp;</th>
                        <th>Tên danh mục</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>ID &nbsp;&nbsp;</th>
                        <th>Tên danh mục</th>
                        <th>Chức năng</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        $show_cate = $cate->show_category();
                        if($show_cate){
                            $i = 0;
                            while($result = $show_cate->fetch_assoc()){
                                $i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['cateID'] ?></td>
                        <td><?php echo $result['cateName'] ?></td>
                        <td>
                            <a href="cate_edit.php?cateID=<?php echo $result['cateID'] ?>">
                                <button class="btn btn-warning p-1 shadow" style="color: black;">
                                    <i class='far fa-edit'> Sửa</i>
                                </button>
                            </a>  || 
                            <a href="?deleteID=<?php echo $result['cateID'] ?>" onclick = "return confirm('Bạn có chắc chắn muốn xóa?')">
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