
<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>

<?php
	/**
	 * 
	 */
	class Brand
	{
		private $db;
		private $fm;
		
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		
		public function insert_brand($brandName, $cateID){

			$brandName = $this->fm->validation($brandName);
			$brandName = mysqli_real_escape_string($this->db->link, $brandName);
			$cateID = mysqli_real_escape_string($this->db->link, $cateID);
			
			if(empty($brandName)){
				$alert = "<span class='text-danger'>Tên thương hiệu không được để trống!</span>";
				return $alert;
			}elseif($cateID=="N"){
                $alert = "<span class='text-danger'>Chưa chọn danh mục sản phẩm!</span>";
				return $alert;
			}else{
				$query = "INSERT INTO brand(brandName, cateID) VALUES('$brandName', '$cateID')";
				$result = $this->db->insert($query);
				if($result){
					$alert = "<span class='text-success'>Thêm thương hiệu thành công!</span>";
					return $alert;
				}else{
					$alert = "<span class='text-danger'>Thêm thương hiệu không thành công!</span>";
					return $alert;
				}
			}
		}
		public function show_brand(){
			$query = "SELECT * FROM brand order by brandID desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function show_brand_by_cate($cateID){
			$query = "SELECT * FROM brand WHERE cateID = '$cateID' order by brandID desc";
			$result = $this->db->select($query);
			return $result;
		}
        public function get_brand_byID($brandID){
			$query = "SELECT * FROM brand WHERE brandID = $brandID";
			$result = $this->db->select($query);
			return $result;
		}
		public function update_brand($brandName, $cateID, $brandID){

			$brandName = $this->fm->validation($brandName);
			$brandName = mysqli_real_escape_string($this->db->link, $brandName);
			$brandID = mysqli_real_escape_string($this->db->link, $brandID);
			$cateID = mysqli_real_escape_string($this->db->link, $cateID);

			if(empty($brandName)){
				$alert = "<span class='text-danger'>Tên thương hiệu không được để trống!</span>";
				return $alert;
			}elseif($cateID=="N"){
                $alert = "<span class='text-danger'>Chưa chọn danh mục sản phẩm!</span>";
				return $alert;
            }else{
				$query = "UPDATE brand SET brandName = '$brandName', cateID = '$cateID' WHERE brandID = '$brandID'";
				$result = $this->db->update($query);
				if($result){
					$alert = "<span class='text-success'>Sửa thương hiệu thành công!</span>";
					return $alert;
				}else{
					$alert = "<span class='text-danger'>Sửa thương hiệu không thành công!</span>";
					return $alert;
				}
			}

		}
		public function delete_brand($brandID){
			$query = "DELETE FROM brand where brandId = '$brandID'";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='text-success'>Xóa thương hiệu thành công!</span>";
				return $alert;
			}else{
				$alert = "<span class='text-danger'>Xóa thương hiệu không thành công!</span>";
				return $alert;
			}
			
		}
		
		public function show_brand_fontend(){
			$query = "SELECT * FROM tbl_brand order by catId desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_product_by_cat($brandID){
			$query = "SELECT * FROM tbl_product WHERE catId='$brandID' order by catId desc LIMIT 8";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_name_by_cat($brandID){
			$query = "SELECT tbl_product.*,tbl_brand.brandName,tbl_brand.catId FROM tbl_product,tbl_brand WHERE tbl_product.catId=tbl_brand.catId AND tbl_product.catId ='$brandID' LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}
		


	}
?>