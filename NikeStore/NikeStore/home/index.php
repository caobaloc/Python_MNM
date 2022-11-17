<?php
    session_start();
    include("../connect.php");
    $sqlmain = "SELECT DISTINCT image, product.name as tensp, product.price as dongia, product.price_sale as sale, product.seo as spseo
                 FROM storage INNER JOIN product ON storage.product_id = product.ID INNER JOIN size ON storage.size_id = size.ID
                 INNER JOIN sub_category ON product.sub_category_id = sub_category.ID
                 WHERE product.status = 1 AND sub_category.status = 1 "; 
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nike Store</title>
    <?php include("component/css.php") ?>
</head>
<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="horizontal-main-wrapper">
        <!-- main header area start -->
        <?php include("component/header.php"); ?>
        <!-- main header area end -->
        <div class="main-content container-fluid">
            <div class="row ">
                <!-- filter area start-->
                <?php include('component/filter.php'); ?>
                <!-- filter area end-->
                <div class="col m-3" >
                    <div class="home-title d-flex justify-content-between">
                        <a href="category.php" class="text-dark pt-2"><b>Trang chủ</b></a>
                        <?php include('component/filter-2.php'); ?>
                    </div>
                    <div class="product-container row mt-3">
                        <?php
                            $dssp = mysqli_query($con,$sqlmain);
                            while($sp = mysqli_fetch_assoc($dssp)){
                        ?>
                        <a href="detail.php?seo=<?=$sp['spseo']?>" class="col-3 p-0">
                            <div class="product-item text-center align-item-center p-3">
                                <div class="product-img">
                                    <img class="product-main-img" src="<?=$sp['image']?>">
                                    <img class="doi-tra-tag" src="../assets/images/icon/Doi-tra-mien-phi-e1620375876379.png">
                                    <img class="giao-nhanh-tag" src="../assets/images/icon/GIAO-NHANH-SDNOW-1.png">
                                    <img class="hoan-tien-tag" src="../assets/images/icon/re-hon-hoan-tien-3.png">
                                    <?php if( $sp["dongia"] != $sp["sale"]) {?>
                                        <span class="sale-tag bg-danger text-white px-2">Sale: <?= number_format((( $sp["dongia"] - $sp["sale"] ) / $sp["dongia"] * 100 ), 2)?>% 🔥</span>
                                    <?php } ?>
                                </div>
                                <p><span><?=$sp['tensp']?></span></p>
                                <?php if( $sp["dongia"] == $sp["sale"]) {?>
                                    <b class="text-dark"><?=number_format($sp["dongia"], 0, ',', '.')?> ₫</b>
                                <?php } else {?>
                                    <b class="text-danger mr-2"><span><?=number_format($sp["dongia"], 0, ',', '.')?> ₫</span></b>
                                    <b class="text-danger"><?=number_format($sp["sale"], 0, ',', '.')?> ₫</b>
                                <?php } ?>
                            </div>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include("component/footer.php") ?>
    <!-- main wrapper end -->
    <?php include("component/js.php") ?>
</body>
</html>