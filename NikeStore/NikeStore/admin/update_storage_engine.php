<?php
    include("../connect.php");
    include("component/css.php");
    include("component/js.php");
    $product=$_POST["product"];
    $size=$_POST['size'];
    $quantity=$_POST['quantity'];
 
    $sql = "UPDATE `storage` SET `quantity` = '$quantity' WHERE `storage`.`product_id` = $product AND `storage`.`size_id` = $size";
    mysqli_query($con,$sql);
?>
<div></div>
<script type="text/javascript">
    Swal.fire({
        icon: 'success',
        title: 'Okay!!',
        text: 'Kho hàng đã được cập nhật!'
    }).then((result) => {
        location.href="manage_storage.php"; 
    })
</script>