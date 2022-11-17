<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");

    if($_SESSION['Permission']==2 || $_SESSION['Permission']==5){
        header("Location: 505.php");
    }

    $id = $_GET["id"];

    $sql = "SELECT ordered.ID as id, user.name as tenkh, ordered.address as diachi, ordered.order_date as ngaydat, ordered.point as diem, phone
        FROM orderdetail INNER JOIN ordered ON orderdetail.order_id = ordered.ID 
                         INNER JOIN user ON ordered.user_id = user.ID 
        WHERE orderdetail.order_id = $id ";
    $result = mysqli_query($con,$sql);
    $hoadon = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý website Nike Store</title>
    <?php include("component/css.php") ?>
    <style>
        @media print {
            body *, .card .invoice-btn{
                visibility: hidden;
            }
            .card, .card *{
                visibility: visible;
            }
        }
    </style>
</head>
<body class="body-bg">
    <div id="preloader">
        <div class="loader"></div>
    </div>
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
                <div class="row">
                    <div class="col-lg-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="invoice-area">
                                    <div class="invoice-head">
                                        <div class="row">
                                            <div class="iv-left col-6">
                                                <span>Chi tiết hoá đơn</span>
                                            </div>
                                            <div class="iv-right col-6 text-md-right">
                                                <span>#<?=$hoadon['id']?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="invoice-address">
                                                <h5><?=$hoadon['tenkh']?></h5>
                                                <p><?=$hoadon['diachi']?></p>
                                                <p><?=$hoadon['phone']?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <ul class="invoice-date">
                                                <li>Ngày đặt hàng : <?=$hoadon['ngaydat']?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="invoice-table table-responsive mt-5">
                                        <table class="table table-bordered table-hover text-right">
                                            <thead>
                                                <tr class="text-capitalize">
                                                    <th class="text-center" style="width: 5%;">STT</th>
                                                    <th class="text-left" style="width: 45%; min-width: 130px;">Sản phẩm</th>
                                                    <th class="text-center">Kích cỡ</th>
                                                    <th class="text-center">Số lượng</th>
                                                    <th style="min-width: 100px">Đơn giá</th>
                                                    <th>Tổng tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql = "SELECT product.name as tensp, size.name as kichco, quantity, product.price_sale as dongia
                                                        FROM orderdetail INNER JOIN product ON orderdetail.product_id = product.ID 
                                                                         INNER JOIN size ON orderdetail.size_id = size.ID 
                                                        WHERE orderdetail.order_id = $id
                                                        ORDER BY orderdetail.ID";
                                                    $result=mysqli_query($con,$sql);
                                                    $count = 0;
                                                    $tong = 0;
                                                    while($row = mysqli_fetch_assoc($result)){
                                                        $count++;
                                                        $tong += $row["quantity"] * $row["dongia"];
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?=$count?></td>
                                                    <td class="text-left"><?=$row["tensp"]?></td>
                                                    <td class="text-center"><?=$row["kichco"]?></td>
                                                    <td class="text-center"><?=$row["quantity"]?></td>
                                                    <td><?=number_format($row["dongia"], 0, ',', '.')?></td>
                                                    <td><?=number_format(($row["quantity"] * $row["dongia"]), 0, ',', '.')?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5">Điểm tích luỹ sử dụng :</td>
                                                    <td><?=number_format($hoadon['diem'], 0, ',', '.')?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">Tổng đơn hàng :</td>
                                                    <td><?=number_format($tong - $hoadon['diem'], 0, ',', '.')?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="invoice-buttons text-right">
                                    <a href="#" class="invoice-btn" onclick="window.print()">in hoá đơn</a>
                                    <a href="#" class="invoice-btn">gửi hoá đơn</a>
                                </div>
                            </div>
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
</html>