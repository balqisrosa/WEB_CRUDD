<?php
  session_start();
  include 'db.php';
  if($_SESSION['status_login'] != true){
    echo '<script>window.location="login.php"</script>';
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bara Store</title>
    <link rel="stylesheet" type="text/css" href="Css/style.css">
<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>
    <!-- header -->
    <header>
        <div class="container">
        <h1><a href="dashboard.php">BaRa Store</a></h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="category.php">Category</a></li>
            <li><a href="data_product.php">Product</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        </div>
    </header>

    <!-- content -->
    <div class="section">
        <div class="container">
            <h3>Produk</h3>
            <div class="box">
                <p><a href="tambah_product.php">Tambah Data</a></p>
            <table border="1" cellspacing="0" class="table">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Category</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $product = mysqli_query($conn, "SELECT * FROM tb_product LEFT JOIN tb_category USING (category_id)ORDER BY product_id DESC");
                        if(mysqli_num_rows($product) > 0){
                        while($row = mysqli_fetch_array($product)){
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row ['category_name']?></td>
                            <td><?php echo $row ['product_name']?></td>
                            <td>Rp. <?php echo number_format($row ['product_price'])?></td>
                            <td><a href="produk/<?php echo $row['product_image'] ?>" target="_blank"><img src="produk/<?php echo $row['product_image']?>" width="50px"></a></td>
                            <td><?php echo ($row ['product_status'] == 0)? 'Tidak Aktif':'Aktif';?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $row ['product_id']?>">Edit</a> || <a href="proses_delete.php?idp=<?php echo $row['product_id']?>" onclick="return confirm('Yakin ingin hapus ?')">Delete</a>
                            </td>
                        </tr>
                        <?php }}else{ ?>
                            <tr>
                                <td colspan="7">Tidak ada data</td>
                            </tr>

                            <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2022 = BaRa Store.</small>
        </div>
    </footer>
</body>
</html>