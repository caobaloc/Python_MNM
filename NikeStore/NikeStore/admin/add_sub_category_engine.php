<?php
    include("../connect.php");
    include("component/css.php");
    include("component/js.php");
    $sub_category = $_POST["sub_category"];
    $name = $_POST["name"];
    $desc = $_POST["desc"];
    $seo = url_slug($name)."-".rand();

    $sql = "INSERT INTO `sub_category` (`ID`, `category_id`, `name`, `desc`, `seo`) VALUES (NULL, '$sub_category', '$name', '$desc','$seo')";
    mysqli_query($con, $sql);
?>
<div></div>
<script type="text/javascript">
    Swal.fire({
        icon: 'success',
        title: 'Okay!!',
        text: 'Loại sản phẩm đã được thêm!'
    }).then((result) => {
        location.href="manage_sub_category.php"; 
    })
</script>