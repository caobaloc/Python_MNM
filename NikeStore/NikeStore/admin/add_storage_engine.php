<?php
    include("../connect.php");
    include("component/css.php");
    include("component/js.php");
    $product=$_POST["product"];
    $size=$_POST['size'];
    $quantity=$_POST['quantity'];
 
    $sql="INSERT INTO `storage` (`product_id`, `size_id`, `quantity`) VALUES ('$product', '$size', '$quantity')";
    try{
        mysqli_query($con,$sql);
?>
<div></div>
<script type="text/javascript">
    Swal.fire({
        icon: 'success',
        title: 'Okay!!',
        text: 'Kho hàng đã được thêm!'
    }).then((result) => {
        location.href="manage_storage.php"; 
    })
</script>
<?php
    }catch(Exception $e){
?>
<div></div>
<script type="text/javascript">
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Kho hàng đã tồn tại!'
    }).then((result) => {
        history.back(); 
    })
</script>
<?php
    }
?>