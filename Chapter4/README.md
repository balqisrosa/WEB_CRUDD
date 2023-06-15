# Langkah Keempat
1. Buat folder untuk CSS, img, dan produk
2. Source code aplikasi

## Source Code db.php
```Php
<?php
  $hostname = 'localhost';
  $username = 'root';
  $password = '';
  $dbname   = 'db_jualan';

  $conn = mysqli_connect($hostname, $username, $password, $dbname) or die ('Gagal terhubung ke database')
?>
```

## Source Code login.php
```Php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onlineshop</title>
    <link rel="stylesheet" type="text/css" href="Css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body id="bg-login">
    <div class="box-Login">
        <h2>Login</h2>
        <form action="" method="POST">
            <input type="text" name="user" placeholder="Username" class="input-control">
            <input type="password" name="pass" placeholder="Password" class="input-control">
            <input type="submit" name="submit" value="Login" class="btn">
        </form>
        <?php
          if(isset($_POST['submit'])){
            session_start();
            include 'db.php';

            $user = mysqli_real_escape_string($conn, $_POST['user']);
            $pass = mysqli_real_escape_string($conn,$_POST['pass']);

            $cek = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '".$user."' AND password = '".MD5($pass)."'");
            if(mysqli_num_rows($cek) > 0){
                $d = mysqli_fetch_object($cek);
                $_SESSION['status_login'] = true;
                $_SESSION['a_global'] = $d;
                $_SESSION['id'] = $d-> admin_id;
                echo '<script>window.location="dashboard.php"</script>';
            }else{
                echo '<script>alert("Username atau password Anda salah!")</script>';
            }
          }
        ?>
    </div>
</body>
</html>
```

## Source Code dashboard.php
```Php
<?php
  session_start();
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
            <li><a href="index.php">Dashboard</a></li>
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
            <h3>Dashboard</h3>
            <div class="box">
                <h4>Selamat Datang <?php echo $_SESSION['a_global'] -> admin_name ?> di Store Second Thrifting</h4>
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
```

## Source Code profil.php
```Php
<?php
  session_start();
  include 'db.php';
  if($_SESSION['status_login'] != true){
    echo '<script>window.location="login.php"</script>';
  }

  $query = mysqli_query($conn,"SELECT * FROM tb_admin WHERE admin_id = '".$_SESSION['id']."'");
  $d = mysqli_fetch_object($query);
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
            <h3>Profil</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control" value="<?php echo $d -> admin_name ?>" requird>
                    <input type="text" name="user" placeholder="Username" class="input-control" value="<?php echo $d -> username ?>" requird>
                    <input type="text" name="hp" placeholder="No Hp" class="input-control" value="<?php echo $d -> admin_telp ?>" requird>
                    <input type="email" name="email" placeholder="Email" class="input-control" value="<?php echo $d -> admin_email ?>" requird>
                    <input type="text" name="alamat" placeholder="Alamat" class="input-control" value="<?php echo $d -> admin_address ?>" requird>
                    <input type="submit" name="submit" value="Ubah Profile" class="btn">
                </form>
                <?php
                  if(isset($_POST['submit'])){

                    $nama   = ucwords($_POST['nama']);
                    $user   = $_POST['user'];
                    $hp     = $_POST['hp'];
                    $email  = $_POST['email'];
                    $alamat = ucwords($_POST['alamat']);

                    $update = mysqli_query($conn, "UPDATE tb_admin SET
                                   admin_name = '".$nama."',
                                   username = '".$user."',
                                   admin_telp = '".$hp."',
                                   admin_email = '".$email."',
                                   admin_address = '".$alamat."'
                                   WHERE admin_id = '".$d -> admin_id."' ");
                    if($update){
                        echo '<script>alert("Ubah data berhasil")</script>';
                        echo '<script>window.location="profil.php"</script>';
                    }else 'gagal'.mysqli_error($conn);
                  } 
                ?>
            </div>

            <h3>Ubah Password</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="password" name="pass1" placeholder="Password Baru" class="input-control" requird>
                    <input type="password" name="pass2" placeholder="Konfirmasi Password Baru" class="input-control" requird>
                    <input type="submit" name="ubah_password" value="Ubah Password" class="btn">
                </form>
                <?php
                  if(isset($_POST['ubah_password'])){

                    $pass1   = $_POST['pass1'];
                    $pass2   = $_POST['pass2'];

                    if($pass2 != $pass1){
                        echo '<script>alert("Konfirmasi Password Baru tidak sesuai")</script>';
                    }else{

                        $u_pass = mysqli_query($conn, "UPDATE tb_admin SET 
                        password = '".MD5($pass1)."'
                        WHERE admin_id = '".$d ->admin_id."' ");
                        if($u_pass){
                            echo '<script>alert("Ubah data berhasil")</script>';
                            echo '<script>window.location.href="profil.php</script>';
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
</body>
</html>
```

