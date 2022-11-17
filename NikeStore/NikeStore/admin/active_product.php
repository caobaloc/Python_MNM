<?php
    include("../connect.php");
    $id = $_POST["id"];

    if($_GET['do']=='deactive')
        $sql = "UPDATE `product` SET `status` = '0' WHERE `product`.`ID` = $id";
    else
        $sql = "UPDATE `product` SET `status` = '1' WHERE `product`.`ID` = $id";
    mysqli_query($con, $sql);   

    header("Location:manage_product.php");
?>