<?php
    session_start();
    include("../connect.php");
    if(isset($_GET['seo'])){
        $seo = $_GET['seo'];
        $sqlmain = "SELECT DISTINCT image, product.name as tensp, product.price as dongia, product.price_sale as sale, category.seo as tlseo, sub_category.seo as dtlseo, product.desc as mota,
                    category.name as dongtl, sub_category.name as tl, product.ID as idsp
                 FROM storage INNER JOIN product ON storage.product_id = product.ID INNER JOIN size ON storage.size_id = size.ID 
                 INNER JOIN sub_category ON product.sub_category_id = sub_category.ID INNER JOIN category ON sub_category.category_id = category.ID 
                 WHERE product.seo = '$seo' ";
    }
    else
        header('Location: ../home');
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
        <div class="main-content container">
            <div class="row justify-content-around">
                <div class="col-lg-6 col-md-6 m-3">
                    <div class="slider slider-for">
                        <?php
                            $dssp = mysqli_query($con,$sqlmain);
                            $sp = mysqli_fetch_assoc($dssp);
                            $anhsp = $sp['image'];
                        ?>
                        <div class="product-detail-img">
                            <img src="<?=$anhsp?>" width="100%">
                        </div>
                        <?php
                            $sqlsub = "SELECT product_image.name as anh FROM product_image INNER JOIN product ON product_image.product_id = product.ID WHERE product.seo = '$seo'";
                            $kq = mysqli_query($con, $sqlsub);
                            while($anhpreview = mysqli_fetch_assoc($kq)){
                        ?>
                        <div class="product-detail-img">
                            <img src="<?=$anhpreview['anh']?>" width="100%">
                        </div>
                        <?php } ?>
                    </div>
                    <div class="slider slider-nav">
                        <div><img src="<?=$anhsp?>" style="cursor: pointer;"></div>
                        <?php
                            $sqlsub = "SELECT product_image.name as anh FROM product_image INNER JOIN product ON product_image.product_id = product.ID WHERE product.seo = '$seo'";
                            $kq = mysqli_query($con, $sqlsub);
                            while($anhpreview = mysqli_fetch_assoc($kq)){
                        ?>
                        <div>
                            <img src="<?=$anhpreview['anh']?>" style="cursor: pointer;" width="100%">
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5 m-3" >
                    <div class="home-title mt-5">
                        <a href="../home" class="text-dark"><b>Trang chủ</b></a>
                        » <a href="category.php?seo=<?=$sp['tlseo']?>" class="text-dark"><b><?=$sp['tl']?></b></a>
                        » <a href="subcategory.php?seo=<?=$sp['dtlseo']?>" class="text-dark"><b><?=$sp['dongtl']?></b></a>
                        » <span><?=$sp['tensp']?></span>
                    </div>
                    <div class="product-detail-title mt-4">
                        <p><?=$sp['tensp']?></p>
                    </div>
                    <div class="product-detail-price mt-4">
                        <?php if($sp['dongia'] == $sp['sale']) { ?>
                            <b><?=number_format($sp["dongia"], 0, ',', '.')?> ₫</b>
                        <?php } else { ?>
                            <b class="mr-2"><span><?=number_format($sp["dongia"], 0, ',', '.')?> ₫</span></b>
                            <b><?=number_format($sp["sale"], 0, ',', '.')?> ₫</b>
                        <?php } ?>
                    </div>
                    <div class="short-description p-3 mt-4">
                        <h6 class="mb-4">VÌ SAO CHỌN NikeStore.vn ?</h6>
                        <p><i class="fa fa-check text-success mr-1"></i>Tặng phiếu bảo hiểm giày và vệ sinh giày 6 tháng trị giá 350K</p>
                        <p><i class="fa fa-check text-success mr-1"></i>Mua tất giảm ngay 20% <a href="#">(click xem chi tiết)</a></p>
                        <p><i class="fa fa-check text-success mr-1"></i>Cam kết chính hãng 100%</p>
                        <p><i class="fa fa-check text-success mr-1"></i>Miễn phí đổi trả 365 ngày <a href="#">(click xem chi tiết)</a></p>
                        <p><i class="fa fa-check text-success mr-1"></i>Miễn phí bảo hành 1 năm trên toàn hệ thống <a href="#">(click xem chi tiết)</a></p>
                        <p><i class="fa fa-check text-success mr-1"></i>Độc quyền phân phối tại NikeStore.vn</p>
                    </div>
                    <?php
                        $sqlcheck = "SELECT SUM(quantity) as kho from storage WHERE storage.product_id = '".$sp['idsp']."' GROUP BY storage.product_id";
                        $kqcheck = mysqli_query($con,$sqlcheck);
                        $checkstorage = mysqli_fetch_assoc($kqcheck);
                        if( $checkstorage['kho'] == 0) {
                    ?>
                    <p class="sold-out-product mt-4">
                        Sản phẩm đã được bán hết
                    </p>
                    <?php } else {?>
                    <form class="mt-4" action="cart_engine.php" method="POST" id="addToCardForm">
                        <div class="product-detail-size mt-4 d-flex align-items-center">
                            <p class="mr-5">Size: </p>
                            <?php
                                $sqlsize = "SELECT size.ID as sizeid, size.name as size, storage.quantity as sl from storage INNER JOIN size ON size.ID = storage.size_id 
                                            WHERE size.status = 1 AND storage.status = 1 AND storage.product_id = '".$sp['idsp']."'";
                                $kqsize = mysqli_query($con,$sqlsize);
                                while ( $size = mysqli_fetch_assoc($kqsize) ){ 
                                    $sldachon = 0;
                            ?>
                                <?php
                                    if(isset($_SESSION['Cart']) && isset($_SESSION["UserName"])){
                                        $cart = $_SESSION['Cart'];
                                        foreach ($cart as $key => $value) {
                                            if($value['mahang'] == $sp['idsp'] && $value['masize'] == $size['sizeid']){
                                                $sldachon = $value["soluong"];
                                                break;
                                            }
                                        }
                                    }
                                ?>
                                <input type="radio" name="size" id="size<?=$size['sizeid']?>" value="<?=$size['sizeid']?>" class="mr-2" onclick="GetSizeQuantity(this,<?=$size['sl']?>,<?=$sldachon?>);" />
                                <label for="size<?=$size['sizeid']?>"><?=$size['size']?></label>
                            <?php } ?>
                        </div>
                        <input type="hidden" name="id" value="<?=$sp['idsp']?>">
                        <input type="hidden" name="product" value="<?=$sp['tensp']?>">
                        <input type="hidden" name="price" value="<?=$sp['dongia']?>">
                        <input type="hidden" name="sale" value="<?=$sp['sale']?>">
                        <input type="hidden" name="image" value="<?=$sp['image']?>">
                        <input type="hidden" name="seo" value="<?=$seo?>">
                        <input type="hidden" name="storage_quantity" id="storage_quantity" value="">
                        <input type="hidden" id="added_quantity" value="">
                        <div class="product-size-quantity mt-4"></div>
                        <h6 class="mt-4 text-primary" data-toggle="modal" data-target="#exampleModalCenter" style="cursor:pointer; text-decoration:underline ;">Bảng quy đổi kích cỡ</h6>
                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-lg" id="exampleModalCenter">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="../assets/images/media/bang-kich-co.jpg" width="100%" alt="Bảng quy đổi kích cỡ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mr-3">
                                <div class="product-detail-quantity d-flex mt-4">
                                    <p class="btn btn-quantity px-3" onclick="this.parentNode.querySelector('#quantityGetToCart').stepDown()">
                                        <i class="fa fa-minus"></i>
                                    </p>
                                    <input id="quantityGetToCart" min="1" name="quantity" value="1" size="1" type="number" class="form-control form-control-sm text-center"/>
                                    <p class="btn btn-quantity px-3" onclick="this.parentNode.querySelector('#quantityGetToCart').stepUp()">
                                        <i class="fa fa-plus"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4" style="width: fit-content;">
                                <button type="button" class="btn btn-buy-now btn-primary py-2 my-2 w-100">Mua ngay</button>
                                <button type="button" class="btn btn-to-cart btn-outline-pink py-2 my-2 w-100">Thêm vào giỏ hàng</button>
                            </div>
                        </div>
                    </form>                    
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="big-description">
            <div class="container mt-5">
                <h2 class="text-center"><b>Mô tả sản phẩm</b></h2>
                <div class="p-5">
                    <?=$sp['mota']?>
                </div>
            </div>
        </div>
        <div class="container">
            <h4 class="m-5"><b>Sản phẩm tương tự</b></h4>
            <div class="product-related row">
            <?php
                $sqlosp = "SELECT DISTINCT image, product.name as tensp, product.price as dongia, product.price_sale as sale, product.seo as spseo
                            FROM storage INNER JOIN product ON storage.product_id = product.ID INNER JOIN size ON storage.size_id = size.ID 
                            INNER JOIN sub_category ON product.sub_category_id = sub_category.ID 
                            WHERE  sub_category.seo = '".$sp['dtlseo']."' ";
                $kqosp = mysqli_query($con, $sqlosp);
                while($osp = mysqli_fetch_assoc($kqosp)){
            ?>
                <a href="detail.php?seo=<?=$osp['spseo']?>" class="p-0">
                    <div class="product-item text-center align-item-center p-3">
                        <div class="product-img">
                            <img class="product-main-img" src="<?=$osp['image']?>">
                            <img class="doi-tra-tag" src="../assets/images/icon/Doi-tra-mien-phi-e1620375876379.png">
                            <img class="giao-nhanh-tag" src="../assets/images/icon/GIAO-NHANH-SDNOW-1.png">
                            <img class="hoan-tien-tag" src="../assets/images/icon/re-hon-hoan-tien-3.png">
                            <?php if( $osp["dongia"] != $osp["sale"]) {?>
                                <span class="sale-tag bg-danger text-white px-2">Sale: <?= number_format((( $osp["dongia"] - $osp["sale"] ) / $osp["dongia"] * 100 ), 2)?>% 🔥</span>
                            <?php } ?>
                        </div>
                        <p><span><?=$osp['tensp']?></span></p>
                        <?php if( $osp["dongia"] == $osp["sale"]) {?>
                            <b class="text-dark"><?=number_format($osp["dongia"], 0, ',', '.')?> ₫</b>
                        <?php } else {?>
                            <b class="text-danger mr-2"><span><?=number_format($osp["dongia"], 0, ',', '.')?> ₫</span></b>
                            <b class="text-danger"><?=number_format($osp["sale"], 0, ',', '.')?> ₫</b>
                        <?php } ?>
                    </div>
                </a>
            <?php } ?>
            </div>
        </div>
    </div>
    <?php include("component/footer.php") ?>
    <!-- main wrapper end -->
    <?php include("component/js.php") ?>
</body>
<script>
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: true,
        focusOnSelect: true
    });
    $('.product-related').slick({
        dots: true,
        infinite: false,
        speed: 300,
        fade: false,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
            }
        ]
    });
    function GetSizeQuantity(a,num,sl){
        if(a.checked == true){
            $("#storage_quantity").val(parseInt(num));
            $("#added_quantity").val(parseInt(sl));
            $(".product-size-quantity").css('border','2px solid red');
            if(num==0){
                $(".product-size-quantity").text('Trong kho đã hết sản phẩm');
                $(".product-size-quantity").css('border','2px solid red');
                $(".product-size-quantity").css('color','red');
                $(".product-size-quantity").css('display','block');
                $("#quantityGetToCart").val(0);
            }
            else{
                $(".product-size-quantity").text('Trong kho còn ' + parseInt(num) + ' sản phẩm');
                $(".product-size-quantity").css('border','2px solid #7cc0a6');
                $(".product-size-quantity").css('color','#7cc0a6');
                $(".product-size-quantity").css('display','block');
                $("#quantityGetToCart").val(1);
            }
            $("#quantityGetToCart").attr('max', parseInt(num));
        }
    }

    function checkBeforeSubmit(){
        if($("#storage_quantity").val() == ""){
            $(".product-size-quantity").text('Vui lòng chọn size giày trước');
            $(".product-size-quantity").css('border','2px solid orange');
            $(".product-size-quantity").css('color','orange');
            $(".product-size-quantity").css('display','block');
        }
        else{
            var test = parseInt($("#added_quantity").val()) + parseInt($("#quantityGetToCart").val());
            if(test > parseInt($("#storage_quantity").val())){
                $(".product-size-quantity").text('Tổng số lượng trong giỏ hàng lớn hơn số lượng tồn trong kho! Bạn không thể thêm sản phẩm');
                $(".product-size-quantity").css('border','2px solid red');
                $(".product-size-quantity").css('color','red');
            }
            else if ($("#quantityGetToCart").val()!=0 )
                $("#addToCardForm").submit();
        }
    }

    $('.btn-buy-now').on('click', function(){
        checkBeforeSubmit();
    });
    $('.btn-to-cart').on('click', function(){
        $("#addToCardForm").attr('action', 'cart_engine.php?seo=<?=$seo?>');
        checkBeforeSubmit();
    });

    $('#quantityGetToCart').on('keyup',function(){
        if(parseInt(this.value) > parseInt(this.max)){
            this.value = this.max;
        }else if(parseInt(this.value) <= 0){
            this.value = 1;
        }
    });
</script>
</html>