<div class="col-sm-4 clearfix">
    <div class="user-profile pull-right">
        <?php 
            if (isset($_SESSION['UserName'])){
                $current_username = $_SESSION['UserName'];
                $s = "SELECT avatar FROM user WHERE username='$current_username'";
                $b = mysqli_query($con,$s);
                $d = mysqli_fetch_assoc($b);
                if($d['avatar']!=null){
                    echo'<img class="avatar" src="'.$d['avatar'].'" alt="avatar">';
                }
                else
                    echo'<img class="avatar" src="../assets/images/avatar/avatar.png" alt="avatar">';
        ?>
        <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
            <?=$_SESSION['UserName']?>
            <i class="fa fa-angle-down"></i>
        </h4>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="update_profile.php">Thông tin </a>
            <a class="dropdown-item" href="../logout.php">Đăng xuất</a>
        </div>
        <?php
            }
            else{
                echo '<a href="../login.php" class="text-white"><i class="fa fa-sign-in mr-2"></i>Đăng nhập</a>';
            }
        ?>
    </div>
</div>