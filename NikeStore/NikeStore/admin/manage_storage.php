<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
    include("component/page.php");
    if($_SESSION['Permission']==4 || $_SESSION['Permission']==5){
        header("Location: 505.php");
    }
    $sql =  "SELECT quantity, product.name as tensp, size.name as kichco, product_id, size_id, storage.status as tt
            FROM storage INNER JOIN product ON product.id = storage.product_id INNER JOIN size ON size.id = storage.size_id
            ORDER BY quantity DESC LIMIT 5 OFFSET $offset";
    $result = mysqli_query($con, $sql);
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
                            <h4 class="page-title pull-left"><b>Quản Lý Kho Hàng</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><span>Quản lý kho hàng</span></li>
                            </ul>
                        </div>
                    </div>
                    <?php include("component/logged.php"); ?>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- table primary start -->
                <a href="add_storage.php"><button type="button" class="btn btn-primary mt-3">Thêm kho hàng mới</button></a>
                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="header-title">Danh sách kho hàng</h4>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead class="text-uppercase bg-primary">
                                        <tr class="text-white">
                                            <th scope="col">#</th>
                                            <th scope="col">Tên sản phẩm</th>
                                            <th scope="col">Kích cỡ</th>
                                            <th scope="col">Số lượng</th>
                                            <th scope="col" colspan="2">Action</th>
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
                                            <td><?=$row["tensp"]?></td>
                                            <td><?=$row["kichco"]?></td>
                                            <td><?=$row["quantity"]?></td>
                                            <td width="50px"><a class="btn-update" href="update_storage.php?product_id=<?=$row["product_id"]?>&size_id=<?=$row["size_id"]?>"><i class=" fa fa-wrench"></i></a></td>
                                            <td class="align-middle" width="50px">
                                                <?php if($row['tt']==1) { ?>
                                                <a class="btn-remove" onclick="remove(<?=$row['product_id']?>,<?=$row['size_id']?>)"><i class=" fa fa-trash"></i></a>
                                                <?php } else { ?>
                                                    <a class="text-success" style="cursor: pointer;" onclick="active(<?=$row['product_id']?>,<?=$row['size_id']?>)"><i class=" fa fa-get-pocket"></i></a>
                                                <?php } ?>
                                            </td>
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
                            echo "<p>Không có dữ liệu</p>";
                    ?>
                </div>
                <?php
                    $sql = "SELECT * FROM storage";
                    $result = mysqli_query($con, $sql);
                    $totalpage = ceil(mysqli_num_rows($result)/5);
                    include("component/pagination.php");
                ?>
                <!-- table primary end -->
            </div>
        </div>
        <!-- main content area end -->
        <?php include("component/footer.php") ?>
        <form action="active_storage.php?do=deactive" method="post" id="xoa">
            <input type="hidden" id="product_id" name="product_id">
            <input type="hidden" id="size_id" name="size_id">
        </form>
    </div>
    <!-- page container area end -->
    <?php include("component/js.php") ?>
    <script type="text/javascript">
        function remove(product_id,size_id){
            Swal.fire({
                title: 'Bạn có muốn ngừng sử dụng <br> kho hàng này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Đã ngừng sử dụng!',
                    'Kho hàng đã ngừng sử dụng',
                    'success'
                    ).then((result) => {
                        $('#product_id').val(product_id);
                        $('#size_id').val(size_id);
                        $('#xoa').submit();
                    });
                }
            })
        }
        function active(product_id,size_id){
            Swal.fire({
                title: 'Bạn có muốn sử dụng <br> kho hàng này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Đã sử dụng!',
                    'Kho hàng đã được sử dụng',
                    'success'
                    ).then((result) => {
                        $('#product_id').val(product_id);
                        $('#size_id').val(size_id);
                        $('#xoa').attr('action','active_storage.php?do=active');
                        $('#xoa').submit();
                    });
                }
            })
        }
    </script>
</body>
</html>