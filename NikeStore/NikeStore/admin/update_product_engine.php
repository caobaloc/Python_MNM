<?php
    include("../connect.php");
    include("component/css.php");
    include("component/js.php");
    $id = $_POST["id"];
    $name = $_POST["name"];
    $sub_category = $_POST["sub_category"];
    $price = $_POST["price"];
    $price_sale = $_POST["price_sale"];
    $desc = $_POST["desc"];

    $sql = "SELECT * FROM product WHERE ID = '$id'";
    $kq = mysqli_query($con, $sql);
    $r = mysqli_fetch_assoc($kq);
    $seo = $r['seo'];

    if($_FILES["image"]["name"]==null)
        $sql = "UPDATE `product` SET `sub_category_id` = '$sub_category', `name` = '$name', `price` = '$price', `price_sale` = '$price_sale', `desc` = '$desc', `seo` = '$seo' WHERE `product`.`ID` = $id";
    else{
        $image = "../assets/images/product/".$seo.".png";
        move_uploaded_file($_FILES["image"]["tmp_name"],$image);
        $sql = "UPDATE `product` SET `sub_category_id` = '$sub_category', `name` = '$name', `price` = '$price', `price_sale` = '$price_sale', `image` = '$image', `desc` = '$desc', `seo` = '$seo' WHERE `product`.`ID` = $id";
    }
    mysqli_query($con, $sql);

    $preview = $_FILES["images"]["tmp_name"]; 
    foreach ($preview as $i) {
        if($i == null) 
            break;
        $images = "";
        $sql = "INSERT INTO `product_image` (`ID`, `product_id`, `name`) VALUES (NULL, '$id', '$images')";
        mysqli_query($con, $sql);

        $preview_id = mysqli_insert_id($con);
        $images = "../assets/images/product/".$seo."-". $preview_id.".png";
        move_uploaded_file($i,$images);
        $sql = "UPDATE `product_image` SET `name` = '$images' WHERE `product_image`.`ID` =  $preview_id";
        mysqli_query($con, $sql);
    }
?>
<div></div>
<script type="text/javascript">
    Swal.fire({
        icon: 'success',
        title: 'Okay!!',
        text: 'Sản phẩm đã được cập nhật!'
    }).then((result) => {
        location.href="manage_product.php"; 
    })
</script>