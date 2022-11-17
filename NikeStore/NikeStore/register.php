<?php
    include("connect.php");

    if(isset($_POST["HoTen"])){
        $hoTen = $_POST["HoTen"];
        $email = $_POST["Email"];
        $phone = $_POST["Phone"];
        $address = $_POST["Address"];
        $username = $_POST["UserName"];
        $password = $_POST["PassWord"];
        $flag = true;
        $seo = url_slug($hoTen);
    }
    else{
        $hoTen = null;
        $email = null;
        $phone = null;
        $address = null;
        $username = null;
        $password = null;
    }
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Đăng ký</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- sweetalert -->
    <script src="assets/js/sweetalert2.all.min.js"></script>
</head>

<body>
    <?php if(!isset($_POST['HoTen'])){ ?>
        <div id="preloader">
            <div class="loader"></div>
        </div>
    <?php } ?>
    <!-- login area start -->
    <div class="login-area login-bg" >
        <div class="container">
            <div class="login-box ptb--100">
                <form action="register.php?do=register" method="post" id="register-form">
                    <div class="login-form-head">
                        <h4>Đăng ký</h4>
                        <p>Hãy trở thành thành viên để nhận thêm nhiều ưu đãi từ <a href="index.php">Nike Store</a></p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputName1">Họ và tên</label>
                            <input type="text" name="HoTen" id="exampleInputName1" field-name="họ tên" value="<?=$hoTen?>">
                            <i class="fa fa-user"></i>
                            <p class="text-danger mt-2"></p>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Địa chỉ email</label>
                            <input type="email" name="Email" id="exampleInputEmail1" field-name="email" value="<?=$email?>">
                            <i class="ti-email"></i>
                            <p class="text-danger mt-2">
                            <?php
                                if(isset($_POST["HoTen"])){
                                    $sql = "select * from user where email = '$email'";
                                    $result = mysqli_query($con, $sql);

                                    if(mysqli_num_rows($result) != 0){
                                        echo "Email đã tồn tại";
                                        $flag = false;
                                    }
                                }
                            ?>
                            </p>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPhone">Số điện thoại</label>
                            <input type="phone" name="Phone" id="exampleInputPhone" field-name="số điện thoại" value="<?=$phone?>">
                            <i class="fa fa-phone"></i>
                            <p class="text-danger mt-2"></p>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputAddress">Địa chỉ</label>
                            <input type="text" name="Address" id="exampleInputAddress" field-name="địa chỉ" value="<?=$address?>">
                            <i class="fa fa-home"></i>
                            <p class="text-danger mt-2"></p>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputUsername">Tên đăng nhập</label>
                            <input type="text" name="UserName" id="exampleInputUsername" field-name="tên đăng nhập" value="<?=$username?>">
                            <i class="ti-user"></i>
                            <p class="text-danger mt-2">
                            <?php
                                if(isset($_POST["HoTen"])){
                                    $sql = "select * from user where username = '$username'";
                                    $result = mysqli_query($con, $sql);

                                    if(mysqli_num_rows($result) != 0){
                                        echo "Tài khoản đã tồn tại";
                                        $flag = false;
                                    }
                                }
                            ?>
                            </p>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Mật khẩu</label>
                            <input type="password" name="PassWord" id="exampleInputPassword1" field-name="mật khẩu">
                            <i class="ti-lock"></i>
                            <p class="text-danger mt-2"></p>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword2">Mật khẩu xác nhận</label>
                            <input type="password" name="RePassWord" id="exampleInputPassword2" field-name="mật khẩu xác nhận">
                            <i class="ti-lock"></i>
                            <p class="text-danger mt-2" id="error_RePassWord"></p>
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="button">Đăng ký <i class="ti-arrow-right"></i></button>
                            <div class="login-other row mt-4">
                                <div class="col-6">
                                    <a class="fb-login" href="#">Đăng ký bằng <i class="fa fa-facebook"></i></a>
                                </div>
                                <div class="col-6">
                                    <a class="google-login" href="#">Đăng ký bằng <i class="fa fa-google"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer text-center mt-3">
                            <p class="text-muted">Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
                        </div>
                        <!--div class="alert alert-danger error mt-3" role="alert"></div-->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/register.js"></script>

    <!-- php -->
    <?php    
        if(isset($_POST["HoTen"])){
            if($flag){
                $password = md5($password);
                $sql = "INSERT INTO `user` (`ID`,`role_id`, `username`, `password`, `name`, `email`, `phone`, `address`, `point`, `avatar`,`seo`,`active`) VALUES (NULL,'3', '$username', '$password','$hoTen', '$email', '$phone', '$address',0,'../assets/images/avatar/avatar.png','$seo',1)";
                mysqli_query($con, $sql);
    ?>
        <script>
                Swal.fire(
                    'Đăng kí thành công',
                    'Chào mừng đến với Nike Store!',
                    'success'
                )
                $(".swal2-confirm, .swal2-container").click( function(){
                    location.href='login.php?user=<?=$username?>';
                });
        </script>
    <?php
            }
        }
    ?>


</body>
</html>