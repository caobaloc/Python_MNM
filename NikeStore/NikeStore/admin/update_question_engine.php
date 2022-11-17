<?php
       include("../connect.php");
       include("component/css.php");
       include("component/js.php");
       $id=$_POST["id"];
       $name=$_POST["title"];
       $desc=$_POST['answer'];
       $seo = url_slug($name)."-".rand();

       $sql="UPDATE `question` SET `title` = '$name', `answer` = '$desc' WHERE `question`.`ID` = $id";
       mysqli_query($con,$sql);
?>
<div></div>
<script type="text/javascript">
    Swal.fire({
        icon: 'success',
        title: 'Okay!!',
        text: 'Câu hỏi thường gặp đã được cập nhật!'
    }).then((result) => {
        location.href="manage_question.php"; 
    })
</script>