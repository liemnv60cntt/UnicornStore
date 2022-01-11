<?php 
include "../classes/user.php";
include "./sendmail.php";
include "../lib/session.php";

$_user = new User();
$ss = new Session();
$ss->init();

$email = "";
$name = "";
$address = "";
$city = "";
$district = "";
$phone = "";
$errors = array();

//if user signup button
if(isset($_POST['signup'])){
    $name =  $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $district = $_POST['district'];
    $phone = $_POST['phone'];
    $email =  $_POST['email'];
    $password =  $_POST['password'];
    $cpassword =  $_POST['cpassword'];
    if($password !== $cpassword){
        $errors['password'] = "Mật khẩu xác nhận không khớp!";
    }
    
    $email_check = $_user->get_users_by_email($email);
    if($email_check){
        $errors['email'] = "Email này đã tồn tại!";
    }
    if(count($errors) === 0){
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $code = rand(999999, 111111);
        $status = "notverified";
        $_insert_user = $_user->insert_user($name, $address, $city, $district, $phone, $email, $encpass, $code, $status);
        if($_insert_user){
            $subject = "Mã xác thực Email";
            $message = "Mã xác thực email của bạn là: <h3> $code </h3>Unicorn Store.";
            $nameTo = "Thành viên mới";
            $nFrom = 'UnicornStore';
            $mFrom = 'unicornstore512@gmail.com';  //dia chi email cua ban 
            $mPass = 'Liemunicorn512';       //mat khau email cua ban
            
            if(sendMail($subject, $message, $nFrom, $mFrom, $mPass, $nameTo, $email)){
                $info = "Chúng tôi đã gửi một mã xác thực đến Email của bạn - $email";
                
                $ss->set('info', $info);
                $ss->set('email', $email);
                $ss->set('password', $password);
                header('location: user-otp.php');
                exit();
            }else{
                $errors['otp-error'] = "Lỗi khi gửi mã!";
            }
        }else{
            $errors['db-error'] = "Lỗi khi thêm dữ liệu vào hệ thống!";
        }
    }

}
    //if user click verification code submit button
    if(isset($_POST['check'])){
        $ss->set('info', "");
        $otp_code = $_POST['otp'];
        
        $check_code = $_user->get_users_by_code($otp_code);
        if($check_code){
            $fetch_data = $check_code->fetch_assoc();
            $fetch_code = $fetch_data['code'];
            $email = $fetch_data['email'];
            $name = $fetch_data['customerName'];
            $code = 0;
            $status = 'verified';
            
            $update_res = $_user->update_otp($code, $status, $fetch_code);
            if($update_res){
                $info = "Chúc mừng bạn đã đăng ký tài khoản thành công!";
                $ss->set('info', $info);
                $ss->set('name', $name);
                $ss->set('email', $email);
                header('location: signup-success.php');
                exit();
            }else{
                $errors['otp-error'] = "Lỗi khi cập nhật mã!";
            }
        }else{
            $errors['otp-error'] = "Mã xác thực không đúng!";
        }
    }

    //if user click login button
    if(isset($_POST['login'])){
        $ss->set('userlogin', false);
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $email_check = $_user->get_users_by_email($email);
        if($email_check){
            $fetch = $email_check->fetch_assoc();
            $fetch_pass = $fetch['password'];
            if(password_verify($password, $fetch_pass)){
                $ss->set('email', $email);
                $status = $fetch['status'];
                $username = $fetch['customerName'];
                $userid = $fetch['customerID'];
                if($status == 'verified'){
                    $ss->set('email', $email);
                    // $ss->set('password', $password);
                    $ss->set('username',$username);
                    $ss->set('userid', $userid);
                    $ss->set('userlogin', true);
                    header('location: ../index.php');
                }else{
                    $info = "Email của bạn chưa được xác thực - $email";
                    $ss->set('info', $info);
                    header('location: user-otp.php');
                }
            }else{
                $errors['email'] = "Sai mật khẩu!";
            }
        }else{
            $errors['email'] = "Bạn chưa đăng ký tài khoản! Nhấn vào link bên dưới để đăng ký!.";
        }
    }

    //if user click continue button in forgot password form
    if(isset($_POST['check-email'])){
        $email = $_POST['email'];
        
        $email_check = $_user->get_users_by_email($email);
        if($email_check){
            $code = rand(999999, 111111);
            
            $insert_code = $_user->update_user($code, $email);
            if($insert_code){
                $subject = "Mã xác thực thay đổi mật khẩu";
                $message = "Mã xác thực thay đổi mật khẩu của bạn là:<h3> $code </h3>Unicorn Store.";
                $nameTo = "Thành viên";
                $nFrom = 'UnicornStore';
                $mFrom = 'unicornstore512@gmail.com';  //dia chi email cua ban 
                $mPass = 'Liemunicorn512'; 
                if(sendMail($subject, $message, $nFrom, $mFrom, $mPass, $nameTo, $email)){
                    $info = "Chúng tôi vừa gửi mã xác thực lại mật khẩu tới: $email";
                    $ss->set('info', $info);
                    $ss->set('email', $email);
                    header('location: reset-code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Lỗi khi gửi mã!";
                }
            }else{
                $errors['db-error'] = "Có lỗi xảy ra!";
            }
        }else{
            $errors['email'] = "Email này không tồn tại trong hệ thống!";
        }
    }

    //if user click check reset otp button
    if(isset($_POST['check-reset-otp'])){
        $ss->set('info', "");
        $otp_code = $_POST['otp'];
        
        $check_code = $_user->get_users_by_code($otp_code);
        if($check_code){
            $fetch_data = $check_code->fetch_assoc();
            $email = $fetch_data['email'];
            $ss->set('email', $email);
            $info = "Vui lòng nhập mật khẩu mới.";
            $ss->set('info', $info);
                
            header('location: new-password.php');
            exit();
        }else{
            $errors['otp-error'] = "Sai mã xác thực!";
        }
    }

    //if user click change password button
    if(isset($_POST['change-password'])){
        $ss->set('info', "");
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        if($password !== $cpassword){
            $errors['password'] = "Mật khẩu xác nhận không đúng!";
        }else{
            $code = 0;
            $email = $_SESSION['email']; //getting this email using session
            $encpass = password_hash($password, PASSWORD_BCRYPT);
            
            $update_pass = $_user->update_password($code, $encpass, $email);
            if($update_pass){
                $info = "Mật khẩu của bạn đã thay đổi. Bây giờ bạn có thể đăng nhập với mật khẩu mới.";
                $ss->set('info', $info);
                header('Location: password-changed.php');
            }else{
                $errors['db-error'] = "Lỗi khi thay đổi mật khẩu!";
            }
        }
    }
    
   //if login now button click
    if(isset($_POST['login-now'])){
        header('Location: login-user.php');
    }
?>