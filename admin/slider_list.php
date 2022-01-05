<?php
include "./includes/sidebar_topbar.php";
include '../classes/product.php';
include_once '../helpers/format.php'
?>
<?php
$fmt = new Format();
$prod = new Product();
$deleteID = (isset($_GET['deleteID']) && $_GET['deleteID'] != null) ? $_GET['deleteID'] : '';
if ($deleteID != '')
    $deleteSlide = $prod->delete_slider($deleteID);

?>
<h1 class="h3 mb-4 text-gray-800">Slider</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách slider</h6>
    </div>
    <div class="card-body">
        <?php
        if (isset($deleteSlide)) {
            echo $deleteSlide;
        }
        ?>
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Ảnh</th>
                        <th>Trạng thái</th>
                        <th style="width: 8em;">Chức năng</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Ảnh</th>
                        <th>Trạng thái</th>
                        <th style="width: 8em;">Chức năng</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $show_slider = $prod->show_slider_list();
                    if ($show_slider) {
                        $i = 0;
                        while ($result = $show_slider->fetch_assoc()) {
                            $i++;
                    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $fmt->textShorten($result['sliderName'], 50) ?></td>
                                <td class="py-1">
                                    <img class="rounded" src="../images/slide_img/<?php echo $result['sliderImage'] ?>" alt="..." style="max-width: 30em;max-height: 10em;">
                                </td>
                                <td><?php
                                    switch ($result['sliderStatus']) {
                                        case 0:
                                            echo "<span class='badge badge-primary p-2'>Sử dụng chính</span>";
                                            break;
                                        case 1:
                                            echo "<span class='badge badge-success p-2'>Sử dụng</span";
                                            break;
                                        case 2:
                                            echo "<span class='badge badge-secondary p-2'>Không sử dụng</span";
                                            break;
                                    }
                                    ?></td>
                                
                                <td>
                                    <div class="d-flex justify-content-center mt-4">
                                        <a href="slider_edit.php?sliderID=<?php echo $result['sliderID'] ?>">
                                            <button class="btn btn-warning p-1 mr-2 shadow" style="color: black;" title="Sửa">
                                                <i class='far fa-edit'></i>
                                            </button>
                                        </a>
                                        <a href="?deleteID=<?php echo $result['sliderID'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            <button class="btn btn-danger p-1 shadow" title="Xóa">
                                                <i class='far fa-trash-alt'></i>
                                            </button>
                                        </a>
                                    </div>
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