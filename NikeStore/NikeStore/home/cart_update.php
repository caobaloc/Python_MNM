<?php
    session_start();
    include("../connect.php");

    $username = $_SESSION["UserName"];
    $sql = "select * from user where username ='$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    if($row['active']==0)
        header("Location: ../login.php");

    $count = $_GET['id'];
    $quantity = $_GET['quantity'];

    $_SESSION['Cart'][$count]['soluong'] = $quantity;
?>
<script>history.go(-1);</script>