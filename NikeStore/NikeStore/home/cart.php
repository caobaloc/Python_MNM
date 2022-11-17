<?php
    session_start();
    include("../connect.php");
    if(isset($_SESSION["UserName"])){
        $username = $_SESSION["UserName"];
        $sql = "select * from user where username ='$username'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $name = $row["name"];
        $address = $row["address"];
        $phone = $row["phone"];
        $point = $row["point"];
        if($row['active']==0)
            header("Location: ../login.php");
    }
    else{
        header("Location: ../login.php");
    }
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
        <div class="main-content container d-flex justify-content-center">
            <?php
                if(isset($_SESSION['Cart'])){
                    $cart = $_SESSION['Cart'];
                    $tongtien = 0;
            ?>
            <div class="cart-container table-responsive mt-5">
                <table class="table text-center">
                    <thead>
                        <tr class="align-center">
                            <td class="text-left"><div class="cart-checkbox ml-3">
                                <input type="checkbox" id="all-product-selected"><b class="ml-4">Sản phẩm</b>
                            </div></td>
                            <th scope="col">Đơn giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Số tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $key => $value) { 
                            $tongtien += ($value['soluong'] * $value['giagiam']);
                        ?>
                        <tr class="align-center">
                            <td class="text-left" style="width: 600px;"><div class="cart-checkbox ml-3">
                                <input type="checkbox" id="product<?=$key?>" class="product-selected" value="<?=$key?>">
                                <div class="product-cart d-flex align-items-center">
                                    <div class="product-cart-img">
                                        <img src="<?=$value['hinhanh']?>" width="150px">
                                    </div>
                                    <div class="product-cart-infor ml-3">
                                        <h5><?=$value['tenhang']?></h5>
                                        <p class="text-left mt-2">Size: <?=$value['tensize']?></p>
                                        <p class="mt-2">
                                            <a href="detail.php?seo=<?=$value['seo']?>">Xem chi tiết mặt hàng</a>
                                            <a class="ml-3 text-danger" href="huy.php?cart_id=<?=$key?>">Xoá</a>
                                        </p>
                                    </div>
                                </div>
                            </div></td>
                            <td>
                                <?php if( $value["dongia"] == $value["giagiam"]) {?>
                                    <h6 class="text-danger"><?=number_format($value['dongia'], 0, ',', '.')?> ₫</h6>
                                <?php } else {?>
                                    <h6 style="text-decoration: line-through;"><?=number_format($value['dongia'], 0, ',', '.')?> ₫</h6>
                                    <h6 class="text-danger"><?=number_format($value['giagiam'], 0, ',', '.')?> ₫</h6>
                                <?php } ?>
                            </td>
                            <td>
                                <form action="cart_update.php" method="GET" class="d-flex justify-content-center ">
                                    <p class="btn btn-quantity px-3" onclick="this.parentNode.querySelector('.cart-quantity').stepDown(); $(this).closest('form').submit();">
                                        <i class="fa fa-minus"></i>
                                    </p>
                                    <input type="hidden" name="id" value="<?=$key?>">
                                    <input name="quantity" class="cart-quantity" min="1" value="<?=$value['soluong']?>" max="<?=$value['soluongkho']?>"  type="number" class="form-control form-control-sm text-center" onchange="checkBeforeSubmit(this)"/>
                                    <p class="btn btn-quantity px-3" onclick="this.parentNode.querySelector('.cart-quantity').stepUp(); $(this).closest('form').submit(); ">
                                        <i class="fa fa-plus"></i>
                                    </p>
                                </form>
                            </td>
                            <td>
                                <h6 class="text-danger"><?=number_format( ($value['soluong'] * $value['giagiam']), 0, ',', '.') ?> ₫</h6>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr class="text-center">
                            <td colspan="2" class="text-left"><p class="ml-4"><a class="text-danger delete-selected" href="javascript:void(0)" onclick="removeSelectedCart();">Xoá sản phẩm đã chọn</a></p></td>
                            <td>                                
                                <h6 class="using-point">Điểm tích luỹ sử dụng:</h6>                                
                                <h6 class="my-3">Tổng tiền:</h6>
                            </td>
                            <td>
                                <h6 class="text-danger using-point"></h6>
                                <h6 class="text-danger my-3 tong"><?=number_format($tongtien, 0, ',', '.') ?> đ</h6>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <form action="xulydonhang.php" class="mt-5 ml-2" method="POST">
                <div class="customer-field p-3">
                    <div class="form-group">
                        <label for="exampleInputName"><h6>Họ và tên</h6></label>
                        <input type="text" class="form-control" id="exampleInputName" name="name" value="<?=$name?>" required> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPhone"><h6>Số điện thoại</h6></label>
                        <input type="text" class="form-control" id="exampleInputPhone" name="phone" value="<?=$phone?>" required> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputAddress"><h6>Địa chỉ</h6></label>
                        <textarea class="form-control" id="exampleInputAddress" name="address" rows="4" required><?=$address?></textarea>
                    </div>
                </div>
                <div class="payment-field p-3 mt-2">
                    <div class="form-group">
                        <label for="exampleInputPayment"><h6>Phương thức thanh toán</h6></label>
                        <select class="form-control pb-2" id="exampleInputPayment" name="payment">
                            <option value="1">Thanh toán bằng ví điện tử</option>
                            <option value="2">Thanh toán qua thẻ ngân hàng</option>
                            <option value="3">Thanh toán khi nhận hàng</option>
                        </select>
                        <label class = "mt-3" for="exampleInputPoint"><h6>Sử dụng điểm tích luỹ: <span class="text-danger"><?=number_format($point, 0, ',', '.')?></span> hiện có</h6></label>
                        <div class="d-flex">
                            <input type="number" class="form-control" id="exampleInputPoint" value="0" required>
                            <input type="hidden" name="point" id="point" value="0">
                            <button type="button" class="btn btn-point btn-pink ml-3">Áp dụng</button>
                        </div>
                        <div class="custom-control custom-checkbox mt-3">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Chấp thuận quy định về <b>Chính sách bảo mật</b> và <b>Điều khoản dịch vụ</b> của chúng tôi.</label>
                        </div>
                    </div>
                    <p id="error"></p>
                    <button type="button" class="btn btn-order btn-outline-pink mt-3 w-100">Đặt hàng</button>
                </div>
            </form>
            <?php } else { ?>
                <div class="d-flex justify-content-center ">
                    <div class="m-5 p-5">
                        <img src="../assets/images/icon/empty-cart.png">
                        <h4 class="text-center">Bạn chưa có đơn hàng nào</h4>
                        <p class="text-center mt-3"><a href="../home"><button class="btn btn-outline-pink">Mua ngay</button> </a></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php include("component/footer.php"); ?>
<!-- main wrapper start -->
<!-- main wrapper end -->
<?php include("component/js.php") ?>
</body>
<script>
    $("#all-product-selected").on('change',function(){
        $(".cart-container .table input[type=checkbox]").prop('checked', this.checked);
    });
    $(".cart-container .table input[type=checkbox]").on('change load',function(){
        if($(".cart-container .table .product-selected:checked").length == 0)
            $('.cart-container .table tfoot .delete-selected').css('display','none');
        else
            $('.cart-container .table tfoot .delete-selected').css('display','table-footer-group');
    });
    $(".cart-container .table .product-selected").on('change load',function(){
        if($(".cart-container .table .product-selected:checked").length == $(".cart-container .table .product-selected").length)
            $("#all-product-selected").prop('checked', this.checked);
        else
            $("#all-product-selected").prop('checked', false);
    });

    $(".btn-point").on('click',function(){
        let a = parseInt($('#exampleInputPoint').val());
        if(a != 0 && $("#exampleInputPoint").val() <= <?=$tongtien?> ){
            if( parseInt($("#exampleInputPoint").val()) > <?=$point?>){
                $('.using-point.text-danger').text(0);
                $("#error").text("Bạn đang chọn vượt số điểm tích luỹ mà bạn hiện đang có");
                $("#error").css("color","red");
            }
            else if( parseInt($("#exampleInputPoint").val()) < 0  ){
                $('.using-point.text-danger').text(0);
                $("#exampleInputPoint").val(0);
                $("#point").val(0);
                $("#error").text("Số điểm tích luỹ không hợp lệ");
                $("#error").css("color","red");
            }
            else{
                $("#error").text("Áp dụng thành công");
                $("#error").css("color","green");
                $('#point').val(a);
                $('.using-point').css("display","block");
                $('.using-point.text-danger').text(formatNumber(parseInt(a), 0, ',', '.'));
                let tong = parseInt(<?=$tongtien?>)-parseInt(a)
                $('.tong.text-danger').text(formatNumber(tong, 0, ',', '.') + "₫");
            }
        }else if( parseInt($("#exampleInputPoint").val()) > <?=$tongtien?>){
            $("#error").text("Bạn đang chọn vượt số điểm tích luỹ nhiều hơn tổng tiền");
            $("#error").css("color","red");
        }     
    });

    $('#exampleInputPoint').keyup(function(){
        if( parseInt($(this).val()) > <?=$point?> )
            $(this).css("color","red");
        else
        $(this).css("color","black");
    });

    function removeSelectedCart(){
        Swal.fire({
            title: 'Bạn chắc chắn muốn xoá?',
            text: "Bạn sẽ không thể hoàn tác lại điều này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Xoá',
            cancelButtonText: 'Huỷ'
        }).then((result) => {
            if (result.isConfirmed) {
                var cartRemoveList = [];
                $(".cart-container .table .product-selected:checked").each(function(){
                    if($(this).prop("checked") == true)
                    cartRemoveList.push($(this).val());
                    else{
                        var removeItem = $(this).val();
                        cartRemoveList = $.grep(cartRemoveList, function(value) {
                            return value != removeItem;
                        });
                }
                });
                var removeurl = "huy.php?do=huy";
                cartRemoveList.forEach(function(item){
                    removeurl = removeurl + "&cart_ids%5B%5D=" + item;
                });
                location.href = removeurl;
            }
            else{

            }
        })
    }
    function checkBeforeSubmit(a){
        x = parseInt(a.value);
        y = parseInt(a.max);
        if(x <= 0)
            a.value = 1;
        else if(x > y){
            a.value = y;
        }
        else{
            a.closest('form').submit();
        }
    }
    function checkBeforeOrder(a){
        if(a.checked == true)
            $('.btn-order').prop("disabled", false);
        else{
            $('.btn-order').prop("disabled", true);
        }
    }
    $(".btn-order").on('click',function () {
        if($('#customCheck1').is(':checked')==true){
            if($("#exampleInputName").val() == "" || $("#exampleInputPhone").val() == "" || $("#exampleInputAddress").val() == ""){
                $("#error").text("Vui lòng điền đầy đủ thông tin");
                $("#error").css("color","red");
            }
            else{
                Swal.fire({
                    title: 'Xác nhận đặt hàng?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#00b815',
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Huỷ'
                }).then((result) => {
                    if(result.isConfirmed)
                        $(this).closest('form').submit();
                })
            }
        }
        else{
            $("#error").text("Vui lòng chấp nhận điều khoản và chính sách của chúng tôi");
            $("#error").css("color","red");
        }
    });
</script>
</html>