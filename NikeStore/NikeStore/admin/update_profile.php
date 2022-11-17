<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
    $username = $_SESSION["UserName"];
    if(isset($_GET["do"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $seo = url_slug($name);
        $image = "../assets/images/avatar/".$username.".png";
    }
    else{
        $sql = "select * from user where username ='$username'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $name = $row["name"];
        $email = $row["email"];
        $phone = $row["phone"];
        $address = $row["address"];
        $image = $row["avatar"];
    }
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
                            <h4 class="page-title pull-left"><b>Cập nhật Thông Tin Cá Nhân</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><span>Cập nhật thông tin cá nhân</span></li>
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
                        <form action="update_profile.php?do=update" method="POST" enctype="multipart/form-data" id="ProductForm">
                            <div class="row">
                                <div class="col-xl-9 col-lg-8 col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputName">Họ Tên</label>
                                        <input type="text" class="form-control" id="exampleInputName" name="name" required value="<?=$name?>" >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Email</label>
                                        <input type="email" class="form-control" id="exampleInputEmail" name="email" required value="<?=$email?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPhone">Số điện thoại</label>
                                        <input type="text" class="form-control" id="exampleInputPhone" name="phone" required value="<?=$phone?>" >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputAddress">Địa chỉ: </label>
                                        <textarea type="text" class="form-control" id="exampleInputAddress" name="address"><?=$address?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Ảnh đại diện:</label>
                                        <input type="file" class="filestyle" id="image" name="avatar" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh" data-btnClass="btn-primary" data-placeholder="Chưa có hình ảnh">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 d-flex justify-content-center">
                                    <div class="image-preview mt-2 ">
                                        <img id="previewImg" src="<?=$image?>"/>
                                    </div>
                                </div>
                            </div>
                            <?php
                                if(isset($_GET["do"])){

                                    $sql = "select email from user except (select email from user where username ='$username')";
                                    $result = mysqli_query($con, $sql);
                                    $r = mysqli_fetch_assoc($result);

                                    if($email==$r["email"])
                                        echo"<p class='text-danger mt-2'>Email đã tồn tại!</p>";
                                    else{
                                        if($_FILES["avatar"]["name"]==null){
                                            $sql = "UPDATE user SET name='$name', email='$email', phone='$phone', address='$address', seo='$seo' where username ='$username'";
                                            mysqli_query($con, $sql);
                                            echo"<p class='text-success mt-2'>Cập nhật thành công!</p>";
                                        }
                                        else{
                                            $image = "../assets/images/avatar/".$username.".png";
                                            move_uploaded_file($_FILES["avatar"]["tmp_name"],$image);
                                            $sql = "UPDATE user SET name='$name', email='$email', phone='$phone', address='$address',avatar='$image', seo='$seo' where username ='$username'";
                                            mysqli_query($con, $sql);
                                            echo"<p class='text-success mt-2'>Cập nhật thành công!</p>";
                                        }
                                    }
                                }
                            ?>
                            <button type="submit" class="btn btn-primary pull-right mt-3">Cập nhật thông tin</button>
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