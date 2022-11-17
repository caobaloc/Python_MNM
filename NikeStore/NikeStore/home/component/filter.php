<div class="col-md-4 col-xl-2 col-lg-3 m-3 filter-engine">
    <form action="?" method="GET" id="filter-form" onchange="this.submit()">
        <?php if(isset($_GET['seo'])) { ?>
            <input type="hidden" name="seo" value="<?=$_GET['seo']?>"/>
        <?php } ?>
        <div id="price-filter-form" class="m-3" ><b>Lọc theo giá sản phẩm</b>
            <?php
                $priceRange = "all";
                if(isset($_GET['pricerange'])){
                    $priceRange = $_GET['pricerange'];
                    switch ($priceRange) {
                        case '0-1000':
                            $sqlmain = $sqlmain. "AND product.price_sale > 0 AND product.price_sale <= 1000000 ";
                            break;
                        case '1000-3000':
                            $sqlmain = $sqlmain. "AND  product.price_sale > 1000000 AND product.price_sale <= 3000000 ";
                            break;
                        case '3000-5000':
                            $sqlmain = $sqlmain. "AND  product.price_sale > 3000000 AND product.price_sale <= 5000000 ";
                            break;
                        case '5000-10000':
                            $sqlmain = $sqlmain. "AND  product.price_sale > 5000000 AND product.price_sale <= 10000000 ";
                            break;
                        case '10000-400000':
                            $sqlmain = $sqlmain. "AND  product.price_sale > 10000000 AND product.price_sale <= 400000000 ";
                            break;
                        default:
                            $sqlmain = $sqlmain;
                            break;
                    }
                }
            ?>
            <div class="custom-control custom-radio mt-3 mb-4">
                <input type="radio" <?php if($priceRange=="all") echo"checked"?> id="priceRadio" name="pricerange" class="custom-control-input" value="all">
                <label class="custom-control-label" for="priceRadio">Tất cả các đơn giá</label>
            </div>
            <div class="custom-control custom-radio mt-3 mb-4">
                <input type="radio" <?php if($priceRange=="0-1000") echo"checked"?> id="priceRadio1" name="pricerange" class="custom-control-input" value="0-1000">
                <label class="custom-control-label" for="priceRadio1">0đ - 1.000.000đ</label>
            </div>
            <div class="custom-control custom-radio mt-3 mb-4">
                <input type="radio" <?php if($priceRange=="1000-3000") echo"checked"?> id="priceRadio2" name="pricerange" class="custom-control-input" value="1000-3000">
                <label class="custom-control-label" for="priceRadio2">1.000.000đ - 3.000.000đ</label>
            </div>
            <div class="custom-control custom-radio mt-3 mb-4">
                <input type="radio" <?php if($priceRange=="3000-5000") echo"checked"?> id="priceRadio3" name="pricerange" class="custom-control-input" value="3000-5000">
                <label class="custom-control-label" for="priceRadio3">3.000.000đ - 5.000.000đ</label>
            </div>
            <div class="custom-control custom-radio mt-3 mb-4">
                <input type="radio" <?php if($priceRange=="5000-10000") echo"checked"?> id="priceRadio4" name="pricerange" class="custom-control-input" value="5000-10000">
                <label class="custom-control-label" for="priceRadio4">5.000.000đ - 10.000.000đ</label>
            </div>
            <div class="custom-control custom-radio mt-3 mb-4">
                <input type="radio" <?php if($priceRange=="10000-400000") echo"checked"?> id="priceRadio5" name="pricerange" class="custom-control-input" value="10000-400000">
                <label class="custom-control-label" for="priceRadio5">10.000.000đ - 400.000.000đ</label>
            </div>
        </div>
        <div id="size-filter-form" class="m-3 trigger-size <?php if(isset($_GET['size-filter'])) echo"expanded" ?> "><b>Lọc theo kích thước</b>
            <?php
                $sql = "SELECT name FROM size";
                $rs = mysqli_query($con,$sql);
                $count = 0;
                if(isset($_GET['size-filter'])){
                    $sizeFilter = $_GET['size-filter'];
                    $sqlmain = $sqlmain."AND ( 0 ";
                }
                while($r = mysqli_fetch_assoc($rs)){
                    $count++;
            ?>
            <div class="custom-control custom-checkbox mt-3 mb-4 ml-2">
                <input type="checkbox" class="custom-control-input" name="size-filter[]" id="sizeCheck<?=$count?>" value="<?=$r['name']?>"
                    <?php 
                        if(isset($_GET['size-filter'])){
                            foreach ($sizeFilter as $sizeChecked) {
                                if($sizeChecked == $r['name']){
                                    echo"checked";
                                    $sqlmain = $sqlmain."OR size.name = '".$r['name']."' ";
                                    break;
                                }
                            }
                        }
                    ?>>
                <label class="custom-control-label" for="sizeCheck<?=$count?>"><?=$r['name']?><span></span></label>
            </div>
            <?php } 
                if(isset($_GET['size-filter'])){
                    $sqlmain = $sqlmain.") ";
                }
            ?>
            <div class="btn-trigger-size text-center">
                <p class="btn btn-outline-dark"><?php if(isset($_GET['size-filter'])) echo"Thu gọn"; else echo"Xem thêm"; ?></p>
            </div>
        </div>
        <div id="sale-filter-form" class="m-3 trigger-size"><b>Đang khuyến mãi</b>
            <?php
                if(isset($_GET['sale-filter'])){
                    $sqlmain = $sqlmain. " AND product.price > product.price_sale ";
                }
            ?>
            <div class="custom-control custom-checkbox mt-3 mb-4 ml-2">
                <input type="checkbox" class="custom-control-input" id="saleCheck" value="sale" name="sale-filter" <?php  if(isset($_GET['sale-filter'])) echo'checked'; ?>>
                <label class="custom-control-label" for="saleCheck">On Sale 🔥</label>
            </div>
        </div>
        <div id="order-filter-form">
            <?php
                $orderBy = "new";
                if(isset($_GET['orderby'])){
                    $orderBy = $_GET['orderby'];                                    
                }
                switch ($orderBy) {
                    case "old":
                        $sqlmain = $sqlmain."ORDER BY product.ID ASC";
                        break;
                    case "price-asc":
                        $sqlmain = $sqlmain."ORDER BY product.price_sale ASC";
                        break;
                    case "price-desc":
                        $sqlmain = $sqlmain."ORDER BY product.price_sale DESC";
                        break;
                    default:
                        $sqlmain = $sqlmain."ORDER BY product.ID DESC";
                        break;
                }
            ?>
            <input type="hidden" id="orderby" name="orderby" value="<?=$orderBy?>">
        </div>
    </form>
</div>