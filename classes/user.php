
<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>


<?php
	/**
	 * 
	 */
	class User
	{
		private $db;
		private $fm;
		
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function get_users_by_email($email){
			$email = mysqli_real_escape_string($this->db->link, $email);
			$query = "SELECT * FROM customer WHERE email = '$email'";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_users_by_code($code){
			$code = mysqli_real_escape_string($this->db->link, $code);
			$query = "SELECT * FROM customer WHERE code = $code";
			$result = $this->db->select($query);
			return $result;
		}
		public function update_otp($code, $status, $fetch_code){
			$code = mysqli_real_escape_string($this->db->link, $code);
			$status = mysqli_real_escape_string($this->db->link, $status);
			$fetch_code = mysqli_real_escape_string($this->db->link, $fetch_code);
			$query = "UPDATE customer SET code = '$code', status = '$status' WHERE code = '$fetch_code'";
			$result = $this->db->update($query);
			if($result)
				return true;
			else
				return false;
		}
		public function update_user($code, $email){
			$code = mysqli_real_escape_string($this->db->link, $code);
			$email = mysqli_real_escape_string($this->db->link, $email);
			$query = "UPDATE customer SET code = $code WHERE email = '$email'";
			$result = $this->db->update($query);
			if($result)
				return true;
			else
				return false;
		}
		public function update_password($code, $password, $email){
			$code = mysqli_real_escape_string($this->db->link, $code);
			$password = mysqli_real_escape_string($this->db->link, $password);
			$email = mysqli_real_escape_string($this->db->link, $email);
			$query = "UPDATE customer SET code = $code, password = '$password' WHERE email = '$email'";
			$result = $this->db->update($query);
			if($result)
				return true;
			else
				return false;
		}
		public function insert_user($customerName, $address, $city, $phone, $email, $password, $code, $status){
			$customerName = $this->fm->validation($customerName);
			$address = $this->fm->validation($address);
			$city = $this->fm->validation($city);
			$customerName = mysqli_real_escape_string($this->db->link, $customerName);
			$address = mysqli_real_escape_string($this->db->link, $address);
			$city = mysqli_real_escape_string($this->db->link, $city);
			$phone = mysqli_real_escape_string($this->db->link, $phone);
			$email = mysqli_real_escape_string($this->db->link, $email);
			$password = mysqli_real_escape_string($this->db->link, $password);
			$code = mysqli_real_escape_string($this->db->link, $code);
			$status = mysqli_real_escape_string($this->db->link, $status);

			$query = "INSERT INTO customer ( customerName,  address,  city_province,  phone,  email,  password,  code,  status)
			values('$customerName', '$address', '$city', '$phone', '$email', '$password', '$code', '$status')";
			$result = $this->db->insert($query);
			if($result)
				return true;
			else
				return false;
		}
		
		


	}
?>