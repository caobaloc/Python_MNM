<?php 
    $filenamearr = explode("/",$_SERVER['PHP_SELF']);
    $filename = array_pop($filenamearr);
?>
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="../home/index.php"><img src="../assets/images/icon/logo3.png" width="100%" alt="logo"></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li <?php if($filename=="index.php") echo"class='active'" ?> ><a href="index.php"><i class="ti-home"></i><span>Trang chủ</span></a>
                    <li <?php if($filename=="manage_ordered.php" || $filename=="manage_orderdetail.php" ) echo"class='active'" ?> ><a href="manage_ordered.php"><i class="ti-clipboard"></i><span>Quản lý đơn hàng</span></a>
                    <li <?php if($filename=="manage_product.php" || $filename=="add_product.php" || $filename=="update_product.php") echo"class='active'" ?> >
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layers-alt"></i> <span>Quản lý sản phẩm</span></a>
                        <ul class="collapse">
                            <li <?php if($filename=="manage_product.php") echo"class='active'" ?> ><a href="manage_product.php">Quản lý sản phẩm</a></li>
                            <li <?php if($filename=="add_product.php" || $filename=="update_product.php") echo"class='active'" ?> ><a href="add_product.php">Thêm sản phẩm</a></li>
                        </ul>
                    </li>
                    <li <?php if($filename=="manage_sub_category.php" || $filename=="add_sub_category.php" || $filename=="update_sub_category.php") echo"class='active'" ?> >
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-package"></i> <span>Quản lý loại sản phẩm</span></a>
                        <ul class="collapse">
                            <li <?php if($filename=="manage_sub_category.php") echo"class='active'" ?> ><a href="manage_sub_category.php">Quản lý loại sản phẩm</a></li>
                            <li <?php if($filename=="add_sub_category.php" || $filename=="update_sub_category.php") echo"class='active'" ?> ><a href="add_sub_category.php">Thêm loại sản phẩm</a></li>
                        </ul>
                    </li>
                    <li <?php if($filename=="manage_category.php" || $filename=="add_category.php" || $filename=="update_category.php") echo"class='active'" ?> >
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-gallery"></i> <span>Quản lý dòng sản phẩm</span></a>
                        <ul class="collapse">
                            <li <?php if($filename=="manage_category.php") echo"class='active'" ?> ><a href="manage_category.php">Quản lý dòng sản phẩm</a></li>
                            <li <?php if($filename=="add_category.php" || $filename=="update_category.php") echo"class='active'" ?> ><a href="add_category.php">Thêm dòng sản phẩm</a></li>
                        </ul>
                    </li>
                    <li <?php if($filename=="manage_size.php") echo"class='active'" ?> ><a href="manage_size.php"><i class="ti-ruler"></i><span>Quản lý kích cỡ</span></a>
                    <li <?php if($filename=="manage_storage.php" || $filename=="add_storage.php" || $filename=="update_storage.php") echo"class='active'" ?> >
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-archive"></i> <span>Quản lý kho hàng</span></a>
                            <ul class="collapse">
                                <li <?php if($filename=="manage_storage.php") echo"class='active'" ?> ><a href="manage_storage.php">Quản lý kho hàng</a></li>
                                <li <?php if($filename=="add_storage.php" || $filename=="update_storage.php") echo"class='active'" ?> ><a href="add_storage.php">Thêm kho hàng</a></li>
                            </ul>
                    <li <?php if($filename=="manage_user.php" || $filename=="change_password.php") echo"class='active'" ?>>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-users"></i> <span>Quản lý người dùng</span></a>
                        <ul class="collapse">
                            <li <?php if($filename=="manage_user.php") echo"class='active'" ?> ><a href="manage_user.php" >Quản lý người dùng</a></li>
                            <li <?php if($filename=="change_password.php") echo"class='active'" ?> ><a href="change_password.php" >Đổi mật khẩu</a></li>
                        </ul>
                    </li>
                    <li <?php if($filename=="manage_question.php") echo"class='active'" ?> ><a href="manage_question.php"><i class="ti-headphone-alt"></i><span>Chăm sóc khách hàng</span></a>
                </ul>
            </nav>
        </div>
    </div>
</div>