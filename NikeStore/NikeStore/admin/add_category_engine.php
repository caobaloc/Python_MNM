<?php
   include("../connect.php");
   include("component/css.php");
   include("component/js.php");
   $name=$_POST["name"];
   $desc=$_POST['desc'];
   $seo = url_slug($name)."-".rand();

   $sql="INSERT INTO `category` (`ID`, `name`, `desc`, `seo`) VALUES (NULL, '$name', '$desc', '$seo')";
   mysqli_query($con,$sql);
?>
<div></div>
<script type="text/javascript">
    Swal.fire({
        icon: 'success',
        title: 'Okay!!',
        text: 'Dòng sản phẩm đã được thêm!'
    }).then((result) => {
        location.href="manage_category.php"; 
    })
</script>