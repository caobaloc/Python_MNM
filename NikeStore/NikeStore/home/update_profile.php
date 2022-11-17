<?php
    session_start();
    include("../connect.php");
    $username = $_SESSION["UserName"];
    if(isset($_GET["do"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $seo = url_slug($name);
        $image = "../assets/images/avatar/".$username.".png";
        $point =  $_POST["point"];
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
        $point = $row['point'];
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
<body>
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <div class="horizontal-main-wrapper">
        <!-- main header area start -->
        <?php include("component/header.php"); ?>
        <!-- main header area end -->
        <div class="container">
                <!-- form primary start -->
            <h4 class="text-center text-pink mt-5">Thông tin cá nhân</h4>
            <div class="profile-container mt-4  p-4">
                <form action="update_profile.php?do=update" method="POST" enctype="multipart/form-data" id="ProductForm" >
                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputName"><h6>Họ Tên</h6></label>
                                <input type="text" class="form-control" id="exampleInputName" name="name" required value="<?=$name?>" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail"><h6>Email</h6></label>
                                <input type="email" class="form-control" id="exampleInputEmail" name="email" required value="<?=$email?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPhone"><h6>Số điện thoại</h6></label>
                                <input type="text" class="form-control" id="exampleInputPhone" name="phone" required value="<?=$phone?>" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputAddress"><h6>Địa chỉ</h6> </label>
                                <textarea type="text" class="form-control" id="exampleInputAddress" name="address"><?=$address?></textarea>
                            </div>
                            <div class="form-group">
                                <label><h6>Ảnh đại diện</h6></label>
                                <input type="file" class="filestyle" id="image" name="avatar" accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh" data-btnClass="btn-primary" data-placeholder="Chưa có hình ảnh">
                            </div>
                            <h6 class="mt-4">Điểm tích luỹ: <span class="text-danger"><?=number_format($point, 0, ',', '.')?></span></h6>
                                <input type="hidden" name="point" value="<?=$point?>">
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 d-flex justify-content-center">
                            <div class="image-preview mt-2 ">
                                <img id="previewImg" src="<?=$image?>"/>
                            </div>
                        </div>
                        <?php
                            if(isset($_GET["do"])){

                                $sql = "select email from user except (select email from user where username ='$username')";
                                $result = mysqli_query($con, $sql);
                                $r = mysqli_fetch_assoc($result);

                                if($email==$r["email"])
                                    echo"<p class='text-danger mt-2 ml-4'>Email đã tồn tại!</p>";
                                else{
                                    if($_FILES["avatar"]["name"]==null){
                                        $sql = "UPDATE user SET name='$name', email='$email', phone='$phone', address='$address', seo='$seo' where username ='$username'";
                                        mysqli_query($con, $sql);
                                        echo"<p class='text-success mt-2 ml-4'>Cập nhật thành công!</p>";
                                    }
                                    else{
                                        $image = "../assets/images/avatar/".$username.".png";
                                        move_uploaded_file($_FILES["avatar"]["tmp_name"],$image);
                                        $sql = "UPDATE user SET name='$name', email='$email', phone='$phone', address='$address',avatar='$image', seo='$seo' where username ='$username'";
                                        mysqli_query($con, $sql);
                                        echo"<p class='text-success mt-2 ml-4'>Cập nhật thành công!</p>";
                                    }
                                }
                            }
                            ?>
                        <div class="col-12">
                            <button type="submit" class="btn btn-pink pull-right">Cập nhật thông tin</button>
                        </div>
                    </div>
                </form>
            </div>
                <!-- form primary end -->
        </div>
    </div>
    <!-- page container area end -->
    <?php include("component/js.php") ?>
</body>
</html>