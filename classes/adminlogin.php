<?php
    $filepath = realpath(dirname(__FILE__));
	include ($filepath.'/../lib/session.php');
	Session::checkLogin();
	include_once($filepath.'/../lib/database.php');
	include_once($filepath.'/../helpers/format.php');
?>

<?php

    class AdminLogin
    {
        private $db;
		private $fm;
        public function __construct()
        {
            $this->db = new Database();
			$this->fm = new Format();
        }
        public function login_admin($adminUser,$adminPassword){
            $adminUser = $this->fm->validation($adminUser);
			$adminPassword = $this->fm->validation($adminPassword);

            $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
			$adminPassword = mysqli_real_escape_string($this->db->link, $adminPassword);

            if(empty($adminUser) || empty($adminPassword)){
				$alert = "Tài khoản và mật khẩu không được để trống!";
				return $alert;
			}else{
                $query = "SELECT * FROM admin WHERE adminUser = '$adminUser' AND adminPassword = '$adminPassword'";
				$result = $this->db->select($query);

				if($result != false){

					$value = $result->fetch_assoc();

					Session::set('adminlogin', true);
					Session::set('adminId', $value['adminId']);
					Session::set('adminUser', $value['adminUser']);
					Session::set('adminName', $value['adminName']);
					header('Location:index.php');

				}else{
					$alert = "Mật khẩu và tài khoản không đúng!";
					return $alert;
				}
            }
        }
    }


?>