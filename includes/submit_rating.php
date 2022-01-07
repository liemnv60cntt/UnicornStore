<?php
//submit_rating.php

include_once "../classes/productreview.php";
include_once "../classes/product.php";

$prodreview = new ProductReview();
$prod = new Product();

if(isset($_POST["rating_data"])){
    
	$customerID	=	$_POST["customer_ID"];
	$productID	=	$_POST["product_ID"];
	$rating		=	$_POST["rating_data"];
	$review		=	$_POST["review"];
	$ratingTime	=	time();
	$insert_review = $prodreview->insert_review($customerID, $productID, $rating, $review, $ratingTime);
	$update_rating_status = $prod->submit_user_rating($customerID, $productID);
    
}
date_default_timezone_set('Asia/Ho_Chi_Minh');
if(isset($_POST["action"])){
	$average_rating = 0;
	$total_review = 0;
	$five_star_review = 0;
	$four_star_review = 0;
	$three_star_review = 0;
	$two_star_review = 0;
	$one_star_review = 0;
	$total_user_rating = 0;
	$review_content = array();
	session_start();
	
	$show_review = $prodreview->get_review($_SESSION['prodID']);
	if($show_review){
		while($row = $show_review->fetch_assoc()){
			$review_content[] = array(
				'customerName'		=>	$row["customerName"],
				'review'			=>	$row["review"],
				'rating'			=>	$row["rating"],
				'ratingTime'		=>	date('H:i, d-m-Y', $row["ratingTime"])
			);
			if($row["rating"] == '5')
			{
				$five_star_review++;
			}
	
			if($row["rating"] == '4')
			{
				$four_star_review++;
			}
	
			if($row["rating"] == '3')
			{
				$three_star_review++;
			}
	
			if($row["rating"] == '2')
			{
				$two_star_review++;
			}
	
			if($row["rating"] == '1')
			{
				$one_star_review++;
			}
	
			$total_review++;
			$total_user_rating = $total_user_rating + $row["rating"];
		}
	}

	
	$average_rating = $total_user_rating / $total_review;
	$output = array(
		'average_rating'	=>	number_format($average_rating, 1),
		'total_review'		=>	$total_review,
		'five_star_review'	=>	$five_star_review,
		'four_star_review'	=>	$four_star_review,
		'three_star_review'	=>	$three_star_review,
		'two_star_review'	=>	$two_star_review,
		'one_star_review'	=>	$one_star_review,
		'review_data'		=>	$review_content
	);
	echo json_encode($output);
}


?>