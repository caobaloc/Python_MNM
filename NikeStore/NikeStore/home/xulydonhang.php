<div></div>
<?php
    session_start();
    include("../connect.php");
    include("component/css.php");
    include("component/js.php");
    $username = $_SESSION['UserName'];

    $sql = "select * from user where username ='$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    if($row['active']==0)
        header("Location: ../login.php");
    else{
        $name = $_POST['name'];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $seo = url_slug($name);
        $payment = $_POST["payment"];
        $date = date('Y-m-d');
        $point = $_POST["point"];

        $cart = $_SESSION['Cart'];

        $sql = "UPDATE user SET name = '$name', phone = '$phone' WHERE  username = '$username'";
        mysqli_query($con,$sql);

        $sql = "SELECT ID FROM user WHERE username = '$username'";
        $id = mysqli_query($con,$sql);
        $id = mysqli_fetch_assoc($id);
        $id = $id['ID'];

        $sql = "INSERT INTO ordered VALUES (NULL, '$id', '$date', '$address', '$payment', '1', '$point', 0)";
        mysqli_query($con,$sql);
        $order_id = mysqli_insert_id($con);

        foreach ($cart as $key => $value) {
            $sql = "INSERT INTO orderdetail VALUES (NULL, '$order_id', '".$value['mahang']."', '".$value['masize']."', '".$value['soluong']."')";
            mysqli_query($con,$sql);
        }
        unset($_SESSION['Cart']);

        $sql = "UPDATE user SET point = point - $point WHERE username = '$username'";
        mysqli_query($con,$sql);

?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Đặt hàng thàng công!',
        text: 'Vui lòng kiểm tra lại trong mục đơn hàng!'
    }).then((result) => {
        location.href = "order.php";
    })
</script>
<?php } ?>