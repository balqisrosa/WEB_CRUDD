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
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
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
            <h3>Tambah Data Product</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select class="input-control" name="category" required>
                        <option value="">..Pilih..</option>
                        <?php
                        $category = mysqli_query($conn, "SELECT *FROM tb_category ORDER BY category_id DESC ");
                        while($r = mysqli_fetch_array($category)){
                        ?>
                        <option value="<?php echo $r['category_id']?>"><?php echo $r['category_name']?></option>
                        <?php } ?>
                    </select>

                    <input type="text" name="nama" class="input-control" placeholder="Name Product" required>
                    <input type="text" name="harga" class="input-control" placeholder="Price" required>
                    <input type="file" name="gambar" class="input-control" required>
                    <textarea class="input-control" name="description" placeholder="Description"></textarea><br>
                    <select class="input-control" name="status">
                        <option value="">..Pilih..</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php 
                if(isset($_POST['submit'])){

                // print_r($_FILES['gambar']);
                // menampung inputan dari form
                $category       = $_POST['category'];
                $nama           = $_POST['nama'];
                $harga          = $_POST['harga'];
                $description    = $_POST['description'];
                $status       = $_POST['status'];

                // menampung data file yang diupload
                $filename = $_FILES['gambar']['name'];
                $tmp_name = $_FILES['gambar']['tmp_name'];

                $type1 = explode('.', $filename);
                $type2 = $type1[1];

                $newname = 'produk'.time().'.'.$type2;

                //menampung data format file yang diizinkan
                $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'jfif', 'gif');

                // validasi format file
                if(!in_array($type2, $tipe_diizinkan)){
                    // jika format file tidak ada di dalam tipe diizinkan
                    echo '<script>alert("Format file tidak diizinkan")</script>';
                }else{
                    // jika format file sesuai dengan yang ada di dalam array tipe diizinkan
                    // proses upload file sekaligus insert ke database
                    move_uploaded_file($tmp_name, './produk/'.$newname);

                    $insert = mysqli_query($conn, "INSERT INTO tb_product VALUES (
                        null,
                        '".$category."',
                        '".$nama."',
                        '".$harga."',
                        '".$description."',
                        '".$newname."',
                        '".$status."',
                        null
                        )");

                        if($insert){
                            echo '<script>alert("Tambah data berhasil")</script>';
                            echo '<script>window.location="data_product.php"</script>';
                        }else{
                            echo 'gagal'.mysqli_error($conn);
                        }
                }

                
                }
                ?>
            </div>          
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2022 = BaRa Store.</small>
        </div>
    </footer>
    <script>
     CKEDITOR.replace( 'description' );
    </script>
</body>
</html>