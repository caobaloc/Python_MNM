<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
    include("component/page.php");
    if($_SESSION['Permission']==4 || $_SESSION['Permission']==5){
        header("Location: 505.php");
    }
    $sql =  "SELECT product.id as id, image, sub_category.name as loaisp, product.name as tensp, price, product.desc as mota, price_sale, product.status as tt
    FROM product INNER JOIN sub_category ON product.sub_category_id = sub_category.id ORDER BY product.id  DESC LIMIT 5 OFFSET $offset";
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
                            <h4 class="page-title pull-left"><b>Quản Lý Sản Phẩm</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><span>Quản lý sản phẩm</span></li>
                            </ul>
                        </div>
                    </div>
                    <?php include("component/logged.php"); ?>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- table primary start -->
                <a href="add_product.php"><button type="button" class="btn btn-primary mt-3">Thêm sản phẩm mới</button></a>
                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="header-title">Danh sách sản phẩm</h4>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead class="text-uppercase bg-primary">
                                        <tr class="text-white">
                                            <th scope="col">#</th>
                                            <th scope="col">ID</th>
                                            <th scope="col">Ảnh minh hoạ</th>
                                            <th scope="col">Loại sản phẩm</th>
                                            <th scope="col">Tên sản phẩm</th>
                                            <th scope="col">Đơn giá</th>
                                            <th scope="col">Sale</th>
                                            <th scope="col" colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                            $count=0;
                            while($row = mysqli_fetch_assoc($result)){
                                $count++;
                                        ?>
                                        <tr>
                                            <th scope="col" class="align-middle"><?=$count?></th>
                                            <td class="align-middle"><?=$row["id"]?></td>
                                            <td width="200px" class="align-middle">
                                                <img src="<?=$row["image"]?>" alt="<?=$row["tensp"]?>">
                                            </td>
                                            <td class="align-middle"><?=$row["loaisp"]?></td>
                                            <td class="align-middle"><?=$row["tensp"]?></td>                                            
                                            <td class="align-middle"><?=number_format($row["price"], 0, ',', '.')?></td>
                                            <td class="align-middle"><?=number_format($row["price_sale"], 0, ',', '.')?></td>
                                            <td class="align-middle" width="50px"><a class="btn-update" href="update_product.php?id=<?=$row["id"]?>"><i class=" fa fa-wrench"></i></a></td>
                                            <td class="align-middle" width="50px">
                                                <?php if($row['tt']==1) { ?>
                                                <a class="btn-remove" onclick="remove(<?=$row['id']?>)"><i class=" fa fa-trash"></i></a>
                                                <?php } else { ?>
                                                    <a class="text-success" style="cursor: pointer;" onclick="active(<?=$row['id']?>)"><i class=" fa fa-get-pocket"></i></a>
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
                            echo "<p class='text-center mb-3'>Không có dữ liệu</p>";
                    ?>
                </div>
                <?php
                    $sql = "SELECT * FROM product";
                    $result = mysqli_query($con, $sql);
                    $totalpage = ceil(mysqli_num_rows($result)/5);
                    include("component/pagination.php");
                ?>
                <!-- table primary end -->
            </div>
        </div>
        <form action="active_product.php?do=deactive" method="post" id="xoa">
            <input type="hidden" id="id" name="id">
        </form>
        <!-- main content area end -->
        <?php include("component/footer.php") ?>
    </div>
    <!-- page container area end -->
    <?php include("component/js.php") ?>
    <script type="text/javascript">
        function remove(id){
            Swal.fire({
                title: 'Bạn có muốn ngừng bày bán <br> mặt hàng này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Đã ngừng bán!',
                    'Sản phẩm đã ngừng bán',
                    'success'
                    ).then((result) => {
                        $('#id').val(id);
                        $('#xoa').submit();
                    });
                }
            })
        }
        function active(id){
            Swal.fire({
                title: 'Bạn có muốn bày bán <br> mặt hàng này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Đã bàn báy!',
                    'Sản phẩm đã được bày bán',
                    'success'
                    ).then((result) => {
                        $('#id').val(id);
                        $('#xoa').attr('action','active_product.php?do=active');
                        $('#xoa').submit();
                    });
                }
            })
        }
  </script>
</body>
</html>