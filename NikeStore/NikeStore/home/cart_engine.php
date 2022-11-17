<div></div>
<?php
    session_start();
    include("../connect.php");
    include("component/css.php");
    include("component/js.php");

    if(!isset($_SESSION["UserName"])){
        header("Location: ../login.php");
    }
    else{

        $username = $_SESSION["UserName"];
        $sql = "select * from user where username ='$username'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row['active']==0)
            header("Location: ../login.php");

        $id = $_POST['id'];
        $product = $_POST['product'];
        $size = $_POST['size'];
        $sql = "SELECT name FROM size WHERE id='$size'";
        $size_name = mysqli_query($con,$sql);
        $size_name = mysqli_fetch_assoc($size_name);
        $size_name = $size_name['name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $sale= $_POST['sale'];
        $image = $_POST['image'];
        $seo = $_POST['seo'];
        $storage_quantity = $_POST['storage_quantity'];
        
        $flag = false;
        if(isset($_SESSION['Cart'])){
            $cart = $_SESSION['Cart'];
            foreach ($cart as $key => $value) {
                if($value['mahang'] == $id && $value['masize'] == $size){
                    $cart[$key]['soluong'] =  $value['soluong'] + $quantity;
                    $flag = true;
                    break;
                }
            }
            if($flag==false){
                $count = array_key_last($cart) + 1;
                $cart[$count] = array("mahang"=>$id,"tenhang"=>$product,"masize"=>$size,"tensize"=>$size_name,"soluong"=>$quantity,"soluongkho"=>$storage_quantity,"dongia"=>$price,"giagiam"=>$sale,"hinhanh"=>$image,"seo"=>$seo);
            }
        }
        else{
            $cart = [];
            $count = 1;
            $cart[$count] = array("mahang"=>$id,"tenhang"=>$product,"masize"=>$size,"tensize"=>$size_name,"soluong"=>$quantity,"soluongkho"=>$storage_quantity,"dongia"=>$price,"giagiam"=>$sale,"hinhanh"=>$image,"seo"=>$seo);
        }
        
        //Cập nhật lại session
        $_SESSION['Cart'] = $cart;

        if(isset($_GET['seo'])){
            $seoback = $_GET['seo'];
?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Đã thêm vào giỏ hàng!'
        }).then((result) => {
            history.go(-1);
        })
    </script>
<?php
        }
        else
            header("Location: cart.php");
    }
?>
    

    