<?php
//submit_rating.php
// $connect = new PDO("mysql:host=localhost;dbname=unicorn_database", "root", "");

include_once "../classes/productreview.php";

$prodreview = new ProductReview();

if(isset($_POST["rating_data"])){
    // $data = array(
	// 	':customerID'		=>	$_POST["customer_ID"],
	// 	':productID'		=>	$_POST["product_ID"],
	// 	':rating'		=>	$_POST["rating_data"],
	// 	':review'		=>	$_POST["review"],
	// 	':ratingTime'			=>	time()
	// );
    // $query = "
	// INSERT INTO product_review 
	// (customerID, productID, rating, review, ratingTime) 
	// VALUES (:customerID, :productID, :rating, :review, :ratingTime)
	// ";
    // //Thực hiện truy vấn và lưu vào database
    // $statement = $connect->prepare($query);
	// $statement->execute($data);
	$customerID	=	$_POST["customer_ID"];
	$productID	=	$_POST["product_ID"];
	$rating		=	$_POST["rating_data"];
	$review		=	$_POST["review"];
	$ratingTime	=	time();
	$insert_review = $prodreview->insert_review($customerID, $productID, $rating, $review, $ratingTime);
    // if($insert_review)
    // 	echo "Đánh giá sản phẩm thành công!";
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
	// $query = "
	// SELECT product_review.*, customer.customerName FROM product_review, customer 
	// WHERE product_review.customerID = customer.customerID and product_review.productID = ".$_SESSION['prodID']."
	// ORDER BY reviewID DESC
	// ";
	// $result = $connect->query($query, PDO::FETCH_ASSOC);
	$show_review = $prodreview->get_review($_SESSION['prodID']);
	if($show_review){
		while($row = $show_review->fetch_assoc()){
			$review_content[] = array(
				'customerName'		=>	$row["customerName"],
				'review'			=>	$row["review"],
				'rating'			=>	$row["rating"],
				'ratingTime'		=>	date('l jS, F Y h:i:s A', $row["ratingTime"])
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

	// foreach($result as $row){
	// 	$review_content[] = array(
	// 		'customerName'		=>	$row["customerName"],
	// 		'review'			=>	$row["review"],
	// 		'rating'			=>	$row["rating"],
	// 		'ratingTime'		=>	date('l jS, F Y h:i:s A', $row["ratingTime"])
	// 	);
	// 	if($row["rating"] == '5')
	// 	{
	// 		$five_star_review++;
	// 	}

	// 	if($row["rating"] == '4')
	// 	{
	// 		$four_star_review++;
	// 	}

	// 	if($row["rating"] == '3')
	// 	{
	// 		$three_star_review++;
	// 	}

	// 	if($row["rating"] == '2')
	// 	{
	// 		$two_star_review++;
	// 	}

	// 	if($row["rating"] == '1')
	// 	{
	// 		$one_star_review++;
	// 	}

	// 	$total_review++;
	// 	$total_user_rating = $total_user_rating + $row["rating"];
	// }
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