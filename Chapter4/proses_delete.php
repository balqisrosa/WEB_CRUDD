<?php
include 'db.php';

if(isset($_GET['idc'])){
    $delete = mysqli_query($conn, "DELETE FROM tb_category WHERE category_id = '".$_GET['idc']."' ");
    echo '<script>window.location="category.php"</script>';
}

if(isset($_GET['idp'])){
    $product = mysqli_query($conn, "SELECT product_image FROM tb_product WHERE product_id ='".$_GET['idp']."' ");
    $p = mysqli_fetch_object($product);

    unlink('./produk/' .$p->product_image);
    $delete = mysqli_query($conn, "DELETE FROM tb_product WHERE product_id = '".$_GET['idp']."' ");
    echo '<script>window.location="data_product.php"</script>';
}
?>