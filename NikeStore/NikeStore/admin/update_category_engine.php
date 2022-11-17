<?php
       include("../connect.php");
       include("component/css.php");
       include("component/js.php");
       $id=$_POST["id"];
       $name=$_POST["name"];
       $desc=$_POST['desc'];
       $seo = url_slug($name)."-".rand();

       $sql="UPDATE `category` SET `name` = '$name', `desc` = '$desc', `seo` = '$seo' WHERE `category`.`ID` = $id";
       mysqli_query($con,$sql);
?>
<div></div>
<script type="text/javascript">
    Swal.fire({
        icon: 'success',
        title: 'Okay!!',
        text: 'Dòng sản phẩm đã được cập nhật!'
    }).then((result) => {
        location.href="manage_category.php"; 
    })
</script>