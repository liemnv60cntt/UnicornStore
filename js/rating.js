$(document).ready(function() {
    var rating_data = 0;

    //Hiển thị modal
    $('#add_review').click(function() {
        $('#review_modal').modal('show');
    });

    //Thiết lập sự kiện rê chuột vào star thì đổi màu
    $(document).on('mouseenter', '.submit_star', function() {
        var rating = $(this).data('rating');
        reset_background();
        for (var count = 1; count <= rating; count++) {
            $('#submit_star_' + count).addClass('text-warning');
        }
    });
    //Hàm reset star thành màu star light
    function reset_background() {
        for (var count = 1; count <= 5; count++) {
            $('#submit_star_' + count).addClass('star-light');
            $('#submit_star_' + count).removeClass('text-warning');
        }
    }
    //Thiết lập sự kiện khi rời chuột khỏi star
    $(document).on('mouseleave', '.submit_star', function() {
        reset_background();
        for (var count = 1; count <= rating_data; count++) {

            $('#submit_star_' + count).removeClass('star-light');

            $('#submit_star_' + count).addClass('text-warning');
        }
    });
    //Thiết lập sự kiện submit star
    $(document).on('click', '.submit_star', function() {
        rating_data = $(this).data('rating');

    });
    //Thiết lập sự kiện nút save
    $('#save_review').click(function() {
        var customer_ID = $('#customer_ID').val();
        var product_ID = $('#product_ID').val();
        var review = $('#review').val();
        if (review == '' || customer_ID == '' || product_ID =='') {
            alert("Vui lòng nhập đầy đủ thông tin!");
            return false;
        } else {
            $.ajax({
                url: "submit_rating.php",
                method: "POST",
                data: {
                    rating_data: rating_data,
                    customer_ID: customer_ID,
                    product_ID: product_ID,
                    review: review
                },
                success: function(data) {
                    $('#review_modal').modal('hide');
                    load_rating_data();
                    alert(data);
                }
            });
        }

    });
    load_rating_data();

    function load_rating_data() {
        $.ajax({
            url: "submit_rating.php",
            method: "POST",
            data: {
                action: 'load_data'
            },
            dataType: "JSON",
            success: function(data) {
                //Hiển thị điểm trung bình và tổng số review
                $('.average_rating').text(data.average_rating);
                $('.total_review').text(data.total_review);

                //Hiển thị màu 5 star theo điểm trung bình
                var count_star = 0;
                $('.main_star').each(function() {
                    count_star++;
                    if (Math.ceil(data.average_rating) >= count_star) {
                        $(this).addClass('text-warning');
                    }else{
                        $(this).removeClass('text-warning');
                    }
                });
                
                //Hiển thị số review theo từng loại star
                $('#total_five_star_review').text(data.five_star_review);

                $('#total_four_star_review').text(data.four_star_review);

                $('#total_three_star_review').text(data.three_star_review);

                $('#total_two_star_review').text(data.two_star_review);

                $('#total_one_star_review').text(data.one_star_review);
                //Hiển thị số review trên thanh progress bar
                $('#five_star_progress').css('width', (data.five_star_review / data.total_review) * 100 + '%');

                $('#four_star_progress').css('width', (data.four_star_review / data.total_review) * 100 + '%');

                $('#three_star_progress').css('width', (data.three_star_review / data.total_review) * 100 + '%');

                $('#two_star_progress').css('width', (data.two_star_review / data.total_review) * 100 + '%');

                $('#one_star_progress').css('width', (data.one_star_review / data.total_review) * 100 + '%');
                //Hiển thị nội dung review của từng user
                if (data.review_data.length > 0) {
                    var html = '';

                    for (var count = 0; count < data.review_data.length; count++) {
                        html += '<div class="row mb-3 px-sm-5">';

                        html += '<div class="col-sm-1 col-2"><div class="rounded-circle bg-danger text-white pt-2 pb-2"><h3 class="text-center">' + data.review_data[count].customerName.charAt(0) + '</h3></div></div>';

                        html += '<div class="col-sm-11 col-10">';

                        html += '<div class="card">';

                        html += '<div class="card-header"><b>' + data.review_data[count].customerName + '</b></div>';

                        html += '<div class="card-body">';

                        for (var star = 1; star <= 5; star++) {
                            var class_name = '';

                            if (data.review_data[count].rating >= star) {
                                class_name = 'text-warning';
                            } else {
                                class_name = 'star-light';
                            }

                            html += '<i class="fas fa-star ' + class_name + ' mr-1"></i>';
                        }

                        html += '<br />';

                        html += data.review_data[count].review;

                        html += '</div>';

                        html += '<div class="card-footer text-end">' + data.review_data[count].ratingTime + '</div>';

                        html += '</div>';

                        html += '</div>';

                        html += '</div>';
                    }

                    $('#review_content').html(html);
                }
                //Hiển thị màu 5 star theo điểm trung bình
                var _html = '';
                _html += '<div>';
                for (var star = 1; star <= 5; star++) {
                    var class_name = '';

                    if (Math.ceil(data.average_rating) >= star) {
                        class_name = 'text-warning';
                    } else {
                        class_name = 'star-light';
                    }

                    _html += '<i class="fas fa-star ' + class_name + ' mr-1"></i>';
                }
                _html += '</div>';
                $('.show_star').html(_html);
            }
        });
    }
});