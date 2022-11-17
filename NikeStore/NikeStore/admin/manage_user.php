<?php 
    session_start();
    include("../connect.php");
    include("component/permission.php");
    include("component/page.php");
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
    <?php if(!isset($_GET["do"])) { ?>
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div> 
    <!-- preloader area end -->
    <?php } ?>
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
                            <h4 class="page-title pull-left"><b>Quản Lý Người Dùng</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><span>Quản lý người dùng</span></li>
                            </ul>
                        </div>
                    </div>
                    <?php include("component/logged.php"); ?>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <?php if($_SESSION['Permission']==1) { ?>
                <div class="mt-3">
                    <h5>Thêm nhân viên mới</h5>
                    <form action="manage_user.php?do=add" method="POST" class="mt-3">
                        <div class="form-group d-flex justify-content-between">
                            <input type="text" class="form-control " name="username" placeholder="Nhập tài khoản" required>
                            <select class="form-control ml-3" style="height:fit-content" name="role">
                                <option value="1">Admin</option>
                                <option value="2" selected>Nhân viên quản lý sản phẩm</option>
                                <option value="4">Nhân viên quản lý đơn hàng</option>
                                <option value="5">Nhân viên chăm sóc khách hàng</option>
                            </select>
                            <button type="submit" class="btn btn-primary ml-3 pull-right">Thêm nhân viên</button>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <input type="text" class="form-control" value="Mật khẩu mặc định: 123456" disabled>
                            <input type="hidden" name="password" value="123456">
                        </div>
                        <?php
                            if(isset($_GET["do"])){
                                $username=$_POST["username"];
                                $password=$_POST["password"];
                                $password=md5($password);
                                $role=$_POST["role"];
                                $sql = "select password from user where username ='$username'";
                                $rs = mysqli_query($con,$sql);
                                if(mysqli_num_rows($rs)!=0)
                                    echo '<p class="text-danger mt-2 ml-3">Tài khoản đã tồn tại</p> ';
                                else{
                                    $sql="INSERT INTO `user` (`ID`, `role_id`, `username`, `password`, `name`, `email`, `phone`, `address`) VALUES (NULL, '$role', '$username', '$password', NULL, NULL, NULL, NULL)";
                                    mysqli_query($con,$sql);
                                    echo '<p class="text-success mt-2 ml-3">Thêm nhân viên thành công</p> ';
                                }
                            }
                        ?>                
                    </form>
                </div>
                <?php } ?>
                <!-- table primary start -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="header-title">Danh sách người dùng</h4>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead class="text-uppercase bg-primary">
                                        <tr class="text-white">
                                            <th scope="col">#</th>
                                            <th scope="col">Họ và tên</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Số điện thoại</th>
                                            <th scope="col">Địa chỉ</th>
                                            <th scope="col">Tài khoản</th>
                                            <th scope="col">Quyền</th>
                                            <th scope="col">Tác vụ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                            $sql = "SELECT user.id as id, user.name as hoten ,email,phone,address,username,role.name as quyen,role.id as quyen_id, active as tt
                                FROM user INNER JOIN role ON user.role_id = role.id 
                                ORDER BY user.id  DESC LIMIT 5 OFFSET $offset";
                            $result = mysqli_query($con,$sql);
                            $count=0;
                            while($row = mysqli_fetch_assoc($result)){
                                $count++;
                                        ?>
                                        <tr>
                                            <th scope="row"><?=$count?></th>
                                            <td><?=$row["hoten"]?></td>
                                            <td><?=$row["email"]?></td>
                                            <td><?=$row["phone"]?></td>
                                            <td><?=$row["address"]?></td>
                                            <td><?=$row["username"]?></td>
                                            <td><?=$row["quyen"]?></td>
                                            <?php if(($_SESSION['Permission']==1 && $row["quyen_id"]!=1 )){ ?>
                                                <td>
                                                <?php if($row['tt']==1) { ?>
                                                    <a class="btn-remove" onclick="lock(<?=$row['id']?>)"><i class=" fa fa-trash"></i></a>
                                                <?php } else { ?>
                                                    <a class="text-success" style="cursor: pointer;" onclick="active(<?=$row['id']?>)"><i class=" fa fa-get-pocket"></i></a>
                                                <?php } ?>
                                                </td>
                                            <?php } else{ ?>
                                                <td><i class=" fa fa-trash text-secondary"></i></td>
                                            <?php } ?>
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
                    $sql = "SELECT * FROM user";
                    $result = mysqli_query($con, $sql);
                    $totalpage = ceil(mysqli_num_rows($result)/5);
                    include("component/pagination.php");
                ?>
                <!-- table primary end -->
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <?php include("component/footer.php") ?>
        <form action="active_user.php?do=lock" method="post" id="xoa">
            <input type="hidden" id="id" name="id">
        </form>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <?php include("component/js.php") ?>
    <script type="text/javascript" >
        function lock(id){
            Swal.fire({
                title: 'Bạn chắc chắn muốn khoá tài khoản này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Khoá'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Đã khoá!',
                    'Tài khoản đã bị khoá',
                    'success'
                    ).then((result) => {
                        if (result.isConfirmed){
                            $('#id').val(id);
                            $('#xoa').submit();
                        }
                    });
                }
            })
        }
        function active(id){
            Swal.fire({
                title: 'Bạn chắc chắn muốn mở khoá tài khoản này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00b815',
                confirmButtonText: 'Mở khoá'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Đã mở khoá!',
                    'Tài khoản đã mở khoá',
                    'success'
                    ).then((result) => {
                        if (result.isConfirmed){
                            $('#id').val(id);
                            $('#xoa').attr('action','active_user.php?do=active');
                            $('#xoa').submit();
                        }
                    });
                }
            })
        }
    </script
    </script>
</body>
</html>