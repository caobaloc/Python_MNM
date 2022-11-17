<?php
    session_start();
    include("connect.php");

    if(isset($_POST["UserName"])){
        $username = $_POST["UserName"];
        $password = $_POST["PassWord"];
        $password_db = md5($password);
        if(isset($_POST["remember_me"])) {
            setcookie("username",$username,time()+86400,'/','',0,0);
            setcookie("password",$password,time()+86400,'/','',0,0);
        }
        else{
            setcookie("username",$username,time()-86400,'/','',0,0);
            setcookie("password",$password,time()-86400,'/','',0,0);
        }
        $flag = true;
    }
    else{
        if(isset($_COOKIE["username"]) && isset($_COOKIE["password"])){
            $username = $_COOKIE["username"];
            $password = $_COOKIE["password"];
        }
        else{
            $username = null;
            $password = null;
        }
        if(isset($_GET["user"])){
            $username = $_GET["user"];
        }
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
    <?php if(!isset($_POST['UserName'])){ ?>
        <div id="preloader">
            <div class="loader"></div>
        </div>
    <?php } ?>
    <!-- login area start -->
    <div class="login-area login-bg">
        <div class="container">
            <div class="login-box ptb--100">
                <form action="login.php?do=login" method="post" id="login-form">
                    <div class="login-form-head">
                        <h4>Đăng nhập</h4>
                        <p>Chào mừng đến với <a href="index.php">Nike Store</a></p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputUsername">Tên đăng nhập</label>
                            <input type="text" id="exampleInputUsername" name="UserName" field-name="tên đăng nhập" value="<?=$username?>">
                            <i class="ti-user"></i>
                            <p class="text-danger mt-2"></p>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword">Mật khẩu</label>
                            <input type="password" id="exampleInputPassword" name="PassWord" field-name="mật khẩu" value="<?=$password?>">
                            <i class="ti-lock"></i>
                            <p class="text-danger mt-2">
                            <?php
                                if(isset($_POST["UserName"])){

                                    $sql = "select username, password from user where username = '$username'";
                                    $result = mysqli_query($con, $sql);

                                    if(mysqli_num_rows($result) == 0){
                                        echo "Tên đăng nhập không tồn tại. Vui lòng kiểm tra lại!";
                                        $flag = false;
                                    }
                                    else{
                                        $row = mysqli_fetch_assoc($result);
                                        if($password_db != $row['password']){
                                            echo "Mật khẩu không đúng. Vui lòng kiểm tra lại!";
                                            $flag = false;
                                        }
                                    }
                                }
                            ?>
                            </p>
                        </div>
                        <div class="row mb-4 rmber-area">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing" name="remember_me" <?php if(isset($_COOKIE["username"])) echo "checked"?>>
                                    <label class="custom-control-label" for="customControlAutosizing">Lưu mật khẩu</label>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <a href="forgot-password.php">Quên mật khẩu?</a>
                            </div>
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="button">Đăng nhập <i class="ti-arrow-right"></i></button>
                            <div class="login-other row mt-4">
                                <div class="col-6">
                                    <a class="fb-login" href="#">Đăng nhập bằng <i class="fa fa-facebook"></i></a>
                                </div>
                                <div class="col-6">
                                    <a class="google-login" href="#">Đăng nhập bằng <i class="fa fa-google"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer text-center mt-3">
                            <p class="text-muted">Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
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
    <script src="assets/js/login.js"></script>

    <!-- php -->
    <?php    
        if(isset($_POST["UserName"])){
            if($flag){
                $_SESSION['UserName'] = $username;
                $sql = "select role_id from user where username ='$username' and active = 1";
                $result = mysqli_query($con,$sql);
                $row = mysqli_fetch_assoc($result);
                if(mysqli_num_rows($result) > 0) {
                $_SESSION['Permission'] = $row["role_id"];
    ?>
    <script>
        Swal.fire(
            'Đăng nhập thành công',
            '',
            'success'
        )
        $(".swal2-confirm, .swal2-container").click( function(){
            <?php
                if($row["role_id"]==3){
            ?>
            location.href='home/index.php';
            <?php
                }
                else{
            ?>
            location.href='admin/index.php';
            <?php       
                }
            ?>
         });
    </script>
    <?php
                }
                else{
    ?>
    <script>
        Swal.fire(
            'Tài khoản đã bị khoá',
            '',
            'error'
        )
        $(".swal2-confirm, .swal2-container").click( function(){
            location.href='login.php';
        });
    </script>
    <?php
                }
            }
        }
    ?>

</body>

</html>