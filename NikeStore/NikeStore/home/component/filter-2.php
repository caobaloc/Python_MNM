<div class="filter-engine-2 d-flex justify-content-center">
    <p class="btn btn-filter btn-outline-pink mr-2"><b><i class="ti-filter mr-2"></i>Bộ lọc</b></p>
    <select class="p-2" onchange="document.getElementById('orderby').value = this.value; document.getElementById('filter-form').submit();">
        <option value="new" <?php if($orderBy=="new") echo"selected"; ?> >Mới nhất</option>
        <option value="old" <?php if($orderBy=="old") echo"selected"; ?> >Cũ nhất</option>
        <option value="price-asc" <?php if($orderBy=="price-asc") echo"selected"; ?> >Theo giá tăng dần</option>
        <option value="price-desc" <?php if($orderBy=="price-desc") echo"selected"; ?> >Theo giá giảm dần</option>
    </select>
</div>