## Source Code category.php
```Php
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
            <h3>Category</h3>
            <div class="box">
                <p><a href="tambah_category.php">Tambah Data</a></p>
            <table border="1" cellspacing="0" class="table">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Category</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $category = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                        if(mysqli_num_rows($category) > 0){
                        while($row = mysqli_fetch_array($category)){
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row ['category_name']?></td>
                            <td>
                                <a href="edit_category.php?id=<?php echo $row ['category_id']?>">Edit</a> || <a href="proses_delete.php?idc=<?php echo $row['category_id']?>" onclick="return confirm('Yakin ingin hapus ?')">Delete</a>
                            </td>
                        </tr>
                        <?php }}else{ ?>
                            <tr>
                                <td colspan="3">Tidak ada data</td>
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
```

## Source Code edit_category.php
```Php
<?php
  session_start();
  include 'db.php';
  if($_SESSION['status_login'] != true){
    echo '<script>window.location="login.php"</script>';
  }

  $category = mysqli_query($conn, "SELECT *FROM tb_category WHERE category_id = '".$_GET['id']."' ");
  if(mysqli_num_rows($category) == 0 ){
    echo '<script>window.location="category.php"</script>';
  }
  $k = mysqli_fetch_object($category);
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
            <h3>Edit Data Category</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Nama Category" class="input-control" value="<?php echo $k -> category_name?>" requird>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php 
                if(isset($_POST['submit'])){

                    $nama = ucwords($_POST['nama']);

                    $update = mysqli_query($conn, "UPDATE tb_category SET
                    category_name = '".$nama."' WHERE category_id = '".$k->category_id."'  ");

                        if($update){
                            echo '<script>alert("Edit data berhasil")</script>';
                            echo '<script>window.location="category.php"</script>';
                        }else{
                            echo 'gagal' .mysqli_error($conn);
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
</body>
</html>
```

## Source Code tambah_category.php
```Php
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
            <h3>Tambah Data Category</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Nama Category" class="input-control" requird>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php 
                if(isset($_POST['submit'])){

                    $nama = ucwords($_POST['nama']);

                    $insert = mysqli_query($conn, "INSERT INTO tb_category VALUES (
                        null,
                        '".$nama."') ");
                        if($insert){
                            echo '<script>alert("Tambah data berhasil")</script>';
                            echo '<script>window.location="category.php"</script>';
                        }else{
                            echo 'gagal' .mysqli_error($conn);
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
</body>
</html>
```

## Source Code produk.php
```Php
<?php
error_reporting(0);
  include 'db.php';
  $contact = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 1");
  $a = mysqli_fetch_object($contact);
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
        <h1><a href="index.php">BaRa Store</a></h1>
        <ul>
            <li><a href="produk.php">Produk</a></li>
            <li><a href="login.php">Login</a></li>
        </div>
    </header>

    <!-- search -->
    <div class="search">
        <div class="container">
            <form action="produk.php">
                <input type="text" name="search" placeholder="Cari-Produk" value="<?php echo $_GET['search'] ?>">
                <input type="hidden" name="kat" value="<?php echo $_GET['kat'] ?>">
                <input type="submit" name="cari" value="Cari Produk">
            </form>
        </div>
    </div>


    <!-- new product -->
    <div class="section">
        <div class="container">
            <h3>Produk</h3>
            <div class="box">
                <?php
                if($_GET['search'] != '' || $_GET['kat'] != ''){
                    $where = "AND product_name LIKE '%".$_GET['search']."%' AND category_id LIKE '%".$_GET['kat']."%' ";
                }
                $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 $where ORDER BY product_id DESC ");
                if(mysqli_num_rows($produk) >0){
                    while($p = mysqli_fetch_array($produk)){
                ?>
                <a href="detail_product.php?id=<?php echo $p['product_id'] ?> ">
                <div class="col-4 gambar">
                    <img src="produk/<?php echo $p['product_image'] ?> ">
                    <p class="nama"><?php echo substr($p['product_name'], 0, 30) ?> </p>
                    <p class="harga">Rp. <?php echo number_format($p['product_price']) ?> </p>
                </div>
                </a>
                <?php }}else{ ?>
                    <p>Produk tidak ada</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="footer">
        <div class="container">
            <h4>Alamat</h4>
            <p><?php echo $a->admin_address ?></p>

            <h4>Email</h4>
            <p><?php echo $a->admin_email ?></p>

            <h4>No. Hp</h4>
            <p><?php echo $a->admin_telp ?></p>
        <small>Copyright &copy; 2022 = BaRa Store.</small>
        </div>
    </div>
</body>
</html>
```

