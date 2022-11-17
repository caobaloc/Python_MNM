<?php
   include("../connect.php");
   include("component/css.php");
   include("component/js.php");
   $name=$_POST["title"];
   $desc=$_POST['answer'];

   $sql="INSERT INTO question VALUES (NULL, '$name', '$desc')";
   mysqli_query($con,$sql);
?>
<div></div>
<script type="text/javascript">
    Swal.fire({
        icon: 'success',
        title: 'Okay!!',
        text: 'Câu hỏi thường gặp đã được thêm!'
    }).then((result) => {
        location.href="manage_question.php"; 
    })
</script>