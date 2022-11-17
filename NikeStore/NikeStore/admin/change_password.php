<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý website Nike Store</title>
    <?php include("component/css.php") ?>
</head>
<body class="body-bg">
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div> 
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <?php include("./component/header.php"); ?>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <?php include("component/search.php"); ?>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left"><b>Đổi Mật Khẩu</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><a href="manage_user.php">Quản lý người dùng</a></li>
                                <li><span>Đổi mật khẩu</span></li>
                            </ul>
                        </div>
                    </div>
                    <?php include("component/logged.php"); ?>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- form primary start -->
                <div class="card mt-3">
                    <div class="card-body">
                        <form action="change_password.php?do=change" method="POST">
                            <div class="form-group">
                                <label for="oldpassword">Mật khẩu cũ</label>
                                <input type="password" class="form-control" name="oldpassword" required>
                            </div>
                            <div class="form-group">
                                <label for="newpassword">Mật khẩu mới: </label>
                                <input type="password" class="form-control" name="newpassword" required>
                            </div>
                            <div class="form-group">
                                <label for="re_newpassword">Xác nhận mật khẩu mới: </label>
                                <input type="password" class="form-control" name="re_newpassword" required>
                                <?php
                                    if(isset($_GET["do"])){
                                        $oldpassword = $_POST["oldpassword"];
                                        $newpassword = $_POST["newpassword"];
                                        $re_newpassword = $_POST["re_newpassword"];
                                        if($oldpassword==$newpassword){
                                            echo '<p class="text-danger mt-3">Mật khẩu mới không được trùng với mật khẩu cũ!</p>';
                                        }
                                        else{
                                            if($newpassword != $re_newpassword)
                                                echo '<p class="text-danger mt-3">Mật khẩu xác nhận không đúng!</p>';
                                            else{
                                                $current_username = $_SESSION["UserName"];
                                                $sql = "select password from user where username ='$current_username'";
                                                $result = mysqli_query($con,$sql);
                                                $row = mysqli_fetch_assoc($result);
                                                $current_password = $row['password'];
                                                if(md5($oldpassword)!=$current_password)
                                                    echo '<p class="text-danger mt-3">Mật khẩu cũ không đúng!</p>';
                                                else{
                                                    $sql = "UPDATE `user` SET `password` = '".md5($newpassword)."' WHERE `user`.`username` = '$current_username'";
                                                    mysqli_query($con,$sql);
                                                    echo '<p class="text-success mt-3">Đổi mật khẩu thành công!</p>';
                                                }
                                            }
                                        }
                                    }
                                ?>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right mt-3">Đổi mật khẩu</button>
                        </form>
                    </div>
                </div>
                <!-- form primary end -->
            </div>
        </div>
        <!-- main content area end -->
        <?php include("component/footer.php") ?>
    </div>
    <!-- page container area end -->
    <?php include("component/js.php") ?>
</body>
</html>