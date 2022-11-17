<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
    include("component/page.php");
    $year = date("Y");
    if(isset($_POST['year'])){
        $year = $_POST['year'];
    }
    function doanhThuThang($con, $month, $year){
        $sql = "SELECT SUM(quantity * product.price_sale) - SUM(ordered.point) as tong from orderdetail 
            INNER JOIN product ON orderdetail.product_id = product.ID
            INNER JOIN ordered ON orderdetail.order_id = ordered.ID
            WHERE ordered.status = 4 AND MONTH(ordered.order_date) = $month AND YEAR(ordered.order_date) = $year";
        $rs = mysqli_query($con, $sql);
        $tongdoanhthu = mysqli_fetch_assoc($rs);
        return $tongdoanhthu['tong'];
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
                            <h4 class="page-title pull-left"><b>Trang Chủ</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><span>Trang chủ</span></li>
                            </ul>
                        </div>
                    </div>
                    <?php include("component/logged.php"); ?>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="d-flex justify-content-end align-items-center mt-4">
                    <h6 class="mr-3">Thống kê năm: </h6>
                    <form action="index.php" method="POST" onchange="this.submit()">
                        <select class="form-control" style="height:fit-content;" name="year">
                            <?php if($year!=date('Y')){
                                echo "<option value=".date("Y").">".date("Y")."</option>";
                            } ?>
                            <option value="<?=$year?>" selected><?=$year?></option>
                            <option value="<?=$year-1?>"><?=$year-1?></option>
                            <option value="<?=$year-2?>"><?=$year-2?></option>
                            <option value="<?=$year-3?>"><?=$year-3?></option>
                        </select>
                    </form>
                </div>
                <div class="d-flex justify-content-around">
                    <div class="mt-4 col-3">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                    $sql = "SELECT SUM(quantity * product.price_sale) - SUM(ordered.point) as tong from orderdetail 
                                            INNER JOIN product ON orderdetail.product_id = product.ID
                                            INNER JOIN ordered ON orderdetail.order_id = ordered.ID
                                            WHERE ordered.status = 4 AND YEAR(ordered.order_date) = $year";
                                    $rs = mysqli_query($con, $sql);
                                    $tongdoanhthu = mysqli_fetch_assoc($rs);
                                ?>
                                <h4 class="header-title">Tổng doanh thu</h4>
                                <h6><i class="ti-stats-up mr-3"></i><span class="text-primary"><?=number_format($tongdoanhthu['tong'],0,',','.')?> VNĐ</span> </h6>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <?php
                                    $sql = "SELECT SUM(quantity) as tong from orderdetail 
                                            INNER JOIN ordered ON orderdetail.order_id = ordered.ID
                                            WHERE ordered.status = 4 AND YEAR(ordered.order_date) = $year";
                                    $rs = mysqli_query($con, $sql);
                                    $tongdoanhthu = mysqli_fetch_assoc($rs);
                                ?>
                                <h4 class="header-title">Tổng số lượng hàng đã bán ra</h4>
                                <h6><i class="ti-bar-chart mr-3"></i><span class="text-primary"><?php if($tongdoanhthu['tong']==null) echo 0; else echo $tongdoanhthu['tong'];?></span></h6>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <?php
                                    $sql = "SELECT COUNT(ID) as tong from ordered where status = 4 AND YEAR(ordered.order_date) = $year";
                                    $rs = mysqli_query($con, $sql);
                                    $tongsoluong = mysqli_fetch_assoc($rs);
                                ?>
                                <h4 class="header-title">Tổng số đơn hàng đã được đặt</h4>
                                <h6><i class="ti-bar-chart-alt mr-3"></i><span class="text-primary"><?=$tongsoluong['tong']?></span></h6>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <?php
                                    $sql = "SELECT COUNT(ID) as tong from ordered where status = 4 AND YEAR(ordered.order_date) = $year";
                                    $rs = mysqli_query($con, $sql);
                                    $tongsoluong = mysqli_fetch_assoc($rs);
                                ?>
                                <h4 class="header-title">Tổng số đơn hàng đã giao</h4>
                                <h6><i class="ti-bar-chart-alt mr-3"></i><span class="text-primary"><?=$tongsoluong['tong']?></span></h6>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <?php
                                    $sql = "SELECT COUNT(ID) as tong from ordered where status = 1 AND YEAR(ordered.order_date) = $year";
                                    $rs = mysqli_query($con, $sql);
                                    $tongsoluong = mysqli_fetch_assoc($rs);
                                ?>
                                <h4 class="header-title">Tổng số đơn hàng đang giao</h4>
                                <h6><i class="ti-bar-chart-alt mr-3"></i><span class="text-primary"><?=$tongsoluong['tong']?></span></h6>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4 col-9">
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content area end -->
        <?php include("component/footer.php") ?>
    </div>
    <!-- page container area end -->
    <?php include("component/js.php") ?>
</body>
<script>
    const labels = [
        'Tháng 1',
        'Tháng 2',
        'Tháng 3',
        'Tháng 4',
        'Tháng 5',
        'Tháng 6',
        'Tháng 7',
        'Tháng 8',
        'Tháng 9',
        'Tháng 10',
        'Tháng 11',
        'Tháng 12',
    ];

    const data = {
        labels: labels,
        datasets: [{
        label: 'Doanh thu năm <?=$year?>',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [<?=doanhThuThang($con, 1, $year)?>, <?=doanhThuThang($con, 2, $year)?>, <?=doanhThuThang($con, 3, $year)?>, <?=doanhThuThang($con, 4, $year)?>, <?=doanhThuThang($con, 5, $year)?>,
        <?=doanhThuThang($con, 6, $year)?>, <?=doanhThuThang($con, 7, $year)?>, <?=doanhThuThang($con, 8, $year)?>, <?=doanhThuThang($con, 9, $year)?>, <?=doanhThuThang($con, 10, $year)?>,
        <?=doanhThuThang($con, 11, $year)?>, <?=doanhThuThang($con, 12, $year)?>],
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {}
    };

    const myChart = new Chart(document.getElementById('myChart'),config);

</script>
</html>