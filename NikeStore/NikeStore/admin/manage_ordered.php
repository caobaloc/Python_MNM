<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
    include("component/page.php");
    
    if($_SESSION['Permission']==2 || $_SESSION['Permission']==5){
        header("Location: 505.php");
    }

    if(isset($_GET['do'])){
        $id=$_POST['id'];

        $username = $_SESSION["UserName"];
        $sql = "select * from user where username ='$username'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row['active']==0){
            header("Location: ../login.php");
            exit();
        }           

        if($_GET['do']=='accept'){
            $sql = "UPDATE ordered SET status = '4' WHERE ID=$id";
            mysqli_query($con,$sql);

            $sql = "SELECT SUM(quantity * product.price_sale) - ordered.point as diem from orderdetail 
                    INNER JOIN product ON orderdetail.product_id = product.ID 
                    INNER JOIN ordered ON orderdetail.order_id = ordered.ID 
                    WHERE orderdetail.order_id = '$id'";
            
            $point = mysqli_query($con,$sql);
            $point = mysqli_fetch_assoc($point);
            $point = $point['diem'] * 0.02;

            $sql = "UPDATE ordered SET pointplus = $point WHERE ID = '$id'";
            mysqli_query($con,$sql);
        }
        else{
            $sql = "UPDATE ordered SET status = '2' WHERE ID=$id";
            mysqli_query($con,$sql);

            $sql = "SELECT point FROM ordered WHERE ID = $id";
            $point = mysqli_query($con,$sql);
            $point = mysqli_fetch_assoc($point);
            $point = $point['point'];

            $sql = "SELECT * FROM orderdetail WHERE order_id = $id";
            $tmp_kq = mysqli_query($con,$sql);
            $sql = "DELETE FROM orderdetail WHERE order_id = $id";
            mysqli_query($con,$sql);
            $sql = "DROP TRIGGER new_order";
            mysqli_query($con,$sql);
            while($tmp = mysqli_fetch_assoc($tmp_kq)){
                $sql = "INSERT INTO orderdetail value ('".$tmp['ID']."','".$tmp['order_id']."','".$tmp['product_id']."','".$tmp['size_id']."','".$tmp['quantity']."')";
                mysqli_query($con,$sql);
            }
            $sql = "CREATE TRIGGER `new_order` AFTER INSERT ON `orderdetail` FOR EACH ROW 
                    UPDATE storage
                    SET quantity = quantity - NEW.quantity
                    WHERE product_id = NEW.product_id AND size_id = NEW.size_id";
            mysqli_query($con,$sql);
        }

        $sql = "SELECT user.ID as userid FROM user INNER JOIN ordered ON user.ID = ordered.user_id WHERE ordered.ID = '$id'";
        $userid = mysqli_query($con,$sql);
        $userid = mysqli_fetch_assoc($userid);
        $userid = $userid['userid'];

        $sql = "UPDATE user SET user.point = user.point + $point WHERE ID = '$userid'";
        mysqli_query($con,$sql);
        header("location: manage_ordered.php");
    }
    $sql="SELECT ordered.id as id, user.name as ten, ordered.order_date as ngaydat, status, ordered.method as phuongthuc
        FROM ordered INNER JOIN user ON ordered.user_id = user.ID 
        ORDER BY ordered.id DESC LIMIT 5 OFFSET $offset";
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
                            <h4 class="page-title pull-left"><b>Quản lý đơn hàng</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><span>Quản lý đơn hàng</span></li>
                            </ul>
                        </div>
                    </div>
                    <?php include("component/logged.php"); ?>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="header-title">Danh sách các đơn hàng</h4>
                    <div class="single-table">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="text-uppercase bg-primary">
                                    <tr class="text-white">
                                        <th scope="col">#</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Khách hàng</th>
                                        <th scope="col">Ngày đặt hàng</th>
                                        <th scope="col">Phương thức</th>
                                        <th scope="col">Chi tiết</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Tuỳ chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $count = 0;
                                    while($row = mysqli_fetch_assoc($result)){
                                        $count++;
                                ?>
                                    <tr>
                                        <th scope="col" class="align-middle"><?=$count?></th>
                                        <td class="align-middle"><?=$row["id"]?></td>                                     
                                        <td class="align-middle"><?=$row["ten"]?></td>
                                        <td class="align-middle"><?=$row["ngaydat"]?></td>
                                        <td class="align-middle">
                                            <?php switch($row["phuongthuc"]){
                                                case 1: echo"Thanh toán qua ví điện tử"; break;
                                                case 2: echo"Thanh toán qua thẻ ngân hàng"; break;
                                                case 3: echo"Thanh toán khi nhận hàng"; break;
                                            } ?>
                                        </td>
                                        <?php switch($row["status"]){
                                            case 1: echo"<td class='align-middle'>Đang giao hàng</td>
                                                        <td class='text-nowrap'>
                                                            <a onclick='accept(".$row['id'].")' href='#' class='btn btn-outline-success mr-3'>Xác nhận đơn hàng</a>
                                                            <a onclick='cancel(".$row['id'].")' href='#' class='btn btn-outline-danger'>Huỷ đơn hàng</a>
                                                        </td>
                                                        <td><a class='btn btn-info' href='manage_orderdetail.php?id=".$row["id"]."'>Chi tiết</a></td>"; break;
                                            case 2: echo"<td class='align-middle'>Đã huỷ</td>
                                                        <td><a href='#' class='btn btn-danger'>Đơn hàng đã bị huỷ bởi người bán</a></td>
                                                        <td><a class='btn btn-info' href='manage_orderdetail.php?id=".$row["id"]."'>Chi tiết</a></td>"; break;
                                            case 3: echo"<td class='align-middle'>Đã huỷ</td>
                                                        <td><a href='#' class='btn btn-danger'>Đơn hàng đã bị huỷ bởi người mua</a></td>
                                                        <td><a class='btn btn-info' href='manage_orderdetail.php?id=".$row["id"]."'>Chi tiết</a></td>"; break;
                                            case 4: echo"<td class='align-middle'>Đã giao hàng</td>
                                                        <td><a href='#' class='btn btn-success'>Đơn hàng đã được giao</a></td>
                                                        <td><a class='btn btn-info' href='manage_orderdetail.php?id=".$row["id"]."'>Chi tiết</a></td>"; break;
                                        }?>
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
                $sql = "SELECT * FROM ordered";
                $result = mysqli_query($con, $sql);
                $totalpage = ceil(mysqli_num_rows($result)/5);
                include("component/pagination.php");
            ?>
            </div>
        </div>
        <!-- main content area end -->
        <?php include("component/footer.php") ?>
    </div>
    <form action="manage_ordered.php?do=accept" method="post" id="accept">
         <input type="hidden" id="acceptid" name="id">
    </form>
    <form action="manage_ordered.php?do=cancel" method="post" id="cancel">
         <input type="hidden" id="cancelid" name="id">
    </form>
    <!-- page container area end -->
    <?php include("component/js.php") ?>
    <script>
        function accept(id){
            Swal.fire({
                title: 'Xác nhận đơn hàng?',
                text: "Bạn sẽ không thể hoàn tác lại điều này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Oke, done!',
                    'Đơn hàng đã được xác nhận',
                    'success'
                    ).then((result) => {
                        $('#acceptid').val(id);
                        $('#accept').submit();
                    });
                }
            })
        }
        function cancel(id){
            Swal.fire({
                title: 'Huỷ đơn hàng?',
                text: "Bạn sẽ không thể hoàn tác lại điều này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Oke, done!',
                    'Đơn hàng đã được huỷ',
                    'success'
                    ).then((result) => {
                        $('#cancelid').val(id);
                        $('#cancel').submit();
                    });
                }
            })
        }
    </script>
</body>
</html>
<?php
?>