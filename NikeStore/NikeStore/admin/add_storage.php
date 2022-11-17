<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
    if($_SESSION['Permission']==4 || $_SESSION['Permission']==5){
        header("Location: 505.php");
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
                            <h4 class="page-title pull-left"><b>Thêm Kho Hàng</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><a href="manage_storage.php">Quản lý kho hàng</a></li>
                                <li><span>Thêm kho hàng</span></li>
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
                        <form  action="add_storage_engine.php" method="POST">
                            <div class="form-group">
                                <label for="exampleInputName">Tên sản phẩm</label>
                                <select class="form-control pb-2" id="exampleInputSubCategory" name="product">
                                <?php
                                                $sql = "SELECT * FROM product";
                                                $result = mysqli_query($con, $sql);
                                                while($row = mysqli_fetch_assoc($result)){
                                            ?>
                                                <option value="<?=$row['ID']?>"><?=$row["name"]?></option>
                                            <?php
                                                }
                                            ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputSubCategory">Kích cỡ</label>
                                <select class="form-control pb-2" id="exampleInputSubCategory" name="size">
                                <?php
                                                $sql = "SELECT * FROM size";
                                                $result = mysqli_query($con, $sql);
                                                while($row = mysqli_fetch_assoc($result)){
                                            ?>
                                                <option value="<?=$row['ID']?>"><?=$row["name"]?></option>
                                            <?php
                                                }
                                            ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDesc">Số lượng: </label>
                                <input type="number" class="form-control" id="exampleInputQuantity" name="quantity">
                                <p class="text-danger mt-2"></p>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right mt-3">Nhập kho hàng</button>
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
    <script>
        $("#exampleInputQuantity").on('keyup',function () {
            if(isNaN($("#exampleInputQuantity").val()))
                $('.form-group .text-danger').text("Vui lòng nhập số!");
            else
                $('.form-group .text-danger').text("");
        });
    </script>
</body>
</html>