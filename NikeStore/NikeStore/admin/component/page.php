<?php
    $current_page = !empty($_GET["page"])?$_GET["page"]:1;
    $offset = ($current_page - 1)*5;
?>