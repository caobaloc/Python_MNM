<div class="flex">
    <div class="card-body">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
            <?php if($current_page > 3) { ?>
            <li class="page-item <?php if($current_page==1) echo'disabled' ?>"><a class="page-link" href="?page=1">Trang đầu</a></li>
            <?php } ?>
                <?php for( $i = 1; $i <= $totalpage; $i++){ ?>
                    <?php if($i != $current_page) { ?>
                        <?php if($i > $current_page - 3 && $i < $current_page + 3) { ?>
                            <li class="page-item"><a class="page-link" href="?page=<?=$i?>"><?=$i?></a></li>
                        <?php } ?>
                    <?php } else { ?>
                        <li class="page-item active"><a class="page-link" href="javascript:void(0)"><?=$i?></a></li>
                    <?php } ?>
                <?php } ?>
            <?php if($current_page < $totalpage - 3) { ?>
            <li class="page-item <?php if($current_page==$totalpage) echo'disabled' ?>"><a class="page-link" href="?page=<?=$totalpage?>">Trang cuối</a></li>
            <?php } ?>
            </ul>
        </nav>
    </div>
</div>
