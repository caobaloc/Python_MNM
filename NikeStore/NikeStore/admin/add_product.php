<?php
    session_start();
    include("../connect.php");
    include("component/permission.php");
    if($_SESSION['Permission']==4 || $_SESSION['Permission']==5){
        header("Location: 505.php");
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
                            <h4 class="page-title pull-left"><b>Thêm Sản Phẩm</b></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><a href="manage_product.php">Quản lý sản phẩm</a></li>
                                <li><span>Thêm sản phẩm</span></li>
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
                        <form action="add_product_engine.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-xl-9 col-lg-8 col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputName">Tên sản phẩm</label>
                                        <input type="text" class="form-control" id="exampleInputName" name="name" required> 
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputSubCategory">Loại sản phẩm</label>
                                        <select class="form-control pb-2" id="exampleInputSubCategory" name="sub_category">
                                            <?php
                                                $sql = "SELECT * FROM sub_category";
                                                $result = mysqli_query($con, $sql);
                                                while($row = mysqli_fetch_assoc($result)){
                                            ?>
                                                <option value="<?=$row["ID"]?>"><?=$row["name"]?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPrice">Đơn giá</label>
                                        <input type="number" class="form-control" id="exampleInputPrice" name="price" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPrice2">Sale</label>
                                        <input type="number" class="form-control" id="exampleInputPrice2" name="price_sale" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 d-flex justify-content-center align-items-center">
                                    <div class="image-preview mt-2 ">
                                        <img id="previewImg" src=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh đại diện</label>
                                <input type="file" class="filestyle" id="image" name="image" required accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh" data-btnClass="btn-primary" data-placeholder="Chưa có hình ảnh">
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh Preview</label>
                                <input type="file" class="filestyle" id="images" name="images[]" required accept="image/png, image/gif, image/jpeg" data-text="Chọn ảnh" data-btnClass="btn-primary" data-placeholder="Chưa có hình ảnh" multiple>
                            </div>
                            <div class="row mt-2 mx-2" style="height: 200px;" id="previewImgs"></div>
                            <div class="form-group">
                                <label for="exampleInputDesc">Mô tả: </label>
                                <textarea id="exampleInputDesc" name="desc"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right mt-3 btn-product" disabled>Nhập sản phẩm</button>
                        </form>
                        <p id="error" class="text-danger" style="display: none;">Giá sale phải nhỏ hơn giá gốc</p>
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
            placeholder: 'Điền mô tả',
            tabsize: 2,
            height: 400
        });
    </script>
</body>
</html>