<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>

<?php
	/**
	 * 
	 */
	class ProductType
	{
		private $db;
		private $fm;
		
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		
		public function insert_type($typeName, $cateID){

			$typeName = $this->fm->validation($typeName);
			$typeName = mysqli_real_escape_string($this->db->link, $typeName);
			$cateID = mysqli_real_escape_string($this->db->link, $cateID);
			
			if(empty($typeName)){
				$alert = "<span class='text-danger'>Tên loại sản phẩm không được để trống!</span>";
				return $alert;
			}elseif($cateID=="N"){
                $alert = "<span class='text-danger'>Chưa chọn danh mục sản phẩm!</span>";
				return $alert;
            }else{
				$query = "INSERT INTO product_type(typeName, cateID) VALUES('$typeName', '$cateID')";
				$result = $this->db->insert($query);
				if($result){
					$alert = "<span class='text-success'>Thêm loại sản phẩm thành công!</span>";
					return $alert;
				}else{
					$alert = "<span class='text-danger'>Thêm loại sản phẩm không thành công!</span>";
					return $alert;
				}
			}
		}
		public function show_type(){
			$query = "SELECT * FROM product_type order by typeID desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function show_type_by_cate($cateID){
			$query = "SELECT * FROM product_type WHERE cateID = '$cateID' order by typeID desc";
			$result = $this->db->select($query);
			return $result;
		}
        public function get_type_byID($typeID){
			$query = "SELECT * FROM product_type WHERE typeID = $typeID";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_type_detail_byID($typeID){
			$query = "SELECT product_type.*, category.* 
				FROM product_type INNER JOIN category ON product_type.cateID = category.cateID
				WHERE typeID = $typeID";
			$result = $this->db->select($query);
			return $result;
		}
		public function update_type($typeName, $cateID, $typeID){

			$typeName = $this->fm->validation($typeName);
			$typeName = mysqli_real_escape_string($this->db->link, $typeName);
            $cateID = mysqli_real_escape_string($this->db->link, $cateID);
			$typeID = mysqli_real_escape_string($this->db->link, $typeID);

			if(empty($typeName)){
				$alert = "<span class='text-danger'>Tên loại sản phẩm không được để trống!</span>";
				return $alert;
			}elseif($cateID=="N"){
                $alert = "<span class='text-danger'>Chưa chọn danh mục sản phẩm!</span>";
				return $alert;
            }else{
				$query = "UPDATE product_type SET typeName = '$typeName', cateID = '$cateID' WHERE typeId = '$typeID'";
				$result = $this->db->update($query);
				if($result){
					$alert = "<span class='text-success'>Sửa loại sản phẩm thành công!</span>";
					return $alert;
				}else{
					$alert = "<span class='text-danger'>Sửa loại sản phẩm không thành công!</span>";
					return $alert;
				}
			}

		}
		public function delete_type($typeID){
			$query = "DELETE FROM product_type where typeId = '$typeID'";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='text-success'>Xóa loại sản phẩm thành công!</span>";
				return $alert;
			}else{
				$alert = "<span class='text-danger'>Xóa loại sản phẩm không thành công!</span>";
				return $alert;
			}
			
		}
		public function get_product_by_type($typeID){
			$query = "SELECT product.*, brand.brandName
			 FROM product INNER JOIN brand ON product.brandID = brand.brandID
			  WHERE typeID='$typeID' order by typeID desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_distinct_product_brandName_by_type($typeID){
			$query = "SELECT DISTINCT brand.brandName
			 FROM product INNER JOIN brand ON product.brandID = brand.brandID
			  WHERE product.typeID='$typeID' order by brand.brandName asc";
			$result = $this->db->select($query);
			return $result;
		}
		public function show_type_fontend(){
			$query = "SELECT * FROM tbl_type order by catId desc";
			$result = $this->db->select($query);
			return $result;
		}
		
		public function get_name_by_cat($typeID){
			$query = "SELECT tbl_product.*,tbl_type.typeName,tbl_type.catId FROM tbl_product,tbl_type WHERE tbl_product.catId=tbl_type.catId AND tbl_product.catId ='$typeID' LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}
		


	}
?>