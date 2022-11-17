<?php
if (!isset($_SESSION['UserName'])) {
	header('Location:../login.php');
}else {
	if (isset($_SESSION['Permission'])) {
		$permission = $_SESSION['Permission'];
		if ($permission == '3') {
			include("404.php");
			exit();
		}
		$username = $_SESSION["UserName"];
        $sql = "select * from user where username ='$username'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row['active']==0){
            header("Location: ../login.php");
			exit();
		}
	}
}
?>