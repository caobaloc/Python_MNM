<?php
    session_start();
    include("../connect.php");
    if(!isset($_SESSION["UserName"])){
        header("Location: ../login.php");
    }
    else{
        $username = $_SESSION["UserName"];
        if($row['active']==0)
            header("Location: ../login.php");
        if(isset($_GET['do'])){

            $id=$_POST['id'];            
            $sql = "UPDATE ordered SET status = '3' WHERE ID=$id";
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

            $sql = "UPDATE user SET user.point = user.point + $point WHERE username = '$username'";
            mysqli_query($con,$sql);
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nike Store</title>
<?php include("component/css.php") ?>
</head>
<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="horizontal-main-wrapper">
        <!-- main header area start -->
        <?php include("component/header.php"); ?>
        <!-- main header area end -->
        <div class="main-content container">
            <h4 class="text-center text-pink mt-5"><b>????n h??ng c???a b???n</b></h4>
            <?php
                $sqli = "SELECT DISTINCT ordered.ID as id, ordered.address as diachi, ordered.order_date as ngaydat, ordered.status as trangthai, ordered.method as payment, ordered.point as diem, pointplus
                    FROM orderdetail INNER JOIN ordered ON orderdetail.order_id = ordered.ID 
                                    INNER JOIN user ON ordered.user_id = user.ID 
                    WHERE user.username = '$username' 
                    ORDER BY ordered.ID DESC";
                $rs = mysqli_query($con,$sqli);
                if(mysqli_num_rows($rs) != 0){
                    while($donhang =  mysqli_fetch_assoc($rs)){
                        $id = $donhang['id'];
            ?>
            <div class="cart-container table-responsive mt-5">
                <table class="table text-center">
                    <thead>
                        <tr class="align-center">
                            <th scope="col">S???n ph???m</th>
                            <th scope="col">????n gi??</th>
                            <th scope="col">S??? l?????ng</th>
                            <th scope="col">S??? ti???n</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT product.name as tensp, size.name as kichco, quantity, product.price as dongia, product.price_sale as giagiam, product.image as hinhanh, product.seo as seo
                                FROM orderdetail INNER JOIN product ON orderdetail.product_id = product.ID 
                                                    INNER JOIN size ON orderdetail.size_id = size.ID 
                                WHERE orderdetail.order_id = $id
                                ORDER BY orderdetail.ID";
                            $result=mysqli_query($con,$sql);
                            $count = 0;
                            $tong = 0;
                            while($row = mysqli_fetch_assoc($result)){
                                $count++;
                                $tong += $row["quantity"] * $row["giagiam"];
                        ?>
                        <tr class="align-center">
                            <td class="text-left"><div class="ml-3">
                                <div class="product-cart d-flex align-items-center">
                                    <div class="product-cart-img">
                                        <img src="<?=$row['hinhanh']?>" width="150px">
                                    </div>
                                    <div class="product-cart-infor ml-3">
                                        <h5><?=$row['tensp']?></h5>
                                        <p class="text-left mt-2">Size: <?=$row['kichco']?></p>
                                        <p class="mt-2">
                                            <a href="detail.php?seo=<?=$row['seo']?>">Xem chi ti???t m???t h??ng</a>
                                        </p>
                                    </div>
                                </div>
                            </div></td>
                            <td>
                                <?php if( $row["dongia"] == $row["giagiam"]) {?>
                                    <h6 class="text-danger"><?=number_format($row['dongia'], 0, ',', '.')?> ???</h6>
                                <?php } else {?>
                                    <h6 style="text-decoration: line-through;"><?=number_format($row['dongia'], 0, ',', '.')?> ???</h6>
                                    <h6 class="text-danger"><?=number_format($row['giagiam'], 0, ',', '.')?> ???</h6>
                                <?php } ?>
                            </td>
                            <td>
                                <p><?=$row['quantity']?></p>
                            </td>
                            <td>
                                <h6 class="text-danger"><?=number_format( ($row['quantity'] * $row['giagiam']) , 0, ',', '.') ?> ???</h6>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr class="text-center">
                            <td class="text-left" colspan="2">
                                <b class="ml-3">?????a ch???: </b><?=$donhang['diachi']?><br>
                                <b class="ml-3">Ng??y ?????t: </b><?=$donhang['ngaydat']?><br>
                                <b class="ml-3">Ph????ng th???c: </b>
                                <?php
                                    switch($donhang['payment']){
                                        case 1: echo "Thanh to??n qua v?? ??i???n t???"; break;
                                        case 2: echo "Thanh to??n qua th??? ng??n h??ng"; break;
                                        case 3: echo "Thanh to??n khi nh???n h??ng"; break;
                                    }
                                ?><br>
                                <b class="ml-3">Tr???ng th??i: </b>
                                <?php
                                    switch($donhang['trangthai']){
                                        case 1: echo "<span class='text-warning'>??ang giao h??ng</span>"; break;
                                        case 2: echo "<span class='text-danger'>???? hu??? b???i ng?????i b??n</span>"; break;
                                        case 3: echo "<span class='text-danger'>???? hu??? b???i ng?????i mua</span>"; break;
                                        case 4: echo "<span class='text-success'>???? nh???n h??ng</span>"; break;
                                    }
                                    if($donhang['trangthai']==1){
                                ?>
                                <br><a onclick="cancel(<?=$donhang['id']?>)" href='#' class='m-3 btn btn-outline-danger'>Hu??? ????n h??ng</a>
                                <?php } else if ($donhang['trangthai']==4 && $donhang['pointplus']!=0 ) { ?>
                                    <br><h6 class="text-success ml-3"><b class="text-dark">??i???m t??ch lu???: </b> +<?=number_format($donhang['pointplus'], 0, ',', '.')?></h6>
                                <?php } ?>
                            </td>
                            <?php if($donhang['diem']!=0) { ?>
                            <td>                                
                                <h6>??i???m t??ch lu??? s??? d???ng:</h6>                                
                                <h6 class="mt-3">T???ng ti???n:</h6>
                            </td>
                            <td>
                                <h6 class="text-danger"><?=number_format($donhang['diem'], 0, ',', '.')?></h6>
                                <h6 class="text-danger mt-3"><?=number_format( $tong - $donhang['diem'], 0, ',', '.') ?> ??</h6>
                            </td>
                            <?php } else { ?>
                            <td><h6>T???ng ti???n:</h6></td>
                            <td><h6 class="text-danger"><?=number_format( $tong - $donhang['diem'], 0, ',', '.') ?> ???</h6></td>
                            <?php } ?>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php }
                } else { 
            ?>
                <div class="d-flex justify-content-center ">
                    <div class="m-5 px-5">
                        <img src="../assets/images/icon/empty-order.png">
                        <h4 class="text-center">B???n ch??a c?? ????n h??ng n??o</h4>
                        <p class="text-center mt-3"><a href="../home"><button class="btn btn-outline-pink">Mua ngay</button> </a></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php include("component/footer.php"); ?>
    <form action="order.php?do=cancel" method="post" id="cancel">
         <input type="hidden" id="cancelid" name="id">
    </form>
<!-- main wrapper start -->
<!-- main wrapper end -->
<?php include("component/js.php") ?>
</body>
<script>
    function cancel(id){
        Swal.fire({
            title: 'Hu??? ????n h??ng?',
            text: "B???n s??? kh??ng th??? ho??n t??c l???i ??i???u n??y!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'X??c nh???n',
            cancelButtonText: 'Hu???'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Oke, done!',
                '????n h??ng ???? ???????c hu???',
                'success'
                ).then((result) => {
                    if (result.isConfirmed){
                        $('#cancelid').val(id);
                        $('#cancel').submit();
                    }
                });
            }
        })
    }
</script>
</html>
<?php } ?>