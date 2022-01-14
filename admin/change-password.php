<?php
include_once "./includes/sidebar_topbar.php";
include_once '../classes/user.php';
?>
<?php
if(isset($_POST['back']))
echo "<script>window.location ='index.php'</script>";
$usr = new User();
$err = '';
$err_color = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['change'])){
        $get_old_pw = $usr->get_admin_old_pw(Session::get('adminID'));
        $oldPw = md5($_POST['oldPw']);
        if($get_old_pw == $oldPw){
            $newPw = md5($_POST['newPw']);
            $confirmPw = md5($_POST['confirmPw']);
            if($newPw == $confirmPw){
                if(strlen($_POST['newPw'])>=8){
                    $updateAdmin = $usr->update_admin_password($newPw, Session::get('adminID'));
                    if($updateAdmin == true){
                        $err = "Đổi mật khẩu thành công!";
                        $err_color = 'alert-success';
                    }else{
                        $err = "Đổi mật khẩu không thành công!";
                        $err_color = 'alert-danger';
                    }
                }else{
                    $err = "Mật khẩu mới phải có tối thiểu 8 ký tự!";
                    $err_color = 'alert-danger';
                }
            }
            else{
                $err = "Mật khẩu xác nhận không đúng!";
                $err_color = 'alert-danger';
            }
        }else{
            $err = "Mật khẩu cũ không đúng!";
            $err_color = 'alert-danger';
        }
        
    }
}
?>
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Đổi mật khẩu</h1>

<div class="card mb-4 py-3 border-bottom-warning shadow">
    <div class="card-body">
        <div class="mb-3">
            <div class="row">
                <div class="col-sm-6">
                    <?php
                        if($err!=''){
                            echo '<div class="alert '.$err_color.' alert-dismissible fade show" role="alert">
                            <strong>Thông báo:</strong> '.$err.'
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
                        }
                    ?>
                    <form action="" method="POST">
                        <label for="inputOldPw" class="form-label">Mật khẩu cũ:</label>
                        <input required class="form-control mb-3" name="oldPw" type="password" id="inputOldPw" value="<?php if(isset($_POST['oldPw'])) echo $_POST['oldPw'] ?>">
                        <label for="inputNewPw" class="form-label">Mật khẩu mới:</label>
                        <input required class="form-control mb-3" name="newPw" type="password" id="inputNewPw" value="<?php if(isset($_POST['newPw'])) echo $_POST['newPw'] ?>">
                        <label for="inputNewPw2" class="form-label">Xác nhận mật khẩu mới:</label>
                        <input required class="form-control mb-3" name="confirmPw" type="password" id="inputNewPw2" value="<?php if(isset($_POST['confirmPw'])) echo $_POST['confirmPw'] ?>">
                        <div class="float-right">
                            <input type="submit" name="back" value="Quay lại" class="btn btn-secondary shadow">
                            <input type="submit" name="change" value="Thay đổi" class="btn btn-primary shadow">
                        </div>
                        
                    </form>
                    
                </div>
                <div class="col-sm-6">

                </div>
            </div>

        </div>
    </div>
</div>


<?php
include "./includes/footer.php";
?>