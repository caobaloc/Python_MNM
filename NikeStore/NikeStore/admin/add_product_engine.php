<div></div>
<?php
    include("../connect.php");
    include("component/css.php");
    include("component/js.php");
    $name = $_POST["name"];
    $sub_category = $_POST["sub_category"];
    $price = $_POST["price"];
    $price_sale = $_POST["price_sale"];
    $preview = $_FILES["images"]["tmp_name"];
    $desc = $_POST["desc"];
    $seo = url_slug($name)."-".rand();
    
    $image = "../assets/images/product/".$seo.".png";
    move_uploaded_file($_FILES["image"]["tmp_name"],$image);

    $sql = "INSERT INTO `product` (`ID`, `sub_category_id`, `name`, `price`, `price_sale`, `image`, `desc`, `seo`) VALUES (NULL, '$sub_category', '$name', '$price','$price_sale', '$image', '$desc','$seo')";
    mysqli_query($con, $sql);

    $id = mysqli_insert_id($con);
    foreach ($preview as $i) {
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
        text: 'Sản phẩm đã được thêm!'
    }).then((result) => {
        location.href="manage_product.php"; 
    })
</script>