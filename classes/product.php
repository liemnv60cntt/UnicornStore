<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
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
	public function search_product($keyword)
	{
		$rowsPerPage = 4;
		if (!isset($_GET['page']) || $_GET['page']=='') {
			$_GET['page'] = 1;
		}
		$offset =($_GET['page']-1)*$rowsPerPage;
		$keyword = $this->fm->validation($keyword);
		$query = "SELECT product.*, brand.brandName
			FROM product INNER JOIN brand ON product.brandID = brand.brandID 
			WHERE product.productName LIKE '%$keyword%' order by product.productID desc LIMIT $offset, $rowsPerPage";
		$result = $this->db->select($query);
		return $result;
	}
	public function search_all_product($keyword)
	{
		$keyword = $this->fm->validation($keyword);
		$query = "SELECT product.*, brand.brandName
			FROM product INNER JOIN brand ON product.brandID = brand.brandID 
			WHERE product.productName LIKE '%$keyword%' order by product.productID desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_distinct_search_product_brandName($keyword)
	{
		$keyword = $this->fm->validation($keyword);
		$query = "SELECT DISTINCT brand.brandName
			FROM product INNER JOIN brand ON product.brandID = brand.brandID 
			WHERE product.productName LIKE '%$keyword%' order by brand.brandName asc";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_distinct_brandName_by_status($status)
	{
		$query = "SELECT DISTINCT brand.brandName
			FROM product INNER JOIN brand ON product.brandID = brand.brandID 
			WHERE product.productStatus = '$status' order by brand.brandName asc";
		$result = $this->db->select($query);
		return $result;
	}
	public function insert_product($data, $files)
	{


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
		//Kiem tra h??nh ???nh v?? l???y h??nh ???nh cho v??o folder images
		$permitted  = array('jpg', 'jpeg', 'png', 'gif');
		//File ???nh 1
		$file_name_1 = $_FILES['image_1']['name'];
		$file_size_1 = $_FILES['image_1']['size'];
		$file_temp_1 = $_FILES['image_1']['tmp_name'];

		$div_1 = explode('.', $file_name_1);
		$file_ext_1 = strtolower(end($div_1));
		$unique_image_1 = $file_name_1;
		$uploaded_image_1 = "../images/product_img/" . $unique_image_1;

		//File ???nh 2
		$file_name_2 = $_FILES['image_2']['name'];
		$file_size_2 = $_FILES['image_2']['size'];
		$file_temp_2 = $_FILES['image_2']['tmp_name'];

		$div_2 = explode('.', $file_name_2);
		$file_ext_2 = strtolower(end($div_2));
		$unique_image_2 = $file_name_2;
		$uploaded_image_2 = "../images/product_img/" . $unique_image_2;

		//File ???nh 3
		$file_name_3 = $_FILES['image_3']['name'];
		$file_size_3 = $_FILES['image_3']['size'];
		$file_temp_3 = $_FILES['image_3']['tmp_name'];

		$div_3 = explode('.', $file_name_3);
		$file_ext_3 = strtolower(end($div_3));
		$unique_image_3 = $file_name_3;
		$uploaded_image_3 = "../images/product_img/" . $unique_image_3;

		//Validation c??c tr?????ng nh???p li???u
		$alert['productName'] = ($productName == "") ? "Ch??a nh???p t??n s???n ph???m" : "";
		$alert['product_type'] = ($product_type == "N") ? "Ch??a ch???n lo???i s???n ph???m" : "";
		$alert['brand'] = ($brand == "N") ? "Ch??a ch???n th????ng hi???u s???n ph???m" : "";
		$alert['description'] = ($description == "") ? "Ch??a nh???p m?? t???" : "";

		if ($productQuantity == "")
			$alert['productQuantity'] = "Ch??a nh???p s??? l?????ng s???n ph???m";
		elseif ($productQuantity < 0) {
			$alert['productQuantity'] = "S??? l?????ng s???n ph???m ph???i >= 0";
			$errors[] = $alert['productQuantity'];
		} else
			$alert['productQuantity'] = "";

		if ($warrantyPeriod == "")
			$alert['warrantyPeriod'] = "Ch??a nh???p th???i h???n b???o h??nh";
		else
			$alert['warrantyPeriod'] = "";

		if ($old_price == "")
			$alert['old_price'] = "Ch??a nh???p ????n gi?? ban ?????u";
		elseif ($old_price < 1000 || $old_price > 10000000000) {
			$alert['old_price'] = "1000 <= ????n gi?? <= 10 000 000 000";
			$errors[] = $alert['old_price'];
		} else
			$alert['old_price'] = "";

		if ($current_price == "")
			$alert['current_price'] = "Ch??a nh???p ????n gi?? hi???n t???i";
		elseif ($current_price < 1000 || $current_price > 10000000000) {
			$alert['current_price'] = "1000 <= ????n gi?? <= 10 000 000 000";
			$errors[] = $alert['current_price'];
		} else
			$alert['current_price'] = "";

		//Ki???m tra file ???nh
		$alert['image_1'] = "";
		$alert['image_2'] = "";
		$alert['image_3'] = "";
		if ($file_name_1 == "") {
			$alert['image_1'] = "Ch??a ch???n ???nh 1";
		} else {
			if (in_array($file_ext_1, $permitted) === false) {
				$alert['image_1'] = "Ch??? upload file: " . implode(', ', $permitted);
				$errors[] = $alert['image_1'];
			} elseif ($file_size_1 > 2097152) {
				$alert['image_1'] = "K??ch th?????c ???nh ph???i < 2MB!";
				$errors[] = $alert['image_1'];
			} else
				$alert['image_1'] = "";
		}

		if ($file_name_2 == "") {
			$alert['image_2'] = "Ch??a ch???n ???nh 2";
		} else {
			if (in_array($file_ext_2, $permitted) === false) {
				$alert['image_2'] = "Ch??? upload file: " . implode(', ', $permitted);
				$errors[] = $alert['image_2'];
			} elseif ($file_size_2 > 2097152) {
				$alert['image_2'] = "K??ch th?????c ???nh ph???i < 2MB!";
				$errors[] = $alert['image_2'];
			} else
				$alert['image_2'] = "";
		}

		if ($file_name_3 == "") {
			$alert['image_3'] = "Ch??a ch???n ???nh 3";
		} else {
			if (in_array($file_ext_3, $permitted) === false) {
				$alert['image_3'] = "Ch??? upload file: " . implode(', ', $permitted);
				$errors[] = $alert['image_3'];
			} elseif ($file_size_3 > 2097152) {
				$alert['image_3'] = "K??ch th?????c ???nh ph???i < 2MB!";
				$errors[] = $alert['image_3'];
			} else
				$alert['image_3'] = "";
		}





		if ($productName == "" || $product_type == "N" || $brand == "N" || $description == "" || $productQuantity == "" || $warrantyPeriod == "" || $old_price == "" || $current_price == "" || $file_name_1 == "" || $file_name_2 == "" || $file_name_3 == "" || !empty($errors)) {
			$alert['mess'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>Th??ng b??o:</strong> Th??m s???n ph???m kh??ng th??nh c??ng!
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>';
			return $alert;
		} else {
			move_uploaded_file($file_temp_1, $uploaded_image_1);
			move_uploaded_file($file_temp_2, $uploaded_image_2);
			move_uploaded_file($file_temp_3, $uploaded_image_3);
			$query = "INSERT INTO product(productName,brandID,typeID,description,productQuantity,productRemain,warrantyPeriod,old_price,current_price,image_1,image_2,image_3) VALUES('$productName','$brand','$product_type','$description','$productQuantity','$productQuantity','$warrantyPeriod','$old_price','$current_price','$unique_image_1','$unique_image_2','$unique_image_3')";
			$result = $this->db->insert($query);
			if ($result) {
				$alert['mess'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
									<strong>Th??ng b??o:</strong> Th??m s???n ph???m th??nh c??ng!
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>';
				$alert['success'] = 1;
				return $alert;
			} else {
				$alert['mess'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Th??ng b??o:</strong> Th??m s???n ph???m kh??ng th??nh c??ng!
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>';
				return $alert;
			}
		}
	}
	public function update_product($data, $files, $id)
	{


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
		//Kiem tra h??nh ???nh v?? l???y h??nh ???nh cho v??o folder images
		$permitted  = array('jpg', 'jpeg', 'png', 'gif');
		//File ???nh 1
		$file_name_1 = $_FILES['image_1']['name'];
		$file_size_1 = $_FILES['image_1']['size'];
		$file_temp_1 = $_FILES['image_1']['tmp_name'];

		$div_1 = explode('.', $file_name_1);
		$file_ext_1 = strtolower(end($div_1));
		$unique_image_1 = $file_name_1;
		$uploaded_image_1 = "../images/product_img/" . $unique_image_1;

		//File ???nh 2
		$file_name_2 = $_FILES['image_2']['name'];
		$file_size_2 = $_FILES['image_2']['size'];
		$file_temp_2 = $_FILES['image_2']['tmp_name'];

		$div_2 = explode('.', $file_name_2);
		$file_ext_2 = strtolower(end($div_2));
		$unique_image_2 = $file_name_2;
		$uploaded_image_2 = "../images/product_img/" . $unique_image_2;

		//File ???nh 3
		$file_name_3 = $_FILES['image_3']['name'];
		$file_size_3 = $_FILES['image_3']['size'];
		$file_temp_3 = $_FILES['image_3']['tmp_name'];

		$div_3 = explode('.', $file_name_3);
		$file_ext_3 = strtolower(end($div_3));
		$unique_image_3 = $file_name_3;
		$uploaded_image_3 = "../images/product_img/" . $unique_image_3;

		//Validation c??c tr?????ng nh???p li???u
		$alert['productName'] = ($productName == "") ? "Ch??a nh???p t??n s???n ph???m" : "";
		$alert['product_type'] = ($product_type == "N") ? "Ch??a ch???n lo???i s???n ph???m" : "";
		$alert['brand'] = ($brand == "N") ? "Ch??a ch???n th????ng hi???u s???n ph???m" : "";
		$alert['description'] = ($description == "") ? "Ch??a nh???p m?? t???" : "";
		$alert['productStatus'] = ($productStatus == "N") ? "Ch??a ch???n tr???ng th??i" : "";

		if ($productQuantity == "")
			$alert['productQuantity'] = "Ch??a nh???p t???ng s??? l?????ng s???n ph???m ban ?????u";
		elseif ($productQuantity < 0) {
			$alert['productQuantity'] = "S??? l?????ng s???n ph???m ph???i >= 0";
			$errors[] = $alert['productQuantity'];
		} else
			$alert['productQuantity'] = "";

		if ($productRemain == "")
			$alert['productRemain'] = "Ch??a nh???p s??? l?????ng s???n ph???m c??n l???i";
		elseif ($productRemain < 0) {
			$alert['productRemain'] = "S??? l?????ng s???n ph???m ph???i >= 0";
			$errors[] = $alert['productRemain'];
		} else
			$alert['productRemain'] = "";

		if ($warrantyPeriod == "")
			$alert['warrantyPeriod'] = "Ch??a nh???p th???i h???n b???o h??nh";
		else
			$alert['warrantyPeriod'] = "";

		if ($old_price == "")
			$alert['old_price'] = "Ch??a nh???p ????n gi?? ban ?????u";
		elseif ($old_price < 1000 || $old_price > 10000000000) {
			$alert['old_price'] = "1000 <= ????n gi?? <= 10 000 000 000";
			$errors[] = $alert['old_price'];
		} else
			$alert['old_price'] = "";

		if ($current_price == "")
			$alert['current_price'] = "Ch??a nh???p ????n gi?? hi???n t???i";
		elseif ($current_price < 1000 || $current_price > 10000000000) {
			$alert['current_price'] = "1000 <= ????n gi?? <= 10 000 000 000";
			$errors[] = $alert['current_price'];
		} else
			$alert['current_price'] = "";

		//N???u ng?????i d??ng ch???n ???nh
		$alert['image_1'] = "";
		$alert['image_2'] = "";
		$alert['image_3'] = "";
		if ($file_name_1 != "") {
			if (in_array($file_ext_1, $permitted) === false) {
				$alert['image_1'] = "Ch??? upload file: " . implode(', ', $permitted);
				$errors[] = $alert['image_1'];
			} elseif ($file_size_1 > 2097152) {
				$alert['image_1'] = "K??ch th?????c ???nh ph???i < 2MB!";
				$errors[] = $alert['image_1'];
			} else
				$alert['image_1'] = "";
		}
		if ($file_name_2 != "") {
			if (in_array($file_ext_2, $permitted) === false) {
				$alert['image_2'] = "Ch??? upload file: " . implode(', ', $permitted);
				$errors[] = $alert['image_2'];
			} elseif ($file_size_2 > 2097152) {
				$alert['image_2'] = "K??ch th?????c ???nh ph???i < 2MB!";
				$errors[] = $alert['image_2'];
			} else
				$alert['image_2'] = "";
		}
		if ($file_name_3 != "") {
			if (in_array($file_ext_3, $permitted) === false) {
				$alert['image_3'] = "Ch??? upload file: " . implode(', ', $permitted);
				$errors[] = $alert['image_3'];
			} elseif ($file_size_3 > 2097152) {
				$alert['image_3'] = "K??ch th?????c ???nh ph???i < 2MB!";
				$errors[] = $alert['image_3'];
			} else
				$alert['image_3'] = "";
		}

		if ($productName == "" || $product_type == "N" || $brand == "N" || $description == "" || $productStatus == "N" || $productQuantity == "" || $productRemain == "" || $warrantyPeriod == "" || $old_price == "" || $current_price == "" || !empty($errors)) {
			$alert['mess'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Th??ng b??o:</strong> C???p nh???t s???n ph???m kh??ng th??nh c??ng!
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>';
			return $alert;
		} else {
			$update_image_1 = ($file_name_1 == "") ? $image_1_old : $file_name_1;
			$update_image_2 = ($file_name_2 == "") ? $image_2_old : $file_name_2;
			$update_image_3 = ($file_name_3 == "") ? $image_3_old : $file_name_3;
			if ($file_name_1 != "")
				move_uploaded_file($file_temp_1, $uploaded_image_1);
			if ($file_name_2 != "")
				move_uploaded_file($file_temp_2, $uploaded_image_2);
			if ($file_name_1 != "")
				move_uploaded_file($file_temp_3, $uploaded_image_3);
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
			if ($result) {
				$alert['mess'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
									<strong>Th??ng b??o:</strong> C???p nh???t s???n ph???m th??nh c??ng!
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>';
				return $alert;
			} else {
				$alert['mess'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<strong>Th??ng b??o:</strong> C???p nh???t s???n ph???m kh??ng th??nh c??ng!
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>';
				return $alert;
			}
		}
	}
	public function show_product()
	{

		$query = "

			SELECT product.*, brand.brandName, product_type.typeName, product_type.cateID

			FROM product INNER JOIN product_type ON product.typeID = product_type.typeID 

			INNER JOIN brand ON product.brandID = brand.brandID 

			order by product.productID desc";

		$result = $this->db->select($query);
		return $result;
	}
	public function delete_product($id)
	{
		$query = "DELETE FROM product where productID = '$id'";
		$result = $this->db->delete($query);
		if ($result) {
			$alert = "<span class='text-success'>X??a s???n ph???m th??nh c??ng!</span>";
			return $alert;
		} else {
			$alert = "<span class='text-danger'>X??a s???n ph???m kh??ng th??nh c??ng</span>";
			return $alert;
		}
	}
	//END BACKEND 
	public function prod_status_convert($status)
	{
		switch ($status) {
			case 0:
				return "M???i ra m???t";
			case 1:
				return "N???i b???t";
			case 2:
				return "B??n ch???y";
			case 3:
				return "??ang khuy???n m??i";
			case 4:
				return "Gi???m gi?? s???c";
			case 5:
				return "H??ng s???p v???";
		}
	}
	public function get_product_by_status($productStatus)
	{

		$rowsPerPage = 4;
		if (!isset($_GET['page']) || $_GET['page']=='') {
			$_GET['page'] = 1;
		}
		$offset =($_GET['page']-1)*$rowsPerPage;

		$query = "SELECT product.*, brand.brandName FROM product 
			INNER JOIN brand ON product.brandID = brand.brandID 
			where productStatus = '$productStatus' order by productID DESC LIMIT $offset, $rowsPerPage";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_all_product_by_status($productStatus)
	{
		$query = "SELECT product.*, brand.brandName FROM product 
			INNER JOIN brand ON product.brandID = brand.brandID 
			where productStatus = '$productStatus' order by productID DESC";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_featured_product()
	{
		$query = "SELECT product.*, brand.brandName FROM product 
			INNER JOIN brand ON product.brandID = brand.brandID where productStatus = '1' order by RAND() LIMIT 4 ";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_discount_product()
	{
		$query = "SELECT product.*, brand.brandName FROM product 
			INNER JOIN brand ON product.brandID = brand.brandID where productStatus = '4' order by RAND() LIMIT 4 ";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_new_product()
	{
		$query = "SELECT product.*, brand.brandName FROM product 
			INNER JOIN brand ON product.brandID = brand.brandID where productStatus = '0' order by productID desc LIMIT 4 ";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_product_by_ID($productID)
	{
		$query = "SELECT product.*, brand.brandName FROM product 
			INNER JOIN brand ON product.brandID = brand.brandID where product.productID = '$productID'";
		$result = $this->db->select($query);
		return $result;
	}	
	public function get_details($id)
	{
		$query = "

			SELECT product.*, brand.brandName, product_type.typeName, product_type.cateID

			FROM product INNER JOIN product_type ON product.typeID = product_type.typeID 

			INNER JOIN brand ON product.brandID = brand.brandID WHERE product.productID = '$id'

			";

		$result = $this->db->select($query);
		return $result;
	}
	public function get_rating($id)
	{
		$query = "

			SELECT *
			FROM product_review
			WHERE productID = '$id'
			";

		$result = $this->db->select($query);
		return $result;
	}
	public function insert_slider($data, $files)
	{
		$sliderName = mysqli_real_escape_string($this->db->link, $data['sliderName']);
		$sliderStatus = mysqli_real_escape_string($this->db->link, $data['sliderStatus']);

		$alert = [];
		$alert['success'] = 0;
		$errors = [];

		//Kiem tra h??nh ???nh v?? l???y h??nh ???nh cho v??o folder images
		$permitted  = array('jpg', 'jpeg', 'png', 'gif');
		//File ???nh
		$file_name = $_FILES['sliderImage']['name'];
		$file_size = $_FILES['sliderImage']['size'];
		$file_temp = $_FILES['sliderImage']['tmp_name'];

		$div = explode('.', $file_name);
		$file_ext = strtolower(end($div));
		$unique_image = $file_name;
		$uploaded_image = "../images/slide_img/" . $unique_image;

		// Validate
		$alert['sliderName'] = ($sliderName == "") ? "Ch??a nh???p ti??u ?????" : "";
		$alert['sliderStatus'] = ($sliderStatus == "N") ? "Ch??a ch???n tr???ng th??i" : "";
		//Ki???m tra file ???nh
		$alert['sliderImage'] = "";
		if ($file_name == "") {
			$alert['sliderImage'] = "Ch??a ch???n ???nh";
		} else {
			if (in_array($file_ext, $permitted) === false) {
				$alert['sliderImage'] = "Ch??? upload file: " . implode(', ', $permitted);
				$errors[] = $alert['sliderImage'];
			} elseif ($file_size > 20971520) {
				$alert['sliderImage'] = "K??ch th?????c ???nh ph???i < 2MB!";
				$errors[] = $alert['sliderImage'];
			} else
				$alert['sliderImage'] = "";
		}

		if ($sliderName == "" || $sliderStatus == "N" || !empty($errors)) {
			$alert['mess'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Th??ng b??o:</strong> Th??m slider kh??ng th??nh c??ng!
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>';
			return $alert;
		} else {
			move_uploaded_file($file_temp, $uploaded_image);
			$query = "INSERT INTO slider(sliderName,sliderStatus,sliderImage) VALUES('$sliderName','$sliderStatus','$unique_image')";
			$result = $this->db->insert($query);
			if ($result) {
				$alert['mess'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
									<strong>Th??ng b??o:</strong> Th??m slider th??nh c??ng!
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>';
				$alert['success'] = 1;
				return $alert;
			} else {
				$alert['mess'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<strong>Th??ng b??o:</strong> Th??m slider kh??ng th??nh c??ng!
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>';
				return $alert;
			}
		}
	}
	public function update_slider($id, $data, $files)
	{
		$sliderID = mysqli_real_escape_string($this->db->link, $id);
		$sliderName = mysqli_real_escape_string($this->db->link, $data['sliderName']);
		$sliderStatus = mysqli_real_escape_string($this->db->link, $data['sliderStatus']);
		$sliderImageOld = mysqli_real_escape_string($this->db->link, $data['sliderImageOld']);

		$alert = [];
		$alert['success'] = 0;
		$errors = [];

		//Kiem tra h??nh ???nh v?? l???y h??nh ???nh cho v??o folder images
		$permitted  = array('jpg', 'jpeg', 'png', 'gif');
		//File ???nh
		$file_name = $_FILES['sliderImage']['name'];
		$file_size = $_FILES['sliderImage']['size'];
		$file_temp = $_FILES['sliderImage']['tmp_name'];

		$div = explode('.', $file_name);
		$file_ext = strtolower(end($div));
		$unique_image = $file_name;
		$uploaded_image = "../images/slide_img/" . $unique_image;

		// Validate
		$alert['sliderName'] = ($sliderName == "") ? "Ch??a nh???p ti??u ?????" : "";
		$alert['sliderStatus'] = ($sliderStatus == "N") ? "Ch??a ch???n tr???ng th??i" : "";
		//Ki???m tra file ???nh
		$alert['sliderImage'] = "";
		if ($file_name != "") {
			if (in_array($file_ext, $permitted) === false) {
				$alert['sliderImage'] = "Ch??? upload file: " . implode(', ', $permitted);
				$errors[] = $alert['sliderImage'];
			} elseif ($file_size > 20971520) {
				$alert['sliderImage'] = "K??ch th?????c ???nh ph???i < 2MB!";
				$errors[] = $alert['sliderImage'];
			} else
				$alert['sliderImage'] = "";
		}

		if ($sliderName == "" || $sliderStatus == "N" || !empty($errors)) {
			$alert['mess'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Th??ng b??o:</strong> C???p nh???t slider kh??ng th??nh c??ng!
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>';
			return $alert;
		} else {
			$update_image = ($file_name == "") ? $sliderImageOld : $file_name;
			if ($file_name != "")
				move_uploaded_file($file_temp, $uploaded_image);
			$query = "UPDATE slider SET
					sliderName = '$sliderName',
					sliderStatus = '$sliderStatus',
					sliderImage = '$update_image'
					
					WHERE sliderID = '$sliderID'";

			$result = $this->db->update($query);
			if ($result) {
				$alert['mess'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
									<strong>Th??ng b??o:</strong> C???p nh???t slider th??nh c??ng!
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>';
				return $alert;
			} else {
				$alert['mess'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<strong>Th??ng b??o:</strong> C???p nh???t slider kh??ng th??nh c??ng!
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>';
				return $alert;
			}
		}
	}
	public function delete_slider($id)
	{
		$query = "DELETE FROM slider where sliderID = '$id'";
		$result = $this->db->delete($query);
		if ($result) {
			$alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Th??ng b??o:</strong> X??a slider th??nh c??ng!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>';
			return $alert;
		} else {
			$alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Th??ng b??o:</strong> X??a slider kh??ng th??nh c??ng!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>';
			return $alert;
		}
	}
	public function show_slider()
	{
		$query = "SELECT * FROM slider where sliderStatus='0' OR sliderStatus='1' order by sliderStatus asc";
		$result = $this->db->select($query);
		return $result;
	}
	public function show_slider_list()
	{
		$query = "SELECT * FROM slider order by sliderID desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_slider_by_ID($id)
	{
		$query = "SELECT * FROM slider WHERE sliderID = '$id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_all_product()
	{
		$query = "SELECT * FROM product";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_wishlist($customer_id)
	{
		$query = "SELECT * FROM wish_list WHERE customerID = '$customer_id' order by wishID desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function check_wishlist($productID, $customerID)
	{
		$query = "SELECT * FROM wish_list WHERE productID = '$productID' AND customerID ='$customerID'";
		$result = $this->db->select($query);
		return $result;
	}
	public function delete_wlist($productID, $customerID)
	{
		$query = "DELETE FROM wish_list where productID = '$productID' AND customerID='$customerID'";
		$result = $this->db->delete($query);
		return $result;
	}
	public function insertWishlist($productID, $customerID)
	{
		$productID = mysqli_real_escape_string($this->db->link, $productID);
		$customerID = mysqli_real_escape_string($this->db->link, $customerID);
		$alert = "";

		$check_wlist = self::check_wishlist($productID, $customerID);
		if ($check_wlist) {
			$del_wlist = self::delete_wlist($productID, $customerID);
			if ($del_wlist) {
				$alert = "<span class='alert alert-danger alert-dismissible fade show' role='alert'>
					???? b??? y??u th??ch
					<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
					</span>";
				return $alert;
			}
		} else {
			$query_insert = "INSERT INTO wish_list(customerID, productID) VALUES('$customerID','$productID')";
			$insert_wlist = $this->db->insert($query_insert);

			if ($insert_wlist) {
				$alert = "<span class='alert alert-danger alert-dismissible fade show' role='alert'>
						???? th??m v??o y??u th??ch!
						<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
						</span>";
				return $alert;
			} else {
				$alert = "<span class='alert alert-danger alert-dismissible fade show' 		role='alert'>
							Th??m v??o y??u th??ch kh??ng th??nh c??ng!
							<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
						</span>";
				return $alert;
			}
		}
	}
	public function check_user_rating($customerID, $productID)
	{
		$query_order = "SELECT orderID FROM orders WHERE customerID = '$customerID' AND orderStatus='3'";
		$result_order = $this->db->select($query_order);
		if ($result_order) {
			while ($get_order = $result_order->fetch_assoc()) {
				$query_order_detail = "SELECT ratingStatus FROM order_details
					WHERE productID='$productID' AND orderID = '" . $get_order['orderID'] . "'";
				$result_order_detail = $this->db->select($query_order_detail);
				if ($result_order_detail) {
					while ($get_order_detail = $result_order_detail->fetch_assoc()) {
						if ($get_order_detail['ratingStatus'] == 0)
							return true;
						else
							return false;
					}
				}
			}
		}
	}
	public function submit_user_rating($customerID, $productID)
	{
		$query_order = "SELECT orderID FROM orders WHERE customerID = '$customerID' AND orderStatus='3'";
		$result_order = $this->db->select($query_order);
		if ($result_order) {
			while ($get_order = $result_order->fetch_assoc()) {
				$query_order_detail = "SELECT ratingStatus FROM order_details
					WHERE productID='$productID' AND orderID = '" . $get_order['orderID'] . "'";
				$result_order_detail = $this->db->select($query_order_detail);
				if ($result_order_detail) {
					while ($get_order_detail = $result_order_detail->fetch_assoc()) {
						if ($get_order_detail['ratingStatus'] == 0) {
							$query = "UPDATE order_details
							SET ratingStatus = '1' 
							WHERE productID='$productID' AND orderID = '" . $get_order['orderID'] . "'";
							$result = $this->db->update($query);
							if ($result)
								return true;
							else
								return false;
						} else
							return false;
					}
				}
			}
		}
	}
	public function update_remain($productID, $quantity, $type)
	{
		$get_product = self::get_product_by_ID($productID);
		if ($get_product)
			$result = $get_product->fetch_assoc();
		if($type == 0)
			$new_remain = $result['productRemain'] - $quantity;
		elseif($type == 1)
			$new_remain = $result['productRemain'] + $quantity;
		else
			$new_remain = 0;
		if ($productID == "" || $new_remain == "") {
			return false;
		} else {
			
			$query = "UPDATE product SET
						productRemain = '$new_remain'						
						WHERE productID = '$productID'";

			$result = $this->db->update($query);
			if ($result) {
				return true;
			} else {
				return false;
			}
		}
	}
}
?>