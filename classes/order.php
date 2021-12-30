
<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>

<?php
	/**
	 * 
	 */
	class Order
	{
		private $db;
		private $fm;
		
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function get_order_detail_by_id($orderID){
			$query = "SELECT * FROM order_details
					 WHERE orderID = '$orderID'
			 		";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_all_order($customerID){
			$query = "SELECT * FROM orders WHERE customerID = '$customerID' ORDER BY orderID desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function count_all_order($customerID){
			$query = "SELECT COUNT(orderID) AS c FROM orders WHERE customerID = '$customerID'";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_order_by_status($customerID, $orderStatus){
			$query = "SELECT * FROM orders 
					WHERE customerID = '$customerID' AND orderStatus = '$orderStatus'
					 ORDER BY orderID desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function count_order_by_status($customerID, $orderStatus){
			$query = "SELECT COUNT(orderID) AS c FROM orders 
					WHERE customerID = '$customerID' AND orderStatus = '$orderStatus'";
			$result = $this->db->select($query);
			return $result;
		}
		public function count_order_details_by_status($orderID, $orderStatus){
			$query = "SELECT COUNT(order_details.orderID) AS c1 FROM `orders`,`order_details` 
					WHERE orders.orderID = order_details.orderID 
						AND orders.orderID = '$orderID' 
						AND orders.orderStatus = '$orderStatus'";
			$result = $this->db->select($query);
			return $result;
		}
		public function count_rating_status($orderID){
			$query = "SELECT COUNT(order_details.orderID) AS c2
				FROM `orders`,`order_details` 
				WHERE orders.orderID = order_details.orderID
					 AND order_details.ratingStatus = '1' AND orders.orderID = '$orderID'";
			$result = $this->db->select($query);
			return $result;
		}
		public function check_order_rating($orderID){
			$count_order = self::count_order_details_by_status($orderID, 3);
			if($count_order)
				$result_count_order = $count_order->fetch_assoc();
			$count_rating_status = self::count_rating_status($orderID);
			if($count_rating_status)
				$result_count_rating_status = $count_rating_status->fetch_assoc();
			if($result_count_order['c1']!=0 && $result_count_rating_status['c2']!=0){
				if($result_count_order['c1'] == $result_count_rating_status['c2'])
					return true;
				else
					return false;
			}else{
				return false;
			}	
		}
		public function check_active($active, $orderID){
			$get_order = self::get_order_by_id($orderID);
			if($get_order)
				$result = $get_order->fetch_assoc();
			switch($active){
				case 1:
					if($result['orderStatus']>=0 && $result['orderStatus']!=4)
						return 'active';
					else
						return;
				case 2:
					if($result['orderStatus']>=1 && $result['orderStatus']!=4)
						return 'active';
					else
						return;
				case 3:
					if($result['orderStatus']>=2 && $result['orderStatus']!=4)
						return 'active';
					else
						return;
				case 4:
					if($result['orderStatus']>=3 && $result['orderStatus']!=4)
						return 'active';
					else
						return;
				case 5:
					if($result['orderStatus']==4)
						return 'active';
					else
						return;
			}
		}
		public function get_order_by_id($id){
			$query = "SELECT * FROM orders WHERE orderID = '$id'";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_order_id(){
			$query = "SELECT orderID FROM orders order by orderID desc LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_new_order_id(){
			$get_id = self::get_order_id();
			if($get_id){
				$result = $get_id->fetch_assoc();
			}
			$spit_id_start = substr($result['orderID'], 0, 8);
			$spit_id_end = (int) substr($result['orderID'], 8);
			$spit_id_end++;
			$final_id = $spit_id_start . $spit_id_end;
			return $final_id;
		}
		public function insertOrder($data, $customerID){
			$orderID = mysqli_real_escape_string($this->db->link, $data['orderID']);
			$orderPrice = mysqli_real_escape_string($this->db->link, $data['orderPrice']);
			$customerNote = mysqli_real_escape_string($this->db->link, $data['note']);
			$alert = [];
			if($orderID=="" || $orderPrice=="" || $customerID==""){
				$alert['mess'] = "<span class='text-danger'>Đặt hàng không thành công!</span>";
				$alert['error'] = 1;
				return $alert;
			}else{
				$query = "INSERT INTO orders(orderID,customerID,orderPrice,customerNote) 
				VALUES('$orderID','$customerID','$orderPrice','$customerNote')";
				$result = $this->db->insert($query);
				if($result){
					$alert['mess'] = "<span class='text-success'>Đặt hàng thành công!</span>";
					$alert['error'] = 0;
					return $alert;
				}else{
					$alert['mess'] = "<span class='text-danger'>Đặt hàng không thành công!</span>";
					$alert['error'] = 1;
					return $alert;
				}
			}
		}
		public function insertOrderDetail($orderID, $productID, $quantity, $totalPrice){
			$orderID = mysqli_real_escape_string($this->db->link, $orderID);
			$productID = mysqli_real_escape_string($this->db->link, $productID);
			$quantity = mysqli_real_escape_string($this->db->link, $quantity);
			$totalPrice = mysqli_real_escape_string($this->db->link, $totalPrice);
			$alert = [];
			if($orderID=="" || $productID=="" || $quantity=="" || $totalPrice==""){
				$alert['mess'] = "<span class='text-danger'>Đặt hàng không thành công!!!</span>";
				$alert['error'] = 1;
				return $alert;
			}else{
				$query = "INSERT INTO order_details(orderID,productID,quantity,totalPrice) 
				VALUES('$orderID','$productID','$quantity','$totalPrice')";
				$result = $this->db->insert($query);
				if($result){
					$alert['mess'] = "<span class='text-success'>Đặt hàng thành công!!!</span>";
					$alert['error'] = 0;
					return $alert;
				}else{
					$alert['mess'] = "<span class='text-danger'>Đặt hàng không thành công!!!</span>";
					$alert['error'] = 1;
					return $alert;
				}
			}


		}
		public function status_convert($orderStatus){
			$status = "";
			switch($orderStatus){
				case 0:
					$status = "Chờ xác nhận";
					break;
				case 1:
					$status = "Đang chuẩn bị hàng";
					break;
				case 2:
					$status = "Đang giao hàng";
					break;
				case 3:
					$status = "Đã giao";
					break;
				case 4:
					$status = "Đã hủy";
					break;
			}
			return $status;
		}
		public function status_bg($orderStatus){
			$bg = "";
			switch($orderStatus){
				case 0:
					$bg = "bg-secondary";
					break;
				case 1:
					$bg = "bg-warning";
					break;
				case 2:
					$bg = "bg-primary";
					break;
				case 3:
					$bg = "bg-success";
					break;
				case 4:
					$bg = "bg-danger";
					break;
			}
			return $bg;
		}
		public function get_shipping_fee($subPrice){
			$shipping_fee = 0;
			if($subPrice <= 200000){
				$shipping_fee = 45000;
			}
			elseif($subPrice > 200000 && $subPrice <= 500000){
				$shipping_fee = 15000;
			}
			else{
				$shipping_fee = 0;
			}
			return $shipping_fee;
		}
		

		
		
		


	}
?>