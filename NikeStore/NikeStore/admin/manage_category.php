<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
    include("component/page.php");
    if($_SESSION['Permission']==4 || $_SESSION['Permission']==5){
        header("Location: 505.php");
    }
    $sql="SELECT category.id as id, category.name as ten, category.desc as mota, category.status as tt FROM category ORDER BY category.id DESC LIMIT 5 OFFSET $offset";
    $result=mysqli_query($con,$sql);
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
                            <h4 class="page-title pull-left"><b>Quản Lý Dòng Sản Phẩm</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><span>Quản lý dòng sản phẩm</span></li>
                            </ul>
                        </div>
                    </div>
                    <?php include("component/logged.php"); ?>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- table primary start -->
                <a href="add_category.php"><button type="button" class="btn btn-primary mt-3">Thêm dòng sản phẩm mới</button></a>
                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="header-title">Danh sách dòng sản phẩm</h4>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead class="text-uppercase bg-primary">
                                        <tr class="text-white">
                                            <th scope="col">#</th>
                                            <th scope="col">ID</th>
                                            <th scope="col">Tên dòng sản phẩm</th>
                                            <th scope="col">Mô tả</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $count = 0;
                                        while($row = mysqli_fetch_assoc($result)){
                                            $count++;
                                    ?>
                                        <tr>
                                            <th scope="col"><?=$count?></th>
                                            <td><?=$row["id"]?></td>                                     
                                            <td><?=$row["ten"]?></td>
                                            <td><?=$row["mota"]?></td>
                                            <td width="50px"><a class="btn-update" href="update_category.php?id=<?=$row["id"]?>"><i class=" fa fa-wrench"></i></a></td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                    </div>
                    <?php
                        if(mysqli_num_rows($result) == 0)
                            echo "<p class='text-center mb-3'>Không có dữ liệu</p>";
                    ?>
                </div>
                <?php
                    $sql = "SELECT * FROM category";
                    $result = mysqli_query($con, $sql);
                    $totalpage = ceil(mysqli_num_rows($result)/5);
                    include("component/pagination.php");
                ?>
                <!-- table primary end -->
            </div>
        </div>
        <!-- main content area end -->
        <?php include("component/footer.php") ?>
    </div>
    <!-- page container area end -->
    <?php include("component/js.php") ?>
</body>
</html>