## Source Code product.php
```Php
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
            <li><a href="product.php">Product</a></li>
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
                            <th>Description</th>
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
                            <td><?php echo $row ['product_description']?></td>
                            <td><img src="produk/<?php echo $row['product_image']?>" width="50px"></td>
                            <td><?php echo ($row ['product_status'] == 0)? 'Tidak Aktif':'Aktif';?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $row ['product_id']?>">Edit</a> || <a href="proses_delete.php?idp=<?php echo $row['product_id']?>" onclick="return confirm('Yakin ingin hapus ?')">Delete</a>
                            </td>
                        </tr>
                        <?php }}else{ ?>
                            <tr>
                                <td colspan="8">Tidak ada data</td>
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
```

## Source Code edit_product.php
```Php
<?php
  session_start();
  include 'db.php';
  if($_SESSION['status_login'] != true){
    echo '<script>window.location="login.php"</script>';
  }
  $product = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '".$_GET['id']."'");
  if(mysqli_num_rows($product) == 0){
    echo '<script>window.location="data_product.php"</script>';
  }
  $p = mysqli_fetch_object($product);
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
            <h3>Edit Data Product</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select class="input-control" name="category" required>
                        <option value="">..Pilih..</option>
                        <?php
                        $category = mysqli_query($conn, "SELECT *FROM tb_category ORDER BY category_id DESC ");
                        while($r = mysqli_fetch_array($category)){
                        ?>
                        <option value="<?php echo $r['category_id']?>"<?php echo ($r['category_id'] == $p->category_id)? 'selected' :'';?>><?php echo $r['category_name']?></option>
                        <?php } ?>
                    </select>

                    <input type="text" name="nama" class="input-control" placeholder="Name Product" value="<?php echo $p->product_name?>" required>
                    <input type="text" name="harga" class="input-control" placeholder="Price" value="<?php echo $p->product_price?>" required>
                    
                    <img src="produk/<?php echo $p->product_image?>" width = "100px">
                    <input type="hidden" name="foto" value="<?php echo $p->product_image?>">
                    <input type="file" name="gambar" class="input-control">
                    <textarea class="input-control" name="description" placeholder="Description"><?php echo $p->product_description?></textarea><br>
                    <select class="input-control" name="status">
                        <option value="">..Pilih..</option>
                        <option value="1" <?php echo($p->product_status == 1)?'selected':''; ?>>Aktif</option>
                        <option value="0" <?php echo($p->product_status == 0)?'selected':''; ?>>Tidak Aktif</option>
                    </select>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php 
                if(isset($_POST['submit'])){

                    // data imputan dari form
                    $category       = $_POST['category'];
                    $nama           = $_POST['nama'];
                    $harga          = $_POST['harga'];
                    $description    = $_POST['description'];
                    $status         = $_POST['status'];
                    $foto           = $_POST['foto'];

                    // data gambar yang baru 
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];

                    
                    // jika admin ganti gambar 
                    if($filename != ''){
                        $type1 = explode('.', $filename);
                        $type2 = $type1[1];

                        $newname = 'produk'.time().'.'.$type2;

                        //menampung data format file yang diizinkan
                        $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'jfif', 'gif');

                        // validasi format file
                    if(!in_array($type2, $tipe_diizinkan)){
                    // jika format file tidak ada di dalam tipe diizinkan
                    echo '<script>alert("Format file tidak diizinkan")</script>';
                    }else {
                        unlink('./produk/'.$foto);
                        move_uploaded_file($tmp_name, './produk/'.$newname);
                        $namagambar = $newname;
                    }
                }else{
                    // jika admin tidak ganti gambar
                    $namagambar = $foto;
                }

                // query update data produk
                  $update = mysqli_query($conn, "UPDATE tb_product SET
                                         category_id = '".$category."',
                                         product_name = '".$nama."',
                                         product_price = '".$harga."',
                                         product_description = '".$description."',
                                         product_image = '".$namagambar."',
                                         product_status = '".$status."'
                                         WHERE product_id = '".$p->product_id ."' ");
                if($update){
                    echo '<script>alert("Ubah data berhasil")</script>';
                    echo '<script>window.location="data_product.php"</script>';
                }else{
                    echo 'gagal'.mysqli_error($conn);
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
```

