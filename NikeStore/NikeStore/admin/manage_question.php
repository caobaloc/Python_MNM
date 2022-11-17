<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
    include("component/page.php");
    if($_SESSION['Permission']==2 || $_SESSION['Permission']==4){
        header("Location: 505.php");
    }
    $sql="SELECT * FROM question ORDER BY id DESC LIMIT 5 OFFSET $offset";
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
                            <h4 class="page-title pull-left"><b>Chăm sóc khách hàng</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><span>Chăm sóc khách hàng</span></li>
                            </ul>
                        </div>
                    </div>
                    <?php include("component/logged.php"); ?>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- table primary start -->
                <a href="add_question.php"><button type="button" class="btn btn-primary mt-3">Thêm câu hỏi mới</button></a>
                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="header-title">Danh sách câu hỏi thường gặp</h4>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead class="text-uppercase bg-primary">
                                        <tr class="text-white">
                                            <th scope="col">#</th>
                                            <th scope="col">ID</th>
                                            <th scope="col">Câu hỏi</th>
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
                                            <td><?=$row["ID"]?></td>                                     
                                            <td><?=$row["title"]?></td>
                                            <td width="50px"><a class="btn-update" href="update_question.php?id=<?=$row["ID"]?>"><i class=" fa fa-wrench"></i></a></td>
                                            <td class="align-middle" width="50px"><a class="btn-remove" onclick="remove(<?=$row['ID']?>)"><i class=" fa fa-trash"></i></a></td>
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
        <form action="delete_question.php" method="post" id="xoa">
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
                title: 'Bạn có muốn xoá câu hỏi này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Đã xoá câu hỏi!',
                        icon:'success'
                    }).then((result) => {
                        $('#id').val(id);
                        $('#xoa').submit();
                    });
                }
            })
        }
    </script>
</body>
</html>