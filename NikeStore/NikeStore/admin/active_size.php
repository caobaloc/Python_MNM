<?php
    include("../connect.php");
    $id = $_POST['id'];

    if($_GET['do']=='deactive')
        $sql = "UPDATE `size` SET `status` = '0' WHERE `size`.`ID` = $id";
    else
        $sql = "UPDATE `size` SET `status` = '1' WHERE `size`.`ID` = $id";
    mysqli_query($con, $sql); 

    header("Location: manage_size.php");
?>