<?php
    include("../connect.php");
    $id = $_POST['id'];

    if($_GET['do']=='lock')
        $sql = "UPDATE `user` SET `active` = '0' WHERE `user`.`ID` = $id";
    else
        $sql = "UPDATE `user` SET `active` = '1' WHERE `user`.`ID` = $id";
    mysqli_query($con, $sql);  

    header("Location: manage_user.php");
?>