## Source Code tambah_product.php
```Php
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
```

## Source Code data_product.php
```Php
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
```

## Source Code detail_product.php
```Php
<?php
error_reporting(0);
  include 'db.php';
  $contact = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 1");
  $a = mysqli_fetch_object($contact);

  $product = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '".$_GET['id']."' ");
  $p = mysqli_fetch_object($product);
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
        <h1><a href="index.php">BaRa Store</a></h1>
        <ul>
            <li><a href="produk.php">Produk</a></li>
            <li><a href="login.php">Login</a></li>
        </div>
    </header>

    <!-- search -->
    <div class="search">
        <div class="container">
            <form action="produk.php">
                <input type="text" name="search" placeholder="Cari-Produk" value="<?php echo $_GET['search'] ?>">
                <input type="hidden" name="kat" value="<?php echo $_GET['kat'] ?>">
                <input type="submit" name="cari" value="Cari Produk">
            </form>
        </div>
    </div>

    <!-- product detail -->
    <div class="section">
        <div class="container">
            <h3>Detail Produk</h3>
            <div class="box">
                <div class="col-2">
                    <img src="produk/<?php echo $p->product_image ?>" width="100%">
                </div>

                <div class="col-2">
                    <h3><?php echo $p->product_name ?></h3>
                    <h4>Rp. <?php echo number_format($p->product_price) ?></h4>
                    <p>Deskripsi :<br>
                <?php echo $p->product_description ?>
                </p>
                <p><a href="https://api.whatsapp.com/send?phone=<?php echo $a->admin_telp ?>&text=Hai, Saya tertarik dengan produk Anda." target="_blank">
                 Hubungi Via WhatsApp</a>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="footer">
        <div class="container">
            <h4>Alamat</h4>
            <p><?php echo $a->admin_address ?></p>

            <h4>Email</h4>
            <p><?php echo $a->admin_email ?></p>

            <h4>No. Hp</h4>
            <p><?php echo $a->admin_telp ?></p>
        <small>Copyright &copy; 2022 = BaRa Store.</small>
        </div>
    </div>
</body>
</html>
```

## Source Code proses_delete.php
```Php
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
```

## Source Code index.php
```Php
<?php
  include 'db.php';
  $contact = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 1");
  $a = mysqli_fetch_object($contact);
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
        <h1><a href="index.php">BaRa Store</a></h1>
        <ul>
            <li><a href="produk.php">Produk</a></li>
            <li><a href="login.php">Login</a></li>
        </div>
    </header>

    <!-- search -->
    <div class="search">
        <div class="container">
            <form action="produk.php">
                <input type="text" name="search" placeholder="Cari-Produk">
                <input type="submit" name="cari" value="Cari Produk">
            </form>
        </div>
    </div>

    <!-- category -->
    <div class="section">
        <div class="container">
            <h3>Kategori</h3>
            <div class="box">
                <?php
                $category = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                if(mysqli_num_rows($category) > 0){
                    while($k = mysqli_fetch_array($category)){
                ?>
                <a href="produk.php?kat=<?php echo $k['category_id'] ?> ">
                <div class="col-5">
                    <img src="img/list-solid.svg" width="50px" style="margin-bottom:5px;">
                    <p><?php echo $k['category_name'] ?></p>
                </div>
                </a>
                <?php }}else{ ?>
                    <p>Kategori tidak ada</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- new product -->
    <div class="section">
        <div class="container">
            <h3>Produk Terbaru</h3>
            <div class="box">
                <?php
                $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 ORDER BY product_id DESC LIMIT 8");
                if(mysqli_num_rows($produk) >0){
                    while($p = mysqli_fetch_array($produk)){
                ?>
                <a href="detail_product.php?id=<?php echo $p['product_id'] ?> ">
                <div class="col-4 gambar" >
                    <img src="produk/<?php echo $p['product_image'] ?> ">
                    <p class="nama"><?php echo substr($p['product_name'], 0, 30) ?> </p>
                    <p class="harga">Rp. <?php echo number_format($p['product_price']) ?> </p>
                </div>
                </a>
                <?php }}else{ ?>
                    <p>Produk tidak ada</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="footer">
        <div class="container">
            <h4>Alamat</h4>
            <p><?php echo $a->admin_address ?></p>

            <h4>Email</h4>
            <p><?php echo $a->admin_email ?></p>

            <h4>No. Hp</h4>
            <p><?php echo $a->admin_telp ?></p>
        <small>Copyright &copy; 2022 = BaRa Store.</small>
        </div>
    </div>
</body>
</html>
```