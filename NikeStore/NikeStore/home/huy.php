<?php
    session_start();
	if(isset($_GET['cart_id'])){
        $cart = $_GET['cart_id'];
        unset($_SESSION['Cart'][$cart]);
    }
    if(isset($_GET['cart_ids'])){
        $cart = $_GET['cart_ids'];
        foreach ($cart as $key) {
            echo $key;
            unset($_SESSION['Cart'][$key]);
        }
    }
    if(count($_SESSION['Cart'])==0)
        unset($_SESSION['Cart']);
?>
<script>history.go(-1)</script>