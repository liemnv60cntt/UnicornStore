<?php
include_once "../classes/product.php";
include "../lib/session.php";
Session::init();
// Action from cart.js
$prod = new Product();

if(isset($_POST['actionWL'])){
    if($_POST['actionWL'] == 'addWL'){
        $customerID = $_POST['customer_ID_WL'];
        $productID = $_POST['product_ID_WL'];
        $insertWL = $prod->insertWishlist($productID, $customerID);        
    }
    if($_POST["actionWL"] == 'remove-wishlist')
	{
		$productID = $_POST['product_ID_WL'];
        $deleteWishList = $prod->delete_wlist($productID, Session::get('userid'));
	}
}

// Action from cart.js

?>