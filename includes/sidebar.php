
<nav id="sidebar" class="collapse show">
    <div class="p-4 pt-1">
        <h5>Danh mục sản phẩm</h5>
        <ul class="list-unstyled components mb-3">
            <?php
                $i = 0;
                $cate_list = $cate->show_category();
                if($cate_list){
                    while($result_cate = $cate_list->fetch_assoc()){
                        $prodtype_list = $prodtype->show_type_by_cate($result_cate['cateID']);
                            ?>
                                <li>
                                <a href="#pageSubmenu<?php echo $i ?>" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-toggle-sidebar"><?php echo $result_cate['cateName'] ?></a>
                                <ul class="collapse list-unstyled" id="pageSubmenu<?php echo $i ?>">
                            <?php
                        if($prodtype_list){
                            while($result_type = $prodtype_list->fetch_assoc()){
                                ?>
                                <li><a href="search_by_type.php?typeID=<?php echo $result_type['typeID'] ?>" class="type-list"><span class="fa fa-chevron-right mr-2"></span> <?php echo $result_type['typeName'] ?></a></li>
                                <?php
                            }
                        }
                        ?>
                        </ul>
                        </li>
                        <?php
                        $i++;
                    }
                }
            ?>
            <!-- <li>
                <a href="#pageSubmenu1" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-toggle-sidebar">Linh kiện máy tính</a>
                <ul class="collapse list-unstyled" id="pageSubmenu1">
                    <li><a href="#"><span class="fa fa-chevron-right mr-2"></span> Casual</a></li>
                    <li><a href="#"><span class="fa fa-chevron-right mr-2"></span> Football</a></li>
                    <li><a href="#"><span class="fa fa-chevron-right mr-2"></span> Jordan</a></li>
                    <li><a href="#"><span class="fa fa-chevron-right mr-2"></span> Lifestyle</a></li>
                    <li><a href="#"><span class="fa fa-chevron-right mr-2"></span> Running</a></li>
                    <li><a href="#"><span class="fa fa-chevron-right mr-2"></span> Soccer</a></li>
                    <li><a href="#"><span class="fa fa-chevron-right mr-2"></span> Sports</a></li>
                </ul>
            </li> -->
    
        </ul>
        <div class="mb-3">
            <h5>Gợi ý cho bạn</h5>
            <div class="tagcloud">
                <a href="search_by_status.php?productStatus=0" class="shadow-sm">Mới ra mắt</a>
                <a href="search_by_status.php?productStatus=1" class="shadow-sm">Nổi bật</a>
                <a href="search_by_status.php?productStatus=2" class="shadow-sm">Bán chạy</a>
                <a href="search_by_status.php?productStatus=3" class="shadow-sm">Đang khuyến mãi</a>
                <a href="search_by_status.php?productStatus=4" class="shadow-sm">Giảm giá sốc</a>
                <a href="search_by_status.php?productStatus=5" class="shadow-sm">Hàng sắp về</a>
            </div>
        </div>
        

    </div>
</nav>