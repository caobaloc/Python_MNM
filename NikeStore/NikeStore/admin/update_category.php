<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
    if($_SESSION['Permission']==4 || $_SESSION['Permission']==5){
        header("Location: 505.php");
    }
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $sql = "SELECT category.id as id,category.name as tendongsp,category.desc as mota FROM category WHERE category.id =$id";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
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
                            <h4 class="page-title pull-left"><b>Thêm Dòng Sản Phẩm</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><a href="manage_category.php">Quản lý dòng sản phẩm</a></li>
                                <li><span>Thêm dòng sản phẩm</span></li>
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
                        <form action="update_category_engine.php" method="POST">
                            <input type="hidden" name="id" value="<?=$id?>">
                            <div class="form-group">
                                <label for="exampleInputName">Tên dòng sản phẩm</label>
                                <input type="text" class="form-control" id="exampleInputName" name="name" required value="<?=$row["tendongsp"]?>" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDesc">Mô tả: </label>
                                <textarea type="text" class="form-control" id="exampleInputDesc" name="desc"><?=$row["mota"]?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right mt-3">Nhập dòng sản phẩm</button>
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