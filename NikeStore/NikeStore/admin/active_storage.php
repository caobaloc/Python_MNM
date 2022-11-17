<?php
    include("../connect.php");
    $product=$_POST["product_id"];
    $size=$_POST['size_id'];

    if($_GET['do']=='deactive')
        $sql = "UPDATE `storage` SET `status` = '0' WHERE product_id = $product AND size_id = $size ";
    else
        $sql = "UPDATE `storage` SET `status` = '1' WHERE product_id = $product AND size_id = $size ";
    mysqli_query($con, $sql);

    header("Location: manage_storage.php");
?>