<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>

<?php
	/**
	 * 
	 */
	class ProductReview
	{
		private $db;
		private $fm;
		
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function insert_review($customerID, $productID, $rating, $review, $ratingTime){
            $customerID = mysqli_real_escape_string($this->db->link, $customerID);
            $productID = mysqli_real_escape_string($this->db->link, $productID);
            $rating = mysqli_real_escape_string($this->db->link, $rating);
            $review = $this->fm->validation($review);
            $review = mysqli_real_escape_string($this->db->link, $review);
            $ratingTime = mysqli_real_escape_string($this->db->link, $ratingTime);

            $query = "INSERT INTO product_review 
            (customerID, productID, rating, review, ratingTime) 
            VALUES ('$customerID', '$productID', '$rating', '$review', '$ratingTime')";
			$result = $this->db->insert($query);
            if($result){
                return true;
            }else{
                return false;
            }
        }
        public function get_review($productID){
			$query = "SELECT product_review.*, customer.customerName FROM product_review, customer 
            WHERE product_review.customerID = customer.customerID and product_review.productID = '$productID'
            ORDER BY reviewID DESC";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_all_review(){
			$query = "SELECT product_review.*, customer.customerName, product.productName, product.image_1 
			FROM product_review, customer, product 
            WHERE product_review.customerID = customer.customerID 
				AND product_review.productID = product.productID
            ORDER BY reviewID DESC";
			$result = $this->db->select($query);
			return $result;
		}
		


	}
?>