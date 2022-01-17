<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
/**
 * 
 */
class Category
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function insert_category($cateName)
	{

		$cateName = $this->fm->validation($cateName);
		$cateName = mysqli_real_escape_string($this->db->link, $cateName);

		if (empty($cateName)) {
			$alert = "<span class='text-danger'>Tên danh mục không được để trống!</span>";
			return $alert;
		} else {
			$query = "INSERT INTO category(cateName) VALUES('$cateName')";
			$result = $this->db->insert($query);
			if ($result) {
				$alert = "<span class='text-success'>Thêm danh mục thành công!</span>";
				return $alert;
			} else {
				$alert = "<span class='text-danger'>Thêm danh mục không thành công!</span>";
				return $alert;
			}
		}
	}
	public function show_category()
	{
		$query = "SELECT * FROM category order by cateID desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_cate_byID($cateID)
	{
		$query = "SELECT * FROM category WHERE cateID = $cateID";
		$result = $this->db->select($query);
		return $result;
	}
	public function update_category($cateName, $cateID)
	{

		$cateName = $this->fm->validation($cateName);
		$cateName = mysqli_real_escape_string($this->db->link, $cateName);
		$cateID = mysqli_real_escape_string($this->db->link, $cateID);

		if (empty($cateName)) {
			$alert = "<span class='text-danger'>Tên danh mục không được để trống!</span>";
			return $alert;
		} else {
			$query = "UPDATE category SET cateName = '$cateName' WHERE cateId = '$cateID'";
			$result = $this->db->update($query);
			if ($result) {
				$alert = "<span class='text-success'>Sửa danh mục thành công!</span>";
				return $alert;
			} else {
				$alert = "<span class='text-danger'>Sửa danh mục không thành công!</span>";
				return $alert;
			}
		}
	}
	public function delete_category($cateID)
	{
		$query = "DELETE FROM category where cateId = '$cateID'";
		$result = $this->db->delete($query);
		if ($result) {
			$alert = "<span class='text-success'>Xóa danh mục thành công!</span>";
			return $alert;
		} else {
			$alert = "<span class='text-danger'>Xóa danh mục không thành công!</span>";
			return $alert;
		}
	}
	public function get_product_by_cate($cateID)
	{
		$rowsPerPage = 4;
		if (!isset($_GET['page']) || $_GET['page']=='') {
			$_GET['page'] = 1;
		}
		$offset = ($_GET['page'] - 1) * $rowsPerPage;
		$query = "SELECT product.*, brand.brandName
			 FROM product, brand, product_type
			  WHERE product.brandID = brand.brandID 
			  	and product.typeID = product_type.typeID
				and product_type.cateID = $cateID
			  	order by product.typeID desc LIMIT $offset, $rowsPerPage";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_all_product_by_cate($cateID)
	{
		$query = "SELECT product.*, brand.brandName
			 FROM product, brand, product_type
			  WHERE product.brandID = brand.brandID 
			  	and product.typeID = product_type.typeID
				and product_type.cateID = $cateID
			  	order by product.typeID desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_distinct_product_brandName_by_cate($cateID)
	{
		$query = "SELECT DISTINCT brand.brandName
			 FROM product, brand, product_type
			  WHERE product.brandID = brand.brandID 
			  	and product.typeID = product_type.typeID
				and product_type.cateID = $cateID
			  	order by brand.brandName asc";
		$result = $this->db->select($query);
		return $result;
	}
}
?>