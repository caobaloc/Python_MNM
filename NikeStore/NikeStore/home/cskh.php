<?php
    session_start();
    include("../connect.php");
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
            <ul class="question-field m-5">
                <h5>Câu hỏi thường gặp</h5>
            <?php
                $sql = "SELECT * FROM question";
                $rs = mysqli_query($con,$sql);
                while($r = mysqli_fetch_assoc($rs)){
            ?>
                <div class="question">
                    <li onclick="$(this).parents('.question').find('.answer').toggleClass('active');">
                        <h6><?=$r["title"]?></h6>
                    </li>
                    <div class="answer">
                        <?=$r["answer"]?>
                    </div>
                </div>
            <?php } ?>
            </ul>
            <h5 class="text-center m-4">Bạn có muốn tìm thêm thông tin gì không?</h5>
            <div class="d-flex justify-content-center">
                <div class="contact-box">
                    <div class="icon">
                        <ti class="ti-email"></ti>
                    </div>
                    <div class="content">
                        <h6>Gmail: <span>cskh_nikestore@gmail.com</span></h6>
                        <p>Gửi câu hỏi của bạn</p>
                    </div>
                </div>
                <div class="contact-box">
                    <div class="icon">
                        <ti class="ti-headphone-alt"></ti>
                    </div>
                    <div class="content">
                        <h6>Hotline: <span>19001215</span></h6>
                        <p>Liên hệ qua đường dây lạnh</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("component/footer.php"); ?>
<!-- main wrapper start -->
<!-- main wrapper end -->
<?php include("component/js.php") ?>
</body>
</html>