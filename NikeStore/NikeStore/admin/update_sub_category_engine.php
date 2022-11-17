<?php
    include("../connect.php");
    include("component/css.php");
    include("component/js.php");
    $id = $_POST["id"];
    $name = $_POST["name"];
    $sub_category = $_POST["sub_category"];
    $desc = $_POST["desc"];
    $seo = url_slug($name)."-".rand();

    $sql = "UPDATE `sub_category` SET `category_id` = '$sub_category', `name` = '$name', `desc` = '$desc', `seo` = '$seo' WHERE `sub_category`.`ID` = $id";
        
    mysqli_query($con, $sql);

?>
<div></div>
<script type="text/javascript">
    Swal.fire({
        icon: 'success',
        title: 'Okay!!',
        text: 'Loại sản phẩm đã được cập nhật!'
    }).then((result) => {
        location.href="manage_sub_category.php"; 
    })
</script>