<?php
$average_rating = 0;
$total_review = 0;
$total_user_rating = 0;
$review_content = array();
$load_rating = $prod->get_rating($prodID);
if ($load_rating) {
    while ($result_rating = $load_rating->fetch_assoc()) {
        $review_content[] = array(
            'rating'    =>    $result_rating["rating"],
        );
        $total_review++;
        $total_user_rating = $total_user_rating + $result_rating["rating"];
    }
    $average_rating = $total_user_rating / $total_review;
}

$html = '';
for ($star = 1; $star <= 5; $star++) {
    $class_name = '';
    if (ceil($average_rating) >= $star) {
        $class_name = 'text-warning';
    } else {
        $class_name = 'star-light';
    }
    $html .= "<i class='fas fa-star $class_name mr-1'></i>";
}
echo $html;
?>
