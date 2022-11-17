<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
    include("component/page.php");
    if($_SESSION['Permission']==4 || $_SESSION['Permission']==5){
        header("Location: 505.php");
    }
    if(isset($_POST['name'])){
        $name = $_POST['name'];
        $sql = "INSERT INTO size VALUES(NULL, '$name')";
        mysqli_query($con, $sql);
        $name = null;
    }
    else
        $name = null;
    $sql =  "SELECT * FROM size ORDER BY ID DESC LIMIT 5 OFFSET $offset";
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
                            <h4 class="page-title pull-left"><b>Quản Lý Kích Cỡ</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><span>Quản lý kích cỡ</span></li>
                            </ul>
                        </div>
                    </div>
                    <?php include("component/logged.php"); ?>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- table primary start -->
                <button type="button" class="btn btn-primary mt-3 btn-show-add-size" onclick="{$('.addSizeForm').css('display','block');$('.updateSizeForm').css('display','none');}">Thêm kích cỡ mới</button></a>
                <div class="row">
                    <div class="col-lg-8 card mt-3 ml-3 mr-3">
                        <div class="card-body">
                            <form action="manage_size.php" method="post" class="addSizeForm mb-5">
                                <div class="form-group">
                                    <label for="exampleInputSize">Kích cỡ mới</label>
                                    <div class="d-flex justify-content-between fg">
                                        <input type="number" class="form-control" name="name" required>
                                        <button type="submit" class="btn btn-primary ml-3 pull-right btn-add-size" >Thêm mới</button>
                                    </div>
                                    <p class="text-danger mt-2"></p>
                                </div>
                            </form>
                            <form action="manage_size_engine.php" method="post" class="updateSizeForm">
                                <input type="hidden" id="updateid" name="updateid">
                                <div class="form-group">
                                    <label for="exampleInputSize">Sửa kích cỡ</label>
                                    <div class="d-flex justify-content-between fg">
                                        <input type="number" class="form-control" name="updatename" required>
                                        <button type="submit" class="btn btn-primary ml-3 pull-right ">Cập nhật kích cỡ</button>
                                    </div>
                                    <p class="text-danger mt-2"></p>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col card mt-3 mr-3 ">
                        <div class="card-body">
                            <h4 class="header-title">Danh sách kích cỡ</h4>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="text-uppercase bg-primary">
                                            <tr class="text-white">
                                                <th scope="col">#</th>
                                                <th scope="col">Size</th>
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
                                                <th scope="col"><?=$count?></th>
                                                <td><?=$row["name"]?></td>
                                                <td><a class="btn-update" onclick="update(<?=$row['ID']?>,<?=$row['name']?>)"><i class=" fa fa-wrench"></i></a></td>
                                                <td class="align-middle" width="50px">
                                                    <?php if($row['status']==1) { ?>
                                                    <a class="btn-remove" onclick="remove(<?=$row['ID']?>)"><i class=" fa fa-trash"></i></a>
                                                    <?php } else { ?>
                                                        <a class="text-success" style="cursor: pointer;" onclick="active(<?=$row['ID']?>)"><i class=" fa fa-get-pocket"></i></a>
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
                            <?php
                                $sql = "SELECT * FROM size";
                                $result = mysqli_query($con, $sql);
                                $totalpage = ceil(mysqli_num_rows($result)/5);
                                include("component/pagination.php");
                            ?>
                        </div>
                        <?php
                            if(mysqli_num_rows($result) == 0)
                                echo "<p class='text-center mb-3'>Không có dữ liệu</p>";
                        ?>
                    </div>
                </div>
                <!-- table primary end -->
            </div>
        </div>
        <form action="active_size.php?do=deactive" method="post" id="xoa">
            <input type="hidden" id="id" name="id">
        </form>
        <!-- main content area end -->
        <?php include("component/footer.php") ?>
    </div>
    <!-- page container area end -->
    <?php include("component/js.php") ?>
    <script type="text/javascript">
        function update(id,name){
            $('#updateid').val(id);
            $('#nameSizeUpdate').val(name);
            $('.updateSizeForm').css('display','block');
            $('.addSizeForm').css('display','none');
        }
        function remove(id){
            Swal.fire({
                title: 'Bạn có muốn ngừng sử dụng <br> kích cỡ này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Đã ngừng sử dụng!',
                    'Kích cỡ đã ngừng sử dụng',
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
                title: 'Bạn có muốn sử dụng <br> kích cỡ này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Đã sử dụng!',
                    'Kích cỡ đã được sử dụng',
                    'success'
                    ).then((result) => {
                        $('#id').val(id);
                        $('#xoa').attr('action','active_size.php?do=active');
                        $('#xoa').submit();
                    });
                }
            })
        }
    </script>
</body>
</html>