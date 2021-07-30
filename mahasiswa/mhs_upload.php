<?php

// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi_mhs.php";

// MENGHUBUNGKAN KONEKSI COMPOSER
require "../data/lib-composer/vendor/autoload.php";


// CEK COOKIE
checkCookie();

// JIKA SUDAH LOGIN MASUKKAN KEDALAM SHOWDATA
if (!isset($_SESSION["login"])) {
  header('location: mhs_login.php');
  exit;
} else {
  if (isset($_SESSION['id_mhs'])) {
    // var_dump($_SESSION['id_mhs']); die;
    $my_id = $_SESSION['id_mhs'];
  } else {
    $my_id = $_COOKIE['id_mhs'];
  }

  // QUERY MAHASISWA
  $mhs = query("SELECT * FROM tb_bio_mhs WHERE id_mhs = '$my_id' ")[0];
}

?>

<?php
// CEK APAKAH TOMBOL SUBMIT SUDAH DITEKAN BELUM
if (isset($_POST["upload"])) {

  // CEK APAKAH BERHASIL DITAMBAHKAN ATAU TIDAK
  if (upload_product($_POST, $mhs) > 0) {
    echo "<script>
    alert( 'Product berhasil diupload!' );
    document.location.href = 'mhs_myproduct.php';
    </script>
    ";
  } else {
    echo "<script>
    alert( 'Product gagal diupload!' );
    document.location.href = 'mhs_myproduct.php';
    </script>
    ";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <title>Upload Product</title>
  <link rel="Icon" href="<?= base_url('data/images/iconE.png'); ?>">
  <!-- Bootsrap CSS -->
  <link rel="stylesheet" href="<?= base_url('data/libraries/bootsrap/css/bootstrap.css'); ?>">
  <!-- font -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="preconnect" href="https://fonts.googleapis.com/css?family=Pirata+One|Rubik:900">
  <!-- font Awesome -->
  <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- font gfonts -->
  <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('data/styles/upload.css?') . time(); ?>">
</head>

<body>

  <!-- start navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

      <img src="<?= base_url('data/images/Yoamn.png" alt="logo emon'); ?>">

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ml-auto">
          <a class="nav-item nav-link active" href="index.php">Home<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="mhs_myproduct.php">My-Product</a>
          <a class="nav-item nav-link" href="mhs_profile.php?id_mhs=<?= $mhs['id_mhs']; ?>">profile</a>
          <a class="nav-item nav-link" href="mhs_upload.php">Upload</a>
          <a class="nav-item nav-link" href="mhs_logout.php">Logout</a>
        </div>
      </div>

    </div>
  </nav>
  <!-- end navbar -->

  <!-- start update product-->
  <div class="container upload">
    <div class="row">

      <div class="col-lg-4">
        <div class="upload-info"></div>
      </div>

      <div class="col-lg-8">
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="judul">
            <h2 class="text-center">UPLOAD</h2>
          </div>

          <div class="upload-form">

            <div class="form-group">
              <label class="control-label col-sm-4" for="tn">Team Name</label>
              <div class="col">
                <input type="text" class="form-control" id="tn" name="nama_tim" placeholder="team name" required="">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-6" for="tm">Team Members (Max. 3 members)</label>
              <div class="col">
                <?php $total = total("SELECT count(id_mhs) AS 'total' FROM tb_bio_mhs WHERE id_mhs != '$my_id' "); ?>
                <select multiple class="form-control" id="tm" name="team_member[]" size="5" required="">
                  <?php
                  global $conn;

                  $members = mysqli_query($conn, "SELECT * FROM tb_bio_mhs WHERE id_mhs != '$my_id' ORDER BY nama_depan ASC") or die(mysqli_error($conn));

                  foreach ($members as $member) {
                    echo '<option value="' . $member["id_mhs"] . '">' . $member["nama_depan"] . " " . $member["nama_belakang"] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-4" for="tp">Title Product</label>
              <div class="col">
                <input type="text" class="form-control" id="tp" name="nama_produk" placeholder="title product" required="">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-6" for="thumb_product">Product Pictures (Max. 5 pictures)</label>
              <div class="col">
                <input type="file" class="form-control" id="thumb_product" name="thumb_product[]" multiple required="">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-4" for="pd">Product Description</label>
              <div class="col">
                <textarea class="form-control" id="pd" name="deskripsi_produk" rows="5" cols="64" required=""></textarea>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10 text-center container">
                <button type="submit" class="btn btn-default animasi yore" name="upload">Upload</button>
              </div>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end upload product -->

  <!-- start footer -->
  <div id="contact">
    <div class="wrapper">
      <div class="footer">

        <div class="footer-section">
          <h3>E-Mon</h3>
          <p>E-Mon is a website that is a collection point for products from D4 Informatics Management</p>
        </div>

        <div class="footer-section">
          <h3>Contact</h3>
          <p>Universitas Negeri Surabaya Kampus Ketintang,Surabaya</p>
          <p>Kode Pos: 60231</p>
        </div>

        <div class="footer-section">
          <h3>Social</h3>
          <p><b>Instagram : </b>@E-Mon</p>
          <p><b>Email : </b>emon.productkarya@gmail.com</p>
        </div>

      </div>
    </div>
  </div>
  <!-- end footer -->

  <!-- start copyright -->
  <div class="class-row-footer">
    <div class="class-col text-center">
      <p>2021 All Rights Reversed by E-Mon Team</p>
    </div>
  </div>
  <!-- end copyright -->


  <!-- jquery first, then popper, then bootsrap  -->
  <script src="<?= base_url('data/libraries/jquery/jquery-3.5.1.min.js'); ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="<?= base_url('data/libraries/bootsrap/js/bootstrap.js'); ?>"></script>
  <script src="<?= base_url('data/libraries/retina/retina.min.js'); ?>"></script>


</body>

</html>