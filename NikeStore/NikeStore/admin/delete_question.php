<?php
    include("../connect.php");
    $id = $_POST["id"];

    $sql="DELETE FROM question WHERE ID = $id";
    mysqli_query($con,$sql);
    
    header("Location:manage_question.php");
?>