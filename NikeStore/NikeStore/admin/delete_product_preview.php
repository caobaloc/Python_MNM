<?php
    include("../connect.php");
    $id = $_GET["id"];
    $preview_id = $_GET['preview_id'];

    $sql = "SELECT name FROM product_image WHERE ID = $preview_id";
    $kq = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($kq);
    unlink($row["name"]);

    $sql="DELETE FROM `product_image` WHERE `product_image`.`ID` = $preview_id";
    mysqli_query($con,$sql);
    
    header("Location:update_product.php?id=$id");
?>