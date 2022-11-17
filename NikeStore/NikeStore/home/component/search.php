<div class="search-box">
    <form action="?" method="GET" onchange="this.submit();">
        <?php
            if(isset($_GET['search'])){
                $search = $_GET['search'];
                $search = url_slug($search);
                $sqlmain = $sqlmain. "AND product.seo LIKE '%$search%' ";
            }else{
                $search = "";
            }
        ?>
        <input type="text" name="search" placeholder="Tìm kiếm sản phẩm ...">
        <i class="ti-search" onclick="this.closest('form').submit();" style="cursor: pointer;"></i>
    </form>
</div>