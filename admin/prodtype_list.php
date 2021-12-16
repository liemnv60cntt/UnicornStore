<?php
include "./includes/sidebar_topbar.php";
include '../classes/producttype.php';
include '../classes/category.php';
?>
<?php
    $type = new ProductType();
    $deleteID = (isset($_GET['deleteID']) && $_GET['deleteID']!=null) ? $_GET['deleteID'] : '';
    if($deleteID != '')
        $deleteType = $type->delete_type($deleteID);
    
?>
<h1 class="h3 mb-4 text-gray-800">Loại sản phẩm</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách các loại sản phẩm</h6>
    </div>
    <div class="card-body">
        <?php
            if (isset($deleteType)) {
                echo $deleteType;
            }
        ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID &nbsp;&nbsp;</th>
                        <th>Tên loại</th>
                        <th>Tên danh mục</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>ID &nbsp;&nbsp;</th>
                        <th>Tên loại</th>
                        <th>Tên danh mục</th>
                        <th>Chức năng</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        $show_type = $type->show_type();
                        if($show_type){
                            $i = 0;
                            while($result = $show_type->fetch_assoc()){
                                $i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['typeID'] ?></td>
                        <td><?php echo $result['typeName'] ?></td>
                        <td><?php 
                            $cate = new Category();
                            $get_cate = $cate->get_cate_byID($result['cateID']);
                            $result_cate = $get_cate->fetch_assoc();
                            echo $result_cate['cateName'] ;
                        ?></td>
                        <td>
                            <a href="prodtype_edit.php?typeID=<?php echo $result['typeID'] ?>">
                                <button class="btn btn-warning p-1 shadow" style="color: black;">
                                    <i class='far fa-edit'> Sửa</i>
                                </button>
                            </a>  || 
                            <a href="?deleteID=<?php echo $result['typeID'] ?>" onclick = "return confirm('Bạn có chắc chắn muốn xóa?')">
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