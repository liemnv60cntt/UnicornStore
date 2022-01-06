        <!-- Carousel -->
        <div id="demo" class="carousel slide" data-bs-ride="carousel">

            <!-- Indicators/dots -->
            <div class="carousel-indicators">
                <?php
                $get_slider = $prod->show_slider();
                $i=0;
                if ($get_slider) {
                    while ($result = $get_slider->fetch_assoc()) {

                ?>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="<?php echo $i ?>" class="<?php if ($result['sliderStatus'] == 0) echo "active"; ?>"></button>
                <?php
                    $i++;
                    }
                }
                ?>
            </div>

            <!-- The slideshow/carousel -->
            <div class="carousel-inner shadow" style="border-radius: 0.6em;">
                <?php
                $get_slider = $prod->show_slider();
                if ($get_slider) {
                    while ($result = $get_slider->fetch_assoc()) {

                ?>
                        <div class="carousel-item <?php if ($result['sliderStatus'] == 0) echo "active"; ?>">
                            <img src="./images/slide_img/<?php echo $result['sliderImage'] ?>" alt="Slide" class="d-block" style="width:100%; max-height: 34em;">
                        </div>
                <?php
                    }
                }
                ?>
            </div>

            <!-- Left and right controls/icons -->
            <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>