<?php
    include("connect.php");
    if(isset($_POST["username"])){
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $flag = true;
    }
    else{
        $email = null;
        $username = null;
        $password = null;
    }
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Đăng nhập</title>
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
    <!-- preloader area start -->
    <?php if(!isset($_POST['username'])){ ?>
        <div id="preloader">
            <div class="loader"></div>
        </div>
    <?php } ?>
    <!-- preloader area end -->
    
    <!-- login area start -->
    <div class="login-area login-bg">
        <div class="container">
            <div class="login-box ptb--100">
                <form action="?" method="POST" id="register-form">
                    <div class="login-form-head">
                        <h4>Quên mật khẩu ư ?</h4>
                        <p>Đừng lo hãy cho chúng tôi biết email và username của bạn</p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" id="exampleInputEmail1" name="email" field-name="email">
                            <i class="ti-email"></i>
                            <p class="text-danger mt-2"></p>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputText">Username</label>
                            <input type="text" id="exampleInputText" name="username" field-name="tên đăng nhập">
                            <i class="ti-user"></i>
                            <p class="text-danger mt-2"></p>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Mật khẩu mới</label>
                            <input type="password" name="password" id="exampleInputPassword1" field-name="mật khẩu">
                            <i class="ti-lock"></i>
                            <p class="text-danger mt-2"></p>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword2">Mật khẩu xác nhận</label>
                            <input type="password" name="RePassWord" id="exampleInputPassword2" field-name="mật khẩu xác nhận">
                            <i class="ti-lock"></i>
                            <p class="text-danger mt-2" id="error_RePassWord"></p>
                            <?php
                                if(isset($_POST["username"])){
                                    $sql = "select * from user where username = '$username' && email = '$email'";
                                    $result = mysqli_query($con, $sql);

                                    if(mysqli_num_rows($result) == 0){
                                        echo "<p class='text-danger mt-2'>Tài khoản và email không khớp! Chúng tôi không thể cập nhật lại mật khẩu cho bạn</p>";
                                        $flag = false;
                                    }
                                }
                            ?>
                        </div>
                        <div class="submit-btn-area mt-5">
                            <button id="form_submit" type="button">Xác nhận <i class="ti-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

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
</body>
    <?php    
        if(isset($_POST["username"])){
            if($flag){
                $password = md5($password);
                $sql = "UPDATE user SET password = '$password' WHERE username = '$username' && email = '$email'";
                mysqli_query($con, $sql);
    ?>
        <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhập lại mật khẩu <br> thành công!'
                }).then((result) => {
                    location.href = "login.php";
                })
        </script>
    <?php
            }
        }
    ?>
</html>