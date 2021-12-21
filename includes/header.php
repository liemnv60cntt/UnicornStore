<?php
include 'lib/session.php';
Session::init();
?>
<?php
	include_once ('lib/database.php');
	include_once ('helpers/format.php');
    //Tự động include các class trong thư mục classes
    spl_autoload_register(function($className){
        include_once "classes/".$className.".php";
    });
    $db = new Database();
	$fm = new Format();
	$ct = new Cart();
	$us = new User();
	$br = new Brand();
	$cate = new Category();
    $prodtype = new ProductType();
	$prod = new Product();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title><?php echo $page_title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/style_header.css">
    <link rel="stylesheet" type="text/css" href="./css/style_card.css">
    <link rel="stylesheet" type="text/css" href="./css/style_sidebar.css">
    <link rel="stylesheet" type="text/css" href="./css/style_detail.css">
    <link rel="stylesheet" type="text/css" href="./css/style_404.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg justify-content-center shadow" id="navbar">
        <div class="container-fluid" style="max-width: 1400px;">
            
            <!-- <button class="navbar-toggler m-2" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <i class='fas fa-tasks' style='font-size:30px'></i>
            </button> -->
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
                <i class='fas fa-list-ul' style='font-size:24px'></i>
            </button>
            <a class="navbar-brand" href="index.php">
                <img src="./images/more/unicorn-logo-3-removebg.png" alt="Logo" id="logo-img">
            </a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <div class="hamburger-toggle">
                    <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </button>
            <!-- <ul class="navbar-nav">
   
                <li class="nav-item">
                    <a href="#sidebar" class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse"><i class='fas fa-list-ul' style='font-size:20px'></i> Danh mục</a>

                </li>

            </ul> -->

            <div class="collapse navbar-collapse" id="mynavbar">

                <form class="d-flex me-auto input-group shadow-sm rounded" style="max-width: 600px;">
                    <input class="form-control" type="text" placeholder="Tìm kiếm sản phẩm">
                    <button class="btn btn-primary search-btn" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="cart_page.php">
                            <i class="fa" style="font-size:26px">&#xf07a;</i>
                            <span class='badge badge-warning' id='lblCartCount'></span> Giỏ hàng</a>
                    </li>
                    <li class="nav-item mt-1 dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" href="javascript:void(0)">
                            <i class='fas fa-user-alt' style='font-size:20px'></i> Tài khoản</a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item text-dark" href="#">Action</a></li>
                                <li><a class="dropdown-item text-dark" href="#">Another action</a></li>
                                <li><a class="dropdown-item text-dark" href="#">Something else here</a></li>
                                <li><a class="dropdown-item text-dark border-top border-secondary border-2" href="#"><i class='fas fa-sign-out-alt'></i> Đăng xuất</a></li>
                            </ul>
                    </li>
                </ul>
                
            </div>
        </div>
    </nav>
    <!-- Content -->
    <div class="container-fluid" style="margin-top:10em; max-width: 1400px;">