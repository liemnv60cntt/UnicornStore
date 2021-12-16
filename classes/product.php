<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>

<?php
	/**
	 * 
	 */
	class Product
	{
		private $db;
		private $fm;
		
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function search_product($tukhoa){
			$tukhoa = $this->fm->validation($tukhoa);
			$query = "SELECT * FROM tbl_product WHERE productName LIKE '%$tukhoa%'";
			$result = $this->db->select($query);
			return $result;

		}
		public function insert_product($data,$files){

			
			$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
			$product_type = mysqli_real_escape_string($this->db->link, $data['product_type']);
			$brand = mysqli_real_escape_string($this->db->link, $data['brand']);
			$description = mysqli_real_escape_string($this->db->link, $data['description']);
			$productQuantity = mysqli_real_escape_string($this->db->link, $data['productQuantity']);
			$warrantyPeriod = mysqli_real_escape_string($this->db->link, $data['warrantyPeriod']);
			$old_price = mysqli_real_escape_string($this->db->link, $data['old_price']);
			$current_price = mysqli_real_escape_string($this->db->link, $data['current_price']);
			$alert = [];
			$alert['success'] = 0;
			$errors = [];
			//Kiem tra hình ảnh và lấy hình ảnh cho vào folder images
			$permitted  = array('jpg', 'jpeg', 'png', 'gif');
			//File ảnh 1
			$file_name_1 = $_FILES['image_1']['name'];
			$file_size_1 = $_FILES['image_1']['size'];
			$file_temp_1 = $_FILES['image_1']['tmp_name'];

			$div_1 = explode('.', $file_name_1);
			$file_ext_1 = strtolower(end($div_1));
			$unique_image_1 = $file_name_1;
			$uploaded_image_1 = "../images/product_img/".$unique_image_1;

			//File ảnh 2
			$file_name_2 = $_FILES['image_2']['name'];
			$file_size_2 = $_FILES['image_2']['size'];
			$file_temp_2 = $_FILES['image_2']['tmp_name'];

			$div_2 = explode('.', $file_name_2);
			$file_ext_2 = strtolower(end($div_2));
			$unique_image_2 = $file_name_2;
			$uploaded_image_2 = "../images/product_img/".$unique_image_2;

			//File ảnh 3
			$file_name_3 = $_FILES['image_3']['name'];
			$file_size_3 = $_FILES['image_3']['size'];
			$file_temp_3 = $_FILES['image_3']['tmp_name'];

			$div_3 = explode('.', $file_name_3);
			$file_ext_3 = strtolower(end($div_3));
			$unique_image_3 = $file_name_3;
			$uploaded_image_3 = "../images/product_img/".$unique_image_3;

			//Validation các trường nhập liệu
			$alert['productName'] = ($productName=="") ? "Chưa nhập tên sản phẩm" : "";
			$alert['product_type'] = ($product_type=="N") ? "Chưa chọn loại sản phẩm" : "";
			$alert['brand'] = ($brand=="N") ? "Chưa chọn thương hiệu sản phẩm" : "";
			$alert['description'] = ($description=="") ? "Chưa nhập mô tả" : "";

			if($productQuantity=="")
				$alert['productQuantity'] = "Chưa nhập số lượng sản phẩm";
			elseif($productQuantity<0){
				$alert['productQuantity'] = "Số lượng sản phẩm phải >= 0";
				$errors[] = $alert['productQuantity'];
			}
			else
				$alert['productQuantity'] = "";

			if($warrantyPeriod=="")
				$alert['warrantyPeriod'] = "Chưa nhập thời hạn bảo hành";
			else
				$alert['warrantyPeriod'] = "";

			if($old_price=="")
				$alert['old_price'] = "Chưa nhập đơn giá ban đầu";
			elseif($old_price<1000 || $old_price>10000000000){
				$alert['old_price'] = "1000 <= đơn giá <= 10 000 000 000";
				$errors[] = $alert['old_price'];
			}
			else
				$alert['old_price'] = "";

			if($current_price=="")
				$alert['current_price'] = "Chưa nhập đơn giá hiện tại";
			elseif($current_price<1000 || $current_price>10000000000){
				$alert['current_price'] = "1000 <= đơn giá <= 10 000 000 000";
				$errors[] = $alert['current_price'];
			}
			else
				$alert['current_price'] = "";

			//Kiểm tra file ảnh
			$alert['image_1'] = "";
			$alert['image_2'] = "";
			$alert['image_3'] = "";
			if($file_name_1==""){
				$alert['image_1'] = "Chưa chọn ảnh 1";
			}
			else{
				if (in_array($file_ext_1, $permitted) === false)
				{
					$alert['image_1'] = "Chỉ upload file: ".implode(', ', $permitted);
					$errors[] = $alert['image_1'];
				}
				elseif ($file_size_1 > 2097152) {
					$alert['image_1'] = "Kích thước ảnh phải < 2MB!";
					$errors[] = $alert['image_1'];
				}
				else
					$alert['image_1'] = "";
			}

			if($file_name_2==""){
				$alert['image_2'] = "Chưa chọn ảnh 2";
			}
			else{
				if (in_array($file_ext_2, $permitted) === false)
				{
					$alert['image_2'] = "Chỉ upload file: ".implode(', ', $permitted);
					$errors[] = $alert['image_2'];
				}
				elseif ($file_size_2 > 2097152) {
					$alert['image_2'] = "Kích thước ảnh phải < 2MB!";
					$errors[] = $alert['image_2'];
				}
				
				else
					$alert['image_2'] = "";
			}

			if($file_name_3==""){
				$alert['image_3'] = "Chưa chọn ảnh 3";
			}
			else{
				if (in_array($file_ext_3, $permitted) === false)
				{
					$alert['image_3'] = "Chỉ upload file: ".implode(', ', $permitted);
					$errors[] = $alert['image_3'];
				}
				elseif ($file_size_3 > 2097152) {
					$alert['image_3'] = "Kích thước ảnh phải < 2MB!";
					$errors[] = $alert['image_3'];
				}
				
				else
					$alert['image_3'] = "";
			}

			
			


			if($productName=="" || $product_type=="N" || $brand=="N" || $description=="" || $productQuantity=="" || $warrantyPeriod=="" || $old_price=="" || $current_price=="" || $file_name_1=="" || $file_name_2=="" || $file_name_3=="" || !empty($errors)){
				$alert['mess'] = "<span class='text-danger'>Thêm sản phẩm không thành công!</span>";
				return $alert;
			}else{
				move_uploaded_file($file_temp_1,$uploaded_image_1);
				move_uploaded_file($file_temp_2,$uploaded_image_2);
				move_uploaded_file($file_temp_3,$uploaded_image_3);
				$query = "INSERT INTO product(productName,brandID,typeID,description,productQuantity,productRemain,warrantyPeriod,old_price,current_price,image_1,image_2,image_3) VALUES('$productName','$brand','$product_type','$description','$productQuantity','$productQuantity','$warrantyPeriod','$old_price','$current_price','$unique_image_1','$unique_image_2','$unique_image_3')";
				$result = $this->db->insert($query);
				if($result){
					$alert['mess'] = "<span class='text-success'>Thêm sản phẩm thành công!</span>";
					$alert['success'] = 1;
					return $alert;
				}else{
					$alert['mess'] = "<span class='text-danger'>Thêm sản phẩm không thành công!</span>";
					return $alert;
				}
			}
		}
		public function update_product($data,$files,$id){

		
			$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
			$product_type = mysqli_real_escape_string($this->db->link, $data['product_type']);
			$brand = mysqli_real_escape_string($this->db->link, $data['brand']);
			$description = mysqli_real_escape_string($this->db->link, $data['description']);
			$productStatus = mysqli_real_escape_string($this->db->link, $data['productStatus']);
			$productQuantity = mysqli_real_escape_string($this->db->link, $data['productQuantity']);
			$productRemain = mysqli_real_escape_string($this->db->link, $data['productRemain']);
			$warrantyPeriod = mysqli_real_escape_string($this->db->link, $data['warrantyPeriod']);
			$old_price = mysqli_real_escape_string($this->db->link, $data['old_price']);
			$current_price = mysqli_real_escape_string($this->db->link, $data['current_price']);
			$image_1_old = mysqli_real_escape_string($this->db->link, $data['image_1_old']);
			$image_2_old = mysqli_real_escape_string($this->db->link, $data['image_2_old']);
			$image_3_old = mysqli_real_escape_string($this->db->link, $data['image_3_old']);
			$alert = [];
			$errors = [];
			//Kiem tra hình ảnh và lấy hình ảnh cho vào folder images
			$permitted  = array('jpg', 'jpeg', 'png', 'gif');
			//File ảnh 1
			$file_name_1 = $_FILES['image_1']['name'];
			$file_size_1 = $_FILES['image_1']['size'];
			$file_temp_1 = $_FILES['image_1']['tmp_name'];

			$div_1 = explode('.', $file_name_1);
			$file_ext_1 = strtolower(end($div_1));
			$unique_image_1 = $file_name_1;
			$uploaded_image_1 = "../images/product_img/".$unique_image_1;

			//File ảnh 2
			$file_name_2 = $_FILES['image_2']['name'];
			$file_size_2 = $_FILES['image_2']['size'];
			$file_temp_2 = $_FILES['image_2']['tmp_name'];

			$div_2 = explode('.', $file_name_2);
			$file_ext_2 = strtolower(end($div_2));
			$unique_image_2 = $file_name_2;
			$uploaded_image_2 = "../images/product_img/".$unique_image_2;

			//File ảnh 3
			$file_name_3 = $_FILES['image_3']['name'];
			$file_size_3 = $_FILES['image_3']['size'];
			$file_temp_3 = $_FILES['image_3']['tmp_name'];

			$div_3 = explode('.', $file_name_3);
			$file_ext_3 = strtolower(end($div_3));
			$unique_image_3 = $file_name_3;
			$uploaded_image_3 = "../images/product_img/".$unique_image_3;

			//Validation các trường nhập liệu
			$alert['productName'] = ($productName=="") ? "Chưa nhập tên sản phẩm" : "";
			$alert['product_type'] = ($product_type=="N") ? "Chưa chọn loại sản phẩm" : "";
			$alert['brand'] = ($brand=="N") ? "Chưa chọn thương hiệu sản phẩm" : "";
			$alert['description'] = ($description=="") ? "Chưa nhập mô tả" : "";
			$alert['productStatus'] = ($productStatus=="N") ? "Chưa chọn trạng thái" : "";

			if($productQuantity=="")
				$alert['productQuantity'] = "Chưa nhập tổng số lượng sản phẩm ban đầu";
			elseif($productQuantity<0){
				$alert['productQuantity'] = "Số lượng sản phẩm phải >= 0";
				$errors[] = $alert['productQuantity'];
			}
			else
				$alert['productQuantity'] = "";

			if($productRemain=="")
				$alert['productRemain'] = "Chưa nhập số lượng sản phẩm còn lại";
			elseif($productRemain<0){
				$alert['productRemain'] = "Số lượng sản phẩm phải >= 0";
				$errors[] = $alert['productRemain'];
			}
			else
				$alert['productRemain'] = "";

			if($warrantyPeriod=="")
				$alert['warrantyPeriod'] = "Chưa nhập thời hạn bảo hành";
			else
				$alert['warrantyPeriod'] = "";

			if($old_price=="")
				$alert['old_price'] = "Chưa nhập đơn giá ban đầu";
			elseif($old_price<1000 || $old_price>10000000000){
				$alert['old_price'] = "1000 <= đơn giá <= 10 000 000 000";
				$errors[] = $alert['old_price'];
			}
			else
				$alert['old_price'] = "";

			if($current_price=="")
				$alert['current_price'] = "Chưa nhập đơn giá hiện tại";
			elseif($current_price<1000 || $current_price>10000000000){
				$alert['current_price'] = "1000 <= đơn giá <= 10 000 000 000";
				$errors[] = $alert['current_price'];
			}
			else
				$alert['current_price'] = "";
			
			//Nếu người dùng chọn ảnh
			$alert['image_1'] = "";
			$alert['image_2'] = "";
			$alert['image_3'] = "";
			if($file_name_1!=""){
				if (in_array($file_ext_1, $permitted) === false)
				{
					$alert['image_1'] = "Chỉ upload file: ".implode(', ', $permitted);
					$errors[] = $alert['image_1'];
				}
				elseif ($file_size_1 > 2097152) {
					$alert['image_1'] = "Kích thước ảnh phải < 2MB!";
					$errors[] = $alert['image_1'];
				}
				else
					$alert['image_1'] = "";
			}
			if($file_name_2!=""){
				if (in_array($file_ext_2, $permitted) === false)
				{
					$alert['image_2'] = "Chỉ upload file: ".implode(', ', $permitted);
					$errors[] = $alert['image_2'];
				}
				elseif ($file_size_2 > 2097152) {
					$alert['image_2'] = "Kích thước ảnh phải < 2MB!";
					$errors[] = $alert['image_2'];
				}
				
				else
					$alert['image_2'] = "";
			}
			if($file_name_3!=""){
				if (in_array($file_ext_3, $permitted) === false)
				{
					$alert['image_3'] = "Chỉ upload file: ".implode(', ', $permitted);
					$errors[] = $alert['image_3'];
				}
				elseif ($file_size_3 > 2097152) {
					$alert['image_3'] = "Kích thước ảnh phải < 2MB!";
					$errors[] = $alert['image_3'];
				}
				
				else
					$alert['image_3'] = "";
			}

			if($productName=="" || $product_type=="N" || $brand=="N" || $description=="" || $productStatus=="N" || $productQuantity=="" || $productRemain=="" || $warrantyPeriod=="" || $old_price=="" || $current_price=="" || !empty($errors)){
				$alert['mess'] = "<span class='text-danger'>Cập nhật sản phẩm không thành công!</span>";
				return $alert;
			}else{
					$update_image_1 = ($file_name_1=="") ? $image_1_old : $file_name_1;
					$update_image_2 = ($file_name_2=="") ? $image_2_old : $file_name_2;
					$update_image_3 = ($file_name_3=="") ? $image_3_old : $file_name_3;
					if($file_name_1!="")
						move_uploaded_file($file_temp_1,$uploaded_image_1);
					if($file_name_2!="")
						move_uploaded_file($file_temp_2,$uploaded_image_2);
					if($file_name_1!="")
						move_uploaded_file($file_temp_3,$uploaded_image_3);
					$query = "UPDATE product SET
					productName = '$productName',
					brandID = '$brand',
					typeID = '$product_type', 
					description = '$description', 
					productStatus = '$productStatus', 
					productQuantity = '$productQuantity',
					productRemain = '$productRemain',
					warrantyPeriod = '$warrantyPeriod',
					old_price = '$old_price',
					current_price = '$current_price',
					image_1 = '$update_image_1',
					image_2 = '$update_image_2',
					image_3 = '$update_image_3'
					
					WHERE productID = '$id'";
					
					$result = $this->db->update($query);
					if($result){
						$alert['mess'] = "<span class='text-success'>Cập nhật sản phẩm thành công!</span>";
						return $alert;
					}else{
						$alert['mess'] = "<span class='text-danger'>Cập nhật sản phẩm không thành công!</span>";
						return $alert;
					}
				
			}

		}
		public function insert_slider($data,$files){
			$sliderName = mysqli_real_escape_string($this->db->link, $data['sliderName']);
			$type = mysqli_real_escape_string($this->db->link, $data['type']);
			
			//Kiem tra hình ảnh và lấy hình ảnh cho vào folder upload
			$permitted  = array('jpg', 'jpeg', 'png', 'gif');

			$file_name = $_FILES['image']['name'];
			$file_size = $_FILES['image']['size'];
			$file_temp = $_FILES['image']['tmp_name'];

			$div = explode('.', $file_name);
			$file_ext = strtolower(end($div));
			// $file_current = strtolower(current($div));
			$unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
			$uploaded_image = "uploads/".$unique_image;


			if($sliderName=="" || $type==""){
				$alert = "<span class='error'>Fields must be not empty</span>";
				return $alert;
			}else{
				if(!empty($file_name)){
					//Nếu người dùng chọn ảnh
					if ($file_size > 2048000) {

		    		 $alert = "<span class='success'>Image Size should be less then 2MB!</span>";
					return $alert;
				    } 
					elseif (in_array($file_ext, $permitted) === false) 
					{
				     // echo "<span class='error'>You can upload only:-".implode(', ', $permitted)."</span>";	
				    $alert = "<span class='success'>You can upload only:-".implode(', ', $permitted)."</span>";
					return $alert;
					}
					move_uploaded_file($file_temp,$uploaded_image);
					$query = "INSERT INTO tbl_slider(sliderName,type,slider_image) VALUES('$sliderName','$type','$unique_image')";
					$result = $this->db->insert($query);
					if($result){
						$alert = "<span class='success'>Slider Added Successfully</span>";
						return $alert;
					}else{
						$alert = "<span class='error'>Slider Added Not Success</span>";
						return $alert;
					}
				}
				
				
			}
		}
		public function show_slider(){
			$query = "SELECT * FROM tbl_slider where type='1' order by sliderId desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function show_slider_list(){
			$query = "SELECT * FROM tbl_slider order by sliderId desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function show_product(){

			$query = "

			SELECT product.*, brand.brandName, product_type.typeName, product_type.cateID

			FROM product INNER JOIN product_type ON product.typeID = product_type.typeID 

			INNER JOIN brand ON product.brandID = brand.brandID 

			order by product.productID desc";

			$result = $this->db->select($query);
			return $result;
		}
		public function update_type_slider($id,$type){

			$type = mysqli_real_escape_string($this->db->link, $type);
			$query = "UPDATE tbl_slider SET type = '$type' where sliderId='$id'";
			$result = $this->db->update($query);
			return $result;
		}
		public function del_slider($id){
			$query = "DELETE FROM tbl_slider where sliderId = '$id'";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='success'>Slider Deleted Successfully</span>";
				return $alert;
			}else{
				$alert = "<span class='error'>Slider Deleted Not Success</span>";
				return $alert;
			}
		}
		
		public function delete_product($id){
			$query = "DELETE FROM product where productID = '$id'";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='text-success'>Xóa sản phẩm thành công!</span>";
				return $alert;
			}else{
				$alert = "<span class='text-danger'>Xóa sản phẩm không thành công</span>";
				return $alert;
			}
			
		}
		public function del_wlist($proid,$customer_id){
			$query = "DELETE FROM tbl_wishlist where productId = '$proid' AND customer_id='$customer_id'";
			$result = $this->db->delete($query);
			return $result;
		}
		public function getproductbyId($id){
			$query = "SELECT * FROM tbl_product where productId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}
		//END BACKEND 
		public function get_featured_product(){
			$query = "SELECT product.*, brand.brandName FROM product 
			INNER JOIN brand ON product.brandID = brand.brandID where productStatus = '1' order by RAND() LIMIT 4 ";
			$result = $this->db->select($query);
			return $result;
		} 
		public function get_discount_product(){
			$query = "SELECT product.*, brand.brandName FROM product 
			INNER JOIN brand ON product.brandID = brand.brandID where productStatus = '4' order by RAND() LIMIT 4 ";
			$result = $this->db->select($query);
			return $result;
		} 
		public function get_new_product(){
			$query = "SELECT product.*, brand.brandName FROM product 
			INNER JOIN brand ON product.brandID = brand.brandID where productStatus = '0' order by productID desc LIMIT 4 ";
			$result = $this->db->select($query);
			return $result;
		}
		public function getproduct_new(){
			$sp_tungtrang = 4;
			if(!isset($_GET['trang'])){
				$trang = 1;
			}else{
				$trang = $_GET['trang'];
			}
			$tung_trang = ($trang-1)*$sp_tungtrang;
			$query = "SELECT * FROM tbl_product order by productId desc LIMIT $tung_trang,$sp_tungtrang";
			$result = $this->db->select($query);
			return $result;
		} 
		public function get_all_product(){
			$query = "SELECT * FROM tbl_product";
			$result = $this->db->select($query);
			return $result;
		} 
		public function get_details($id){
			$query = "

			SELECT product.*, brand.brandName, product_type.typeName, product_type.cateID

			FROM product INNER JOIN product_type ON product.typeID = product_type.typeID 

			INNER JOIN brand ON product.brandID = brand.brandID WHERE product.productID = '$id'

			";
			
			$result = $this->db->select($query);
			return $result;
		}
		public function get_rating($id){
			$query = "

			SELECT *
			FROM product_review
			WHERE productID = '$id'
			";
			
			$result = $this->db->select($query);
			return $result;
		}
		public function getLastestDell(){
			$query = "SELECT * FROM tbl_product WHERE brandId = '6' order by productId desc LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}
		public function getLastestOppo(){
			$query = "SELECT * FROM tbl_product WHERE brandId = '3' order by productId desc LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}
		public function getLastestHuawei(){
			$query = "SELECT * FROM tbl_product WHERE brandId = '4' order by productId desc LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}
		public function getLastestSamsung(){
			$query = "SELECT * FROM tbl_product WHERE brandId = '2' order by productId desc LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_compare($customer_id){
			$query = "SELECT * FROM tbl_compare WHERE customer_id = '$customer_id' order by id desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_wishlist($customer_id){
			$query = "SELECT * FROM tbl_wishlist WHERE customer_id = '$customer_id' order by id desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function insertCompare($productid, $customer_id){
			
			$productid = mysqli_real_escape_string($this->db->link, $productid);
			$customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
			
			$check_compare = "SELECT * FROM tbl_compare WHERE productId = '$productid' AND customer_id ='$customer_id'";
			$result_check_compare = $this->db->select($check_compare);

			if($result_check_compare){
				$msg = "<span class='error'>Product Already Added to Compare</span>";
				return $msg;
			}else{

			$query = "SELECT * FROM tbl_product WHERE productId = '$productid'";
			$result = $this->db->select($query)->fetch_assoc();
			
			$productName = $result["productName"];
			$price = $result["price"];
			$image = $result["image"];

			
			
			$query_insert = "INSERT INTO tbl_compare(productId,price,image,customer_id,productName) VALUES('$productid','$price','$image','$customer_id','$productName')";
			$insert_compare = $this->db->insert($query_insert);

			if($insert_compare){
						$alert = "<span class='success'>Added Compare Successfully</span>";
						return $alert;
					}else{
						$alert = "<span class='error'>Added Compare Not Success</span>";
						return $alert;
					}
			}
		}
		public function insertWishlist($productid, $customer_id){
			$productid = mysqli_real_escape_string($this->db->link, $productid);
			$customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
			
			$check_wlist = "SELECT * FROM tbl_wishlist WHERE productId = '$productid' AND customer_id ='$customer_id'";
			$result_check_wlist = $this->db->select($check_wlist);

			if($result_check_wlist){
				$msg = "<span class='error'>Product Already Added to Wishlist</span>";
				return $msg;
			}else{

			$query = "SELECT * FROM tbl_product WHERE productId = '$productid'";
			$result = $this->db->select($query)->fetch_assoc();
			
			$productName = $result["productName"];
			$price = $result["price"];
			$image = $result["image"];

			
			
			$query_insert = "INSERT INTO tbl_wishlist(productId,price,image,customer_id,productName) VALUES('$productid','$price','$image','$customer_id','$productName')";
			$insert_wlist = $this->db->insert($query_insert);

			if($insert_wlist){
						$alert = "<span class='success'>Added to Wishlist Successfully</span>";
						return $alert;
					}else{
						$alert = "<span class='error'>Added to Wishlist Not Success</span>";
						return $alert;
					}
			}
		}


	}
?>