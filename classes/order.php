
<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
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
	public function year_revenue()
	{
		$year = date("Y");
		$sum = 0;
		$query = "SELECT * FROM `orders` WHERE orderStatus = '3' AND YEAR(updateTime) = $year";
		$result = $this->db->select($query);
		if($result){
			while($rs = $result->fetch_assoc()){
				$sum += $rs['orderPrice'];
			}
		}
		return $sum;
	}
	public function month_revenue()
	{
		$month = date("m");
		$sum = 0;
		$query = "SELECT * FROM `orders` WHERE orderStatus = '3' AND MONTH(updateTime) = $month";
		$result = $this->db->select($query);
		if($result){
			while($rs = $result->fetch_assoc()){
				$sum += $rs['orderPrice'];
			}
		}
		return $sum;
	}
	public function sum_revenue($startDate, $lastDate, $orderStatus)
	{
		$sum = 0;
		$orderStatistic = self::order_statistic($startDate, $lastDate, $orderStatus);
		if ($orderStatistic != false) {
			while ($result = $orderStatistic->fetch_assoc()) {
				$sum += $result['orderPrice'];
			}
		}
		return $sum;
	}
	public function order_statistic($startDate, $lastDate, $orderStatus)
	{

		$start_cv = strtotime($startDate);
		$start_date = date("Y-m-d", $start_cv);
		$last_cv = strtotime($lastDate);
		//Cộng thêm 1 ngày
		$last_date_plus = mktime(0, 0, 0, date("m", $last_cv), date("d", $last_cv) + 1, date("y", $last_cv));
		$last_date = date("Y-m-d", $last_date_plus);

		if ($start_cv < $last_cv) {
			$query = "SELECT * FROM `orders` WHERE orderStatus = '$orderStatus' AND updateTime BETWEEN CAST('$start_date' AS DATE) AND CAST('$last_date' AS DATE) ORDER BY updateTime DESC;";
			$result = $this->db->select($query);
			return $result;
		} else {
			return false;
		}
	}
	public function show_all_order()
	{
		$query = "SELECT * FROM orders ORDER BY orderDate desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function check_sold($productID)
	{	
		$sold = 0;
		$query_order = "SELECT orderID FROM orders 
					WHERE orderStatus = '3'";
		$result_order = $this->db->select($query_order);
		if($result_order){
			while($rs_order = $result_order->fetch_assoc()){
				$query = "SELECT quantity FROM order_details
					 WHERE productID = '$productID' AND orderID = '".$rs_order['orderID']."'";
				$result = $this->db->select($query);
				if($result){
					while($rs = $result->fetch_assoc()){
						$sold += $rs['quantity'];
					}
				}
			}
		}
		return $sold;
	}
	public function get_order_detail_by_id($orderID)
	{
		$query = "SELECT * FROM order_details
					 WHERE orderID = '$orderID'
			 		";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_all_order($customerID)
	{
		$query = "SELECT * FROM orders WHERE customerID = '$customerID' ORDER BY orderDate desc";
		$result = $this->db->select($query);
		return $result;
	}
	
	public function count_all_order($customerID)
	{
		$query = "SELECT COUNT(orderID) AS c FROM orders WHERE customerID = '$customerID'";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_order_by_status($customerID, $orderStatus)
	{
		$query = "SELECT * FROM orders 
					WHERE customerID = '$customerID' AND orderStatus = '$orderStatus'
					 ORDER BY orderDate desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function count_all_order_by_status($orderStatus)
	{
		$query = "SELECT COUNT(orderID) AS c FROM orders 
					WHERE orderStatus = '$orderStatus'";
		$result = $this->db->select($query);
		if ($result) {
			$rs = $result->fetch_assoc();
			return $rs['c'];
		} else
			return 0;
	}
	public function count_order_by_status($customerID, $orderStatus)
	{
		$query = "SELECT COUNT(orderID) AS c FROM orders 
					WHERE customerID = '$customerID' AND orderStatus = '$orderStatus'";
		$result = $this->db->select($query);
		return $result;
	}
	public function count_order_details_by_status($orderID, $orderStatus)
	{
		$query = "SELECT COUNT(order_details.orderID) AS c1 FROM `orders`,`order_details` 
					WHERE orders.orderID = order_details.orderID 
						AND orders.orderID = '$orderID' 
						AND orders.orderStatus = '$orderStatus'";
		$result = $this->db->select($query);
		return $result;
	}
	public function count_rating_status($orderID)
	{
		$query = "SELECT COUNT(order_details.orderID) AS c2
				FROM `orders`,`order_details` 
				WHERE orders.orderID = order_details.orderID
					 AND order_details.ratingStatus = '1' AND orders.orderID = '$orderID'";
		$result = $this->db->select($query);
		return $result;
	}
	public function check_order_rating($orderID)
	{
		$count_order = self::count_order_details_by_status($orderID, 3);
		if ($count_order)
			$result_count_order = $count_order->fetch_assoc();
		$count_rating_status = self::count_rating_status($orderID);
		if ($count_rating_status)
			$result_count_rating_status = $count_rating_status->fetch_assoc();
		if ($result_count_order['c1'] != 0 && $result_count_rating_status['c2'] != 0) {
			if ($result_count_order['c1'] == $result_count_rating_status['c2'])
				return true;
			else
				return false;
		} else {
			return false;
		}
	}
	public function check_active($active, $orderID)
	{
		$get_order = self::get_order_by_id($orderID);
		if ($get_order)
			$result = $get_order->fetch_assoc();
		switch ($active) {
			case 1:
				if ($result['orderStatus'] >= 0 && $result['orderStatus'] != 4)
					return 'active';
				else
					return;
			case 2:
				if ($result['orderStatus'] >= 1 && $result['orderStatus'] != 4)
					return 'active';
				else
					return;
			case 3:
				if ($result['orderStatus'] >= 2 && $result['orderStatus'] != 4)
					return 'active';
				else
					return;
			case 4:
				if ($result['orderStatus'] >= 3 && $result['orderStatus'] != 4)
					return 'active';
				else
					return;
			case 5:
				if ($result['orderStatus'] == 4)
					return 'active';
				else
					return;
		}
	}
	public function get_order_by_id($id)
	{
		$query = "SELECT * FROM orders WHERE orderID = '$id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_order_id()
	{
		$query = "SELECT orderID FROM orders order by orderDate desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_new_order_id()
	{
		$temp = [];
		$permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$get_id = self::get_order_id();
		if ($get_id) {
			while($result = $get_id->fetch_assoc()){
				$temp[] = $result['orderID'];
			}
		}
		$spit_id_start = date('y') . date('m') . date('d');
		$spit_id_between = substr(str_shuffle($permitted_chars), 0, 4);
		$spit_id_end = substr(str_shuffle($permitted_chars), 0, 4);
		$final_id = $spit_id_start . $spit_id_between . $spit_id_end;
		//Mã phụ - phòng trường hợp trùng - rất hiếm xảy ra
		$final_id_other = $spit_id_start . rand(11111,99999) . substr(str_shuffle($permitted_chars), 0, 5);
		for($i=0; $i< count($temp); $i++){
			if($temp[$i] == $final_id){
				return $final_id_other;
			}
		}
		return $final_id;
	}
	public function reOrder($orderID, $orderStatus, $customerID, $customerNote)
	{
		$reStatus = 0;
		$orderID = mysqli_real_escape_string($this->db->link, $orderID);
		$customerID = mysqli_real_escape_string($this->db->link, $customerID);
		$customerNote = mysqli_real_escape_string($this->db->link, $customerNote);
		$updateTime = date('Y-m-d H:i:s');
		if ($customerNote == '')
			$customerNote = "Mua lại!";
		$alert = "";
		if ($orderStatus <= 3) {
			$alert = '<div class="alert alert-danger mx-5 mt-3 text-center alert-dismissible fade show" role="alert">
							<strong>Thông báo:</strong> Mua lại đơn hàng không thành công!
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							
						</div>';
			return $alert;
		} else {
			$query = "UPDATE orders 
					SET orderStatus = '$reStatus', customerNote = '$customerNote', updateTime = '$updateTime', orderDate = '$updateTime'
					WHERE orderID = '$orderID' AND customerID = '$customerID'";
			$result = $this->db->update($query);
			if ($result) {
				$alert = '<div class="alert alert-success mx-5 mt-3 text-center alert-dismissible fade show" role="alert">
								<strong>Thông báo:</strong> Mua lại đơn hàng thành công!
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								
							</div>';
				return $alert;
			} else {
				$alert = '<div class="alert alert-danger mx-5 mt-3 text-center alert-dismissible fade show" role="alert">
								<strong>Thông báo:</strong> Mua lại đơn hàng không thành công!
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								
							</div>';
				return $alert;
			}
		}
	}
	public function cancelOrder($orderID, $orderStatus, $customerID, $customerNote)
	{
		$cancelStatus = 4;
		$orderID = mysqli_real_escape_string($this->db->link, $orderID);
		$customerID = mysqli_real_escape_string($this->db->link, $customerID);
		$customerNote = mysqli_real_escape_string($this->db->link, $customerNote);
		$updateTime = date('Y-m-d H:i:s');
		if ($customerNote == '')
			$customerNote = "Hủy đơn hàng!";
		$alert = "";
		if ($orderStatus >= 2) {
			$alert = '<div class="alert alert-danger mx-5 mt-3 text-center alert-dismissible fade show" role="alert">
							<strong>Thông báo:</strong> Hủy đơn hàng không thành công!
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							
						</div>';
			return $alert;
		} else {
			$query = "UPDATE orders 
					SET orderStatus = '$cancelStatus', customerNote = '$customerNote', updateTime = '$updateTime'
					WHERE orderID = '$orderID' AND customerID = '$customerID'";
			$result = $this->db->update($query);
			if ($result) {
				$alert = '<div class="alert alert-success mx-5 mt-3 text-center alert-dismissible fade show" role="alert">
								<strong>Thông báo:</strong> Hủy đơn hàng thành công!
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								
							</div>';
				return $alert;
			} else {
				$alert = '<div class="alert alert-danger mx-5 mt-3 text-center alert-dismissible fade show" role="alert">
								<strong>Thông báo:</strong> Hủy đơn hàng không thành công!
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								
							</div>';
				return $alert;
			}
		}
	}
	public function updateOrder($orderID, $orderStatus, $adminNote)
	{
		$orderID = mysqli_real_escape_string($this->db->link, $orderID);
		$adminNote = mysqli_real_escape_string($this->db->link, $adminNote);
		$updateTime = date('Y-m-d H:i:s');
		$alert = "";
		if ($orderStatus == "") {
			$alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>Thông báo:</strong> Cập nhật đơn hàng không thành công!
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>';
			return $alert;
		} else {
			$query = "UPDATE orders 
					SET orderStatus = '$orderStatus', adminNote = '$adminNote', updateTime = '$updateTime' 
					WHERE orderID = '$orderID'";
			$result = $this->db->update($query);
			if ($result) {
				$alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
								<strong>Thông báo:</strong> Cập nhật đơn hàng thành công!
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>';
				return $alert;
			} else {
				$alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Thông báo:</strong> Cập nhật đơn hàng không thành công!
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>';
				return $alert;
			}
		}
	}
	public function insertOrder($data, $customerID)
	{
		$orderID = mysqli_real_escape_string($this->db->link, $data['orderID']);
		$orderPrice = mysqli_real_escape_string($this->db->link, $data['orderPrice']);
		$customerNote = mysqli_real_escape_string($this->db->link, $data['note']);
		$orderDate = date('Y-m-d H:i:s');
		$alert = [];
		if ($orderID == "" || $orderPrice == "" || $customerID == "") {
			$alert['mess'] = "<span class='text-danger'>Đặt hàng không thành công!</span>";
			$alert['error'] = 1;
			return $alert;
		} else {
			$query = "INSERT INTO orders(orderID,customerID,orderPrice,customerNote,orderDate,updateTime) 
				VALUES('$orderID','$customerID','$orderPrice','$customerNote','$orderDate','$orderDate')";
			$result = $this->db->insert($query);
			if ($result) {
				$alert['mess'] = "<span class='text-success'>Đặt hàng thành công!</span>";
				$alert['error'] = 0;
				return $alert;
			} else {
				$alert['mess'] = "<span class='text-danger'>Đặt hàng không thành công!</span>";
				$alert['error'] = 1;
				return $alert;
			}
		}
	}
	public function insertOrderDetail($orderID, $productID, $quantity, $totalPrice)
	{
		$orderID = mysqli_real_escape_string($this->db->link, $orderID);
		$productID = mysqli_real_escape_string($this->db->link, $productID);
		$quantity = mysqli_real_escape_string($this->db->link, $quantity);
		$totalPrice = mysqli_real_escape_string($this->db->link, $totalPrice);
		$alert = [];
		if ($orderID == "" || $productID == "" || $quantity == "" || $totalPrice == "") {
			$alert['mess'] = "<span class='text-danger'>Đặt hàng không thành công!!!</span>";
			$alert['error'] = 1;
			return $alert;
		} else {
			$query = "INSERT INTO order_details(orderID,productID,quantity,totalPrice) 
				VALUES('$orderID','$productID','$quantity','$totalPrice')";
			$result = $this->db->insert($query);
			if ($result) {
				$alert['mess'] = "<span class='text-success'>Đặt hàng thành công!!!</span>";
				$alert['error'] = 0;
				return $alert;
			} else {
				$alert['mess'] = "<span class='text-danger'>Đặt hàng không thành công!!!</span>";
				$alert['error'] = 1;
				return $alert;
			}
		}
	}
	public function status_convert($orderStatus)
	{
		$status = "";
		switch ($orderStatus) {
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
	public function status_bg($orderStatus)
	{
		$bg = "";
		switch ($orderStatus) {
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
	public function get_shipping_fee($subPrice)
	{
		$shipping_fee = 0;
		if ($subPrice <= 200000) {
			$shipping_fee = 45000;
		} elseif ($subPrice > 200000 && $subPrice <= 500000) {
			$shipping_fee = 15000;
		} else {
			$shipping_fee = 0;
		}
		return $shipping_fee;
	}
}
?>