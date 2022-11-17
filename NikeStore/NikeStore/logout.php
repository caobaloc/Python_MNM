<?php 

    session_start(); 
 
    if (isset($_SESSION['UserName'])){
        unset($_SESSION['UserName']); 
        if(isset($_SESSION['Cart']))
            unset($_SESSION['Cart']);
    }

    header("location:login.php");
?>