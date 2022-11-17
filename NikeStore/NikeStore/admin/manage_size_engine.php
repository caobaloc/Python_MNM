<?php
    include("../connect.php");
    $updatename = $_POST['updatename'];
    $id = $_POST['updateid'];
    $sql = "UPDATE `size` SET `name` = '$updatename' WHERE `size`.`ID` = $id";
    mysqli_query($con, $sql);
    header("Location: manage_size.php");    
?>