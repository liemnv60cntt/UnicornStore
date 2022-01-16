
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
		public function get_all_users(){
			$query = "SELECT * FROM customer ORDER BY customerID DESC";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_users_by_email($email){
			$email = mysqli_real_escape_string($this->db->link, $email);
			$query = "SELECT * FROM customer WHERE email = '$email'";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_users_by_id($id){
			$query = "SELECT * FROM customer WHERE customerID = '$id'";
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
			$query = "UPDATE customer SET code = '$code', status = '$status' 
					WHERE code = '$fetch_code'";
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
		public function update_user_profile($data, $id){
			$customerName = mysqli_real_escape_string($this->db->link, $data['customerName']);
			$address = mysqli_real_escape_string($this->db->link, $data['address']);
			$city_province = mysqli_real_escape_string($this->db->link, $data['city_province']);
			$district = mysqli_real_escape_string($this->db->link, $data['district']);
			$phone = mysqli_real_escape_string($this->db->link, $data['phone']);
			$alert = [];
			$alert['success'] = "";
			$alert['error'] = "";
			//Validate các trường nhập liệu
			$alert['customerName'] = ($customerName=="") ? "*Họ tên không được để trống" : "";
			$alert['address'] = ($address=="") ? "*Địa chỉ không được để trống" : "";
			$alert['city_province'] = ($city_province=="") ? "*Tỉnh/Thành phố không được để trống" : "";
			$alert['district'] = ($district=="") ? "*Quận/Huyện không được để trống" : "";
			$alert['phone'] = ($phone=="") ? "*SĐT không được để trống" : "";

			if($customerName=="" || $address=="" || $city_province=="" || $district=="" || $phone==""){
				$alert['error'] = "Cập nhật thông tin tài khoản không thành công!";
				return $alert;
			}else{
				$query = "UPDATE customer
					SET customerName = '$customerName',
						address = '$address',
				   		city_province = '$city_province',
						district = '$district',
				   		phone = '$phone' 
			  	 	WHERE customerID = '$id'";
				$result = $this->db->update($query);
				if($result){
					$alert['success'] = "Cập nhật thông tin tài khoản thành công!";
					return $alert;
				}
				else{
					$alert['error'] = "Cập nhật thông tin tài khoản không thành công!";
					return $alert;
				}
			}			
		}
		public function update_password($code, $password, $email){
			$code = mysqli_real_escape_string($this->db->link, $code);
			$password = mysqli_real_escape_string($this->db->link, $password);
			$email = mysqli_real_escape_string($this->db->link, $email);
			$query = "UPDATE customer SET code = $code, password = '$password'
					 WHERE email = '$email'";
			$result = $this->db->update($query);
			if($result)
				return true;
			else
				return false;
		}
		public function insert_user($customerName, $address, $city, $district, $phone, $email, $password, $code, $status){
			$customerName = $this->fm->validation($customerName);
			$address = $this->fm->validation($address);
			$city = $this->fm->validation($city);
			$customerName = mysqli_real_escape_string($this->db->link, $customerName);
			$address = mysqli_real_escape_string($this->db->link, $address);
			$city = mysqli_real_escape_string($this->db->link, $city);
			$district = mysqli_real_escape_string($this->db->link, $district);
			$phone = mysqli_real_escape_string($this->db->link, $phone);
			$email = mysqli_real_escape_string($this->db->link, $email);
			$password = mysqli_real_escape_string($this->db->link, $password);
			$code = mysqli_real_escape_string($this->db->link, $code);
			$status = mysqli_real_escape_string($this->db->link, $status);

			$query = "INSERT INTO customer ( customerName,  address,  city_province, district,  phone,  email,  password,  code,  status)
			values('$customerName', '$address', '$city', '$district', '$phone', '$email', '$password', '$code', '$status')";
			$result = $this->db->insert($query);
			if($result)
				return true;
			else
				return false;
		}
		public function update_admin_password($password, $id){
			$password = mysqli_real_escape_string($this->db->link, $password);
			$id = mysqli_real_escape_string($this->db->link, $id);
			$query = "UPDATE admin SET adminPassword = '$password' WHERE adminID = '$id'";
			$result = $this->db->update($query);
			if($result)
				return true;
			else
				return false;
		}
		public function get_admin_old_pw($id){
			$query = "SELECT adminPassword FROM admin WHERE adminID = $id";
			$result = $this->db->select($query);
			if($result){
				$get_pw = $result->fetch_assoc();
				return $get_pw['adminPassword'];
			}
		}


	}
?>