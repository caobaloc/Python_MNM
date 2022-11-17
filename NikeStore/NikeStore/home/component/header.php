<div class="top-header bg-pink">
    <div class="container p-2">
        <p class="text-white">Mua giày, đến NikeStore!  - Thương hiệu bán lẻ Giày Nike chính hãng số 1 về dịch vụ</p>
    </div>                
</div>
<div class="header-area">
    <div class="container">
        <div class="row align-items-center justify-content-between py-3">
            <div class="col-md-3 col-lg-2 my-3">
                <div class="logo">
                    <a href="../home"><img src="../assets/images/icon/logo2.png" alt="logo"></a>
                </div>
            </div>
            <div class="col-lg-4  d-none d-lg-block">
                <nav class="menu">
                    <ul class="d-flex" id="nav_menu">
                        <li class="px-3 py-3"><a class="menu-hover-effect" href="javascript:void(0)">Sản phẩm</a>
                            <ul>
                            <?php 
                                $sql = "SELECT * FROM category WHERE category.status = 1 ";
                                $rs = mysqli_query($con,$sql);
                                while ($r = mysqli_fetch_assoc($rs)) {
                            ?>
                                <li class="px-3 py-2"><a class="menu-hover-effect" href="category.php?seo=<?=$r['seo']?>"><?=$r['name']?></a>
                                    <ul>
                                    <?php 
                                        $sql = "SELECT * FROM sub_category WHERE category_id = '".$r['ID']."' AND sub_category.status = 1 ";
                                        $rs2 = mysqli_query($con,$sql);
                                        while ($row = mysqli_fetch_assoc($rs2)) {
                                    ?>
                                        <li class="px-3 py-2"><a class="menu-hover-effect" href="subcategory.php?seo=<?=$row['seo']?>"><?=$row['name']?></a></li>
                                    <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                            </ul>
                        </li>
                        <li class="px-3 py-3"><a class="menu-hover-effect" href="#">Giới thiệu</a></li>
                        <li class="px-3 py-3"><a class="menu-hover-effect" href="cskh.php">CSKH</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-6 col-md-9 d-flex justify-content-between align-items-center pull-right header-items">
                <!-- search area start-->
                <?php include('component/search.php'); ?>
                <!-- search area end-->
                <div class="d-flex justify-content-center align-items-center w-100">
                    <div class="cart ml-3">
                        <form action="cart.php">
                            <button class="btn btn-outline-pink d-flex align-items-center justify-content-around" type="submit">
                                <i class="fa fa-shopping-cart mr-2"></i><b>Cart</b>
                                <span class="badge bg-pink text-white ml-2 px-2 py-1 rounded-circle btn-cart">
                                <?php    
                                    if(isset($_SESSION['Cart']) & isset($_SESSION['UserName']))
                                        echo count($_SESSION['Cart']);
                                    else echo 0;
                                ?>
                                </span>
                            </button>
                        </form>
                    </div>
                    <div class="user-profile ml-3 pull-right">
                            <?php if (isset($_SESSION['UserName'])){ ?>
                                <div class="btn btn-outline-pink pl-5 pr-3 dropdown-toggle" data-toggle="dropdown" >
                            <?php
                                    $current_username = $_SESSION['UserName'];
                                    $s = "SELECT avatar FROM user WHERE username='$current_username'";
                                    $b = mysqli_query($con,$s);
                                    $d = mysqli_fetch_assoc($b);
                                    if($d['avatar']!=null){
                                        echo'<img class="avatar mr-2" src="'.$d['avatar'].'" alt="avatar">';
                                    }
                                    else
                                        echo'<img class="avatar mr-2" src="../assets/images/avatar/avatar.png" alt="avatar">';
                            ?>
                            <b>
                                <?=$_SESSION['UserName']?>
                            </b>
                        </div>    
                        <div class="dropdown-menu">
                            <?php if ($_SESSION['Permission']!=3){ ?>
                            <a class="dropdown-item" href="../admin/index.php">Đi tới trang quản lý </a>
                            <?php } ?>
                            <a class="dropdown-item" href="order.php">Đơn hàng</a>
                            <a class="dropdown-item" href="update_profile.php">Thông tin </a>
                            <a class="dropdown-item" href="../logout.php">Đăng xuất</a>
                        </div>
                        <?php } else{ ?>
                                <a href="../login.php"class="btn btn-outline-pink"><i class="fa fa-sign-in mr-2"></i><b>Đăng nhập</b></a>
                        <?php } ?>   
                    </div>
                </div>
            </div>
            <!-- mobile_menu -->
            <div class="col-12 d-block d-lg-none">
                <div id="mobile_menu"></div>
            </div>
        </div>
    </div>
</div>