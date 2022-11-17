<?php 
    $filenamearr = explode("/",$_SERVER['PHP_SELF']);
    $filename = array_pop($filenamearr);
?>
<div class="header-area">
    <div class="row align-items-center">
        <!-- nav and search button -->
        <div class="col-md-6 col-sm-8 clearfix">
            <div class="nav-btn pull-left">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="search-box pull-left">
                <?php
                    if(isset($_GET['search'])){
                        $key = $_GET['search'];
                        $key = url_slug($key);
                        if($filename=="manage_product.php"){
                            $sql = "SELECT product.id as id, image, sub_category.name as loaisp, product.name as tensp, price, product.desc as mota 
                            FROM product INNER JOIN sub_category ON product.sub_category_id = sub_category.id 
                            WHERE product.seo LIKE '%$key%'
                            ORDER BY product.id  DESC LIMIT 5 OFFSET $offset  ";
                            $result = mysqli_query($con, $sql);
                        }
                        if($filename=="manage_category.php"){
                            $sql = "SELECT category.id as id, category.name as ten, category.desc as mota FROM category
                            WHERE category.seo LIKE '%$key%'
                            ORDER BY category.id DESC LIMIT 5 OFFSET $offset";
                            $result = mysqli_query($con, $sql);
                        }
                        if($filename=="manage_sub_category.php"){
                            $sql = "SELECT sub_category.id as id , category.name as dongsp, sub_category.name as loaisp, sub_category.desc as mota 
                            FROM sub_category INNER JOIN category ON sub_category.category_id = category.id
                            WHERE sub_category.seo LIKE '%$key%'
                            ORDER BY sub_category.id DESC LIMIT 5 OFFSET $offset";
                            $result = mysqli_query($con, $sql);
                        }
                        if($filename=="manage_size.php"){
                            $sql =  "SELECT * FROM size 
                            WHERE size.name = '$key'
                            ORDER BY ID DESC LIMIT 5 OFFSET $offset";
                            $result = mysqli_query($con, $sql);
                        }
                        if($filename=="manage_storage.php"){
                            $sql =  "SELECT quantity, product.name as tensp, size.name as kichco, product_id, size_id
                                    FROM storage INNER JOIN product ON product.id = storage.product_id INNER JOIN size ON size.id = storage.size_id
                                    WHERE product.seo LIKE '%$key%'
                                    ORDER BY quantity DESC LIMIT 5 OFFSET $offset";
                            $result = mysqli_query($con, $sql);
                        }
                        if($filename=="index.php"){
                            $sql="SELECT ordered.id as id, user.name as ten, ordered.order_date as ngaydat, status, user.address as diachi
                                FROM ordered INNER JOIN user ON ordered.user_id = user.ID 
                                WHERE user.seo LIKE '%$key%'
                                ORDER BY ordered.id DESC LIMIT 5 OFFSET $offset";
                            $result=mysqli_query($con,$sql);
                        }
                        if($filename=="manage_user.php"){
                            $sql = "SELECT user.id as id, user.name as hoten ,email,phone,address,username,role.name as quyen,role.id as quyen_id 
                                    FROM user INNER JOIN role ON user.role_id = role.id 
                                    WHERE user.seo LIKE '%$key%'
                                    ORDER BY user.id  DESC LIMIT 5 OFFSET $offset";
                            $result = mysqli_query($con,$sql);
                        }
                    }
                ?>
                <form action="<?=$filename?>" id="form">
                    <input type="text" name="search" placeholder="Tìm kiếm ..." onchange="searchengine();">
                    <i class="ti-search"></i>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function searchengine(){
        document.getElementById("form").submit();
    }
</script>