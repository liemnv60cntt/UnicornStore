<?php
include "./includes/sidebar_topbar.php";
include '../classes/product.php';
?>
<?php
$prod = new Product();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $insertSlider = $prod->insert_slider($_POST, $_FILES);
}
?>
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Thêm slider</h1>

<div class="card mb-4 py-3 border-bottom-primary shadow">
    <div class="card-body">
        <div class="mb-3">

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3 col-12">
                    </div>
                    <div class="col-md-6 col-12">
                        <?php
                        if (isset($insertSlider)) {
                            echo $insertSlider['mess'];
                        }
                        ?>
                    </div>
                    <div class="col-md-3 col-12">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-12">
                        <label for="inputTitle" class="form-label ml-md-5">Tiêu đề:</label>
                    </div>
                    <div class="col-md-6 col-12">
                        <input class="form-control w-100 mb-3" name="sliderName" type="text" id="inputTitle" placeholder="Vui lòng nhập tiêu đề..." value="<?php if (isset($_POST['sliderName'])) echo $_POST['sliderName']; ?>">
                    </div>
                    <div class="col-md-3 col-12">
                        <?php
                        if (isset($insertSlider)) {
                            echo "<span class='text-danger'>";
                            echo $insertSlider['sliderName'];
                            echo "<span>";
                        }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-12">
                        <label for="selectStatus" class="form-label ml-md-5">Trạng thái:</label>
                    </div>
                    <div class="col-md-6 col-12">
                        <select id="selectStatus" name="sliderStatus" class="form-control mb-3">
                            <option value="N">-----Chọn trạng thái-----</option>
                            <option value="0" <?php
                                                if (isset($_POST['sliderStatus']) && $_POST['sliderStatus'] == '0')
                                                    echo "selected";
                                                ?>>Sử dụng chính</option>
                            <option value="1" <?php
                                                if (isset($_POST['sliderStatus']) && $_POST['sliderStatus'] == '1')
                                                    echo "selected";
                                                ?>>Sử dụng</option>
                            <option value="2" <?php
                                                if (isset($_POST['sliderStatus']) && $_POST['sliderStatus'] == '2')
                                                    echo "selected";
                                                ?>>Không sử dụng</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-12">
                        <?php
                        if (isset($insertSlider)) {
                            echo "<span class='text-danger'>";
                            echo $insertSlider['sliderStatus'];
                            echo "<span>";
                        }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-12">
                        <label for="inputImage1" class="form-label ml-md-5">Ảnh:</label>
                    </div>
                    <div class="col-md-6 col-12">
                        <input class="form-control-file w-100 mb-3" name="sliderImage" type="file" id="inputImage1">
                        <?php
                        if (isset($_FILES['sliderImage']) && $_FILES['sliderImage']['name'] != "")
                            echo '<input class="border-0 mb-3 w-100" readonly type="text" name="sliderImage_old" value="' . $_FILES['sliderImage']['name'] . '">';
                        ?>

                    </div>
                    <div class="col-md-3 col-12">
                        <?php
                        if (isset($insertSlider)) {
                            echo "<span class='text-danger'>";
                            echo $insertSlider['sliderImage'];
                            echo "<span>";
                        }
                        ?>
                    </div>
                </div>


                <?php
                $image_01 = "";
                if (isset($_FILES['sliderImage']) && isset($insertSlider)) {
                    if ($insertSlider['success'] == 1) {
                        $image_01 = $_FILES['sliderImage']['name'];
                        echo '<div class="row">
                                    <div class="col-md-3 col-12">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <img src="../images/slide_img/' . $image_01 . '" alt="..." style="width: 100%;" class="shadow mb-3 mr-2 rounded">
                                        <h6><b>Ảnh: </b>' . $image_01 . '</h6>
                                    </div>
                                    <div class="col-md-3 col-12">
                                    </div>
                                </div>';
                    }
                }
                ?>

                <div class="d-flex justify-content-center mt-3">
                    <a href="slider_add.php" class="btn btn-secondary shadow mr-2">Làm mới</a>
                    <input type="submit" name="add" value="Thêm" class="btn btn-primary shadow">
                </div>


            </form>


        </div>
    </div>
</div>


<?php
include "./includes/footer.php";
?>