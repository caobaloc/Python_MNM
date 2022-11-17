<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
    if($_SESSION['Permission']==2 || $_SESSION['Permission']==4){
        header("Location: 505.php");
    }
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $sql = "SELECT * FROM question WHERE ID = '$id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý website Nike Store</title>
    <?php include("component/css.php") ?>
</head>
<body class="body-bg">
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div> 
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <?php include("./component/header.php"); ?>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <?php include("component/search.php"); ?>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left"><b>Cập nhật câu hỏi thường gặp</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><a href="manage_category.php">Chăm sóc khách hàng</a></li>
                                <li><span>Cập nhật câu hỏi thường gặp</span></li>
                            </ul>
                        </div>
                    </div>
                    <?php include("component/logged.php"); ?>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- form primary start -->
                <div class="card mt-3">
                    <div class="card-body">
                        <form action="update_question_engine.php" method="POST">
                            <input type="hidden" name="id" value="<?=$id?>">
                            <div class="form-group">
                                <label for="exampleInputName">Câu hỏi</label>
                                <input type="text" class="form-control" id="exampleInputName" name="title" required value="<?=$row['title']?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDesc">Câu trả lời: </label>
                                <textarea type="text" class="form-control" id="exampleInputDesc" name="answer"><?=$row['answer']?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right mt-3">Cập nhật câu hỏi</button>
                        </form>
                    </div>
                </div>
                <!-- form primary end -->
            </div>
        </div>
        <!-- main content area end -->
        <?php include("component/footer.php") ?>
    </div>
    <!-- page container area end -->
    <?php include("component/js.php") ?>
    <script>
        $('#exampleInputDesc').summernote({
            placeholder: 'Điền câu trả lời',
            tabsize: 2,
            height: 400
        });
    </script>
</body>
</html>